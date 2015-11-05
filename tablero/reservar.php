<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();

	$idpiso = "";

	$queryIdEsp = mysql_query("SELECT * FROM espacio WHERE nombre_espacio='".$_POST['nespacio']."'");
	while ($ides = mysql_fetch_array($queryIdEsp)) {		
		$idpiso = $ides["id_piso"]; 
	}
			
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
		                'piso'=> $idpiso,
						'actualizacion' => '3'						
					  );

	echo json_encode($arrayjson);

	// header('Location: ../tablero/');
?>