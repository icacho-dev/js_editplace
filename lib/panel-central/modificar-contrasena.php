<?php
include ("../../lang/lang-esp.php");
?>
<div id="mensaje" style="display: none;">
aca ira el mensaje
</div>


<form action="$path/lib/agrega_pagina.php" method="post" name="frm_change_clave" id="frm_change_clave">
	<b><?php echo $_ETIQUETA_ACTUAL_CLAVE; ?></b>
	<br />
	<input name="txtclave" id="txtclave" type="password" class="ui-state-default ui-corner-all ui-state-active required"  title="clave actual, " size="35" />
	<br />
	<b><?php echo $_ETIQUETA_CLAVE_NUEVA; ?></b>
	<br />
	<input name="txtnewclave" id="txtnewclave" type="password" class="ui-state-default ui-corner-all ui-state-active required"  title="Nueva Clave, " size="35" />
    <br>
    <b><?php echo $_ETIQUETA_CONFIRMAR_CLAVE; ?></b>
	<br />
	<input name="txtnewclave2" id="txtnewclave2" type="password" class="ui-state-default ui-corner-all ui-state-active required"  title="Nueva Clave, " size="35" />
	<br />
    <br />
    <input type="submit" name="btn-change-clave" id="btn-change-clave" value="Actualizar" class="ui-state-default ui-corner-all ui-state-active ui-button" />
</form>