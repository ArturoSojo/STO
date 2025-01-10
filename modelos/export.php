<?php
require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
   // $this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Reporte de Pedidos Entregados',0,0,'C');
    // Salto de línea
    $this->Ln(10);

    $this->Cell(30,10,'Cliente',1,0,'C',0);
    $this->Cell(30,10,'Producto',1,0,'C',0);
	$this->Cell(20,10,'Cantidad',1,0,'C',0);
	$this->Cell(25,10,'Pago',1,0,'C',0);
  $this->Cell(30,10,'Tipo de Pago',1,0,'C',0);
  $this->Cell(25,10,'Referencia',1,0,'C',0);
	$this->Cell(30,10,"Fecha",1,1,'C',0);


}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Pagina').$this->PageNo().'/{nb}',0,0,'C');
}
}

$base= new mysqli("localhost","root","","sto");

$modo = $_POST["modo"];

$dia_hoy = (int)date('d'); 
$mes_hoy = (int)date('m'); 
$anio_hoy = (int)date('Y'); 

 if ($modo == "Día") {

 	$fecha = date("Y-m-d");
	$sql = "SELECT * FROM pedidos WHERE pedido_fecha= '$fecha' AND pedido_estado_envio= 'Entregado' ORDER BY pedido_id DESC";

 }elseif ($modo == "Semana") {
 
  	$semana = mktime(0, 0, 0, $mes_hoy, $dia_hoy-7, $anio_hoy); 
  	$fecha = date("Y-m-d", $semana);
  	$fecha1 = date("Y-m-d");
 	
	$sql = "SELECT * FROM pedidos WHERE pedido_estado_envio='Entregado' AND pedido_fecha BETWEEN '$fecha' AND '$fecha1' ORDER BY pedido_id DESC";
 
 }elseif ($modo == "Mes") {
 
  	$mes1 = mktime(0, 0, 0, $mes_hoy-1, $dia_hoy, $anio_hoy);  
  	$antes = date("Y-m-d", $mes1);
  	$dia = date("Y-m-d");
 	
	$sql = "SELECT * FROM pedidos WHERE pedido_estado_envio='Entregado' AND pedido_fecha BETWEEN '$antes' AND '$dia' ORDER BY pedido_id DESC";

 }
	
	$resultado=$base->query($sql);
           
            // Creación del objeto de la clase heredada
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial','',9);
             
            while ($row = $resultado->fetch_assoc()) {

            	$id_cli = $row['cliente_id'];

              $query = "SELECT * FROM cliente WHERE cliente_id='$id_cli'";
              $customer=$base->query($query);
              $cliente = $customer->fetch_assoc();

    $pdf->Cell(30,10,utf8_decode($cliente['cliente_nombre']) . ' ' . utf8_decode($cliente['cliente_apellido']),1,0,'C',0);
                $pdf->Cell(30,10,utf8_decode($row['pedido_nombre']),1,0,'C',0);
                $pdf->Cell(20,10,$row['pedido_cantidad'],1,0,'C',0);
                $pdf->Cell(25,10,$row['pedido_costo']."Bs",1,0,'C',0);
                $pdf->Cell(30,10,$row['tipo_pago'],1,0,'C',0);
                $pdf->Cell(25,10,$row['referencia'],1,0,'C',0);
                $pdf->Cell(30,10,$row['pedido_fecha'],1,1,'C',0);
            }
           
            $pdf->Output();

?>