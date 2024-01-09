<?php 
//validar usuario

if($_COOKIE["val"]==true){
	if($_COOKIE["c"]!=1){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para Acceder al Modulo de Compras');location.href='fondo.php' </script>";
    exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido'); location.href='fondo.php' </script>";
 exit;
}
?>
<html>
        <head>
               
                <style type="text/css">
<!--
body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        margin: 0;
        font-size: 80%;
        font-weight: bold;
        background: #FFF;
        }

h2 {
        font: bold 12px Verdana, Arial, Helvetica, sans-serif;
        color: #000;
        margin: 0px;
        padding: 0px 0px 0px 15px;
}

ul {
        list-style: none;
        margin: 0;
        padding: 0;
        }

img {
    border: none;
}

/*- Menu 10--------------------------- */

#menu10 {
        width: 160px;
        margin: 2px;
        }

#menu10 li a {
        height: 32px;
          voice-family: "\"}\"";
          voice-family: inherit;
          height: 24px;
        text-decoration: none;
        }

#menu10 li a:link, #menu10 li a:visited {
        color: #4D4D4D;
        display: block;
        background:  url(../imagenes/menu10.gif);
        padding: 8px 0 0 5px;
        }

#menu10 li a:hover, #menu10 li #current {
        color: #FF9834;
        background:  url(../imagenes/menu10.gif) 0 -32px;
        padding: 8px 0 0 5px;
        }
-->
                </style>
        </head>

        <body>
        <div id="menu10">
                <ul>
                                <!-- CSS Tabs -->
<li><a href="../registrar_compras.php" target="centro">Registrar Compras</a></li>
<li><a href="../consultar_compras.php" target="centro">Consultar Compras</a></li>
<li><a href="../consultar_costos_compras.php" target="centro">Precios Compras</a></li>
<li><a href="../ajustar_precios.php" target="centro">Ajustes de Precios</a></li>
<li><a href="../consultar_ajustar_precios.php" target="centro">Visualizar Precios</a></li>
<li><a href="../fondo.php" target="centro">Salir</a></li>

                        </ul>
                </div>
</body>
</html>