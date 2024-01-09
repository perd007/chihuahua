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

$maxRows_prod = 10;
$pageNum_prod = 0;
if (isset($_GET['pageNum_prod'])) {
  $pageNum_prod = $_GET['pageNum_prod'];
}
$startRow_prod = $pageNum_prod * $maxRows_prod;

mysql_select_db($database_conexion, $conexion);
$query_prod = "SELECT * FROM productos";
$query_limit_prod = sprintf("%s LIMIT %d, %d", $query_prod, $startRow_prod, $maxRows_prod);
$prod = mysql_query($query_limit_prod, $conexion) or die(mysql_error());
$row_prod = mysql_fetch_assoc($prod);

if (isset($_GET['totalRows_prod'])) {
  $totalRows_prod = $_GET['totalRows_prod'];
} else {
  $all_prod = mysql_query($query_prod);
  $totalRows_prod = mysql_num_rows($all_prod);
}
$totalPages_prod = ceil($totalRows_prod/$maxRows_prod)-1;

$queryString_prod = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_prod") == false && 
        stristr($param, "totalRows_prod") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_prod = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_prod = sprintf("&totalRows_prod=%d%s", $totalRows_prod, $queryString_prod);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" rel="stylesheet" type="text/css" />
<link href="css/letras.css" rel="stylesheet" type="text/css" />
<title>Documento sin título</title>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" width="755" >
  <tbody>
    <tr>
      <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
      <td colspan="4" align="center" valign="center" background="imagenes/v_back_sup.jpg" class="tituloDOSE_3"><span class="negrita">Ultimos Costos de Compra</span></td>
      <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
    </tr>
    <tr align="center" class="letras">
      <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
      <td width="227"  valign="baseline" bgcolor="#6da6e2"class="negrita">Nombre</td>
      <td width="190" valign="baseline" bgcolor="#6da6e2" class="negrita"><label for="tipo2">Marca</label></td>
      <td width="177" valign="baseline" bgcolor="#6da6e2" class="negrita">Codigo</td>
      <td width="134" valign="baseline" bgcolor="#6da6e2" class="negrita">Precio</td>
      <td background="imagenes/v_back_der.gif">&nbsp;</td>
    </tr>
    <?php do {
		
		mysql_select_db($database_conexion, $conexion);
		$query_precios = "SELECT * FROM precios where id_producto='$row_prod[id_producto]' order by id_precios desc";
		$precios = mysql_query($query_precios, $conexion) or die(mysql_error());
		$row_precios = mysql_fetch_assoc($precios);
		
		 ?>
    <tr class="trListaBody" onclick="mClk(this, 'registro');" id="<?php echo $row_prod['id_producto']; ?>">
      <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
      <td align="center" ><?php echo $row_prod['nombre']; ?></td>
      <td align="center"><?php echo $row_prod['marca']; ?></td>
      <td align="center"><?php echo $row_prod['codigo']; ?></td>
      <td align="center"><?php echo $row_precios['precio'];?></td>
      <td background="imagenes/v_back_der.gif">&nbsp;</td>
    </tr>
    <?php } while ($row_prod = mysql_fetch_assoc($prod)); ?>
    <tr>
      <td background="imagenes/v_back_izq.gif" height="1" width="15"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
      <td colspan="4" class="tituloDOSE_2">&nbsp;
        <table border="0" align="center">
          <tr>
            <td><?php if ($pageNum_prod > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_prod=%d%s", $currentPage, 0, $queryString_prod); ?>"><img src="imagenes/First.gif" /></a>
              <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_prod > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_prod=%d%s", $currentPage, max(0, $pageNum_prod - 1), $queryString_prod); ?>"><img src="imagenes/Previous.gif" /></a>
              <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_prod < $totalPages_prod) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_prod=%d%s", $currentPage, min($totalPages_prod, $pageNum_prod + 1), $queryString_prod); ?>"><img src="imagenes/Next.gif" /></a>
              <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_prod < $totalPages_prod) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_prod=%d%s", $currentPage, $totalPages_prod, $queryString_prod); ?>"><img src="imagenes/Last.gif" /></a>
              <?php } // Show if not last page ?></td>
          </tr>
        </table></td>
      <td background="imagenes/v_back_der.gif" width="12"></td>
    </tr>
    <tr>
      <td align="left" height="1" width="15"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
      <td height="1" colspan="4" background="imagenes/v_back_inf.gif"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
      <td align="right" height="1" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>