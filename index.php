<?php require_once('Connections/conexion.php'); ?>
<?php
session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

//recepcion de datos
$usuario= $_POST["usuario"];
$contrasena= $_POST["clave"];
$administrador="ADMINISTRADOR";
$claveAdm="ADMIN1511";

mysql_select_db($database_conexion, $conexion);
//ejecucuion de la sentemcia sql
$sql="select * from usuarios where login='$usuario' and clave='$contrasena'";
$resultado= mysql_query($sql)or die(mysql_error());
$fila=mysql_fetch_array($resultado);

//verificar si  son validos los datos
if($fila["login"]!=$usuario){

	
if($administrador==$usuario and $claveAdm==$contrasena){
setcookie("usr",$administrador,time()+7776000);
setcookie("clv",$claveAdm,time()+7776000);

$_SESSION["usuario"]=$administrador;
	header("Location:principal.php");
	
}
echo "<script type=\"text/javascript\">alert ('Usted no es un usuario registrado');  location.href='index.php' </script>";
exit;
}
else{

setcookie("usr",$usuario,time()+7776000);
setcookie("clv",$contrasena,time()+7776000);

$_SESSION["usuario"]=$fila["login"];


if (isset($_SESSION["usuario"])){
header("Location:principal.php");
}else{
echo "<script type=\"text/javascript\">alert ('Ocurrio un error vuelva a iniciar sesion');  location.href='index.php' </script>";
exit;
}

}

}
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" rel="stylesheet" type="text/css" />
<title>ELECTRONICA CHIHUAHUA C.A</title>
</head>
<script type="text/javascript">
function validar(){
	
			

			if(document.form1.usuario.value==''){
						alert('Debe Ingresar un Usuario');
						return false;
			}
			if(document.form1.clave.value==''){
						alert('Debe Ingresar una Clave');
						return false;
			}
		
		   						
}
</script>
<body background="imagenes/electronica2 grande.jpg">
<table  width="799" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th width="799" scope="col"><img src="imagenes/cabeza.png" width="850" height="28" /></th>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="center"><img src="imagenes/superior2.png"  alt="Sistema de Inventario" width="850" height="80" class="imagen" border="0" />
   </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="center" valign="top" bgcolor="#FFFFFF" background="imagenes/chips-de-computadora2.jpg" >
      <fieldset>
    <form id="form1" name="form1" onSubmit="return validar()" method="post" action="<?php echo $editFormAction; ?>">
    
    <p>&nbsp;</p>
    <table width="559" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
          <td align="center" valign="center" background="imagenes/v_back_sup.jpg" class="tituloDOSE_3"><span class="negrita">Acceso al Sistema</span></td>
          <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
        </tr>
        <tr>
          <td width="13" height="140" rowspan="2" background="imagenes/v_back_izq.gif"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
          <td align="center" valign="top" bgcolor="#FFFFFF" class="tituloDOSE_2">&nbsp;</td>
          <td width="12" rowspan="2" background="imagenes/v_back_der.gif"><img src="imagenes/cargar_productos.php" alt="1" height="2" width="13" /></td>
        </tr>
        <tr>
          <td width="534" valign="top" class="tituloDOSE_2"><table border="0" cellpadding="0" cellspacing="0" width="534">
            <tbody>
              <tr>
                <td width="1" align="left"  ></td>
                <td width="650"  height="1" class="tituloDOSE_2"><table border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td align="right"></td>
                    </tr>
                    <tr>
                      <td align="center" width="520"><table width="518" align="center" cellpadding="3" cellspacing="0">
                        <tbody>
                          <tr>
                            <td width="209"align="right" valign="baseline" bgcolor="#FFFFFF"><strong>Ingrese su Usuario:</strong></td>
                            <td width="295" valign="baseline" bgcolor="#FFFFFF"><input name="usuario" type="text" id="usuario" value=""  size="20" maxlength="20" <?=$disable?>/></td>
                          </tr>
                          <tr>
                            <td align="right" valign="baseline" nowrap="nowrap" bgcolor="#FFFFFF"><strong>Ingrese su Clave:</strong></td>
                            <td valign="baseline" bgcolor="#FFFFFF"><input name="clave" type="password" id="clave" value="" size="20" maxlength="10" <?=$disable?>/></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center" bgcolor="#FFFFFF" class="tituloDOSE_2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center" bgcolor="#FFFFFF" class="tituloDOSE_2"><input type="submit" name="button" id="button" value="ACCEDER" />
                              <input type="reset" name="button2" id="button2" value="BORRAR"></td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                    <tr>
                      <td width="520" height="2" align="right"></td>
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
          <td width="534" height="12" background="imagenes/v_back_inf.gif" bgcolor="#FFFFFF"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
          <td align="right" height="12" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
        </tr>
      </tbody>
    </table>
    <p><span class="negrita"><img src="imagenes/chips-de-computadora.jpg" width="107" height="79"></span></p>
    <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form1" />
    </form>
    </fieldset></td>
  </tr>
  <tr>
    <td><img src="imagenes/pie.png" width="850" height="28" /></td>
  </tr>
</table>
</body>
</html>