<?
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


if(mysql_query("UPDATE zona SET contenido = '" . $_POST["texto"] . "' WHERE id = '". $_POST["id"] ."'"))
	{
	mysql_close($conectar);
	header("Location: ".$pag_referida);
	exit;
	}
else
	{
	mysql_close($conectar);
	header("Location: ".$pag_referida);
	exit;
	}
?>