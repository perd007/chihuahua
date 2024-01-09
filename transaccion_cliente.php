<?php require_once('Connections/conexion.php'); ?>
<?php

 //session_start();



 $cedula= $_REQUEST['cedula'];


mysql_select_db($database_conexion, $conexion);
$query_clientes = "SELECT * FROM clientes where cedula='$cedula'";
$clientes = mysql_query($query_clientes, $conexion) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);


	//envia los datos al ajax
    echo $row_clientes["cedula"]."-".$row_clientes["nombres"]."-".$row_clientes["telefono"]."-".$row_clientes["direccion"]."-".$row_clientes["tipo"];



 
mysql_free_result($clientes);
?>
