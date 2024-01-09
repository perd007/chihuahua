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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	
	
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
	
	
  $insertSQL = sprintf("INSERT INTO productos (nombre, descripcion, codigo, marca, modelo, sub_grupo, serial, foto) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($_POST['marca'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['sub_grupo'], "int"),
					   GetSQLValueString($_POST['serial'], "text"),
					   GetSQLValueString($nombreFoto, "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   if($Result1==1){
  echo "<script type=\"text/javascript\">alert ('Producto Cargado');  location.href='' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='' </script>";
  exit;
  }
}



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
<title>Documento sin título</title>
<link href="css.css" rel="stylesheet" type="text/css" />
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
<form action="<?php echo $editFormAction; ?>" method="post" onsubmit="return validar()" name="form1" id="form1" enctype="multipart/form-data">
<table align="left" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="722"><table border="0" cellpadding="0" cellspacing="0" width="687">
        <tbody>
          <tr>
            <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
            <td class="tituloDOSE_3" align="center" background="imagenes/v_back_sup.jpg" valign="center"><span class="negrita">Carga de Productos</span></td>
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
                  <td align="center" width="140"><table cellpadding="3" cellspacing="0" width="660">
                    <tbody>
                      <tr>
                        <td width="72" align="left" valign="baseline" nowrap="nowrap">Sub-grupo:</td>
                        <td width="270" valign="baseline"><label for="sub_grupo"></label>
                          <select name="sub_grupo" id="sub_grupo">
                            <?php
do {  
?>
                            <option value="<?php echo $row_subgrupo['id_subgrupo']?>"><?php echo $row_subgrupo['nombre']?></option>
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
                        <td width="240" valign="baseline"><input name="modelo" type="text" value="" size="40" maxlength="45" /></td>
                        </tr>
                      <tr>
                        <td align="left" valign="baseline" nowrap="nowrap">Codigo:</td>
                        <td valign="baseline"><input type="text" name="codigo" value="" size="32" /></td>
                        <td align="right">Serial:</td>
                        <td align="left"><label for="serial"></label>
                          <input name="serial" type="text" id="serial" maxlength="20" /></td>
                        </tr>
                      <tr>
                        <td align="left" valign="baseline" nowrap="nowrap">Marca:</td>
                        <td valign="baseline"><input name="marca" type="text" value="" size="45" maxlength="45" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap">Nombre:</td>
                        <td valign="baseline"><input name="nombre" type="text" value="" size="40" maxlength="45" /></td>
                        </tr>
                      <tr>
                        <td align="left">Unidad:</td>
                        <td align="left"><label for="unidad"></label>
                          <select name="unidad" id="unidad">
                            <option value="Kg">Kg</option>
                            <option value="Mts">Mts</option>
                            <option value="Cm">Cm</option>
                            <option value="Litros">Litros</option>
                            <option value="Ml">Ml</option>
                          </select></td>
                        <td align="right">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="tituloDOSE_2" align="left">Descripcion</td>
                        <td colspan="3" valign="baseline"><label for="descripcion"></label>
                          <textarea name="descripcion" onKeyDown="if(this.value.length &gt;= 500){ alert('Has superado el tama&ntilde;o m&aacute;ximo permitido de este campo'); return false; }" id="descripcion" cols="80" rows="4"></textarea></td>
                      </tr>
                      <tr>
                        <td class="tituloDOSE_2" align="right">Imagen:</td>
                        <td class="tituloDOSE_2" align="left" colspan="3"><input name="foto" type="file" class="inputs" id="foto" size="30" /></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center"><input type="submit" value="CARGAR PRODUCTO" /></td>
                      </tr>
                      </tbody>
                  </table></td>
                  </tr>
                <tr>
                  <td align="right" width="80%"></td>
                  </tr>
              </tbody>
            </table></td>
            <td background="imagenes/v_back_der.gif" width="12">&nbsp;</td>
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
  <input type="hidden" name="MM_insert" value="form1">

</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($subgrupo);
?>
