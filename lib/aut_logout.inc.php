<?
//  --------------------------------------------------------------
//  Motor Autentificador de Usuarios
//  PHP-Mysql-Session
//  por Juan Rivera C. (ELCHE)
//  juan.rivera.c@gmail.com
//  --------------------------------------------------------------
//  Script basado en Autentificator by Cluster. v2.01 - 16/10/2002
//  --------------------------------------------------------------
//  Mejoras gráficas y perfeccionado en tres niveles de usuarios
//  --------------------------------------------------------------
//  ---------------- Motor autentificación usuarios --------------
//  ---------------- ------------------------------ --------------

// Cargamos variables


// le damos un mobre a la sesion (por si quisieramos identificarla)
session_name($usuarios_sesion);
// iniciamos sesiones
session_start();

// destruimos la session de usuarios.
session_destroy();
?>
<script language="javascript">
document.location='index.php';
</script>