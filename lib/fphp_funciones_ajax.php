<?php
include("fphp.php");
//mysql_select_db($database_conexion, $conexion);

if ($accion == "requerimiento_detalles_insertar") {
	if ($Tipo == "item") {
		
		$readonly = "readonly";
		$sql = "SELECT * FROM productos where id_producto='$Codigo'";
		$disabled_descripcion = "disabled";
		$id = $Codigo;
		
	} 
	
	$query = mysql_query($sql) or die($sql.mysql_error());
	
	if (mysql_num_rows($query) != 0) {
		$field_detalles = mysql_fetch_array($query);
		 $nombre = $field_detalles['nombre'];
		
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalle?>">
            <th align="center">
                <?=$nrodetalle?>
            </th>
            <td align="center">
            	<?=$field_detalles['codigo']?>
                <input type="hidden" name="id<?=$nrodetalle?>" class="cell2" style="text-align:center;" value="<?=$id?>" readonly />
                <input type="hidden" name="nrodetalle" class="cell2" style="text-align:center;" value="<?=$nrodetalle?>" readonly />
                 <input type="hidden" name="candetalle" class="cell2" style="text-align:center;" value="<?=$candetalle?>" readonly />
                
               
            </td>
            <td align="center">
                <textarea name="descripcion<?=$nrodetalle?>" disabled="disabled" style="height:30px;" class="cell" onBlur="this.style.height='30px';" onFocus="this.style.height='60px';"  ><?=$nombre?></textarea>
                 <input type="hidden" name="nombre<?=$nrodetalle?>" class="cell2" style="text-align:center;" value="<?=$nombre?>" readonly />
            </td>
            <td align="center">
                <input type="text" name="Cantidad<?=$nrodetalle?>"  id="Cantidad<?=$nrodetalle?>" onchange="sumaTotal(<?=$nrodetalle?>)" class="cell"   style="text-align:right; font-weight:bold;" value="0" />
            </td>
             <td align="center">
                <input type="text" name="costo<?=$nrodetalle?>" id="costo<?=$nrodetalle?>" class="cell" style="text-align:right; font-weight:bold;" value="0" onchange="sumaTotal2(<?=$nrodetalle?>)" onFocus="numeroFocus(this);" />
            </td>
             <td align="center">
                <input type="text" name="total<?=$nrodetalle?>" id="total<?=$nrodetalle?>" disabled="disabled"  class="amt" style="text-align:right; font-weight:bold; background-color:transparent; border:none; width:100%;"  />  
            </td>
		</tr>
         
       <?
	}
}

//	--------------------------
if ($accion == "requerimiento_pedido") {
	if ($Tipo == "item") {
		
		$readonly = "readonly";
		$sql = "SELECT * FROM productos where id_producto='$Codigo'";
		$disabled_descripcion = "disabled";
		$id = $Codigo;
		
	} 
	
	$query = mysql_query($sql) or die($sql.mysql_error());
	
	if (mysql_num_rows($query) != 0) {
		$field_detalles = mysql_fetch_array($query);
		 $nombre = $field_detalles['nombre'];
		
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalle?>">
            <td align="center">
            	<div style="color: #000;"><?=$field_detalles['codigo']?></div>
                <input type="hidden" name="id<?=$nrodetalle?>" class="cell2" style="text-align:center;" value="<?=$id?>" readonly />
                <input type="hidden" name="nrodetalle" class="cell2" style="text-align:center;" value="<?=$nrodetalle?>" readonly />
                 <input type="hidden" name="candetalle" class="cell2" style="text-align:center;" value="<?=$candetalle?>" readonly />
                
               
            </td>
            <td align="center">
                <input type="text"  name="descripcion<?=$nrodetalle?>" disabled="disabled" style="height:30px;" class="cell" onBlur="this.style.height='30px';" onFocus="this.style.height='60px';" value="<?=$nombre?>"  />
                 <input type="hidden" name="nombre<?=$nrodetalle?>" class="cell2" style="text-align:center;" value="<?=$nombre?>" readonly />
            </td>
            <td align="center">
                <input type="text" name="Cantidad<?=$nrodetalle?>" id="Cantidad<?=$nrodetalle?>"  class="cell" style="text-align:right; font-weight:bold;" onchange="sumaTotal(<?=$nrodetalle?>)" onclick="calculo()" value="0" />
            </td>
             <td align="center">
            <input type="text" name="disponible<?=$nrodetalle?>" id="disponible<?=$nrodetalle?>" class="cell2" style="text-align:center;" value="<?=$disponible?>" readonly />
            </td>
             <td align="center">
                <input type="text" name="costo<?=$nrodetalle?>" disabled="disabled"  class="cell" style="text-align:right; font-weight:bold;" value="<?=$precio?>"  onFocus="numeroFocus(this);" />
                <input type="hidden" name="precio<?=$nrodetalle?>" id="precio<?=$nrodetalle?>"  style="text-align:center;" value="<?=$precio?>" readonly />
            </td>
             <td align="center">
                <input type="text" name="total<?=$nrodetalle?>" id="total<?=$nrodetalle?>"  disabled="disabled"  class="amt" style="text-align:right; font-weight:bold; background-color:transparent; border:none; width:100%;"  />  
            </td>
		</tr>
         
       <?
	}
}

?>