<?php
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
	//Vamos concatenando trozos del texto original sin sobrepasar el limite
	// y añadimos "..." al final
	foreach($texto_troceado as $trozo){
		if(strlen("$texto_mod $trozo") > $n_caracteres-3)
			break;
		else
			$texto_mod .= " $trozo";
	}
	
	return "$texto_mod...";
	
}
?>