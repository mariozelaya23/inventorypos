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
$pdf->AddPage('P');

//output the result
$pdf->Output();

?>