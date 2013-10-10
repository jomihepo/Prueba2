<?
 /* SERVIDORES DONDE ESTÁ DISPONIBLE $_SERVER['DOCUMENT_ROOT'] */
 if(!isset($_SERVER["DOCUMENT_ROOT"])){
	$_SERVER["DOCUMENT_ROOT"]=substr($_SERVER['SCRIPT_FILENAME'] , 0 , -strlen($_SERVER['PHP_SELF'])+1 );
}

require_once $_SERVER['DOCUMENT_ROOT']."/requires/sources/__conf.php";
require_once $_SERVER['DOCUMENT_ROOT']."/requires/sources/__bbdd.php";
?>