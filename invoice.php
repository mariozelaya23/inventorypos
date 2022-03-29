<?php

//Call the FPDF library
require('fpdf/fpdf.php');

//A4 width : 219mm



//default margin : 10mm each side

//writable horizonal : 219-(10*2) = 189mm

//create pdf object
$pdf = new FPDF('P','mm','A4');


//String orientation (P or L) - portrait or landscape

//String unit (pt,mm,cm and in) - measure unit

//Mixed format (A3, A4, A5, Letter and Legal) - format of pages

//add new page
$pdf->AddPage();

//$pdf->SetFillColor(123,255,234);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(80,10,'Server Net Hosting',0,0,'');

$pdf->SetFont('Arial','B',13);
$pdf->Cell(112,10,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Address: Simi Valley, C.A.',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Invoice: #12345',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Phone number: 805-365-6520',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Date: 03/29/2022',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Email: info@servernethosting.com',0,1,'');
$pdf->Cell(80,5,'Website: www.servernethosting.com',0,1,'');

//output the result
$pdf->Output();

?>