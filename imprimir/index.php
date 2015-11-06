<?php
require('pdf_js.php');

class PDF_AutoPrint extends PDF_JavaScript
{
function AutoPrint($dialog=false)
{
	//Open the print dialog or start printing immediately on the standard printer
	$param=($dialog ? 'true' : 'false');
	$script="print($param);";
	$this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
	//Print on a shared printer (requires at least Acrobat 6)
	$script = "var pp = getPrintParams();";
	if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
	else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
	$script .= "print(pp);";
	$this->IncludeJS($script);
}
}

$nusuario = $_GET['usuarioSistema'];
$fechaRegistro = $_GET['fechaRegistro'];
$edificioEspacio = $_GET['edificioEspacio'];
$pisoEspacio = $_GET['pisoEspacio'];
$nespacio = $_GET['espacioSeleccionado'];
$placa = $_GET['placaVehiculo'];

$pdf=new PDF_AutoPrint('P','mm','A5');
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
//Open the print dialog
$pdf->AutoPrint(true);
$pdf->Output();
?>
