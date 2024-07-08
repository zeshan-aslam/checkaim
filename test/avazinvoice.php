<?php
require('fpdf.php');


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'avaz test');
$pdf->Cell(40,11,'avaz test');
$pdf->Cell(50,200,'khushwinder');
$pdf->Output();
?>
