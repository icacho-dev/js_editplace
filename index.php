<?php
//error_reporting(E_ALL);
// Carga de librerias php
include("lib/aut_config.inc.php");
include("lib/aut_login_us.inc.php");
require("lang/lang-esp.php");
include("lib/funciones.php");
require_once('lib/output.class.php');
require_once('lib/sql.php');

/*incluyendo para idioma*/
//$sitelang ="";
//if(empty($sitelang)){ 
//      $sitelang = getenv("HTTP_ACCEPT_LANGUAGE");
//      echo($sitelang);
//      } 
//switch($sitelang){ 
//          case "es" : 
//             include("./lang/lang-esp.php"); 
//             break; 
//          case "en" : 
//             include("./lang/lang-esp.php"); 
//             break; 
//          default : 
//             include("./lang/lang-esp.php"); 
//             break; 
//       }  
/*fin de idioma*/



if(isset($_SESSION["sitio"]))
	{
	if(isset($_GET["sitio"]))
		{
		$_SESSION['sitio'] = $_GET["sitio"];
		}
	}
else
	{
	if(isset($_GET["sitio"]))
		{
		$_SESSION['sitio'] = $_GET["sitio"];
		}
	else
		{
		$_SESSION['sitio'] = 1;
		}
	}
        if(isset($_GET['route'])){
            $_GET = getVariables($_GET['route']);
        }


$sql = new sql(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);

/*declaracion de variables*/
$vars['ly']=array();
/**/

/* /////////////////// RESCATE OPCIONES DEL SITIO ////////////////// */
$result_s = $sql->go("SELECT * FROM sitios WHERE id='".$_SESSION["sitio"]."'");
$vars['sitio'] = mysql_to_array($result_s);
/* ///////////////// FIN RESCATE OPCIONES DEL MENU //////////////// */


/* /////////////// VARIABLES GENERALES ////////////// */
$vars['titulo'] = $titulo;
$vars['path'] = $url_path;
$vars['theme'] = "theme/".$vars['sitio'][0]["theme"];
$vars['pie_pagina'] = $pie_pagina;
/* ///////////// FIN VARIABLES GENERALES //////////// */



/* /////////////// CONFIGURAICION LOGIN ////////////// */
if(isset($_SESSION['usuario_autentificado']))
	{
	$vars['logged'] = true;
	$vars['nombre_perfil'] = $_SESSION['nombre'];
	
	}
/* ///////////// FIN CONFIGURAICION LOGIN //////////// */






/* /////////////////// RESCATE MENU ////////////////// */
$vars['menu'] = get_menu(array('orderby'=> 'orden', 'order'=>'ASC', 'echo'=>0, 'sitio'=>$_SESSION["sitio"]));
/* ///////////////// FIN RESCATE MENU //////////////// */


/* /////////////////// RESCATE MULTISITIOS ////////////////// */
$vars['lang'] = get_lang(array('orderby'=> 'titulo', 'order'=>'ASC', 'format'=>'bandera', 'echo'=>0));
/* ///////////////// FIN RESCATE MULTISITIOS //////////////// */




if(isset($_GET[0]) and $_GET[0] == "pagina" and isset($_GET[1]))
	{	
	$result =	$sql->go("SELECT * FROM paginas WHERE url_amigable='".$_GET[1]."'");
	$vars['pagina'] = mysql_to_array($result);
	}
else
	{
	if($vars['sitio'][0]["portada"] == 'dinamica')
		{
		$result =	$sql->go("SELECT * FROM paginas WHERE id='".$vars['sitio'][0]["id_portada"]."'");
		$vars['pagina'] = mysql_to_array($result);
		}
	}


if(!isset($_GET[0]))
	{
	$mod = 0;
	}
else
	{
	$mod = $vars['pagina'][0]['id_modulo'];
	}




/* ////////////////// RESCATE FOOTER ////////////////// */
$vars['footer1'] = footer1($vars['path'], $_SESSION['sitio']);		// path;
/* //////////////// FIN RESCATE FOOTER //////////////// */



/* ////////////////// RESCATE LAYOUT ////////////////// */
if(isset ($_GET[1])){
   $rl =	$sql->go("SELECT * FROM paginas WHERE url_amigable='".$_GET[1]."'");
    $vars['ly'] = mysql_to_array($rl);
    $vars['layout'] = layout($vars['ly'][0]["id"],$_SESSION['usuario_autentificado']); 
}

/* //////////////// FIN RESCATE LAYOUT //////////////// */



/* ////////////////// RESCATE HEADER ////////////////// */

    $vars['header1'] = header1($vars['path'],$vars['ly'][0]["id"]);


$vars['header2'] = header2($vars['path'],$mod);
/* //////////////// FIN RESCATE HEADER //////////////// */



//var_dump($vars);


/* ////////////////////// PARSEO PAGINA ///////////////////// */
$html = dynamoParser::mergeFile("theme/".$vars['sitio'][0]["theme"]."/header.html",$vars);


if($_GET)
	{	
	$direccion = reDireccion($_GET);
	$html .= dynamoParser::mergeFile("theme/".$vars['sitio'][0]["theme"]."/".$direccion,$vars);
	}
else
	{
	if($vars['sitio'][0]["portada"] == 'dinamica')
		{
		$html .= dynamoParser::mergeFile("theme/".$vars['sitio'][0]["theme"]."/pagina.html",$vars);
		}
	else
		{
		$html .= dynamoParser::mergeFile("theme/".$vars['sitio'][0]["theme"]."/home.html",$vars);
		}
	}
$html .= dynamoParser::mergeFile("theme/".$vars['sitio'][0]["theme"]."/footer.html",$vars);
/* //////////////////// FIN PARSEO PAGINA /////////////////// */


echo $html;
exit;
?>