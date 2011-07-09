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

// Validacion URL Amigable Unica
$resp = mysql_query("SELECT * FROM paginas WHERE url_amigable='".$_POST["url"]."'");
$num = mysql_num_rows($resp); 
if($num != 0)
	{
	echo "ko: Ya Existe una pagina con esta Url Amigable";
	exit;
	}

// Capturar el Orden mas Alto de las Paginas
$resp = mysql_query("SELECT MAX(orden) as maxi FROM paginas");
$damefila=mysql_fetch_object($resp);
$max = $damefila->maxi;
$max++;



if(mysql_query("insert into paginas (id_sitio,titulo,url_amigable,orden,tipo,padre,mostrar,mostrar_menu) values ('".$_POST['sitio']."','".$_POST['pagina']."','".$_POST['url']."','".$max."','".$_POST["tipo"]."','".$_POST["padre"]."','".$_POST["publicado"]."','".$_POST["menu"]."')"))
	{
	mysql_close($conectar);
	echo "ok:La Pagina se agrego correctamente";
	exit;
	}
else
	{
	mysql_close($conectar);
	echo "ko:La Pagina no se pudo agregar";
	exit;
	}
?>