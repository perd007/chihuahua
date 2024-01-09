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



	    $num1=$_POST["precioCompra"];
		$num1 = str_replace(",",".",$num1);

	
		$num=$_POST['precio'];
		$num = str_replace(".","",$num);
		$num = str_replace(",",".",$num);

//validamos si el aumento fue por precio
	if($_POST['porcentaje2']==0 and $_POST['precio2']==1 and $_POST['utilidad2']==0){
	
				if($num1>=$num){
				 echo "<script type=\"text/javascript\">alert ('El precio de Venta no puede ser menor ni igaul al de compra');  location.href='' </script>";
				}
				
				$tipoAumento="precio";
				$montoAumento=$num;
	}
	
	
	//validamos si el aumento fue por porcntaje 
	if($_POST['porcentaje2']==1 and $_POST['precio2']==0 and $_POST['utilidad2']==0){
	
		$x=$_POST['precioVenta'] + ($_POST['precioVenta'] * $_POST['porcentaje'])/100;
		$num=$x;
		
		$tipoAumento="porcentaje";
		$montoAumento=$_POST['porcentaje'];
	}	
	
	//validamos si el aumento fue por utilidad	
	if($_POST['utilidad2']==1 and $_POST['precio2']==0 and $_POST['porcentaje2']==0){
	
		$x=$_POST['precioVenta'] + $_POST['utilidad'];
		$num=$x;
		
		$tipoAumento="utilidad";
		$montoAumento=$_POST['utilidad'];
	}	
	

		
			
  $insertSQL = sprintf("INSERT INTO precios (id_producto, precio, fecha, montoAumento, tipoAumento) VALUES (%s, %s, NOW(), %s, %s)",
                       GetSQLValueString($_POST['id_productos'], "int"),
                       GetSQLValueString($num, "double"),
					   GetSQLValueString($montoAumento, "double"),
					   GetSQLValueString($tipoAumento, "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  if($Result1==1){
  echo "<script type=\"text/javascript\">alert ('Datos Guardados');  location.href='' </script>";
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
<title>Documento sin título</title>
<style type="text/css">
.Letras1 {font-size:14px;
font-style:italic;

background-color:transparent;
border:none;
}
.Letras1 {font-size:14px;
font-style:italic;

background-color:transparent;
border:none;
}
</style>
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
<style> 
a{text-decoration:none} 
.dato {
background-color: transparent; 
border:#FFF;
font-size:14px;
font-style:italic;
width:100%; 
 
}
.Letras {
font-size:14px;
font-style:italic;

background-color:transparent;
border:none;
 
}
.boton {
	font-size: 14px;
	font-style: italic;
	font-weight: bold; 
}
</style>
<script language="javascript">

function validaFloat()
{
	var numero=document.form1.precio.value;
  if (!/^([0-9])*[,]?[0-9]*$/.test(numero))
   alert("El valor " + numero + " no es un número");
   return false;
}


function activarUtilidad(){
	document.getElementById('precio').value=0;
	document.getElementById('porcentaje').value=0;
	
	document.getElementById('precio2').value=0;
	document.getElementById('porcentaje2').value=0;
	document.getElementById('utilidad2').value=1;

}
function activarPorcentaje(){
	document.getElementById('precio').value=0;
	document.getElementById('utilidad').value=0;
	
	document.getElementById('precio2').value=0;
	document.getElementById('utilidad2').value=0;
	document.getElementById('porcentaje2').value=1;

}
function activarMonto(){
	document.getElementById('porcentaje').value=0;
	document.getElementById('utilidad').value=0;
	
	document.getElementById('precio2').value=1;
	document.getElementById('utilidad2').value=0;
	document.getElementById('porcentaje2').value=0;

}


function validar(){
	
		if(document.form1.id_productos.value==""){
						alert("Debe Seleccionar un Producto");
						return false;
				}
				
				
		if(document.form1.codigo.value==""){
						alert("Debe Seleccionar un Producto");
						return false;
				}		
				
				
		if(document.form1.precio.value=="" || document.form1.porcentaje.value=="" || document.form1.utilidad.value==""){
						alert("Debe Ingresar algun aumento");
						return false;
				}
				
	if(document.form1.porcentaje.value=="" || document.form1.utilidad.value==""){
				if(document.form1.precio.value<=0){
						alert("El Precio debe ser Mayor a Cero");
						return false;
				}	
			
				}
				
	if(document.form1.precio.value=="" || document.form1.utilidad.value==""){
				if(document.form1.porcentaje.value<=0){
						alert("El Porcentaje debe ser Mayor a Cero");
						return false;
				}	
			
				}
				
	if(document.form1.precio.value=="" || document.form1.porcentaje.value==""){
				if(document.form1.utilidad.value<=0){
						alert("La Utilidad debe ser Mayor a Cero");
						return false;
				}	
			
				}
		
				
		
		
			
}


</script>
<body>
<!-- pretty -->
<span class="gallery clearfix"></span>
<form action="<?php echo $editFormAction; ?>" method="post" onsubmit="return validar()" name="form1" id="form1">
  <table border="0" cellpadding="0" cellspacing="0" width="775">
    <tbody>
      <tr>
        <td align="left" height="1"><img src="imagenes/vc_esq_izq_sup.gif" alt="7" height="32" width="13" /></td>
        <td class="tituloDOSE_3" align="center" background="imagenes/v_back_sup.jpg" valign="center"><span class="negrita">Ajuste de Precios para Productos</span></td>
        <td align="right" height="1" width="12"><img src="imagenes/vc_esq_der_sup.gif" alt="6" height="32" width="13" /></td>
      </tr>
      <tr>
        <td width="13" height="140" rowspan="2" align="right" background="imagenes/v_back_izq.gif"><img src="imagenes/v_back_izq.gif" alt="3" height="2" width="13" /></td>
        <td valign="baseline" align="right"  class="gallery clearfix">
        <a  href="listado_productos_ajuste.php?iframe=true&amp;width=950&amp;height=525" target="_blank" rel="prettyPhoto[iframe1]" >
        <input type="button" class="btLista" value="Producto" id="btItem"  /></a></td>
        <td width="12" rowspan="2" background="imagenes/v_back_der.gif"><img src="imagenes/cargar_productos.php" alt="1" height="2" width="13" /></td>
      </tr>
      <tr>
        <td valign="top"><table width="700" align="center" border="1" bordercolor="#0000FF" class="tblLista">
          <thead>
            <tr>
              <th width="79">Codigo</th>
              <th width="281" >Producto</th>
              <th  width="64">Precio Nuevo</th>
              <th  width="65">Aumento Utilidad</th>
              <th  width="65">Aumento %</th>
            </tr>
            <tr>
              <td><input type="text" name="codigo" id="codigo" readonly="readonly"  class="dato" value="" size="32" style="text-align:left; font-weight:bold;"  /></td>
              <td ><input type="text" name="nombre" id="nombre" readonly="readonly"  class="dato" value="" size="32" style="text-align:center; font-weight:bold;" /></td>
              <td align="left"><input onclick="activarMonto()" name="precio" id="precio" type="text" class="Letras"  style="text-align:center; font-weight:bold;" onchange="return validaFloat()" value="0" size="11" maxlength="4"  /></td>
              <td align="left"><input onclick="activarUtilidad()" name="utilidad" type="text" class="Letras" id="utilidad"  style="text-align:center; font-weight:bold;"  onchange="return validaFloat()" value="0" size="11" maxlength="4"  /></td>
              <td align="left"><input onclick="activarPorcentaje()" name="porcentaje" type="text" class="Letras" id="porcentaje"  style="text-align:center; font-weight:bold;"  onchange="return validaFloat()" value="0" size="11" maxlength="4"  /></td>
            </tr>
          </thead>
          <tbody id="lista_detalles">
          
          
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td height="19" align="right" background="imagenes/v_back_izq.gif">&nbsp;</td>
        <td valign="top"><strong>Fecha de Compra:</strong>
        <input type="text" name="fechaCompra" id="fechaCompra" readonly="readonly"  class="Letras1" value="" size="10"  /></td>
        <td background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="19" align="right" background="imagenes/v_back_izq.gif">&nbsp;</td>
        <td valign="top"><strong>Ultimo Precio de Venta:</strong>
          <input type="text" name="precioVenta" id="precioVenta" readonly="readonly" class="Letras" value="" size="11" onblur="numeroBlur(this);" onfocus="numeroFocus(this);"  /></td>
        <td background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="19" align="right" background="imagenes/v_back_izq.gif">&nbsp;</td>
        <td valign="top"><strong>Ultimo Precio de Compra:</strong>
        <input type="text" name="precioCompra" id="precioCompra" readonly="readonly" class="Letras" value="" size="11" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);"  /></td>
        <td background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="19" align="right" background="imagenes/v_back_izq.gif">&nbsp;</td>
        <td align="center" valign="top"><input name="button" type="submit" class="boton"  id="button" value="GUARDAR" C /></td>
        <td background="imagenes/v_back_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" height="12" width="13"><img src="imagenes/v_esq_izq_inf.gif" alt="5" height="12" width="13" /></td>
        <td background="imagenes/v_back_inf.gif" height="12" width="750"><img src="imagenes/v_back_inf.gif" alt="2" height="12" width="2" /></td>
        <td align="right" height="12" width="12"><img src="imagenes/v_esq_der_inf.gif" alt="4" height="12" width="13" /></td>
      </tr>
    </tbody>
  </table>
  <p>
     <input type="hidden" name="MM_insert" value="form1" />
     <input type="hidden" name="id_productos" id="id_productos" value="" />
     <input type="hidden" name="precio2" id="precio2" value="" />
     <input type="hidden" name="porcentaje2" id="porcentaje2" value="" />
     <input type="hidden" name="utilidad2" id="utilidad2" value="" />
  </p>
</form>
</body>
</html>
<?php
mysql_free_result($compras);

mysql_free_result($compra_Productos);
?>
