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

$maxRows_subgrupo = 15;
$pageNum_subgrupo = 0;
if (isset($_GET['pageNum_subgrupo'])) {
  $pageNum_subgrupo = $_GET['pageNum_subgrupo'];
}
$startRow_subgrupo = $pageNum_subgrupo * $maxRows_subgrupo;

mysql_select_db($database_conexion, $conexion);
$query_subgrupo = "SELECT * FROM `sub-grupo`";
$query_limit_subgrupo = sprintf("%s LIMIT %d, %d", $query_subgrupo, $startRow_subgrupo, $maxRows_subgrupo);
$subgrupo = mysql_query($query_limit_subgrupo, $conexion) or die(mysql_error());
$row_subgrupo = mysql_fetch_assoc($subgrupo);

if (isset($_GET['totalRows_subgrupo'])) {
  $totalRows_subgrupo = $_GET['totalRows_subgrupo'];
} else {
  $all_subgrupo = mysql_query($query_subgrupo);
  $totalRows_subgrupo = mysql_num_rows($all_subgrupo);
}
$totalPages_subgrupo = ceil($totalRows_subgrupo/$maxRows_subgrupo)-1;




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<link href="css/letras.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css">
.centrar {
	text-align: center;
}

a{text-decoration:none}
</style>
<body>
<table width="763" border="0" cellpadding="0" cellspacing="0"  >
  <tbody>
    <tr>
      <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
      <td colspan="5" align="center" valign="center" background="imagenes/v_back_sup.jpg" class="tituloDOSE_3"><span class="negrita">Consulta de Sub-Grupos</span></td>
      <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
    </tr>
    <tr align="center">
      <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
      <td width="129"  valign="baseline" bgcolor="#6da6e2"class="letras">Grupo</td>
      <td width="168"  valign="baseline" bgcolor="#6da6e2"class="letras">Nombre</td>
      <td width="293" valign="baseline" bgcolor="#6da6e2" class="letras">Descripcion</td>
      <td width="86" valign="baseline" bgcolor="#6da6e2" class="letras">Opciones</td>
      <td width="62" valign="baseline" bgcolor="#6da6e2" class="letras">Opciones</td>
      <td background="imagenes/v_back_der.gif">&nbsp;</td>
    </tr>
    <?php do { 
	
	mysql_select_db($database_conexion, $conexion);
	$query_grupo = "SELECT * FROM grupo where id_grupo='$row_subgrupo[grupo]'";
	$grupo = mysql_query($query_grupo, $conexion) or die(mysql_error());
	$row_grupo = mysql_fetch_assoc($grupo);
	$totalRows_grupo = mysql_num_rows($grupo);

$queryString_subgrupo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_subgrupo") == false && 
        stristr($param, "totalRows_subgrupo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_subgrupo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_subgrupo = sprintf("&totalRows_subgrupo=%d%s", $totalRows_subgrupo, $queryString_subgrupo);
	
	
	?>
    <tr class="trListaBody" onclick="mClk(this, 'registro');" id="<?php echo $row_prod['id_productos']; ?>">
      <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
      <td align="center" ><?php echo $row_grupo['nombre']; ?></td>
      <td align="center" ><?php echo $row_subgrupo['nombre']; ?></td>
      <td align="center"><?php echo $row_subgrupo['descrpcion']; ?></td>
      <td align="center"><a href="modificar_subgrupo.php?id=<?php echo $row_subgrupo['id_subgrupo']; ?>">
        <input type="button"  value="Modificar" />
      </a></td>
      <td align="center"><a href="eliminar_subgrupos.php?id=<?php echo $row_subgrupo['id_subgrupo']; ?>">
        <input type="button"  value="Eliminar" />
      </a></td>
      <td background="imagenes/v_back_der.gif">&nbsp;</td>
    </tr>
    <?php } while ($row_subgrupo = mysql_fetch_assoc($subgrupo)); ?>
    <tr>
      <td background="imagenes/v_back_izq.gif" height="1" width="13"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
      <td colspan="5" class="tituloDOSE_2"><table border="0" align="center">
          <tr>
            <td><?php if ($pageNum_subgrupo > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_subgrupo=%d%s", $currentPage, 0, $queryString_subgrupo); ?>"><img src="First.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_subgrupo > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_subgrupo=%d%s", $currentPage, max(0, $pageNum_subgrupo - 1), $queryString_subgrupo); ?>"><img src="Previous.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_subgrupo < $totalPages_subgrupo) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_subgrupo=%d%s", $currentPage, min($totalPages_subgrupo, $pageNum_subgrupo + 1), $queryString_subgrupo); ?>"><img src="Next.gif" /></a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_subgrupo < $totalPages_subgrupo) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_subgrupo=%d%s", $currentPage, $totalPages_subgrupo, $queryString_subgrupo); ?>"><img src="Last.gif" /></a>
                <?php } // Show if not last page ?></td>
          </tr>
      </table></td>
      <td background="imagenes/v_back_der.gif" width="12"></td>
    </tr>
    <tr>
      <td align="left" height="1" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
      <td height="1" colspan="5" background="imagenes/v_back_inf.gif"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
      <td align="right" height="1" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($subgrupo);

mysql_free_result($grupo);
?>
