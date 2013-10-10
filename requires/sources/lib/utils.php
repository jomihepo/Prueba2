<?
/**
 * 
 ************************************************************************************** 
 * 14/04/2010
 * ARCHIVO PARA FORMATEO CIFRAS (ES/EN) 
 * Formato de la cifra XXXX.xx (ej: 9999.22)
 * Nota: -estudiar posibilidad de ampliar para formatos de otros países 
 ************************************************************************************** 
 * 
 */
function format_number($number,$idioma='ES',$n_decimales=null){ 
	
	//Comprobamos que la cifra proporciona sea numerica
	if(!is_numeric($number)){
		return "La cifra no es numerica";
	}
	else{
		//Valores por defecto para ES
		$miles = "."; 
		$decimal = ",";

		if($idioma == 'EN'){
			$miles = ".";
			$decimal = ",";
		}
		//Comprobamos si hemos pasado numero de decimales (y es entero)
		if($n_decimales == null || !is_int($n_decimales)){
			//Si no han pasado numero de decimales obtenemos el número que tiene la cifra
			$esdecimal = strpos("$number",'.');
			if($esdecimal){
				$n_decimales = strlen("$number")-$esdecimal-1;
			}
			else{
				$n_decimales = 0;
			}
		}
		
		//Devolvemos la cifra formateada con los decimales y en el formato de idioma pedido
		return number_format($number,$n_decimales,$decimal,$miles);
	}
}

/**
 * 
 ************************************************************************************** 
 * 15/04/2010
 * ARCHIVO PARA FORMATEO TEXTO EN FORMA URL
 * (Ej: "Los molinos más famosos de España" >> los-molinos-mas-famosos-de-espana ) 
 ************************************************************************************** 
 * 
 */
function format_url($texto){ 
	
	$spacer = "-";
	$url = trim($texto);
    $url = str_replace(array("á","à","ä","Á","À","Ä"),"a",$url);
    $url = str_replace(array("é","è","ë","É","È","Ë"),"e",$url);
    $url = str_replace(array("í","ì","ï","Í","Ì","Ï"),"i",$url);
    $url = str_replace(array("ó","ò","ö","Ó","Ò","Ö"),"o",$url);
    $url = str_replace(array("ú","ù","ü","Ú","Ù","Ü"),"u",$url);
    $url = str_replace(array("ñ","Ñ"),"n",$url);
    $url = str_replace(array('"',"'","´","`"),$spacer,$url);
    $url = str_replace(array("ç","Ç"),"c",$url);
    $url = str_replace(array("¡","!","¿","?"),$spacer,$url);
	$url = ereg_replace("[ \t\n\r]+", $spacer, $url);
	$url = ereg_replace("^[¡¿-]+", "", $url);
	$url = ereg_replace("[?!-]+$", "", $url);
	$url = str_replace(" ", $spacer, $url);
	$url = ereg_replace("[ -]+", $spacer, $url);
	$url = strtolower($url);
 
   
	return $url; 
	
}

/**
 * 
 ************************************************************************************** 
 * 14/04/2010
 * ARCHIVO PARA LIMITAR TEXTO A N_CARACTERES
 ************************************************************************************** 
 * 
 */
function limit_text($texto,$n_caracteres){ 
	//Eliminamos tags html en caso de que los haya menos los saltos de linea.
	$texto = strip_tags($texto,'<br>');
	//No pasamos un numero entero de caracteres
	if(!is_int($n_caracteres)){
		return "El número de caracteres no es un entero";
	}
	//Pasamos un texto vacio
	if(strlen($texto)<= 0){
		return "El texto está vacío";
	}
	//Si la longitud del texto es menor al limite no tocamos nada
	if(strlen($texto) < $n_caracteres){
		return $texto;
	}
	
	$texto_troceado = split(" ",trim($texto));
	$texto_mod = '';
	// Vamos concatenando trozos del texto original sin sobrepasar el limite
	// y añadimos "..." al final
	foreach($texto_troceado as $trozo){
		if(strlen("$texto_mod $trozo") > $n_caracteres-3)
			break;
		else
			$texto_mod .= " $trozo";
	}
	
	return "$texto_mod...";
	
}

/**
 * 
 ************************************************************************************** 
 * 15/04/2010
 * ARCHIVO PARA FORMATEO TEXTO A ASCII 
 * (Ej: pruebaprueba.com >>  
 ************************************************************************************** 
 * 
 */
function string_to_ascii($string){ 

	$ascii = '';
	 foreach (str_split($string) as $obj) 
    { 
        $ascii .= '&#' . ord($obj) . ';'; 
    }
	
	return($ascii);

}

/**
 * 
 ************************************************************************************** 
 * 28/04/2010
 * INCRUSTA REPRODUCTOR YOUTUBE  con las dimensiones y el video que se indica
 * Ej: http://www.youtube.com/watch?v=zVt9kQWNp3I&feature=player_embedded 
 * youtube('zVt9kQWNp3I',800,600)
 * donde ancho = 800px
 *       alto = 600px
 *       codigo del video en youtube = zVt9kQWNp3I 
 ************************************************************************************** 
 * 
 */
function youtube($codigo=null,$ancho=480,$alto=385){ 

	return '<object width="'.$ancho.'" height="'.$alto.'">
				<param name="movie" value="http://www.youtube.com/v/'.$codigo.'"></param>
				<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
				<embed src="http://www.youtube.com/v/'.$codigo.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$ancho.'" height="'.$alto.'></embed>
			</object>';

}


/**
 * 
 ************************************************************************************** 
 * 21/05/2010
 * Devuelve el primer párrafo de un texto html. Si no tiene etiquetas <p></p> 
 * devuelve el texto completo con etiquetas <p></p>
 ************************************************************************************** 
 * 
 */
 
 function first_paragraph($html){
	
	$inicio = strpos($html,'<p>');
	$fin = strpos($html,'</p>');
	
	if($inicio !==  false && $fin !== false)
		return substr($html,$inicio,$fin + strlen('</p>'));
	else
		return "<p>$html</p>";
		
 }
 
 
 /**
 * 
 ************************************************************************************** 
 * 24/05/2010
 * Formatea una fecha procedente de bbdd en formato español y anglosajón
 * y con el separador personalizado
 ************************************************************************************** 
 * 
 */
 
 function format_date($fecha,$separador='-',$formato='ES'){
	
	if(!preg_match("/^([0-9]{4,4})-([0-9]{2,2})-([0-9]{2,2})$/",$fecha))
		return "Compruebe el formato de la fecha: $fecha";
	
	$temp = explode("-",$fecha);
	
	if($formato == 'ES')
		return "{$temp[2]}$separador{$temp[1]}$separador{$temp[0]}";
	else
		return "{$temp[1]}$separador{$temp[2]}$separador{$temp[0]}";
	
 }
 
 
 /**
 * 
 ************************************************************************************** 
 * 03/06/2010
 * Echo recursivo de una variable para visualizarla en el navegador
 ************************************************************************************** 
 * 
 */
 
 function volcar_variable($variable){
	
	echo "<pre>";
	var_dump($variable);
	echo "<pre>";
 
 }

 /**
 * 
 ************************************************************************************** 
 * 04/06/2010
 * Formatea un telefono en grupos de dos o tres cifras
 ************************************************************************************** 
 * 
 */
 
 function format_phone($telefono,$dos_format=false){
	
	$temp = str_replace(array(" ","-"),"",$telefono);

	if(!preg_match('/([0-9]+){9,}/',$temp))
		return "El formato de telefono no es correcto: $telefono";
	else{
	
			$numero = substr($telefono,-6);
			$prefijo = substr($telefono,0,(count($telefono)-1)-6);
			
			if($dos_format)
				return  "$prefijo ".implode(" ",str_split($numero,2));
			else
				return  "$prefijo ".implode(" ",str_split($numero,3));
	}
 
 }
 
 
 /**
 * 
 ************************************************************************************** 
 * 20/07/2010
 * Obteniene contenido DOM respuesta a una peticion de una página de un servidor
 * cuando no es posible el uso por temas de seguridad con file_get_contents o file
 *  Uso:
 *       $xml = loadXML2("127.0.0.1", "/path/to/xml/server.php?code=do_something");
 *       if($xml) {
 *          // xml doc cargado
 *       } else {
 *         // fllo. mostramos mensaje de error.
 *       }
 ************************************************************************************** 
 * 
 */
 function loadXML2($domain, $path, $timeout = 30) {

    $fp = fsockopen($domain, 80, $errno, $errstr, $timeout);
    if($fp) {
        // make request
        $out = "GET $path HTTP/1.1\r\n";
        $out .= "Host: $domain\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
       
        // get response
        $resp = "";
        while (!feof($fp)) {
            $resp .= fgets($fp, 128);
        }
        fclose($fp);
        // check status is 200
        $status_regex = "/HTTP\/1\.\d\s(\d+)/";
	
        if(preg_match($status_regex, $resp, $matches) && $matches[1] == 200) {   
            // load xml as object
            $parts = explode("\r\n\r\n", $resp);  
            return simplexml_load_string($parts[1]);               
        }
    }
    return false;
   
	} 
 
?>