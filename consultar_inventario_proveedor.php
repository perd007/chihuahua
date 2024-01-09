<?php require_once('Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


$maxRows_productos = 20;
$pageNum_productos = 0;
if (isset($_GET['pageNum_productos'])) {
  $pageNum_productos = $_GET['pageNum_productos'];
}
$startRow_productos = $pageNum_productos * $maxRows_productos;

mysql_select_db($database_conexion, $conexion);
$query_productos = "SELECT compras.num_fac, compra_productos.factura, compra_productos.producto as id, count(compra_productos.producto) from compras
inner join compra_productos
on compras.num_fac=compra_productos.factura and compras.proveedor='$_POST[rif]'
group by compra_productos.producto";
$query_limit_productos = sprintf("%s LIMIT %d, %d", $query_productos, $startRow_productos, $maxRows_productos);
$productos = mysql_query($query_limit_productos, $conexion) or die(mysql_error());
$row_productos = mysql_fetch_assoc($productos);

if (isset($_GET['totalRows_productos'])) {
  $totalRows_productos = $_GET['totalRows_productos'];
} else {
  $all_productos = mysql_query($query_productos);
  $totalRows_productos = mysql_num_rows($all_productos);
}
$totalPages_productos = ceil($totalRows_productos/$maxRows_productos)-1;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<link href="css.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/custom-theme/jquery-ui-1.8.16.custom.css" charset="utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" charset="utf-8" />
<link type="text/css" rel="stylesheet" href="css/prettyPhoto.css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>

<script type="text/javascript" src="js2/jquery-1.7.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js2/jquery-ui-1.8.16.custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js2/jquery.prettyPhoto.js" charset="utf-8"></script>
<script type="text/javascript" src="js2/funciones.js" charset="utf-8"></script>
<script type="text/javascript" src="js2/fscript.js" charset="utf-8"></script>

<script type="text/javascript" src="js/jquery-1.7.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js" charset="utf-8"></script>
<script type="text/javascript" src="js/funciones.js" charset="utf-8"></script>
<script type="text/javascript" src="js/fscript.js" charset="utf-8"></script>
<script type="text/javascript" src="js/funciones.js" charset="utf-8"></script>
<script type="text/javascript" src="js/fscript.js" charset="utf-8"></script>
<script type="text/javascript" src="js/form.js" charset="utf-8"></script>
<style type="text/css"> 
    @import url("jscalendar-1.0/calendar-win2k-cold-1.css");
    </style>
    
 <script language="JavaScript">
function enviar(){
if(document.form1.rif.value!=""){
	
document.form1.submit();}
 }
</script>
<body>
<!-- pretty -->
<span class="gallery clearfix"></span>
<form id="form1" name="form1" method="post" action="consultar_inventario_proveedor.php">
<table align="left" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="759"><table border="0" cellpadding="0" cellspacing="0" width="742">
        <tbody>
          <tr>
            <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
            <td class="tituloDOSE_3" align="center" background="imagenes/v_back_sup.jpg" valign="center"><span class="negrita">Consulta de Inventario Segun Proveedor</span></td>
            <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
          </tr>
          <tr>
            <td background="imagenes/v_back_izq.gif" height="1" width="13"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
            <td class="tituloDOSE_2"><table border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td align="right"></td>
                </tr>
                <tr>
                  <td align="center" width="140"><table cellpadding="3" cellspacing="0" width="689">
                    <tbody>
                      <tr>
                        <td width="119" align="right" valign="baseline" nowrap="nowrap">Proveedor:</td>
                        <td colspan="3" valign="baseline" class="gallery clearfix"><input name="rif" id="rif" readonly="readonly" onchange="enviar()" value="<?=$_POST["rif"]?>" type="text" size="17" maxlength="12" />
                          <input name="proveedor" value="<?=$_POST["proveedor"]?>" id="proveedor" readonly="readonly" type="text" size="70" maxlength="46" />
                          <a  href="listaproveedores.php?iframe=true&amp;width=950&amp;height=525" target="_blank" rel="prettyPhoto[iframe1]" ><img src="imagenes/f_boton.png" alt="" width="20" style="cursor:pointer;" title="Seleccionar" align="absbottom" /></a>
                          <input type="hidden" name="TipoClasificacion" id="FlagCompras" value="C" /></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center"  class="negrita"><table width="699" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <th scope="col"><div id="para1"  class="negrita"/></div></th>
                            <th scope="col"><div id="para2" class="negrita"/></div></th>
                            <th scope="col"><div id="para3" class="negrita"/></div></th>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center" background="imagenes/v_back_sup.jpg" class="negrita">Productos</td>
                      </tr>
                      <tr>
                        <td class="tituloDOSE_2" align="left">&nbsp;</td>
                        <td width="211" valign="baseline">&nbsp;</td>
                        <td width="55" align="right" valign="baseline" nowrap="nowrap">&nbsp;</td>
                        <td width="297" align="right" valign="baseline"  class="gallery clearfix">
                          <input type="submit"  class="btLista" value="BUSCAR" id="btItem"  /></td>
                      </tr>
                      <tr>
                        <td colspan="4" ><table width="700" align="center" class="tblLista">
                          <thead>
                            <tr>
                              <th width="79">Codigo</th>
                              <th width="281" >Descripcion</th>
                              <th  width="131">Precio</th>
                              <th  width="131">Disponibilidad</th>
                              </tr>
 
                            <?php do { 
							
				mysql_select_db($database_conexion, $conexion);
				$query_productos2 = "SELECT * FROM productos where id_producto='$row_productos[id]' ";
				$productos2 = mysql_query($query_productos2, $conexion) or die(mysql_error());
				$row_productos2 = mysql_fetch_assoc($productos2);
				$totalRows_productos2 = mysql_num_rows($productos2);			
							
				mysql_select_db($database_conexion, $conexion);
				$query_precios = "SELECT * FROM precios where id_producto='$row_productos2[id_producto]' order by id_precios desc";
				$precios = mysql_query($query_precios, $conexion) or die(mysql_error());
				$row_precios = mysql_fetch_assoc($precios);
				$totalRows_precios = mysql_num_rows($precios);
							
                            //consultamos disponibilidad
							$query_almacen1 = "SELECT sum(cantidad) FROM almacen where id_producto='$row_productos2[id_producto]' and (transaccion='COMPRA' or transaccion='COMPRA-MODIFICADA') ";
							$almacen1 = mysql_query($query_almacen1, $conexion) or die(mysql_error());
							$row_almacen1 = mysql_fetch_assoc($almacen1);
							
							$query_almacen2 = "SELECT sum(cantidad) FROM almacen where  id_producto='$row_productos2[id_producto]' and transaccion='VENTA' ";
							$almacen2 = mysql_query($query_almacen2, $conexion) or die(mysql_error());
							$row_almacen2 = mysql_fetch_assoc($almacen2);
							
							$query_pedido = "SELECT sum(cantidad) FROM pedido_productos where  id_producto='$row_productos2[id_producto]' ";
							$pedido = mysql_query($query_pedido, $conexion) or die(mysql_error());
							$row_pedido = mysql_fetch_assoc($pedido);
							
							$query_almacen3 = "SELECT sum(cantidad) FROM almacen where  id_producto='$row_productos2[id_producto]' and transaccion='EXTRAIDO' ";
							$almacen3 = mysql_query($query_almacen3, $conexion) or die(mysql_error());
							$row_almacen3 = mysql_fetch_assoc($almacen3);
							
							$query_apartado = "SELECT sum(cantidad) FROM productos_apartados where  id_producto='$row_productos2[id_producto]' ";
							$apartado = mysql_query($query_apartado, $conexion) or die(mysql_error());
							$row_apartado = mysql_fetch_assoc($apartado);
							
							$disponible=$row_almacen1["sum(cantidad)"]-$row_almacen2["sum(cantidad)"]-$row_pedido["sum(cantidad)"]-$row_almacen3["sum(cantidad)"]-$row_apartado["sum(cantidad)"];
						
							//
							
							?>
                              <tr>
                                <td align="center"><?php echo $row_productos2['codigo']; ?></td>
                                <td align="center"><?php echo $row_productos2['nombre']; ?></td>
                                <td align="center"><?php echo $row_precios['precio']; ?></td>
                                <td align="center"><?php echo $disponible; ?></td>
                              </tr>
                              <?php } while ($row_productos = mysql_fetch_assoc($productos)); ?>
                          </thead>
                          <tbody id="lista_detalles">
                          </tbody>
                        </table></td>
                      </tr>
                      <tr >
                        <td colspan="4"></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td align="right" width="80%"></td>
                </tr>
              </tbody>
            </table></td>
            <td background="imagenes/v_back_der.gif" width="12"><img src="imagenes/cargar_productos.php" alt="1" height="2" width="13" /></td>
          </tr>
          <tr>
            <td align="left" height="1" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
            <td background="imagenes/v_back_inf.gif" height="1" width="717"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
            <td align="right" height="1" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr> </tr>
  </tbody>
</table>
<input type="hidden" name="id_productos" id="id_productos" value="h" />
</form>
</body>
</html>
<?php
mysql_free_result($productos);

mysql_free_result($precios);

mysql_free_result($productos2);
?>
