<?php
/**
 * 
 ************************************************************************************** 
 * 14/04/2010
 * ARCHIVO PARA INCLUSION DE CONTENIDO DE CABECERA:
 *  - Archivos JS y CSS
 *  - Contenido SEO : title, description, keywords....
 * 
 *
 ************************************************************************************** 
 * 
 */

$aRutas=split("/",$_SERVER['REQUEST_URI']);

/* Obtenemos la última parte de la URL para cuando no se especifique title, keywords y description */
//$url = substr($aRutas[count($aRutas)-1],0,strpos($aRutas[count($aRutas)-1],"."));

/* U obtenemos todo el path en forma de URL para cuando no se especifique title, keywords y description */
$url = '';
foreach($aRutas as $ruta){
	if($ruta != ''){
		$url .= "-$ruta";
	}
}

//arrays con la ristra de CSS y JS que se generara
$a_CSS = array();
$a_JS = array();

$a_CSS[] = '<link rel="stylesheet" href="/estilos/comunes.css" type="text/css" charset="utf-8" />';

// Aqui insertamos los archivos JS y CSS comunes que necesitemos de la forma :
// $a_JS[] = '<script type="text/javascript" src="/path/al/archivo/javascript.js"></script>';
// $a_CSS[] = '<link rel="stylesheet" href="/path/al/archivo/estilo.css" type="text/css" charset="utf-8" />';

/**JQUERY**/

$a_JS[] = '<script type="text/javascript" src="/requires/sources/js/jquery-1.4.2.js"></script>';
$a_JS[] = '<script type="text/javascript" src="/requires/sources/js/jquery.media.js"></script>';


// Aqui insertamos los archivos JS y CSS particulares de cada seccion

switch ($categoria)
{
	default: 
		$a_CSS[] = '<link rel="stylesheet" href="/estilos/'.$categoria.'.css" type="text/css" charset="utf-8" />';
}

// Sino tenemos titulo dinamico se pone el de por defecto
if (empty($title))
{
	$title=str_replace("-"," ",$url);
}

// Si no tenemos keyworks dinamicas se ponen a manao
if (!isset($keywords))
{
	$keywords = $title;
}
// Sino tenemos descripcion dinamica se pona el de por defecto
if (!isset($descripcion))
{
	$descripcion = $title;
}
?>


<title><?=$title?></title>
<meta name="DC.Title" content="<?=$title?>" />
<meta name="Keywords" content="<?=$keywords?>" />
<meta name="Description" content="<?=$descripcion?>" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="PRAGMA" content="NO-CACHE" />
<meta http-equiv="Expires" content="01-Mar-94 00:00:01 GMT" />
<meta http-equiv="CACHE-CONTROL" content="NO-CACHE,NO-STORE,MUST-REVALIDATE" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="shortcut icon" href="favicon.ico" />

<?
//genera las etiquetas link para los css que meti en el array
foreach($a_CSS as $link)
{
	print $link."\n";
}


?>

<?
//genera las etiquetas script para los js que meti en en el array
foreach($a_JS as $scripts)
{
	print $scripts."\n";
}


?>