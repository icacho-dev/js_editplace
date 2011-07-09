<?php
// Cargar datos conexion y otras variables.
require ("../aut_config.inc.php");
include ("../aut_login.inc.php");
include ("../../lang/lang-esp.php");

//declaracion de instancias
$rs_sitio=""; //variable de Recordset
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

$rs_sitio =(mysql_query("SELECT * FROM sitios WHERE mostrar=1 order by orden",$conectar));


if($rs_sitio){

?>
<button id="create-sitio"><?php echo $_BUTTON_CREAR_SITIO; ?></button>

<div class="sitio" style="margin-top: 20px;">
<?php
        echo ("<ul id=\"sortable_sitio\">");
        while($filatmp=mysql_fetch_array($rs_sitio)){
            
            echo ("<li  class=\"ui-state-default\" id=" . $filatmp["id"] . ">");
                echo ($filatmp["titulo"]  . 
                            "  <div id='botones'>    " .
                                " <img src='". PATH_ROOT ."/img/btneditar.png' alt='boton de editar' class='editar' id='" .$filatmp['id'] . "'/>  " .
                                " <img id=" . $filatmp['id'] .  " class='delete' src='" .PATH_ROOT ."/img/btneliminar.png' alt='boton de Desabilitar'/></div>"   );
            echo ("</li>");
        }
        echo ("</ul>");
?>
</div>

<div id="dialog-form" style="display: none">
	<p class="validateTips"></p>
        <div id="loadAjax" style="display:none"> <img src="<?php echo(PATH_ROOT . "/img/ajax-loader.gif") ?>" /></div>

        <form id="frmsitio">
	<fieldset>
		<label for="txttitulo"><?php echo $_ETIQUETA_TITULO; ?></label>
		<input type="text" name="txttitulo" id="txttitulo" class="text ui-widget-content ui-corner-all" />
                <br />
                <br />
		<label for="txticono"><?php echo $_ETIQUETA_ICONO; ?></label>
		<input type="text" name="txticono" id="txticono" value="" class="text ui-widget-content ui-corner-all" />
                <br />
                <br />
		
	</fieldset>
	</form>
</div>

<?php
        mysql_close($conectar);
	exit;

	}


?>