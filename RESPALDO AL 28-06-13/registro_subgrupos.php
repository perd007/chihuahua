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
  $insertSQL = sprintf("INSERT INTO `sub-grupo` (nombre, descrpcion, grupo) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['descrpcion'], "text"),
                       GetSQLValueString($_POST['grupo'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   if($Result1==1){
  echo "<script type=\"text/javascript\">alert ('Sub-Grupo Registrado');  location.href='' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='' </script>";
  exit;
  }
}

mysql_select_db($database_conexion, $conexion);
$query_grupo = "SELECT * FROM grupo";
$grupo = mysql_query($query_grupo, $conexion) or die(mysql_error());
$row_grupo = mysql_fetch_assoc($grupo);
$totalRows_grupo = mysql_num_rows($grupo);
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
						
			if(document.form1.nombre.value==""){
						alert("Debe ingresar el nombre del Sub-Grupo");
						return false;
				}
			
		}
		

		
</script>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" onsubmit="return validar()"  name="form1" id="form1">
  <table align="left" border="0" cellspacing="0">
    <tbody>
      <tr>
        <td width="584"><table border="0" cellpadding="0" cellspacing="0" width="585">
          <tbody>
            <tr>
              <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
              <td class="tituloDOSE_3" align="center" background="imagenes/v_back_sup.jpg" valign="center"><span class="negrita">Registro de Sub-Grupos</span></td>
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
                    <td align="center" width="140"><table cellpadding="3" cellspacing="0" width="557">
                      <tbody>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap">Grupo:</td>
                          <td valign="baseline"><label for="grupo"></label>
                            <select name="grupo" id="grupo">
                              <?php
do {  
?>
                              <option value="<?php echo $row_grupo['id_grupo']?>"><?php echo $row_grupo['nombre']?></option>
                              <?php
} while ($row_grupo = mysql_fetch_assoc($grupo));
  $rows = mysql_num_rows($grupo);
  if($rows > 0) {
      mysql_data_seek($grupo, 0);
	  $row_grupo = mysql_fetch_assoc($grupo);
  }
?>
                            </select></td>
                        </tr>
                        <tr>
                          <td width="78" align="right" valign="baseline" nowrap="nowrap">Nombre:</td>
                          <td width="467" valign="baseline"><input name="nombre" type="text" id="nombre" value="" size="45" maxlength="45" /></td>
                        </tr>
                        <tr>
                          <td class="tituloDOSE_2" align="left">Descripcion</td>
                          <td valign="baseline"><label for="descrpcion"></label>
                            <textarea name="descrpcion" onkeydown="if(this.value.length &gt;= 500){ alert('Has superado el tamaño máximo permitido de este campo'); return false; }" id="descrpcion" cols="75" rows="8"></textarea></td>
                        </tr>
                        <tr>
                          <td class="tituloDOSE_2" align="left">&nbsp;</td>
                          <td class="tituloDOSE_2" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><input type="submit" value="REGISTRAR SUB_GRUPO" /></td>
                        </tr>
                      </tbody>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" width="80%"></td>
                  </tr>
                </tbody>
              </table></td>
              <td background="imagenes/v_back_der.gif" width="12"></td>
            </tr>
            <tr>
              <td align="left" height="1" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
              <td background="imagenes/v_back_inf.gif" height="1" width="560"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
              <td align="right" height="1" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <tr> </tr>
    </tbody>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($grupo);
?>
