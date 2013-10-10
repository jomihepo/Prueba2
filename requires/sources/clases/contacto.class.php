<?
class Contacto{

	var $errores = array();
	var $enviado = false;
	
	function __construct($campos=array(),$tabla=null,$from = null,$fromName = null,$to = null,$subject=null,$template = null){
		
		global $NOMBRE_EMPRESA;
		
		if(!isset($_POST['enviar'])){
			return false;
		}
		
		if(empty($campos)){
			die("Contacto::No se han especificado campos para validar");
		}
		// if($from == null){
			// die("Contacto::No se ha especificado la dirección del remitente");
		// }
		if($fromName == null){
			$fromName = $from;
		}
		if($to == null){
			die("Contacto::No se ha especificado la dirección de envio");
		}
		if($subject == null){
			$subject = 'Formulario de contacto';
		}
		
		if($this->validacion($campos) === true){
			
			if($tabla != null){ // Si pasamos una tabla guardamos los datos
				$this->insertaBBDD($campos,$tabla);
			}
			
			require_once $_SERVER['DOCUMENT_ROOT']."/requires/sources/lib/phpmailer/class.phpmailer.php";
			
			$cuerpo = '';
			
			/* Envio del email */
			if($template == null){
			
				
				//$body = file_get_contents($_SERVER['DOCUMENT_ROOT']."/requires/sources/templates/index.html");
				//$cuerpo = '<table>';
				
				foreach($campos as $campo){
					
					if($campo['enviar'] == true){
						//$cuerpo .= '<tr><th>'.$campo['texto'].'</th><td>'.$_POST[$campo['nombre']].'</td></th>'; 
						$cuerpo .= $campo['texto'].' '.$_POST[$campo['nombre']]."\n"; 
					}
				
				}
			}
			else{
				//$body = file_get_contents($_SERVER['DOCUMENT_ROOT']."/requires/sources/templates/".$template);
			}
			
			$body = $cuerpo;
			// $body = str_replace('[CONTENIDO]',$cuerpo,$body);
			// $body = str_replace('[EMPRESA]',$NOMBRE_EMPRESA,$body);
			
			//try {
			  // $correo->AddAddress($to);
			  // $correo->SetFrom($from, $fromName);
			  // $correo->AddReplyTo($from, $fromName);
			  // $correo->Subject = $subject;
			
			  //$correo->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT']."/requires/sources/templates/logo.gif", 'logo', 'logo.gif'); 
			 // die($to);
			  $correo  = new PHPMailer();
			  //$correo->IsHTML(true);
			  $correo->AddAddress($to);
			 //$correo->AddBcc('r.ruiz@interactivaclic.com');
			  $correo->From = $from;
			  $correo->FromName = $fromName;
			  $correo->CharSet = 'utf-8';
			  $correo->Subject = $subject;
			  $correo->Body = str_replace("\\r\\n", "\n", $body); //Esto soluciona el problema de los saltos de linea
			  // $correo->Body = "Hola";
			  //$correo->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT']."/requires/sources/templates/logo.gif", 'logo', 'logo.gif');
				  
			  if($correo->Send()){
				$this->enviado = true;
			  }
			 
			// } catch (phpmailerException $e) {
			  // echo $e->errorMessage(); // Error messages from PHPMailer
			// } catch (Exception $e) {
			  // echo $e->getMessage(); // Boring error messages from anything else!
			// }
			
			
		}
		
	}
	
	
	private function validacion($campos){
	
		foreach($campos as $campo){
			
			$_POST[$campo['nombre']] = trim(strip_tags($_POST[$campo['nombre']]));
			
			if($campo['requerido'] == true && $_POST[$campo['nombre']] == ''){
				$this->errores[$campo['nombre']] = "{$campo['nombre']} es requerido";
				continue;
			}
			
			
			switch($campo['validacion']){
			
				
				case 'numerico':
					if(!is_numeric($_POST[$campo['nombre']])){
						$this->errores[$campo['nombre']] = "{$campo['nombre']} no es un valor numérico";
					}
				break;
				
				case 'alfanumerico':
				break;
				
				case 'telefono':
					if(!preg_match('/^[0-9]{9,9}$/',$_POST[$campo['nombre']])){
						$this->errores[$campo['nombre']] = "{$campo['nombre']} no es un teléfono válido";
					}	
				break;
				
				
				case 'codigo_postal':
					if(!preg_match('/^[0-9]{5,5}$/',$_POST[$campo['nombre']])){
						$this->errores[$campo['nombre']] = "{$campo['nombre']} no es un código postal válido";
					}
						
				break;
			
				case 'email':
					if(!preg_match('/^[a-zA-Z0-9_.-]{2,}@[a-zA-Z0-9_-]{2,}\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,4})?$/',$_POST[$campo['nombre']])){
						$this->errores[$campo['nombre']] = "{$campo['nombre']} no es un email correcto";
					}
				break;
				
				case 'texto':
					if(!preg_match('/^[a-zA-Z0-9_.-,;]$/',$_POST[$campo['nombre']])){
						$this->errores[$campo['nombre']] = "{$campo['nombre']} tiene caracteres no válidos";
					}
				break;
				
				case 'combo':
					if($_POST[$campo['nombre']] < 0){
						$this->errores[$campo['nombre']] = "{$campo['nombre']} tienes que elegir una opción";
					}
				break;
				
			}
			
		
		}
		
		// print_r($this->errores);
		// die;
		
		if(count($this->errores) == 0){
			return true;
		}
		else{
			return false;
		}
		
	
	}
	
	
	private function insertaBBDD($campos,$tabla){
		global $MYSQL_LINK;
		/* Hay que revisar esta parte */
		// $SQL = "SHOW TABLES LIKE `pedo`";
		// $consulta = mysql_query($SQL,$MYSQL_LINK);
		// if(mysql_num_rows($consulta) != 1){
			// die("Contacto::La tabla proporcionada no existe en la bbdd");
		// }
		// else{
			$SQL = "INSERT INTO `$tabla` ";
			
			$columnas = array();
			$valores = array();
			
			foreach($campos as $campo){
			
				if(function_exists('mysql_real_escape_string')){
					$_POST[$campo['nombre']] = mysql_real_escape_string($_POST[$campo['nombre']]);
				}
				else{
					$_POST[$campo['nombre']] = addslashes($_POST[$campo['nombre']]);
				}
			
				if($campo['insertar'] == true){
					$columnas[] = $campo['nombre'];
					$valores[] = "'".$_POST[$campo['nombre']]."'";
				}
			}
			
			if(!empty($columnas) && !empty($valores)){
			
				$SQL .= " (".implode(",",$columnas).",fecha,hora) VALUES (".implode(",",$valores).",CURDATE(),CURTIME())";
				@mysql_query($SQL,$MYSQL_LINK);
				
				if(!mysql_error())
					return true;
				else
					return false;
			}
			
		//}
	}
	
	function muestraError($campo){
		if(isset($this->errores[$campo]))
			return 'style="background-color:#FC7C71;"';
	
	}


}



?>