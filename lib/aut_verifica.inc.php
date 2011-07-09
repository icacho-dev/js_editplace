<?
//  --------------------------------------------------------------
//  Motor Autentificador de Usuarios
//  PHP-Mysql-Session
//  por Juan Rivera C.
//  juanrivera@mediasur.cl
//  --------------------------------------------------------------
//  Script basado en Autentificator by Cluster. v2.01 - 16/10/2002
//  --------------------------------------------------------------
//  Mejoras gráficas y perfeccionado en niveles de usuarios
//  --------------------------------------------------------------
//  ---------------- Motor autentificación usuarios --------------
//  ---------------- ------------------------------ --------------

// Cargar datos conexion y otras variables.

require ("aut_config.inc.php");

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
if (!$conectar)
	{
    die('Problema en la Conexion: ' . mysql_error());
	}
	
mysql_select_db($sql_db); 

$usuario=htmlspecialchars($_POST['usuario'],ENT_QUOTES);
$pass=md5($_POST['contrasena']);

$sql="SELECT email, pass, id_admin, nombre, user, usuario FROM admin WHERE usuario='".$usuario."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

if(mysql_num_rows($result)>0)
	{
	if(strcmp($row['pass'],$pass)==0)
		{
		// le damos un mobre a la sesion.
		session_name($usuarios_sesion);
		// incia sessiones
		session_start();
		
		// Paranoia: decimos al navegador que no "cachee" esta página.
		session_cache_limiter('nocache,private');
		
		//definimos usuario_autenticado con un valor cualquiera
		$_SESSION['usuario_autentificado'] = $usuario_autentificado;
		$_SESSION['id_admin']=$row['id_admin'];
		$_SESSION['nombre']=$row['nombre'];
				
		echo "yes";
		exit;
		}
	else
		{
		echo "no";
		exit;
		}
	}
else
	{
	echo "no";
	exit;
	}
?>