<?php
// Cargar datos conexion y otras variables.
require ("aut_config.inc.php");
include ("aut_login.inc.php");

//declaracion de instancias
$rs_zona=""; //variable de Recordset

$order =$_POST["order"];
$propiedades = json_decode(stripslashes($_POST["propiedades"]),true);
$page = $_POST["pagina"];
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

$page = getIdPage($conectar, $page); //get id page

for($cont =0;$cont < sizeof($propiedades);$cont++){
    
    $proid = eregi_replace('"', "", $propiedades[$cont]["proid"]);
    $prostyle = eregi_replace('"', "", $propiedades[$cont]["prostyle"]);
    $proclass = eregi_replace('"', "", $propiedades[$cont]["proclass"]);
    $promodulo = eregi_replace('"', "", $propiedades[$cont]["promodulo"]);
    
    
    if(checkidZona($conectar, $proid)){
        $sc_sql ="UPDATE zona SET
                        id_pagina = '" . $page . "',
                        id_modulo = '" . $promodulo . "',
                        css = '" . $prostyle . "',
                        padre = '0',
                        class = '" . $proclass ."'
                        WHERE id = '". $proid ."'";
    }else{
        $sc_sql ="insert into zona (id,
                            id_pagina,
                            id_modulo,
                            css,
                            padre,
                            orden,
                            class)
                            values('" . $proid ."',
                                    '" . $page . "',
                                    '" . $promodulo . "',
                                    '" . $prostyle . "',
                                    '0',
                                    '0',
                                    '" . $proclass . "')";
    }

    

   $rs_zona = mysql_query($sc_sql,$conectar);
   
   if($rs_zona){
       echo 'Registro Guardado Correctamente';
   }else{
       echo mysql_error();
   }
   
}




function orderZonas($conexion,$idPage,$orderZone){
    $rs_zone="";
    $cont=0;
    $sc_zona="";
    $items= explode(',',$orderZone);
    foreach ($items as $item) :
            $cont+=1;
            $sc_zona="UPDATE zona SET orden = '" . $cont . "' WHERE id = '" .$item ."'";
            $rs_zone=mysql_query($sc_zona,$conexion);
        
            echo("cont " . $cont . " id " . $item . "<br />");
    endforeach;
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

function checkidZona($conexion,$id){
    
    $rs_zone="";
    $obj_zona="";
    /*getIdPage*/
    $sc_zone ="SELECT id FROM zona WHERE id = '" . $id ."'";
    $rs_zone = mysql_query($sc_zone, $conexion);
    $count_rs=mysql_num_rows($rs_zone);

    if($count_rs > 0){
     return true;
    }else{
        return false;
    }
    
}
/*deleting data not valid*/
function deleZona($conexion,$page,$idzona){
    $sc_zone="";
    $rs_zone="";
    $obj_zona="";
    $idzonadel =array();

    $idzonatmp =explode(",",$idzona);
    $arraytmp=array();
    foreach ($idzonatmp as $value) {
        $arraytmp[]="'" . $value."'";
    }

    /*getIdPage*/
    $sc_zone ="SELECT id FROM zona WHERE id NOT IN(". implode(',', $arraytmp) . ") AND id_pagina = '" . $page . "'";
   
    $rs_zone = mysql_query($sc_zone, $conexion);
    
    $count_rs=mysql_num_rows($rs_zone);

    if($count_rs <> 0){
        
        while($row = mysql_fetch_object($rs_zone)){
           $idzonadel[]="'" .$row->id ."'";  
        }

        $sc_zone="DELETE From zona where id in (" . implode(",", $idzonadel) . ")";
        $rs_zone=mysql_query($sc_zone,$conexion);
                
    }
    
}
/*ending code*/


/*actualizar orden de webs*/
orderZonas($conectar, $page, $order);
/*fin de actualizar orden de webs*/
/*deleting data no valida*/
deleZona($conectar, $page, $order);
/*ending data*/

?>

