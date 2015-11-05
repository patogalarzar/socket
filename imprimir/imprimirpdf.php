<?php
	require('fpdf.php');
	$nusuario = $_GET['usuarioSistema'];
	$fechaRegistro = $_GET['fechaRegistro'];
	$edificioEspacio = $_GET['edificioEspacio'];
	$pisoEspacio = $_GET['pisoEspacio'];
	$nespacio = $_GET['espacioSeleccionado'];
	$placa = $_GET['placaVehiculo'];
	
	// $pdf = new FPDF('P','mm','A5');
	// $pdf->AddPage();
	// $pdf->SetFont('Arial','B',16);
	// $pdf->Cell(0,15,'Ticket de parqueo',0,1,'C');
	// $pdf->Cell(50,10,'Usuario: ',1);
	// $pdf->Cell(0,10,$nusuario,1,1);
	// $pdf->Cell(50,10,'Fecha Registro: ',1);
	// $pdf->Cell(0,10,$fechaRegistro,1,1);
	// $pdf->Cell(50,10,'Edificio: ',1);
	// $pdf->Cell(0,10,$edificioEspacio,1,1);
	// $pdf->Cell(50,10,'Piso: ',1);
	// $pdf->Cell(0,10,$pisoEspacio,1,1);
	// $pdf->Cell(50,10,'Espacio: ',1);
	// $pdf->Cell(0,10,$nespacio,1,1);
	// $pdf->Cell(50,10,'Placa Vehiculo: ',1);
	// $pdf->Cell(0,10,$placa,1,1);
	// $pdf->Output();

?>
<!DOCTYPE html>
<html>
	<head>		
		<meta charset="utf-8" />
		<title>OROMALL - Ticket</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="../css/style.css">	
		<link rel="stylesheet" type="text/css" href="../fonts/flaticon/flaticon.css"> 
	    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

		<script languaje="JavaScript">
			function imprimir() {
				if (window.print)
					window.print();
				else
					alert("Disculpe, su navegador no soporta esta opción.");
			}
		</script>
	</head>
	<body onLoad="javascript:imprimir()">
		<h3>Liberar el espacio de parqueo</h3>
		<div class="caja">			
			<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." value="<?php echo "Usuario: ".$nusuario; ?>"/>
			<input class="cajatexto" id="fechaSalida" type="text" placeholder="Usuario..." value="<?php echo "Fecha Salida: ".$fechaRegistro; ?>"/>
			<input class="cajatexto" id="edificioEspacio" type="text" placeholder="Edificio espacio..." value='<?php echo "Edificio: ".$edificioEspacio; ?>'/>
			<input class="cajatexto" id="pisoEspacio" type="text" placeholder="Piso espacio..." value="<?php echo "Piso: ".$pisoEspacio; ?>"/>
			<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..." value="<?php echo "Espacio: ".$nespacio; ?>"/>
			<input class="cajatexto" id="placa" type="text" placeholder="Espacio parqueo..." value="<?php echo "Placa: ".$placa; ?>"/>
		</div>
	</body>
</html>
