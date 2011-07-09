<?php
require_once 'Model/Sitio.Class.php';
/*Declaracion de Variables*/
$evento="";
$objsitio = "";
$objsitio = new Sitio();
/*fin de la declaracion de variables*/


$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script. si es asi se arroja un error.
if ($_SERVER['HTTP_REFERER'] == ""){
	die ("Error cod.:1 - Acceso incorrecto!");
	exit;
}

/*programacion*/
$evento = $_POST["evento"];

switch ($evento){
        case "getdata":
            $objsitio->set_id($_POST["id"]);
            echo(json_encode($objsitio->getidSitio()));
            break;
        case "updateData":
            $objsitio->set_id($_POST["id"]);
            $objsitio->set_titulo($_POST["titulo"]);
            $objsitio->set_icon($_POST["icono"]);
            if($objsitio->update() <> 0){
                echo("Registro Actualizado Correctamente");
            }else{
                echo("Error al Actualizar el Registro");
            }
            break;
        case "desactivateData":
            $objsitio->set_id($_POST["id"]);
            
            echo ($objsitio->desactivate());    
            break;
       case "addData":
           $objsitio->set_titulo($_POST["titulo"]);
           $objsitio->set_icon($_POST["icono"]);
           echo($objsitio->add());
           break;
       case "order":
           $array_id = "";
           $array_id = explode(',',$_POST["array_id"]);
           if ($objsitio->order($array_id)){
               echo 'Registro Ordenado';
           }else{
               echo 'Error al Ordenar el Registro';
           }
           
           break;
    
    
}



?>
