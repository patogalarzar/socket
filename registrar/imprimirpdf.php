<?php
	require('fpdf.php');
	// $nusuario = $_POST['nusuario'];
	// $fechaRegistro = $_POST['fechaRegistro'];
	// $edificioEspacio = $_POST['edificioEspacio'];
	// $pisoEspacio = $_POST['pisoEspacio'];
	// $nespacio = $_POST['nespacio'];
	// $placa = $_POST['placa'];
	
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(40,10,'Ticket de parqueo');
	$pdf->Output();
?>
