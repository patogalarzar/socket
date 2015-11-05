<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();
	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];
	$nusuario = $_POST['nusuario'];	
	$timestamp = date("Y-m-d H:i:s");

	$idespacio = "";
	$idpiso = "";

	$queryIdEsp = mysql_query("SELECT * FROM espacio WHERE nombre_espacio='$nespacio'");
	while ($ides = mysql_fetch_array($queryIdEsp)) {
		$idespacio = $ides["id_espacio"]; 
		$idpiso = $ides["id_piso"]; 
	}

	$idusuario = "";

	$queryIdUs = mysql_query("SELECT id_usuario FROM usuario WHERE alias_usuario='$nusuario'");
	while ($idus = mysql_fetch_array($queryIdUs)) {
		$idusuario = $idus["id_usuario"];
	}

	$insert    = "INSERT INTO ticket values ('','$placa','$timestamp','','1','$idespacio','$nusuario')";
	$resI = mysql_query($insert) or die (mysql_error());

	$update    = "UPDATE espacio SET estado_espacio='OCUPADO' WHERE nombre_espacio='".$nespacio."'";
	$resU = mysql_query($update) or die (mysql_error());
	
	salir();
	
	$edificio="";
	if ($idpiso > 0 and $idpiso < 6) {
		$edificio = "1";		
	}elseif ($idpiso > 5 and $idpiso < 10) {
		$edificio = "2";		
	}else{
		$edificio = "3";		
	}
	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $nespacio,
						'placa'   => $placa,
						'nusuario'=> $nusuario,
						'edificio'=> $edificio,
						'piso'=> $idpiso,						
						'actualizacion' => '1',
						'estado' => 'RESERVADO'					
					  );

	echo json_encode($arrayjson);
?>