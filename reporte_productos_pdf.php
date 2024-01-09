<?php require_once('Connections/conexion.php'); ?>
<?php 
require('fpdf/fpdf.php');


//obtener registro


class PDF extends FPDF
	{
var $widths;
var $aligns;

//Funcion para definir el tamaño de las columnas
	function SetWidths($w)
	{
    $this->widths=$w;
}
	 
	function SetAligns($a)
	{
	    $this->aligns=$a;
}
//Funcion para Mostrar los datos en filas 
function Row($data)
	{
    $nb=0;
    for($i=0;$i<count($data);$i++)
	        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
   $h=4*$nb;
   $this->CheckPageBreak($h);
	    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
	        $x=$this->GetX();
        $y=$this->GetY();
	        $this->Rect($x,$y,$w,$h);
	        $this->MultiCell($w,4,$data[$i],0,$a);
	        $this->SetXY($x+$w,$y);
		


    }
	    $this->Ln($h);
	}
	 
	function CheckPageBreak($h)
	{
	    if($this->GetY()+$h>$this->PageBreakTrigger)
	        $this->AddPage($this->CurOrientation);
	}
	 
	function NbLines($w,$txt)
	{
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
    $sep=-1;
	    $i=0;
    $j=0;
	    $l=0;
	    $nl=1;
    while($i<$nb)
	    {
	        $c=$s[$i];
	        if($c=="\n")
	        {
            $i++;
	            $sep=-1;
	            $j=$i;
            $l=0;
	            $nl++;
	            continue;
	        }
        if($c==' ')
	            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
	        {
	            if($sep==-1)
	            {
	                if($i==$j)
	                    $i++;
	            }
	            else
	                $i=$sep+1;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	        }
	        else
	            $i++;
	    }
	    return $nl;
	}
	
	
//Funcion para el Encabezado
	function Header()
	{
		

	
	//$this->Image('imagenes/logoHeader2.jpg', 20, 10, 100);	
	$this->SetFont('Arial', 'B', 10);
	$this->SetDrawColor(255, 255, 255); $this->SetFillColor(255, 255, 255); $this->SetTextColor(0, 0, 0);
	$this->SetFont('Arial', 'B', 10);
	$this->SetWidths(array(180));
	$this->SetAligns(array('C'));
	$this->Ln(20);
	$this->Row(array('LISTADO DE PRODUCTOS'));
	$this->Ln(10);
	$this->SetDrawColor(0, 0, 0); $this->SetFillColor(0, 0, 0); $this->SetTextColor(0, 0, 0);
	$y=$this->GetY();
	$this->Rect(5, $y, 200, 0.1, "DF");
	$this->Ln(1);
	}
//---------------------------------------------------
	 //funcion para el pie de Pagina
	function Footer()
	{
		
	    $this->SetY(-15);
	    $this->SetFont('Arial','B',10);
		$this->SetDrawColor(0, 0, 0); $this->SetFillColor(0, 0, 0); $this->SetTextColor(0, 0, 0);
		$y=$this->GetY();
		$this->Rect(5, $y, 200, 0.1, "DF");

	}
	}
	


// creamos el objeto FPDF
	$pdf=new PDF('P','mm','Letter'); // vertical, milimetros y tamaño
	$pdf->Open();
	$pdf->SetFillColor(210,0,0);
	$pdf->AddPage(); // agregamos la pagina
	$pdf->SetMargins(10,10,10); // definimos los margenes en este caso estan en milimetros
	 // dejamos un pequeño espacio de 10 milimetros
	

//obtener los regsitro


//agregamos encabezados de productos
	$pdf->SetDrawColor(255, 255, 255);$pdf->SetFillColor(255, 255, 255); $pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetWidths(array(20, 100, 30,  40));
	$pdf->SetAligns(array('C', 'C', 'C', 'C'));
	$pdf->Row(array('Codigo', 'Descripcion', 'Disponible', 'Precio'));
	$pdf->Ln(2);
	$pdf->SetDrawColor(0, 0, 0); $pdf->SetFillColor(0, 0, 0); $pdf->SetTextColor(0, 0, 0);
	$y=$pdf->GetY();
	$pdf->Rect(5, $y, 200, 0.1, "DF");
	$pdf->Ln(2);
	$pdf->SetDrawColor(255, 255, 255);$pdf->SetFillColor(255, 255, 255); $pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial', '', 10);
	


// Realizamos nuestra consulta
	mysql_select_db($database_conexion, $conexion);
	$strConsulta = "SELECT *
			FROM productos
			";
	
	// ejecutamos la consulta
	$productos = mysql_query($strConsulta, $conexion) or die(mysql_error());
		
	// listamos la tabla de electore 
	$numfilas = mysql_num_rows($productos);
for ($i=0; $i<$numfilas; $i++)   {       
	
	$fila = mysql_fetch_array($productos);                  
	
  //obtenemso el precio del producto
mysql_select_db($database_conexion, $conexion);
$query_precios = "SELECT * FROM precios where id_producto='$fila[id_producto]' order by id_precios desc";
$precios = mysql_query($query_precios, $conexion) or die(mysql_error());
$row_precios = mysql_fetch_assoc($precios);
$totalRows_precios = mysql_num_rows($precios);	
		
	//consultamos disponibilidad
							$query_almacen = "SELECT sum(cantidad) FROM almacen where id_producto='$fila[id_producto]' and (transaccion='COMPRA' or transaccion='COMPRA-MODIFICADA') ";
							$almacen = mysql_query($query_almacen, $conexion) or die(mysql_error());
							$row_almacen = mysql_fetch_assoc($almacen);
							
							$query_almacen2 = "SELECT sum(cantidad) FROM almacen where  id_producto='$fila[id_producto]' and transaccion='VENTA' ";
							$almacen2 = mysql_query($query_almacen2, $conexion) or die(mysql_error());
							$row_almacen2 = mysql_fetch_assoc($almacen2);
							
							$query_pedido = "SELECT sum(cantidad) FROM pedido_productos where  id_producto='$fila[id_producto]' ";
							$pedido = mysql_query($query_pedido, $conexion) or die(mysql_error());
							$row_pedido = mysql_fetch_assoc($pedido);
							
							$query_almacen3 = "SELECT sum(cantidad) FROM almacen where  id_producto='$fila[id_producto]' and transaccion='EXTRAIDO' ";
							$almacen3 = mysql_query($query_almacen3, $conexion) or die(mysql_error());
							$row_almacen3 = mysql_fetch_assoc($almacen3);
							
							
							$disponible=$row_almacen["sum(cantidad)"]-$row_almacen2["sum(cantidad)"]-$row_pedido["sum(cantidad)"]-$row_almacen3["sum(cantidad)"];
						
	$pdf->Row(array($fila['codigo'], $fila['nombre'], $disponible, $row_precios['precio']));
		}


$pdf->Output();


?>