<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();
		
	$update    = "UPDATE espacio SET estado_espacio='RESERVADO' WHERE nombre_espacio='".$_POST['nespacio']."'";
	$resU = mysql_query($update) or die (mysql_error());

	if ( isset($_POST['idAnterior']) && !empty($_POST['idAnterior'])) {
		$update    = "UPDATE espacio SET estado_espacio='LIBRE' WHERE nombre_espacio='".$_POST['idAnterior']."'";
		$resU = mysql_query($update) or die (mysql_error());
	}
	
	salir();
	
	
	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $_POST['nespacio'],						
		                'idAnterior'=> $_POST['idAnterior'],
						'actualizacion' => '3'						
					  );

	echo json_encode($arrayjson);

	// header('Location: ../tablero/');
?>