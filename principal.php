<?php include("login.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ELECTRONICA CHIHUAHUA C.A</title>
<link href="css2/estilo.css" rel="stylesheet" type="text/css" />
</head>
                <style type="text/css">
<!--
    body {
        margin:0;
        padding:0;
        font: bold 24px/1.5em Verdana;
	

	}

h2 {
        font: bold 24px Verdana, Arial, Helvetica, sans-serif;
        color: #000;
        margin: 0px;
        padding: 0px 0px 0px 15px;
}

img {
border: none;
}

/*- Menu Tabs 10--------------------------- */

    #tabs10 {
      float:left;
      width:100%;
      font-size:100%;
          border-bottom:1px solid #2763A5;
      line-height:normal;
      }
    #tabs10 ul {
          margin:0;
          padding:0px 0px 0 0px;
          list-style:none;
      }
    #tabs10 li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabs10 a {
      float:left;
      background:url("imagenes/tableft10.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 4px;
      text-decoration:none;
      }
    #tabs10 a span {
      float:left;
      display:block;
      background:url("imagenes/tabright10.gif") no-repeat right top;
      padding:7px 20px 6px 8px;
      color:#FFF;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs10 a span {float:none;}
    /* End IE5-Mac hack */
    #tabs9 a:hover span {
      color:#FFF;
      }
    #tabs10 a:hover {
      background-position:0% -42px;
      }
    #tabs10 a:hover span {
      background-position:100% -42px;
      }

      #tabs10 #current a {
              background-position:0% -42px;
      }
      #tabs10 #current a span {
              background-position:100% -42px;
      }
-->
                </style>
                
<script>                
 function fondo(){

    document.getElementById('centro').src = "fondo.php";

	
	
}

</script>               
                
<body background="imagenes/electronica2 grande.jpg">
<div id="contenedor">
<center>
<table border="0" cellpadding="0" cellspacing="0" width="850">
<tr >
<td colspan="2" ><img src="imagenes/superior2.png"  alt="Sistema de Inventario" width="850" height="80" class="imagen" border="0">
</td>
</tr>
<tr>
  <td colspan="2" valign="top">
<div id="tabs10">
 <ul>
<!-- CSS Tabs -->
<li><a href="menus/menu_productos.php" target="menus" onclick="fondo()"><span>Productos</span></a></li>
<li><a href="menus/menu_compras.php" target="menus" onclick="fondo()"><span>Compras</span></a></li>
<li><a href="menus/menu_proveedores.php" target="menus" onclick="fondo()"><span>Proveedores</span></a></li>
<li><a href="menus/menu_clientes.php" target="menus" onclick="fondo()"><span>Clientes</span></a></li>
<li><a href="menus/menu_almacen.php" target="menus" onclick="fondo()"><span>Almacen</span></a></li>
<li><a href="menus/menu_apartado.php" target="menus" onclick="fondo()"><span>Apartado</span></a></li>
<li><a href="menus/menu_cajas.php" target="menus" onclick="fondo()"><span>Caja</span></a></li>
<li><a href="menus/menu_ventas.php" target="menus" onclick="fondo()"><span>Ventas</span></a></li>
<li><a href="menus/menu_reportes.php" target="menus" onclick="fondo()"><span>Reportes</span></a></li>
<li><a href="menus/menu_usuarios.php" target="menus" onclick="fondo()"><span>Usuarios</span></a></li>
<li><a href="cerrarSesion.php" target="_parent"><span>Salir</span></a></li>

</ul>
</div>
</td>
</tr>

<tr>
<td width="46" valign="top"><iframe name="menus" id="menus" style="display:block" align="left" frameborder="0" scrolling="no"  width="170" height="320" ><span class="negrita"></span></iframe><img src="imagenes/chips-de-computadora.jpg" alt="" width="107" height="79" /></td>
 <td width="754" valign="top"><iframe src="fondo.php" name="centro" id="centro" style="display:block" align="left" frameborder="0"  scrolling="auto"  width="800" height="520"></iframe></td>
</tr>
<tr>
  <td colspan="2" align="center"><div align="center"><img src="imagenes/logo.jpg" width="35" height="32" />Realizado por Innovaciones Informatica J.P, C.A. Ing. Jose Carlos Perdomo</div></td></tr>
</table></center>

</div>

<p>&nbsp;</p>
</body>
</html>
