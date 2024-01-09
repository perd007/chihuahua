<?php require_once('Connections/conexion.php');


//recibimos
$id=$_GET["id"];



mysql_select_db($database_conexion, $conexion);
$query_productos = "SELECT * FROM productos where sub_grupo='$id'";
$productos = mysql_query($query_productos, $conexion) or die(mysql_error());
$row_productos = mysql_fetch_assoc($productos);
$totalRows_productos = mysql_num_rows($productos);

if($totalRows_productos>=1){
echo"<script type=\"text/javascript\">alert ('Este Sub_Grupo esta vinculado a un Producto y por lo tanto no se Pede Eliminar'); location.href='consultar_grupos.php' </script>";
exit;
	
}



mysql_select_db($database_conexion, $conexion);
$sql="delete from `sub-grupo` where id_subgrupo='$id'";
$verificar=mysql_query($sql,$conexion) or die(mysql_error());

if($verificar){
	echo"<script type=\"text/javascript\">alert ('Grupo Eliminado'); location.href='consultar_subgrupos.php' </script>";
}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='consultar_subgrupos.php' </script>";
	exit;
	
}//fin de l primer else



?>