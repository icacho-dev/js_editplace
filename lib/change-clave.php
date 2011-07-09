<?php
// Cargar datos conexion y otras variables.
require ("aut_config.inc.php");
include ("aut_login.inc.php");

// chequear página que lo llama para devolver errores a dicha página.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script. si es asi se arroja un error.
if ($_SERVER['HTTP_REFERER'] == "")
	{
	die ("Error cod.:1 - Acceso incorrecto!");
	exit;
	}

$conectar = mysql_connect($sql_host, $sql_usuario, $sql_pass);
if (!$conectar){die('Problema en la Conexion: ' . mysql_error());}
mysql_select_db($sql_db);
$clave=$_POST['clave1'];
$newclave=$_POST['clave2'];
$newclave1=$_POST['clave3'];

$rs_admin = mysql_query("select * from admin where pass = md5('" . $clave ."')");
$row_resultado= mysql_num_rows($rs_admin);
if( $row_resultado>0 &&
            $newclave == $newclave1){
            if(mysql_query("UPDATE admin SET pass  = md5('" .$newclave . "')")){
                echo('Se a Cambiado la clave Satisfactoriamente');
            }else{
                echo('Error Favor de Verificar los datos');
            }
    
}else{
    echo('Error Favor de Verificar los datos');
}



	


?>


