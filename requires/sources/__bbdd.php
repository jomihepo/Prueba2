<?php
/**
 * 
 ************************************************************************************** 
 * 14/04/2010
 * ARCHIVO PARA CONEXION BBDD
 *
 ************************************************************************************** 
 * 
 */
if (is_null($MYSQL_LINK)) 
{
	$MYSQL_LINK=mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWORD) or die(mysql_error());
	mysql_select_db($MYSQL_DB) or die(mysql_error());
	@mysql_query("SET NAMES 'utf8'"); // Evita los problemas con como se ve los caracteres no-ascii introducidos desde formulario y el phpMyAdmin

}