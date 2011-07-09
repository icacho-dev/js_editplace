<?php
require ("aut_config.inc.php");
// -------- Chequear sesi�n existe -------
// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesi�n de identificaci�n del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.
if (!isset($_SESSION['usuario_autentificado']))
	{
	// Borramos la sesion creada por el inicio de session anterior
	session_destroy();
	header("Location: login.php");
	exit;
	}
else
	{
    if ($_SESSION['usuario_autentificado'] != $usuario_autentificado)
		{
		//si no existe, envio a la p�gina de autentificacion
		header("Location: login.php?mensaje=Usted no est� autorizado para ver Dicha zona.");
		//ademas salgo de este script
		exit();
		}
	}
?>