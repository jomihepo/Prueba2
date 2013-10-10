<?php
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

?>