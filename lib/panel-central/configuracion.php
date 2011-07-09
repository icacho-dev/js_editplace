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

$rs_config =(mysql_query("SELECT * FROM configuracion WHERE id ='1'",$conectar));
$da_config=mysql_fetch_object($rs_config);

$rs_sitio =(mysql_query("SELECT * FROM sitios WHERE id ='".$_SESSION['sitio']."'",$conectar));
$da_sitio=mysql_fetch_object($rs_sitio);


?>

<form id="frm-configuracion" name="frm-configuracion" method="post">
	<b><?php echo $_ETIQUETA_EMAIL; ?></b>
    <br />
    <div>
        <input name="txtemail" id="txtemail" type="text" value="<?php echo $da_config->email?>" class="ui-state-default ui-corner-all ui-state-active required" />
    </div>
    <br />
    <b>Render Portada</b>
    <br />
    <div id="div-portada">
    <input type="radio" id="dinamica" name="portada" class="portada-class" value="dinamica" <?php if($da_sitio->portada == "dinamica") echo "checked='checked'"; ?> /><label for="dinamica">Dinamica</label>
    <input type="radio" id="estatica" name="portada" class="portada-class" value="estatica" <?php if($da_sitio->portada == "estatica") echo "checked='checked'"; ?> /><label for="estatica">Estatica</label>
    </div>
    
    <div id="paginas-portada" <?php if($da_sitio->portada == "estatica") echo "style='display:none'"; ?>>
        <div id="portada-pagina">
            <?php
            $rs_portada =(mysql_query("SELECT * FROM paginas WHERE id_sitio ='".$_SESSION['sitio']."' and mostrar='1'",$conectar));
            while($da_portada=mysql_fetch_object($rs_portada))
                {
                if($da_sitio->id_portada == $da_portada->id)
                    {
                    ?>
                    <input type="radio" id="portada-<?php echo $da_portada->id?>" name="portada_pagina" value="<?php echo $da_portada->id?>" checked="checked" /><label for="portada-<?php echo $da_portada->id?>"><?php echo $da_portada->titulo?></label>
                    <?php
                    }
				else
                    {
                    ?>
                    <input type="radio" id="portada-<?php echo $da_portada->id?>" name="portada_pagina" value="<?php echo $da_portada->id?>" /><label for="portada-<?php echo $da_portada->id?>"><?php echo $da_portada->titulo?></label>
                    <?php
                	}
            	}
        	?>
 		</div>
    </div>
    
    <br />
    <b><?php echo $_ETIQUETA_TEMPLATE ?></b>
    <br />
    <div id="div-theme">
	    <input type="radio" id="<? echo $da_sitio->theme?>" name="theme" value="<? echo $da_sitio->theme?>" checked="checked" /><label for="<? echo $da_sitio->theme?>"><? echo $da_sitio->theme?></label>
    <?php
	$ruta = "../../theme/";
        $dh="";
    if ($dh == opendir($ruta))
		{
		while (($file = readdir($dh)) !== false)
			{
			if (is_dir($ruta.$file) && $file!="." && $file!="..")
				{
				if($da_sitio->theme != $file)
					{
					?>
    	            <input type="radio" id="<? echo $file?>" name="theme" value="<? echo $file?>" /><label for="<? echo $file?>"><? echo $file?></label>
        	        <?php
					}
				}
			}
		closedir($dh);
		}
		
	
	?>
    </div>
    <br />
    <br />
    <input id="send" name="send" type="submit" value="Guardar" class="ui-state-default ui-corner-all ui-state-active" />
</form>
<?php
mysql_close($conectar);
exit;
?>