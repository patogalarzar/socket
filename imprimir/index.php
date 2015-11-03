<html>
<head>
	<title>Imprimir pdf</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="../css/style.css">	
	<link type="text/css" rel="stylesheet"  href="../fonts/flaticon/flaticon.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <script src="../js/jquery-1.7.2.min.js"></script>
	<script src="../js/fancywebsocket.js"></script>
	<script src="../js/socket.js"></script>
	<script language="javascript">
		function imprimir()
		{	
			alert("alert");
			window.location.href="/tablero/";
			// $.ajax({
				
				// type: "get",
				// url: "imprimirpdf.php",
				// data: "nespacio="+nespacio+"&placa="+placa+"&nusuario="+nusuario+"&libresA="+libresA+"&ocupadosA="+ocupadosA+"&libresB="+libresB+"&ocupadosB="+ocupadosB+"&libresE="+libresE+"&ocupadosE="+ocupadosE+"&contas1="+contas1+"&contas2="+contas2+"&contap1="+contap1+"&contap2="+contap2+"&contap3="+contap3+"&contbp1="+contbp1+"&contbp2="+contbp2+"&contbp3="+contbp3+"&contbp4="+contbp4,
				// dataType:"html",
				// success: function(data) 
				// {
				// 	// alert(data);
				//  	// send(data);// array JSON
				//  	// window.location="../tablero/";
				// 	// document.getElementById("espacioSeleccionado").value = "";
				// 	// document.getElementById("placaVehiculo").value = "";
				// },
				// error:function(data){
				// 	// alert(data);
				// }
			// });
		}
	</script>
</head>
<body>
	<div class="contenedor">
 		<section id="imprimir" class="contenido">
 			<h3>Imprimir ticket de parqueo</h3>
			<div class="caja">
				<form action="imprimirpdf.php" method=POST target="_blank">
					<input class="cajatexto" id="usuarioSistema" name="usuarioSistema" type="text" placeholder="Usuario..." value="PATO"/>
					<input class="cajatexto" id="fechaRegistro" name="fechaRegistro" type="text" placeholder="Fecha..." value="02/11/2015"/>
					<input class="cajatexto" id="edificioEspacio" name="edificioEspacio" type="text" placeholder="Edificio espacio..." value="TORRE A"/>
					<input class="cajatexto" id="pisoEspacio" name="pisoEspacio" type="text" placeholder="Piso espacio..." value="AS1 / SUBSUELO"/>
					<input class="cajatexto" id="espacioSeleccionado" name="espacioSeleccionado" type="text" placeholder="Espacio parqueo..." value="A1"/>
					<input class="cajatexto" id="placaVehiculo" name="placaVehiculo" type="text" placeholder="Placa vehiculo..."/>
					<input class="boton" type="submit" value="Registrar" onclick="imprimir();"/>
				</form>
				
			</div>
 	  	</section>
 	</div>

</body>
</html>