<?php
/**
 * 
 ************************************************************************************** 
 * 15/04/2010
 * ARCHIVO PARA FORMATEO TEXTO A ASCII 
 * (Ej: pruebaprueba.com >>  
 ************************************************************************************** 
 * 
 */
function string_to_ascii($texto){ 

	$ascii = NULL;
	for ($i = 0; $i < strlen($string); $i++)
	{
		$ascii += "&#".ord($string[$i]).";";
	}

	return($ascii);

}
?>