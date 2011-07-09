<?php
// Cargar datos conexion y otras variables.
require ("../aut_config.inc.php");
include ("../../lang/lang-esp.php");
include ("../aut_login.inc.php");

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

$rs_paginas =(mysql_query("SELECT id,titulo,url_amigable,orden FROM paginas WHERE tipo ='pagina' and mostrar=1 and id_sitio= '" . $_SESSION['sitio'] ."' order by orden",$conectar));


if($rs_paginas)
	{
//        $fila=array();
//        while($filatmp=mysql_fetch_array($rs_paginas)){
//            $fila=array_merge($fila,$filatmp);
//        }
//        echo json_encode($fila);
?>
<div class="editar-page">
<?php
        echo ("<ul id=\"sortable\">");
        while($filatmp=mysql_fetch_array($rs_paginas)){
            
            echo ("<li  class=\"ui-state-default\" id=" . $filatmp["id"] . ">");
                echo ($filatmp["titulo"]  . 
                            "  <div id='botones'> <a href=" . PATH_ROOT ."/pagina/" . $filatmp['url_amigable'] . " target=_blank >    " .
                                " <img src='" . PATH_ROOT . "/img/btneditar.png' alt='boton de editar'/>  " . "</a>" .
                                "<a href='#' id=" . $filatmp['id'] .  " class='delete' >
                                    <img src='" . PATH_ROOT  ."/img/btneliminar.png' alt='boton de eliminar'/> </a></div>"   );
            echo ("</li>");
        }
        echo ("</ul>");
?>
</div>
<?php
        mysql_close($conectar);
	exit;

	}


?>