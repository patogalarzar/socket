<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();
	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];
	$nusuario = $_POST['nusuario'];
	$libresA = $_POST['libresA'];
	$ocupadosA = $_POST['ocupadosA'];
	$libresB = $_POST['libresB'];
	$ocupadosB = $_POST['ocupadosB'];
	$libresE = $_POST['libresE'];
	$ocupadosE = $_POST['ocupadosE'];
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

	$insert    = "INSERT INTO ticket values ('','$placa','$timestamp','','1','$idespacio','$idusuario')";
	$resI = mysql_query($insert) or die (mysql_error());

	$update    = "UPDATE espacio SET estado_espacio='OCUPADO' WHERE nombre_espacio='".$nespacio."'";
	$resU = mysql_query($update) or die (mysql_error());
	
	salir();
	
	$edificio="";
	if ($idpiso > 0 and $idpiso < 6) {
		$edificio = "1";
		$libresA = $libresA -1;
		$ocupadosA = $ocupadosA +1;
	}elseif ($idpiso > 5 and $idpiso < 10) {
		$edificio = "2";
		$libresB = $libresB -1;
		$ocupadosB = $ocupadosB +1;
	}else{
		$edificio = "3";
		$libresE = $libresE -1;
		$ocupadosE = $ocupadosE +1;
	}
	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $nespacio,
						'placa'   => $placa,
						'nusuario'=> $nusuario,
						'edificio'=> $edificio,
						'libresA' => $libresA,
						'ocupadosA' => $ocupadosA,
						'libresB' => $libresB,
						'ocupadosB' => $ocupadosB,
						'libresE' => $libresE,
						'ocupadosE' => $ocupadosE,
						'actualizacion' => '1'
					  );

	echo json_encode($arrayjson);
?>