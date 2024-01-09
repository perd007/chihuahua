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

$maxRows_grupo = 10;
$pageNum_grupo = 0;
if (isset($_GET['pageNum_grupo'])) {
  $pageNum_grupo = $_GET['pageNum_grupo'];
}
$startRow_grupo = $pageNum_grupo * $maxRows_grupo;

mysql_select_db($database_conexion, $conexion);
$query_grupo = "SELECT * FROM grupo";
$query_limit_grupo = sprintf("%s LIMIT %d, %d", $query_grupo, $startRow_grupo, $maxRows_grupo);
$grupo = mysql_query($query_limit_grupo, $conexion) or die(mysql_error());
$row_grupo = mysql_fetch_assoc($grupo);

if (isset($_GET['totalRows_grupo'])) {
  $totalRows_grupo = $_GET['totalRows_grupo'];
} else {
  $all_grupo = mysql_query($query_grupo);
  $totalRows_grupo = mysql_num_rows($all_grupo);
}
$totalPages_grupo = ceil($totalRows_grupo/$maxRows_grupo)-1;

$queryString_grupo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_grupo") == false && 
        stristr($param, "totalRows_grupo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_grupo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_grupo = sprintf("&totalRows_grupo=%d%s", $totalRows_grupo, $queryString_grupo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" rel="stylesheet" type="text/css" />
<link href="CSS/letras.css" rel="stylesheet" type="text/css" />
<title>Documento sin título</title>
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar este Grupo?');
			if(valor==false){
			return false;
			}
			else{
			return true;
			}
		
}
//-->
</script>
<style type="text/css">
.centrar {
	text-align: center;
}

a{text-decoration:none}
</style>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="664" >
  <tbody>
    <tr>
      <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
      <td colspan="4" align="center" valign="center" background="imagenes/v_back_sup.jpg" class="tituloDOSE_3"><span class="negrita">Consulta de Grupos</span></td>
      <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
    </tr>
    <tr align="center" class="letras">
      <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
      <td width="200"  valign="baseline" bgcolor="#6da6e2"class="negrita">Nombre</td>
      <td width="276" valign="baseline" bgcolor="#6da6e2" class="negrita"><label for="tipo2">Descripcion</label></td>
      <td width="100" valign="baseline" bgcolor="#6da6e2" class="negrita">Opciones</td>
      <td width="63" valign="baseline" bgcolor="#6da6e2" class="negrita">Opciones</td>
      <td background="imagenes/v_back_der.gif">&nbsp;</td>
    </tr>
    
    <?php do { ?>
      <tr class="trListaBody" onclick="mClk(this, 'registro');" id="<?php echo $row_prod['id_productos']; ?>">
        <td background="imagenes/v_back_izq.gif" height="1">&nbsp;</td>
        <td align="center" ><?php echo $row_grupo['nombre']; ?></td>
        <td align="center"><?php echo $row_grupo['descripcion']; ?></td>
        <td align="center"><a href="modificar_grupo.php?id=<?php echo $row_grupo['id_grupo']; ?>">
          <input type="button"  value="Modificar" />
        </a></td>
        <td align="center"><a onclick='return validar()' href="eliminar_grupo.php?id=<?php echo $row_grupo['id_grupo']; ?>">
          <input type="button"  value="Eliminar" />
        </a></td>
        <td background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <?php } while ($row_grupo = mysql_fetch_assoc($grupo)); ?>
    
    <tr>
      <td background="imagenes/v_back_izq.gif" height="1" width="13"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
      <td colspan="4" class="tituloDOSE_2"><table border="0" align="center">
          <tr>
            <td><?php if ($pageNum_grupo > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_grupo=%d%s", $currentPage, 0, $queryString_grupo); ?>"><img src="First.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_grupo > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_grupo=%d%s", $currentPage, max(0, $pageNum_grupo - 1), $queryString_grupo); ?>"><img src="Previous.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_grupo < $totalPages_grupo) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_grupo=%d%s", $currentPage, min($totalPages_grupo, $pageNum_grupo + 1), $queryString_grupo); ?>"><img src="Next.gif" /></a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_grupo < $totalPages_grupo) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_grupo=%d%s", $currentPage, $totalPages_grupo, $queryString_grupo); ?>"><img src="Last.gif" /></a>
                <?php } // Show if not last page ?></td>
          </tr>
      </table></td>
      <td background="imagenes/v_back_der.gif" width="12"></td>
    </tr>
    <tr>
      <td align="left" height="1" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
      <td height="1" colspan="4" background="imagenes/v_back_inf.gif"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
      <td align="right" height="1" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($grupo);
?>
