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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
		//insercion de la foto
$foto=$_POST["foto"];
$path="C:/xampp/htdocs/chihuahua/fotos";
$nombreFoto = $_FILES['foto']['name'];
$tipos = $_FILES['foto']['type'];
if (is_uploaded_file($_FILES['foto']['tmp_name'])){
	copy($_FILES['foto']['tmp_name'], "$path/$nombreFoto");
		
	}else{
		echo "<script type=\"text/javascript\">alert ('no se guardo la foto');  location.href='' </script>";
  exit;
	}
	
	
  $updateSQL = sprintf("UPDATE productos SET  marca=%s, modelo=%s, nombre=%s, codigo=%s, descripcion=%s, serial=%s, foto=%s WHERE id_producto=%s",  
                       GetSQLValueString($_POST['marca'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
					   GetSQLValueString($_POST['serial'], "text"),
					    GetSQLValueString($nombreFoto, "text"),
                       GetSQLValueString($_POST['id_productos'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   if($Result1==1){
  echo "<script type=\"text/javascript\">alert ('Producto Actualizado');  location.href='consultar_productos.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='' </script>";
  exit;
  }
}

$id=$_GET["id"];
mysql_select_db($database_conexion, $conexion);
$query_productos = "SELECT * FROM productos where id_producto='$id'";
$productos = mysql_query($query_productos, $conexion) or die(mysql_error());
$row_productos = mysql_fetch_assoc($productos);
$totalRows_productos = mysql_num_rows($productos);



//juego de registros
mysql_select_db($database_conexion, $conexion);
$query_subgrupo = "SELECT * FROM `sub-grupo`";
$subgrupo = mysql_query($query_subgrupo, $conexion) or die(mysql_error());
$row_subgrupo = mysql_fetch_assoc($subgrupo);
$totalRows_subgrupo = mysql_num_rows($subgrupo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" rel="stylesheet" type="text/css" />

<title>Documento sin título</title>
</head>
<script language="javascript">





function validar(){

			
				
			if(document.form1.modelo.value==""){
						alert("Debe ingresar un reemplazo");
						return false;
				}
			if(document.form1.codigo.value==""){
						alert("Debe ingresar un codigo para el producto");
						return false;
				}
			if(document.form1.marca.value==""){
						alert("Debe ingresar una marca");
						return false;
				}
			if(document.form1.nombre.value==""){
						alert("Debe ingresar un nombre para el producto");
						return false;
				}
			
				
		}
		

		
</script>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" onsubmit="return validar()"  name="form1" id="form1" enctype="multipart/form-data">
  <table align="left" border="0" cellspacing="0">
    <tbody>
      <tr>
        <td width="687"><table border="0" cellpadding="0" cellspacing="0" width="687">
          <tbody>
            <tr>
              <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
              <td class="tituloDOSE_3" align="center" background="imagenes/v_back_sup.jpg" valign="center"><span class="negrita">Actualizar de Producto</span></td>
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
                    <td align="center" width="661"><table cellpadding="3" cellspacing="0" width="660">
                      <tbody>
                        <tr>
                          <td align="left" valign="baseline" nowrap="nowrap">Foto</td>
                          <td colspan="3" valign="baseline"><? echo "<img src='fotos/".$row_productos['foto']."' width='150' height='150' />"; ?></td>
                          </tr>
                        <tr>
                          <td width="72" align="left" valign="baseline" nowrap="nowrap">Sub-grupo:</td>
                          <td width="270" valign="baseline"><label for="sub_grupo"></label>
                            <select name="sub_grupo" id="sub_grupo">
                              <?php
do {  
?>
                              <option value="<?php echo $row_subgrupo['id_subgrupo']?>"<?php if (!(strcmp($row_subgrupo['id_subgrupo'], $row_productos['sub_grupo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_subgrupo['nombre']?></option>
                              <?php
} while ($row_subgrupo = mysql_fetch_assoc($subgrupo));
  $rows = mysql_num_rows($subgrupo);
  if($rows > 0) {
      mysql_data_seek($subgrupo, 0);
	  $row_subgrupo = mysql_fetch_assoc($subgrupo);
  }
?>
                            </select></td>
                          <td width="54" align="right" valign="baseline" nowrap="nowrap">Reemplazo:</td>
                          <td width="240" valign="baseline"><input name="modelo" type="text" value="<?php echo $row_productos['modelo']; ?>" size="40" maxlength="45" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="baseline" nowrap="nowrap">Codigo:</td>
                          <td valign="baseline"><input type="text" name="codigo" value="<?php echo $row_productos['codigo']; ?>" size="32" /></td>
                          <td align="right">Serial:</td>
                          <td align="left"><label for="serial"></label>
                            <input name="serial" type="text" id="serial" value="<?php echo $row_productos['serial']; ?>" maxlength="20" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="baseline" nowrap="nowrap">Marca:</td>
                          <td valign="baseline"><input name="marca" type="text" value="<?php echo $row_productos['marca']; ?>" size="45" maxlength="45" /></td>
                          <td align="right" valign="baseline" nowrap="nowrap">Nombre:</td>
                          <td valign="baseline"><input name="nombre" type="text" value="<?php echo $row_productos['nombre']; ?>" size="40" maxlength="45" /></td>
                        </tr>
                        <tr>
                          <td align="left">Unidad:</td>
                          <td align="left"><label for="unidad"></label>
                            <select name="unidad" id="unidad">
                              <option value="Kg" <?php if (!(strcmp("Kg", $row_productos['unidad']))) {echo "selected=\"selected\"";} ?>>Kg</option>
                              <option value="Mts" <?php if (!(strcmp("Mts", $row_productos['unidad']))) {echo "selected=\"selected\"";} ?>>Mts</option>
                              <option value="Cm" <?php if (!(strcmp("Cm", $row_productos['unidad']))) {echo "selected=\"selected\"";} ?>>Cm</option>
                              <option value="Litros" <?php if (!(strcmp("Litros", $row_productos['unidad']))) {echo "selected=\"selected\"";} ?>>Litros</option>
                              <option value="Ml" <?php if (!(strcmp("Ml", $row_productos['unidad']))) {echo "selected=\"selected\"";} ?>>Ml</option>
                            </select></td>
                          <td align="left">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="tituloDOSE_2" align="left">Descripcion</td>
                          <td colspan="3" valign="baseline"><label for="descripcion"></label>
                            <textarea name="descripcion" onkeydown="if(this.value.length &gt;= 500){ alert('Has superado el tamaño máximo permitido de este campo'); return false; }" id="descripcion" cols="80" rows="4"><?php echo $row_productos['descripcion']; ?></textarea></td>
                        </tr>
                        <tr>
                          <td class="tituloDOSE_2" align="right">Imagen:</td>
                          <td class="tituloDOSE_2" align="left" colspan="3"><?php echo $row_productos['foto']; ?><input name="foto" type="file" class="inputs" id="foto" size="30"  /></td>
                        </tr>
                        <tr>
                          <td colspan="4" align="center"><input type="submit" value="CARGAR PRODUCTO" /></td>
                        </tr>
                      </tbody>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" width="661"></td>
                  </tr>
                </tbody>
              </table></td>
              <td background="imagenes/v_back_der.gif" width="12"><img src="imagenes/cargar_productos.php" alt="1" height="2" width="13" /></td>
            </tr>
            <tr>
              <td align="left" height="1" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
              <td background="imagenes/v_back_inf.gif" height="1" width="662"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
              <td align="right" height="1" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <tr> </tr>
    </tbody>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_productos" value="<?php echo $row_productos['id_producto']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>

