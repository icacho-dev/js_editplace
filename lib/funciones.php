<?php
include ("aut_config.inc.php");
//include ("./../lang/lang-esp.php");
$result = '';

/* ////////////// FUNCION DE REDIRECCIONAMIENTO //////////////// */
/* Esta es una función muy simple y su finalidad es cargar un    */
/* template u otro dependiendo del o los valores que entregan en */
/* la URL del Navegador.                                         */
/* Ejemplo:   http://tusitio.com/pagina/quienes-somos            */
/* $url[0] => pagina                                             */
/* $url[1] => quienes-somos                                      */
/* ///////////////////////////////////////////////////////////// */
function reDireccion($url)
	{
	
	switch ($url[0])
		{
		case "pagina":
			if(array_key_exists(1, $url))
				{
				return "pagina.html";
				break;
				}
		case "login":
			return "login.html";
			break;
		case "acerca-de":
			return "acerca-de.html";
			break;
		case "pagina":
			return "pagina.html";
			break;
		case "tags":
			return "tags.html";
			break;
		case "ver-articulo":
			return "ver-articulo.html";
			break;
		default:
			return "404.html";
        	break;
		}
	}
/* //////////// FIN FUNCION DE REDIRECCIONAMIENTO ////////////// */








/* ////////////// FUNCION DE CAPTURA DE LA URL AMIGABLE //////////////// */
/* El .htaccess que esta en el directorio raiz de nuestro sitio nos      */
/* entrega la url completa que se encuentra inmediatamente despues al    */
/* Path, y por medio de esta funcion podemos obtener cada porcion de la  */
/* URL y poder ejecutar una u otra cosa                                  */
function getVariables($url)
	{
	$url = preg_replace('/\/$/', '', $url);
	$partes = explode('/', $url);
	$cantPartes = count($partes);
	if($cantPartes == 1 and $url=="") return false;
 	$variables = array();
	for($c = 0; $c < $cantPartes; $c++){$valor=limpiar($partes[$c]);$variables[$c] = $valor;}
	return $variables;
	}
function limpiar($valor)
	{
	return preg_replace('/[^a-zA-Z0-9-_]/', '', $valor);
	}
/* //////////// FIN FUNCION DE CAPTURA DE LA URL AMIGABLE ////////////// */





/* //////////// FUNCION PARA GENERAR URL AMIGABLE ////////////// */
/* Esta es una Funcion muy simple, y lo que hace es tomar una    */
/* frase que nosotros le entreguemos, por ejemplo el titulo de   */
/* un Artículo y eliminará todo caracter extraño como acentos,   */
/* ñ, simbolos aritmeticos, mayusculas, etc.                     */
/* Ejemplo: Lorem ípsum dolor sit & amet                         */
/* Quedara asi: lorem-ipsum-dolor-sit-amet                       */
function urls_amigables($url)
	{
	// Tranformamos todo a minusculas
	$url = strtolower($url);
	
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);
	
	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);
	
	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
	}
/* */


/* ////////////// FUNCION EXTRAE TROSOS DE TEXTO ////////////// */
/* Esta funcion es muy util cuando queremos extraer por ejemplo */
/* los primeros 200 caracteres de un articulo para poder mostrar*/
/* un resumen */
function cortar_texto($value,$lenght)
	{
	$limited=$value;
	if (strlen($value) >= $lenght )
		{
		$limited = substr($value,0,$lenght);
		$limited .= "...";
		}
	return $limited;
	}
/* //////////// FIN FUNCION EXTRAE TROSOS DE TEXTO //////////// */






/* ////////////// FUNCION EXTRAE TROSOS DE TEXTO ////////////// */
function mysql_to_array($resp)
	{
    $tabla_resp=array();
    $r=0;
    while($row = mysql_fetch_assoc($resp))
		{
        $arr_row=array();
        $c=0;
        while ($c < mysql_num_fields($resp))
			{
            $col = mysql_fetch_field($resp, $c);
            //$arr_row[$col -> name] = utf8_encode($row[$col -> name]);
			$arr_row[$col -> name] = $row[$col -> name];
            $c++;
        	}
        $tabla_resp[$r] = $arr_row;
        $r++;
    	}
    return $tabla_resp;
	}


function header1($path, $id)
	{
	$result = "
        <base href=\"$path\" >
        <link type=\"text/css\" href=\"$path/css/960.css\" rel=\"stylesheet\" />
        <link type=\"text/css\" href=\"$path/css/reset.css\" rel=\"stylesheet\" />
        <link type=\"text/css\" href=\"$path/css/jquery-ui-1.8.12.custom.css\" rel=\"stylesheet\" />
	<link type=\"text/css\" href=\"$path/css/style.css\" rel=\"stylesheet\" />
	<link type=\"text/css\" href=\"$path/css/droppy.css\" rel=\"stylesheet\" />
        <script type=\"text/javascript\" src=\"$path/js/jquery-1.5.1.min.js\"></script>

	<script type=\"text/javascript\" src=\"$path/js/UI/jquery.droppy.js\"></script>
       
       
    
	<script type=\"text/javascript\">
		$(document).ready(function()
			{
			$('.ocultar').click(function()
				{
				$('.ocultar').hide(1000);			
				});
			});
		$(function()
			{
			$('#nav').droppy({speed: 100});
			});

	</script>";
	
	if(isset($_SESSION['usuario_autentificado']))
		{
		$result.= "<script type=\"text/javascript\" src=\"$path/js/jquery-ui-1.8.12.custom.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.core.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.widget.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.mouse.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.resizable.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.selectable.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.draggable.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.droppable.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.sortable.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.livequery.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.datepicker.min.js\"></script>
				<script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.tabs.min.js\"></script>
				<script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.button.min.js\"></script>
				<script type=\"text/javascript\" src=\"$path/js/UI/ui.selectmenu.js\"></script>
				<script type=\"text/javascript\" src=\"$path/js/jFriendly.jquery.js\"></script>
				<script type=\"text/javascript\" src=\"$path/js/UI/jquery.validate.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/UI/jquery.ui.dialog.min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/json/taffy-min.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/Class/tools.js\"></script>
            <script type=\"text/javascript\" src=\"$path/js/Class/editorcss.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/Class/editPages.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/Class/layoutPages.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/Class/change-Clave.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/Class/sitio.js\"></script>
                <script type=\"text/javascript\" src=\"$path/js/Class/configuracion.js\"></script>
                

            <script type=\"text/javascript\">
		$(document).ready(function()
			{
			$('#pagina').jFriendly('#url');
			$('#frm_agregar_pagina').validate({ errorLabelContainer: $('.men-error')});
			});
            
		$(function() {
				$('#panel-central').resizable();
				});
		$(function()
			{
			$('.ag-pag').click(function()
				{
				var ide = $(this).attr('rel');
				var tit = $(this).attr('title');
				$('#'+ide).dialog({
					modal: true, width:700, title: tit, show: 'blind', hide: 'blind', close: function(event, ui)
						{
						window.location.reload();
						}
					});
				return false;
				});
			
			
			
			
			$('.ui-button').livequery('click', function ()
		        {
        		//alert($(this).attr('for'));
				if($(this).attr('for') == 'dinamica')
					$('#paginas-portada').show();
				if($(this).attr('for') == 'estatica')
					$('#paginas-portada').hide();
    		    });
			
			
			
			$('#menu-config').click(function()
				{
				$('#panel-central').slideToggle('slow');
         
				});
				
			
			
			$('#tabs-config').tabs({
                            
				ajaxOptions: {
					error: function( xhr, status, index, anchor ) {
						$(anchor.hash).html(\"Couldn't load this tab. We'll try to fix this as soon as possible. \" +
							\"If this wouldn't be a demo.\" );
                                                        
						}
					}, load: function()
					{ $( '#div-portada' ).buttonset(); $( '#portada-pagina' ).buttonset(); $( '#div-theme' ).buttonset(); }
				});
                         
                        
                         


                        

			$( '#div-padre' ).buttonset();
			$( '#div-modulo' ).buttonset();
			$( '#div-tipo' ).buttonset();
			$( '#div-publicado' ).buttonset();
			$( '#div-menu' ).buttonset();
			
			

	
				
				
				
			$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		
		
		$.validator.setDefaults(
			{
			submitHandler: function()
				{
				$.post($('#frm_agregar_pagina').attr('action'), $('#frm_agregar_pagina').serialize(), function(data)
						{
						var op = data.split(':');
						if(op[0] == 'ok')
					  		{
							$('.men-success').html(op[1]).fadeIn('slow');
					    	$('form').reset();
							}
						else
						  	{
							$('.men-error').html(op[1]).fadeIn('slow');
							}
						});
					return false;
				}
			});
		
		
		var v = jQuery('#form').validate(
			{
			submitHandler: function(form)
				{
				jQuery(form).ajaxSubmit({
					target: '#result'
					});
				}
			});
		
		
		jQuery.fn.reset = function ()
			{
			$(this).each (function() { this.reset(); });
			}

            
		</script>";
		
		
		
		
		
		/* / ////// / RESCATE DE MODULOS / ////// / */
		
		$sql = new sql();
		$query ="SELECT * FROM zona WHERE id_pagina = '" . $id ."'";
		
		$sql->go($query);
		$numrows = $sql->numRows();
		$arr_mod = array();
		if($numrows <> 0)
			{
			$resp = $sql->fetchAll();
			foreach($resp as $key => $row)
				{
				$query_mod ="SELECT * FROM modulos WHERE id_modulo = '" . $row["id_modulo"] ."'";
				$sql->go($query_mod);
				$row_mod = $sql->fetchArray();
				$arr_mod[] = $row_mod["directorio"];
				}
			}
		
		$arr_mod = array_unique ($arr_mod);
		$cont = count($arr_mod);
//		echo "<pre>";
//		var_dump($arr_mod);
//		echo "</pre>";
		
		for($i=0;$i<$cont;$i++)
			{
                            if(isset($arr_mod[$i])){
                                include("./mod/".$arr_mod[$i]."/header1.php");
                            }
			}
                
			
		}
	else
		{
		$result.= "<script type=\"text/javascript\">
		$(document).ready(function()
			{
			$('#entrar').click(function()
				{
				$.post('$path/lib/aut_verifica.inc.php', $('#loginform').serialize(), function(data)
					{
					if(data=='yes')
						document.location='$path';
					else
						$('.men-error').html('Usuario o Contrase&ntilde;a incorrecta').fadeIn('slow');
					});
				return false;
				});
			});
	
		</script>";
		}
		
	
	return $result;
	}

function header2($path,$modulo)
	{
        $result="";
	if(isset($_SESSION['usuario_autentificado']))
		{
		$result = "<div id=\"panel\">
    	    <ul>
        		<li><a href=\"".PATH_ROOT."\"><img src=\"$path/img/dashboard.png\" alt=\"Portada\" /></a></li>
            	<li><a class=\"pointer\" id=\"menu-config\"><img src=\"$path/img/config.png\" alt=\"Configuraci&oacute;n\" /></a></li>
				<li><a class=\"pointer\" id=\"menu-mod\"><img src=\"$path/img/mod.png\" alt=\"Modulos\" /></a></li>
	            <li><a href=\"$path/salir.php\"><img src=\"$path/img/salir.png\" alt=\"Salir\" /></a></li>
    	    </ul>
	    </div>";
		
				
		$result.="<div id='panel-central'>
				  	<div id=\"tabs-config\" style=\"width: 980px; margin:0 auto; text-align:left;\">
						<ul>
							<li><a href=\"".PATH_ROOT."/lib/panel-central/editar-paginas.php\" id='editar-web'>" . $_EDITAR_PAGINA. "</a></li>
							<li><a href=\"".PATH_ROOT."/lib/panel-central/layout-pagina.php\" id='layout-web'>" . $_LAYOUT_PAGINA . "</a></li>
							<li><a href=\"".PATH_ROOT."/lib/panel-central/sitios.php\" id='sitios'>" .  $_SITIOS . "</a></li>
							<li><a href=\"".PATH_ROOT."/lib/panel-central/configuracion.php\" id='configuracion'>" .  $_CONFIGURACION . "</a></li>
                                                        <li><a href=\"".PATH_ROOT."/lib/panel-central/modificar-contrasena.php\" id='modificar-clave'>" .  $_MODIFICAR_CLAVE . "</a></li>
						</ul>
					</div>
				  </div>";
		}
	$result.="<div class='men-error ocultar'>Campos requeridos: </div>";
	$result.="<div class='men-success ocultar'></div>";
	
	return $result;
	}

function footer1($path, $sitio){
        $result = "";
	if(isset($_SESSION['usuario_autentificado']))
		{
		$result = "


            <div id=\"ag-pagina\" title=\"\" style=\"display:none\">
			<form action=\"$path/lib/agrega_pagina.php\" method=\"post\" name=\"frm_agregar_pagina\" id=\"frm_agregar_pagina\">
				<b>Tipo de P&aacute;gina</b>
				<br />
				<div id=\"div-tipo\">
					<input type=\"radio\" id=\"tipo1\" name=\"tipo\" value=\"pagina\" checked=\"checked\" /><label for=\"tipo1\">Pagina</label>
					<input type=\"radio\" id=\"tipo2\" name=\"tipo\" value=\"enlace\" /><label for=\"tipo2\">Enlace</label>
				</div>
				
				<b>Padre?</b>
				<br />
				<div id=\"div-padre\">
					<input type=\"radio\" id=\"padre0\" name=\"padre\" value=\"0\" checked=\"checked\" /><label for=\"padre0\">Sin Padre</label>";
		
		/* /////////////////// RESCATE MODULOS ////////////////// */
		$query	= "SELECT * FROM paginas WHERE id_sitio='".$sitio."' and mostrar='1' and mostrar_menu='1' ORDER BY titulo DESC";
		$resp =	mysql_query($query);
		$vars['padre'] = mysql_to_array($resp);
		
		while (list($key, $value) = each($vars['padre']))
			{
			$result.="<input type=\"radio\" id=\"padre".$vars['padre'][$key]['id']."\" name=\"padre\" value=\"".$vars['padre'][$key]['id']."\" /><label for=\"padre".$vars['padre'][$key]['id']."\">".$vars['padre'][$key]['titulo']."</label>";
			}
		
		
		$result.= "</div>

				<br />
				<b>Nombre de la Nueva P&aacute;gina</b>
				<br />
				<input name=\"pagina\" id=\"pagina\" type=\"text\" class=\"ui-state-default ui-corner-all ui-state-active required\"  title=\"Titulo de la Pagina, \" size=\"35\" />
				<br />
				<b>URL Amigable</b>
				<br />
				<input name=\"url\" id=\"url\" type=\"text\" class=\"ui-state-default ui-corner-all ui-state-active required\"  title=\"Url Amigable, \" size=\"35\" />
				<br />";
                
		/* /////////////////// RESCATE MODULOS ////////////////// */
//		$query	= "SELECT * from modulos WHERE estado='1' order by nombre desc";
//		$resp =	mysql_query($query);
//		$vars['modulos'] = mysql_to_array($resp);
//
//		$c = 0;
//		$result.="<b>Modulo</b>
//				<br />
//				<div id=\"div-modulo\">";
//		while (list($key, $value) = each($vars['modulos']))
//			{
//			if($c == 0)
//				{
//				$result.="<input type=\"radio\" id=\"modulo".$vars['modulos'][$key]['id_modulo']."\" name=\"modulo\" value=\"".$vars['modulos'][$key]['id_modulo']."\" checked=\"checked\" /><label for=\"modulo".$vars['modulos'][$key]['id_modulo']."\">".$vars['modulos'][$key]['nombre']."</label>";
//				}
//			else
//				{
//				$result.="<input type=\"radio\" id=\"modulo".$vars['modulos'][$key]['id_modulo']."\" name=\"modulo\" value=\"".$vars['modulos'][$key]['id_modulo']."\" /><label for=\"modulo".$vars['modulos'][$key]['id_modulo']."\">".$vars['modulos'][$key]['nombre']."</label>";
//				}
//			$c++;
//			}
//		$result.="</div>";
		/* ///////////////// FIN RESCATE MODULOS //////////////// */
		
		$result.= "<br />
				<b>Publicado?</b>
				<br />
				<div id=\"div-publicado\">
					<input type=\"radio\" id=\"publicado1\" name=\"publicado\" value=\"1\" checked=\"checked\" /><label for=\"publicado1\">Publicar</label>
					<input type=\"radio\" id=\"publicado2\" name=\"publicado\" value=\"0\" /><label for=\"publicado2\">No Publicar</label>
				</div>
				
				<b>Mostrar en el Men&uacute;?</b>
				<br />
				<div id=\"div-menu\">
					<input type=\"radio\" id=\"menu1\" name=\"menu\" value=\"1\" checked=\"checked\" /><label for=\"menu1\">Mostrar</label>
					<input type=\"radio\" id=\"menu2\" name=\"menu\" value=\"0\" /><label for=\"menu2\">No Mostrar</label>
				</div>
				
				<input name=\"sitio\" type=\"hidden\" value=\"".$_SESSION["sitio"]."\" />
				<input type=\"submit\" name=\"guardar_pagina\" id=\"guardar_pagina\" value=\"Guardar\" class=\"ui-state-default ui-corner-all ui-state-active ui-button\" />
			</form>
		</div>";
        
		}
	
	
	return $result;
	}








function geraMenuAuto($id, $sitio)
	{
        $var="";
	$path = PATH_ROOT;
	$sql = new sql();
	$sql->go("SELECT * FROM paginas WHERE padre = '" . $id . "' and mostrar='1' and mostrar_menu='1' and id_sitio='".$sitio."' ORDER BY orden ASC");
	
	$numLinhas = $sql->numRows();
	for($i = 0; $i < $numLinhas; $i++)
		{
		$list = $sql->fetchArray();
		if (existeFilho($list["id"]) > 0)
			{
			if($list["tipo"]=="enlace")
				{
				$var .= "	<li><a href='#'>".$list["titulo"]."</a>\n";
				}
			if($list["tipo"]=="pagina")
				{
				$var .= "	<li><a href='".$path."/pagina/".$list["url_amigable"]."'>".$list["titulo"]."</a>\n";
				}
			//$var .= "	<li><a href=''>".$list["titulo"]."</a>\n";
			$var .= "		<ul>\n" . geraMenuAuto($list["id"], $sitio) . "    </ul>\n";
			$var .= "	</li>\n";
			}
		else
			{
			if($list["tipo"]=="enlace")
				{
				$var .= "	<li><a href='#'>".$list["titulo"]."</a>\n";
				}
			if($list["tipo"]=="pagina")
				{
				$var .= "	<li><a href='".$path."/pagina/".$list["url_amigable"]."'>".$list["titulo"]."</a>\n";
				}
			//$var .= "	<li><a href=\"$link\">".$list["titulo"]."</a></li>\n";
			}
		}
	if (strlen($var) > 0)
		return $var;
	else
		return false;
	}
function existeFilho($id)
	{
	$sql = new sql();
	$sql->go("SELECT * FROM paginas WHERE padre = '" . $id . "' and mostrar='1' and mostrar_menu='1' ORDER BY padre");
	return $sql->numRows();
	}

/*function create_html_list($result)
	{
	foreach ($result as $key => $value)
		{
		$path = PATH_ROOT;
			$res.= "<li><a href=\"".$path."/pagina/".$value["url_amigable"]."\">".$value["titulo"]."</a>";
		}
		return $res;
	}*/

function get_menu($args)
	{
	$sql = new sql();
    $orderby					= 'orden';
    $order						= 'ASC';
    $echo						= 1;
	$sitio						= 1;
	

	if(isset($args["orderby"]))
		$orderby = $args["orderby"];
	if(isset($args["order"]))
		$order = $args["order"];
	if(isset($args["echo"]))
		$echo = $args["echo"];
	if(isset($args["sitio"]))
		$sitio = $args["sitio"];
	
	$result= geraMenuAuto(0,$sitio);
	
	
	if($echo == 1)
		print_r($result);
	else
		return $result;
	}


function get_lang($args)
	{
        $res="";
	$path = PATH_ROOT;
	
	$sql = new sql();
    $orderby					= 'titulo';
    $order						= 'ASC';
    $echo						= 1;
	$format						= 'bandera'; // bandera o titulo
	

	if(isset($args["orderby"]))
		$orderby = $args["orderby"];
	if(isset($args["order"]))
		$order = $args["order"];
	if(isset($args["echo"]))
		$echo = $args["echo"];
	if(isset($args["format"]))
		$formar = $args["format"];
	
	
	
	
	$sql->go("SELECT * FROM sitios WHERE mostrar='1' ORDER BY $orderby $order");
	$result = $sql->fetchAll();
	
	if($formar == "bandera")
		{
		foreach ($result as $key => $value)
			{
			$res.= "<li><a href=\"".$path."/index.php?sitio=".$value["id"]."\"><img src='".$path."/img/".$value["icon"]."' alt='' \></a>";
			}
		}
	
	if($formar == "titulo")
		{
		foreach ($result as $key => $value)
			{
			$res.= "<li><a href=\"".$path."/index.php?sitio=".$value["id"]."\">".$value["titulo"]."</a>";
			}
		}
	
	if($echo == 1)
		print_r($res);
	else
		return $res;
	}




        
        /*codigo para despues quitar*/
function getPage(){
    /*get page*/
           $tmppage=explode("/",strrev($_SERVER['HTTP_REFERER']));
           $page=strrev($tmppage[0]);
           return $page;
}
function getIdPage($pagina){
    $sql = new sql();

    $sc_pagina ="SELECT id FROM paginas WHERE url_amigable = '" . $pagina ."'";
    $sql->go($sc_pagina);
   
    $count_rs=$sql->numRows();

    if ($count_rs  <>   0){
        $obj_pagina=  $sql->fetchArray();

        $pagina=$obj_pagina["id"];
    }else{
        $pagina=1;
    }
    /*fin de GetIDPage*/
    $sql->clearResult();
    return $pagina;
}

function layout($id,$autorizado)
	{
	$htmdiv ="";
	
	$sql = new sql();
	$query ="SELECT * FROM zona WHERE id_pagina = '" . $id ."' ORDER BY orden";
	
	$sql->go($query);
	$numrows = $sql->numRows();
	if($numrows <> 0)
		{
		$result = $sql->fetchAll();
		foreach($result as $key => $row)
			{
			$htmdiv.="<div id='" . $row["id"] ."' class='" . $row["class"] ."' style ='" . $row["css"] . "' >";
			
			$query_mod ="SELECT * FROM modulos WHERE id_modulo = '" . $row["id_modulo"] ."'";
			$sql->go($query_mod);
			$row_mod = $sql->fetchArray();
			if(isset($autorizado)){
			$htmdiv.="<img src='img/btneditar.png' rel='".$row["id"]."' class='propiedades ".$row_mod["directorio"]."' style='float:right; cursor:pointer' />";
                        }
			$htmdiv.=$row["contenido"];
			$htmdiv.="</div>";
			}
		/*while ($row = $sql->fetchArray())
			{
			$htmdiv.="<div id='" . $row["id"] ."' class='" . $row["class"] ."' style ='" . $row["css"] . "' >";
			
			$query_mod ="SELECT * FROM modulos WHERE id_modulo = '" . $row["id_modulo"] ."'";
			$sql->go($query_mod);
			$row_mod = $sql->fetchArray();
			
			$htmdiv.="<img src='img/btneditar.png' class='propiedades ".$row_mod["directorio"]."' style='float:right; cursor:pointer' />";
			$htmdiv.="</div>";
			}*/
		}
	return $htmdiv;
	}
?>
