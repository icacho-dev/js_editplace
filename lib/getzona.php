<?php
// Cargar datos conexion y otras variables.
require ("aut_config.inc.php");
include ("aut_login.inc.php");

//declaracion de instancias
$rs_zona=""; //variable de Recordset
// fin de la declaracion de instancias

/*funciones*/
function checkpagezona($page,$conexion){
            $rs_zona="";
            $obj_zona="";
            $sc_zona="SELECT id,
                             contenido,
                             id_modulo,
                             css,
                             class FROM
                             zona
                             WHERE
                             id_pagina = '" . $page . "'
                             ORDER BY orden";
            
            $rs_zona = mysql_query($sc_zona, $conexion) or die("Bug in Search");;
            $count_rows= mysql_num_rows($rs_zona);
 
            if($count_rows>0){
                    $rows = array();
                    while($r = mysql_fetch_assoc($rs_zona)) {
                        $rows[] = $r;
                    }
                    echo json_encode($rows);
                    exit();       
            }
        }

function getIdPage($conexion,$pagina){
    $rs_pagina="";
    $obj_pagina="";
    /*getIdPage*/
    $sc_pagina ="SELECT id FROM paginas WHERE url_amigable = '" . $pagina ."'";
    $rs_pagina = mysql_query($sc_pagina, $conexion);
    $count_rs=mysql_num_rows($rs_pagina);

    if ($count_rs  <>   0){
        $obj_pagina=  mysql_fetch_object($rs_pagina);

        $pagina=$obj_pagina->id;
    }else{
        $pagina=1;
    }
    /*fin de GetIDPage*/

    return $pagina;
}
/*fin de funciones*/



// chequear página que lo llama para devolver errores a dicha página.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script. si es asi se arroja un error.
if ($_SERVER['HTTP_REFERER'] == ""){
	die ("Error cod.:1 - Acceso incorrecto!");
	exit;
	}

$conectar = mysql_connect($sql_host, $sql_usuario, $sql_pass);

if (!$conectar){die('Problema en la Conexion: ' . mysql_error());}
mysql_select_db($sql_db);


if(isset ($_GET["idpagina"])){
    checkpagezona($_GET["idpagina"],$conectar);
}else{
    $page=$_GET["pagina"];
    $idpage=getIdPage($conectar, $page);
/*if the constructor have created the div*/
checkpagezona($idpage,$conectar);
/*fin*/
}


?>
