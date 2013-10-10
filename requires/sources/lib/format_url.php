<?php
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
    $url = str_replace(array('á','à','ä','Á','À','Ä'),'a',$url);
    $url = str_replace(array('é','è','ë',),'e',$url);
    $url = str_replace(array('í','´ì','ï','Í','Ì','Ï'),'i',$url);
    $url = str_replace(array('ó','ò','ö','Ó','Ò','Ö'),'o',$url);
    $url = str_replace(array('ú','ù','ü','Ú','Ù','Ü'),'u',$url);
    $url = str_replace(array('ñ','Ñ'),'n',$url);
    $url = str_replace(array('"',"'","´","`"),$spacer,$url);
    $url = str_replace(array('ç','Ç'),'c',$url);
    $url = str_replace(array('¡','!','¿','?'),$spacer,$url);
	$url = ereg_replace("[ \t\n\r]+", $spacer, $url);
	$url = ereg_replace("^[¡¿-]+", "", $url);
	$url = ereg_replace("[?!-]+$", "", $url);
	$url = str_replace(" ", $spacer, $url);
	$url = ereg_replace("[ -]+", $spacer, $url);
	$url = strtolower($url);
 
   
	return $url; 
	
}
?>