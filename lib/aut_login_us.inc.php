<?php
// -------- Chequear sesión existe -------
// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesión de identificación del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.
if (!isset($_SESSION['usuario_autentificado']))
	{
	// Borramos la sesion creada por el inicio de session anterior
	//session_destroy();
	
	}
else
	{
    if ($_SESSION['usuario_autentificado'] != $usuario_autentificado)
		{
		//si no existe, envio a la página de autentificacion
		
		}
	}
?>