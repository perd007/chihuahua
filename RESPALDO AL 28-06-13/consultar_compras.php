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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_compras = 15;
$pageNum_compras = 0;
if (isset($_GET['pageNum_compras'])) {
  $pageNum_compras = $_GET['pageNum_compras'];
}
$startRow_compras = $pageNum_compras * $maxRows_compras;

mysql_select_db($database_conexion, $conexion);
$query_compras = "SELECT * FROM compras";
$query_limit_compras = sprintf("%s LIMIT %d, %d", $query_compras, $startRow_compras, $maxRows_compras);
$compras = mysql_query($query_limit_compras, $conexion) or die(mysql_error());
$row_compras = mysql_fetch_assoc($compras);

if (isset($_GET['totalRows_compras'])) {
  $totalRows_compras = $_GET['totalRows_compras'];
} else {
  $all_compras = mysql_query($query_compras);
  $totalRows_compras = mysql_num_rows($all_compras);
}
$totalPages_compras = ceil($totalRows_compras/$maxRows_compras)-1;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/funciones.js" charset="utf-8"></script>
<title>Documento sin título</title>
<style type="text/css">
.centrar {
	text-align: center;
	color:#EFEFEF;
}

a{text-decoration:none}
</style>

<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar este Compra?');
			if(valor==false){
			return false;
			}
			else{
			return true;
			}
		
}
//-->
</script>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" width="760" >
  <tbody>
    <tr>
      <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
      <td colspan="5" align="center" valign="center" background="imagenes/v_back_sup.jpg" class="tituloDOSE_3"><span class="negrita">Visualizar Compras </span></td>
      <td align="right" height="1" width="13"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
    </tr>
    <tr align="center" class="centrar">
      <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
      <td width="103"  valign="baseline" bgcolor="#c3131e"class="negrita">Fecha</td>
      <td width="122" valign="baseline" bgcolor="#c3131e" class="negrita"><label for="tipo2">N° Factura</label></td>
      <td width="375" valign="baseline" bgcolor="#c3131e" class="negrita">Proveedor</td>
      <td width="68" valign="baseline" bgcolor="#c3131e" class="negrita">Opciones</td>
      <td width="66" valign="baseline" bgcolor="#c3131e" class="negrita">Opciones</td>
      <td background="imagenes/v_back_der.gif">&nbsp;</td>
    </tr>
    <?php 
	mysql_select_db($database_conexion, $conexion);
	$query_proveedores = "SELECT * FROM proveedor where rif='$row_compras[proveedor]'";
	$proveedores = mysql_query($query_proveedores, $conexion) or die(mysql_error());
	$row_proveedores = mysql_fetch_assoc($proveedores);
	$totalRows_proveedores = mysql_num_rows($proveedores);

	
	?>
    <?php do { ?>
      <tr class="trListaBody" onclick="mClk(this, 'registro');" id="<?php echo $row_prod['id_productos']; ?>">
        <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
        <td align="center" ><?php echo $row_compras['fecha']; ?></td>
        <td align="center"><?php echo $row_compras['num_fac']; ?></td>
        <td align="center"><?php echo $row_proveedores['nombre']; ?></td>
        <td align="center"><a href="modificar_compras.php?factura=<?php echo $row_compras['num_fac']; ?>">
          <input type="button"  value="Modificar" />
        </a></td>
        <td align="center"><a onclick='return validar()' href="eliminar_compras.php?id=<?php echo $row_compras['id_compras']; ?>&factura=<?php echo $row_compras['num_fac']; ?>">
          <input type="button"  value="Eliminar" />
        </a></td>
        <td background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <?php } while ($row_compras = mysql_fetch_assoc($compras)); ?>

<tr>
      <td background="imagenes/v_back_izq.gif" height="1" width="13"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
      <td colspan="5" class="tituloDOSE_2"><table border="0" align="center">
          <tr>
            <td><?php if ($pageNum_compras > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_compras=%d%s", $currentPage, 0, $queryString_compras); ?>"><img src="First.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_compras > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_compras=%d%s", $currentPage, max(0, $pageNum_compras - 1), $queryString_compras); ?>"><img src="Previous.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_compras < $totalPages_compras) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_compras=%d%s", $currentPage, min($totalPages_compras, $pageNum_compras + 1), $queryString_compras); ?>"><img src="Next.gif" /></a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_compras < $totalPages_compras) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_compras=%d%s", $currentPage, $totalPages_compras, $queryString_compras); ?>"><img src="Last.gif" /></a>
                <?php } // Show if not last page ?></td>
          </tr>
      </table></td>
      <td background="imagenes/v_back_der.gif" width="13"><img src="imagenes/cargar_productos.php" alt="1" height="2" width="13" /></td>
    </tr>
    <tr>
      <td align="left" height="1" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
      <td height="1" colspan="5" background="imagenes/v_back_inf.gif"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
      <td align="right" height="1" width="13"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($compras);

mysql_free_result($proveedores);
?>
