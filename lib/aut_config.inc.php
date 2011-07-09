<?php
// Nombre de la session (puede dejar este mismo)
$usuarios_sesion="autentificador";
$usuario_autentificado = "3306f2e6385848ffa3fcff3c7c4b6f68";

// Datos conexión a la Base de datos (MySql)
$sql_host="localhost";		// Host, nombre del servidor o IP del servidor Mysql.
$sql_usuario="root";		// Usuario de Mysql
$sql_pass="";				// contrase?a de Mysql
$sql_db="editinplace";		// Base de datos que se usará.

if(!defined('DB_HOST')){
    define('DB_HOST',		'localhost');	// Database Host
}
if(!defined('DB_USER')){
    define('DB_USER',		'root');		// Database User Name
}
if(!defined('DB_PASSWORD')){
    define('DB_PASSWORD',	'');		// Database User Password
}
if(!defined('DB_NAME')){
    define('DB_NAME',		'editinplace');		// Database Name
}
if(!defined('PATH_ROOT')){
    define('PATH_ROOT',"http://localhost/editplace/");
}



$url_path = "http://localhost/editplace/";
$url_theme = "theme/stocker";



$titulo = "StockerPlace";
$pie_pagina = "Desarrollado por <a href='http://stockergroup.com' target='_blank'>Stocker Group</a>";
?>