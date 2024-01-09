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
 

//validamos que no exista dos cedula iguales
mysql_select_db($database_conexion, $conexion);
$query_valEmp = "SELECT * FROM empleados where cedula='$_POST[cedula]'";
$valEmp = mysql_query($query_valEmp, $conexion) or die(mysql_error());
$row_valEmp = mysql_fetch_assoc($valEmp);
$totalRows_valEmp = mysql_num_rows($valEmp);

if($totalRows_valEmp>=1){
echo "<script type=\"text/javascript\">alert ('Cedula ya Registrada'); location.href='consultar_usuarios.php' </script>";
 exit;
}
//


 //validamos que  no existan dos usuarios iguales
mysql_select_db($database_conexion, $conexion);
$query_valUsu = "SELECT * FROM usuarios where login='$_POST[login]'";
$valUsu = mysql_query($query_valUsu, $conexion) or die(mysql_error());
$row_valUsu = mysql_fetch_assoc($valUsu);
$totalRows_valUsu = mysql_num_rows($valUsu);

if($totalRows_valUsu>=1){
echo "<script type=\"text/javascript\">alert ('Usuario ya Registrado'); location.href='consultar_usuarios.php' </script>";
 exit;

}
  
  $insertSQL1 = sprintf("INSERT INTO empleados (cedula, nombres, cargo, direccion, telefono) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL1, $conexion) or die(mysql_error());
  
  $insertSQL2 = sprintf("INSERT INTO usuarios (id_empleado, login, clave) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['clave'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($insertSQL2, $conexion) or die(mysql_error());
  
   $insertSQL3 = sprintf("INSERT INTO permisos_usuarios (id_usuario, p, f, c, a, v, r, cl, prv, s, u, ac, cc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['p'], "int"),
                       GetSQLValueString($_POST['f'], "int"),
                       GetSQLValueString($_POST['c'], "int"),
                       GetSQLValueString($_POST['a'], "int"),
                       GetSQLValueString($_POST['v'], "int"),
                       GetSQLValueString($_POST['r'], "int"),
                       GetSQLValueString($_POST['cl'], "int"),
                       GetSQLValueString($_POST['prv'], "int"),
                       GetSQLValueString($_POST['s'], "int"),
                       GetSQLValueString($_POST['u'], "int"),
					   GetSQLValueString($_POST['ac'], "int"),
                       GetSQLValueString($_POST['cc'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result3 = mysql_query($insertSQL3, $conexion) or die(mysql_error());
  
  if($Result1==1 and $Result2==1 and $Result3==1){
  echo "<script type=\"text/javascript\">alert ('USUARIO CARGADO AL SISTEMA');  location.href='' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='' </script>";
  exit;
  }
  
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" rel="stylesheet" type="text/css" />
<title>Documento sin título</title>
</head>
<script type="text/javascript">
function validar(){
	
			if(document.form1.telefono.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('telefono').value)){
				alert('EL NUMERO DE TELEFONO DEBE SER NUMERICO');
				return false;
		   		}
				}
		   		
				if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('cedula').value)){
				alert('EL NUMERO DE CEDULA DEBE SER NUMERICO');
				return false;
		   		}
				}
		   		
				if(document.form1.login.value=='ADMINISTRADOR'){
						alert('DEBE INGRESAR OTRO NOMBRE DE USUARIO');
						return false;
			}
			
			

			if(document.form1.cedula.value==''){
						alert('Debe Ingresar un Numero de Cedula');
						return false;
			}


			if(document.form1.nombres.value==''){
						alert('Debe Ingresar un Nombre');
						return false;
			}
			if(document.form1.telefono.value==''){
						alert('Debe Ingresar un Telefono');
						return false;
			}
			
			if(document.form1.login.value==''){
						alert('Debe Ingresar un Usuario');
						return false;
			}
			if(document.form1.clave.value==''){
						alert('Debe Ingresar una Clave y Repetirla');
						return false;
			}
			if(document.form1.clave2.value==''){
						alert('Debe Ingresar una Clave y Repetirla');
						return false;
			}

if(document.form1.clave2.value!=document.form1.clave.value){
						alert('Las claves no coinciden');
						return false;
			}
			
		
			if(document.form1.p.checked==false) { 
			 	
			  		if(document.form1.f.checked==false){
						
			 				if(document.form1.c.checked==false){ 
							
								if(document.form1.a.checked==false){ 
			 	
									if(document.form1.v.checked==false){ 
			 									
										if(document.form1.r.checked==false){ 
			 					
											if(document.form1.cl.checked==false){ 
			 					
												if(document.form1.prv.checked==false){ 
			 					
													if(document.form1.s.checked==false){ 
			 					
														if(document.form1.u.checked==false){ 
														
															if(document.form1.ac.checked==false){ 
															
																if(document.form1.cc.checked==false){

			 														alert("DEBE INGRESAR ALGUN PERMISO PARA ESTE USUARIO");
		   															return false;	
																	}
																}
															}
													
														}
													
													}	
												}	
										
											}
										
										}
									}
								}
							
						}
					
				
			}
	
		
		   						
}
</script>

<body>
<form action="<?php echo $editFormAction; ?>" onsubmit="return validar()" method="post" name="form1" id="form1">
  <table border="0" cellpadding="0" cellspacing="0" width="696">
    <tbody>
      <tr>
        <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
        <td align="center" valign="center" background="imagenes/v_back_sup.jpg" class="tituloDOSE_3"><span class="negrita">Registro de Usuarios</span></td>
        <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
      </tr>
      <tr>
        <td width="13" height="140" rowspan="2" background="imagenes/v_back_izq.gif">&nbsp;</td>
        <td valign="top" class="tituloDOSE_2">&nbsp;</td>
        <td width="12" rowspan="2" background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td class="tituloDOSE_2" valign="top" width="671"><table border="0" cellpadding="0" cellspacing="0" width="671">
          <tbody>
            <tr>
              <td width="1" align="left"  ></td>
              <td width="763"  height="1" class="tituloDOSE_2"><table border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td align="right"></td>
                  </tr>
                  <tr>
                    <td align="center" width="659"><table cellpadding="3" cellspacing="0" width="660">
                      <tbody>
                        <tr>
                          <td width="61" height="28"align="right" valign="baseline">Nombre:</td>
                          <td width="222" valign="baseline"><input type="text" name="nombres" value="" size="32" /></td>
                          <td width="79" align="right" valign="baseline" nowrap="nowrap"><p>Cedula :</p></td>
                          <td width="272" valign="baseline"><input name="cedula" id="cedula" type="text" value="" size="15" maxlength="8" /></td>
                        </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap">Telefono:</td>
                          <td valign="baseline"><input name="telefono" id="telefono" type="text" value="" size="20" maxlength="11" /></td>
                          <td align="right" valign="baseline">Cargo:</td>
                          <td valign="baseline"><label for="tipo3"></label>
                            <input name="cargo" type="text" id="cargo" value="" size="32" /></td>
                        </tr>
                        <tr>
                          <td class="tituloDOSE_2" align="left">Direccion</td>
                          <td colspan="3" valign="baseline"><label for="direccion">
                            <textarea name="direccion" cols="60" rows="4" id="direccion" ></textarea>
                          </label></td>
                        </tr>
                        <tr >
                          <td colspan="4" align="center" background="imagenes/v_back_sup.jpg"  class="tituloDOSE_2"><strong>Usuario del Sistema</strong></td>
                          </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap">Usuario:</td>
                          <td valign="baseline"><input name="login" id="login" value="" type="text" size="30" maxlength="20" /></td>
                          <td align="right" valign="baseline" nowrap="nowrap">&nbsp;</td>
                          <td valign="baseline">&nbsp;</td>
                          </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap">Clave:</td>
                          <td valign="baseline"><input name="clave" id="clave" value="" type="password" size="20" maxlength="10" /></td>
                          <td align="right" valign="baseline" nowrap="nowrap">Repetir Clave:</td>
                          <td valign="baseline"><input name="clave2" type="password" id="clave2" value="" size="20" maxlength="10" /></td>
                          </tr>
                        <tr>
                          <td colspan="4" align="center" valign="baseline" background="imagenes/v_back_sup.jpg" nowrap="nowrap"><strong>Permisos del Usuario</strong></td>
                          </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="p" type="checkbox" id="p" value="1" /></td>
                          <td valign="baseline">Productos</td>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="r" type="checkbox" id="r" value="1" /></td>
                          <td valign="baseline">Reportes</td>
                        </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="f" type="checkbox" id="f" value="1" /></td>
                          <td valign="baseline">Facturacion y Devolucion</td>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="cl" type="checkbox" id="cl" value="1" /></td>
                          <td valign="baseline">Clientes</td>
                        </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="c" type="checkbox" id="c" value="1" /></td>
                          <td valign="baseline">Compras</td>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="prv" type="checkbox" id="prv" value="1" /></td>
                          <td valign="baseline">Proveedores</td>
                        </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="a" type="checkbox" id="a" value="1" /></td>
                          <td valign="baseline">Almacen</td>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="s" type="checkbox" id="s" value="1" /></td>
                          <td valign="baseline">Apartado</td>
                        </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="v" type="checkbox" id="v" value="1" /></td>
                          <td valign="baseline">Pedidos</td>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="u" type="checkbox" id="u" value="1" /></td>
                          <td valign="baseline">Usuarios</td>
                        </tr>
                        <tr>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="ac" type="checkbox" id="ac" value="1" />
                            <label for="ac"></label></td>
                          <td valign="baseline">Abrir Caja</td>
                          <td align="right" valign="baseline" nowrap="nowrap"><input name="cc" type="checkbox" id="cc" value="1" /></td>
                          <td valign="baseline">Cerrar Caja</td>
                        </tr>
                        <tr>
                          <td colspan="4" align="center" class="tituloDOSE_2"><input type="submit" name="button" id="button" value="REGISTRAR" /></td>
                        </tr>
                      </tbody>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" width="659"></td>
                  </tr>
                </tbody>
              </table></td>
              <td width="1"></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td align="left" height="12" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
        <td width="671" height="12" background="imagenes/v_back_inf.gif"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
        <td align="right" height="12" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
      </tr>
    </tbody>
  </table>
 
    <input type="hidden" name="MM_insert" value="form1" />

</form>
</body>
</html>