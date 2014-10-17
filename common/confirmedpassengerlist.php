<?php
require('../fpdf/fpdf.php');
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="downloaded.pdf"');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();




?>