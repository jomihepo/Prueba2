<?php
/**
 * 
 ************************************************************************************** 
 * 14/04/2010
 * FICHERO GENERAL DE CONFIGURACIÓN ZONA PÚBLICA
 * RELLENAR:
 * - Variables $DOMINIO_*
 * - Variables $MYSQL_*
 * - Variables de la última sección
 * 
 ************************************************************************************** 
 * 
 */

$idioma = (isset($_GET['idioma'])) ? $idioma=$_GET['idioma'] : $idioma='ES';
$url = $_GET['url'];
$desde = (int)$_GET['desde'];
require_once $_SERVER['DOCUMENT_ROOT']."/requires/multiidioma/$idioma.php";
require_once $_SERVER['DOCUMENT_ROOT'].'/requires/multiidioma/enlaces.php';


$DOMINIO_PRODUCCION = ''; //World Wide Web
$DOMINIO_DESARROLLO = ''; //DESARROLLO
$DOMINIO_TESTING = ''; //DynDNS , no-ip


/**
 * NO TOCAR
 * CAMBIA EL NOMBRE DE HOST A UNO CONCRETO, A NO SER QUE ESTEMOS EN DESARROLLO O TESTING
 * PARA EVITAR CONTENIDO DUPLICADO (varios hostsnames podrán apuntar al mismo site)
 */
if (
	($_SERVER['HTTP_HOST'] != $DOMINIO_TESTING) &&
	($_SERVER['HTTP_HOST'] != $DOMINIO_DESARROLLO) &&
	($_SERVER['HTTP_HOST'] != $DOMINIO_PRODUCCION))
{
	header('HTTP/1.1 301 Moved Permanently');
	
	if($_SERVER['REQUEST_URI'] != "")
	{
		header('Location: http://'. $DOMINIO_PRODUCCION . $_SERVER['REQUEST_URI'] );
	}
	else
	{
		/*todo geolocate ip address*/
		header('Location: http://'. $DOMINIO_PRODUCCION);
	}	
}

/**
 *
 * VARIABLES VARIAS
 *
*/

//NOMBRE EMPRESA
$NOMBRE_EMPRESA='';

/* VERIFICAR USO DE ESTA INFO PARA ELIMINAR */
//RUTA DE ALMACENAMIENTO DE LOS ARCHIVOS. IMPORTANTE, PONER BARRA / AL FINAL
$ARCHIVO_RUTA='/archivosbd/';
//VARIABLE TAMAÑO MÁXIMO ARCHIVO 10 MBytes
$ARCHIVO_MAX=10*1024*1024;

//REGISTROS POR PAGINA
$PAGINACION=10;
/* VERIFICAR USO DE ESTA INFO PARA ELIMINAR HASTA AQUÍ */

//DIRECCION DE CONTACTO PARA LOS CORREOS
//CLAVES GOOGLE MAPS
switch ($_SERVER['HTTP_HOST']) 
{
	case $DOMINIO_PRODUCCION: //.COM
		error_reporting(0); //no mostramos errores en produccion
		$CORREO = ''; //direccion de email para producción
		$MYSQL_HOST = '';
		$MYSQL_USER = '';
		$MYSQL_PASSWORD = '';
		$MYSQL_DB = '';
		$API_GOOGLE_MAPS = '';
		break;
		
	case $DOMINIO_TESTING: //DYNDNS,NO-IP
		$CORREO = ''; //direccion de email para testing
		$MYSQL_HOST = '';
		$MYSQL_USER = '';
		$MYSQL_PASSWORD = '';
		$MYSQL_DB = '';
		$API_GOOGLE_MAPS = '';
		break;
		
	default: //DESARROLLO
		$CORREO = ''; //direccion de email para desarrollo
		$MYSQL_HOST = '';
		$MYSQL_USER = '';
		$MYSQL_PASSWORD = '';
		$MYSQL_DB = '';
		$API_GOOGLE_MAPS = '';
}

?>