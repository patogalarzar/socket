<?php
	require('fpdf.php');
	$nusuario = $_POST['usuarioSistema'];
	$fechaRegistro = $_POST['fechaRegistro'];
	$edificioEspacio = $_POST['edificioEspacio'];
	$pisoEspacio = $_POST['pisoEspacio'];
	$nespacio = $_POST['espacioSeleccionado'];
	$placa = $_POST['placaVehiculo'];
	
	$pdf = new FPDF('P','mm','A5');
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,15,'Ticket de parqueo',0,1,'C');
	$pdf->Cell(50,10,'Usuario: ',1);
	$pdf->Cell(0,10,$nusuario,1,1);
	$pdf->Cell(50,10,'Fecha Registro: ',1);
	$pdf->Cell(0,10,$fechaRegistro,1,1);
	$pdf->Cell(50,10,'Edificio: ',1);
	$pdf->Cell(0,10,$edificioEspacio,1,1);
	$pdf->Cell(50,10,'Piso: ',1);
	$pdf->Cell(0,10,$pisoEspacio,1,1);
	$pdf->Cell(50,10,'Espacio: ',1);
	$pdf->Cell(0,10,$nespacio,1,1);
	$pdf->Cell(50,10,'Placa Vehiculo: ',1);
	$pdf->Cell(0,10,$placa,1,1);
	$pdf->Output();

?>
