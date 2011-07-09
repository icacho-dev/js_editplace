<?php
// Cargar datos conexion y otras variables.
require ("aut_config.inc.php");


//declaracion de instancias
$rs_paginas=""; //variable de Recordset
// fin de la declaracion de instancias

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

$rs_paginas =(mysql_query("SELECT id,titulo,url_amigable,orden FROM paginas WHERE tipo ='pagina'",$conectar));


if($rs_paginas)
	{
        $fila=array();
        while($filatmp=mysql_fetch_array($rs_paginas)){
            $fila=array_merge($fila,$filatmp);
        }
        echo json_encode($fila);
        mysql_close($conectar);
	exit;
        
	}


?>
