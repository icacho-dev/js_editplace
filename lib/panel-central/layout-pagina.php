<?php
include ("../../lang/lang-esp.php");
require ("../aut_config.inc.php");
include ("../aut_login.inc.php");
require_once '../sql.php';
/*variables*/

$tmppage=explode("/",strrev($_SERVER['HTTP_REFERER']));
$page=strrev($tmppage[0]);
//
if( $page == ""){
    echo($page);
    exit();
}
/*ending of variables*/
$conectar = mysql_connect($sql_host, $sql_usuario, $sql_pass);

if (!$conectar){die('Problema en la Conexion: ' . mysql_error());}
mysql_select_db($sql_db);
?>


<?php
//other funciones
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
//ending
//function for check the div
        function checkpagezona($page,$conexion){
            $rs_zona="";
            $obj_zona="";
            $sc_zona="SELECT id,
                             id_pagina,
                             contenido,
                             id_modulo,
                             css,
                             padre,
                             orden,
                             class FROM
                             zona
                             WHERE
                             id_pagina = '" . $page . "'
                             ORDER BY orden";
            $rs_zona = mysql_query($sc_zona, $conexion) or die("Bug in Search");;
            $count_rows= mysql_num_rows($rs_zona);
            if($count_rows>0){
                while($obj_zona = mysql_fetch_object($rs_zona)){
                        echo("<div id='" .$obj_zona->id . "' class= '" . $obj_zona->class . "' style= '" . $obj_zona->css . "'>");
                        echo("<img id='" .$obj_zona->id . "' src='" . PATH_ROOT ."/img/btneditar.png' class='propiedades' />
                            <img src='" . PATH_ROOT ."/img/handle.png' class='handle' />
                            <img id='" .$obj_zona->id . "' src='" .  PATH_ROOT ."/img/btneliminar.png' class='eliminar' rel='" .$obj_zona->id . "' />");
                        echo("</div>");
                   
                    }

            }
        }
?>
<style type="text/css">

form
	{
	overflow:hidden;
	margin:0 auto;
	width:980px;
/*	padding:10px;*/
	}
  

#constructor img
	{
	float:right;
	top:0;
	margin-left:5px;
	}

.handle{
            cursor: move;
}
.propiedades{
            cursor: pointer;

}
.eliminar{
   cursor: pointer;
}
#grid12-content{
  
   padding: 0px 0px 0px 0px;
}
#grid12-content div{
    border:1px solid #000000;
    margin-left: 10px;
    margin-right: 0px;
    background-color: #84b4d8;
    margin-top: 3px;
    margin-bottom: 3px;
    cursor: pointer;
   
}
#grid12-content div p{
    padding: 5px;
    margin-right: 0px;
    margin-left: 0px;

}
#constructor{
   background-color: #CCCCCC;
   padding: 0px 0px 0px 0px;
   overflow:hidden;
   cursor: pointer;
   margin-left: 0px;
}
#constructor div{
 
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 5px;
    padding: 0px 0px 0px 0px;
    border:1px solid #000000;
    cursor: pointer;



}
#constructor .ui-selecting { background: #FECA40; }
#constructor .ui-selected { background: #F39814; color: white; }
#tbl-dialog tr,#tbl-dialog td {
    margin-bottom: 10px;
    margin-top: 15px;
    
}
</style>

<div id="contenedor">
    
    <div class="container_12">
        <div class="grid_3 alpha"><h5><?php echo $_ETIQUETA_LAYOUT; ?>:</h5></div>
        <div class="grid_7 omega">
       
        <select id="cmb-page" name="cmb-page"  >
                     <OPTION selected value=""><?php echo $_COPIAR_PAGINA; ?></OPTION>
                    <!-- codigo de insercion de Data -->
                     <?php
                            $idsitio = $_SESSION["sitio"];
                            $sql = new sql();
                            $query ="SELECT DISTINCT paginas.id,paginas.titulo 
                                        FROM paginas INNER JOIN zona 
                                        ON zona.id_pagina=paginas.id  
                                        WHERE
                                        paginas.id_sitio ='" . $idsitio . "'";
                            $sql->go($query);
                            
                            
                            $cont_rows = $sql->numRows();
                            
                            if ($cont_rows > 0){
                                while ($row = $sql->fetchArray()) {
                                ?>
                                <option value="<?php echo($row["id"]); ?>"> 
                                <?php echo($row["titulo"]); ?></option>
                            <?php
                                }//end while
                            }
                        ?>
         </select>
        
        </div>
        <div class="clear"></div>
    </div>
	 <div class="clear"></div>

         
         
         
        <div class="container_12" id="grid12-content">
	
	<div class="grid_12">
		<p>
			940
		</p>
	</div>
	<!-- end .grid_12 -->

	<div class="clear"></div>
	<div class="grid_1">
		<p>
			60
		</p>
	</div>
	<!-- end .grid_1 -->
	<div class="grid_11">
		<p>

			860
		</p>
	</div>
	<!-- end .grid_11 -->
	<div class="clear"></div>
	<div class="grid_2">
		<p>
			140
		</p>
	</div>

	<!-- end .grid_2 -->
	<div class="grid_10">
		<p>
			780
		</p>
	</div>
	<!-- end .grid_10 -->
	<div class="clear"></div>
	<div class="grid_3">

		<p>
			220
		</p>
	</div>
	<!-- end .grid_3 -->
	<div class="grid_9">
		<p>
			700
		</p>
	</div>

	<!-- end .grid_9 -->
	<div class="clear"></div>
	<div class="grid_4">
		<p>
			300
		</p>
	</div>
	<!-- end .grid_4 -->
	<div class="grid_8">

		<p>
			620
		</p>
	</div>
	<!-- end .grid_8 -->
	<div class="clear"></div>
	<div class="grid_5">
		<p>
			380
		</p>

	</div>
	<!-- end .grid_5 -->
	<div class="grid_7">
		<p>
			540
		</p>
	</div>
	<!-- end .grid_7 -->
	<div class="clear"></div>

	<div class="grid_6">
		<p>
			460
		</p>
	</div>
	<!-- end .grid_6 -->
	<div class="grid_6">
		<p>
			460
		</p>

	</div>
	<!-- end .grid_6 -->
	<div class="clear"></div>
	</div>
	<!-- end .grid_6.pull_6 -->
	<div class="clear"></div>
</div>

        <form name="frm-constructordeMaquetas" id="frm-maquetas" action="#" >
            <div id="constructor" style="border:1px solid #000000;" class="container_12">
             <?php
                    $tmppage=explode("/",strrev($_SERVER['HTTP_REFERER']));
                    $page=strrev($tmppage[0]);
                    $idpage=getIdPage($conectar, $page);
                    /*if the constructor have created the div*/
                    checkpagezona($idpage,$conectar);
                    /*fin*/      
             ?>
	   </div>
		<input name="guardar" id="guardar" type="button" value="<?php echo $_BUTTON_GUARDAR; ?>" />
	</form>

<div id="dialog-modal" style="display: none;">
    <form id="frm-layout" style="width:350px;">   
 <table id="tbl-dialog" border="0px">
     <tbody>
            <tr>
                <td>
                   <label for="Modulo">Modulo:</label> 
                </td>

                <td>
                

                 <select id="modulo" name="modulo"  >
                     <OPTION selected value="">Seleccionar un Modulo</OPTION>
                    <!-- codigo de insercion de Data -->
                     <?php
                            $sc_modulos ="select id_modulo,nombre from modulos where estado =1";
                            $rs_modulos = mysql_query($sc_modulos, $conectar);
                            $cont_rows = mysql_num_rows($rs_modulos);
                            if ($cont_rows > 0){
                                while ($row = mysql_fetch_object($rs_modulos)) {
                                ?>
                    <option value="<?php echo($row->id_modulo); ?>"> <?php echo($row->nombre); ?></option>
                            <?php
                                }//end while
                            }
                        ?>
                 </select>

                </td>
            </tr>
             
            <tr>
                
               <td colspan=2>
                
                <textarea rows="10" cols="48" name="txtcss" id="txtcss">
                </textarea>
                
                
                </td>
            </tr>
    </tbody>
</table>
</form>
</div>