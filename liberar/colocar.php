<?php 
	require_once("../clases/conect.php");
	require_once("../clases/consultas.php");
	date_default_timezone_set("America/Guayaquil");

	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];	
	$timestamp = date("Y-m-d H:i:s");
	
	$id_espacio = "";
	$id_ticket ="";
	
	$espacioMAX = consultarMAX("espacio","id_espacio","nombre_espacio","=",$_POST["nespacio"]);
		while ($espacio = mysql_fetch_array($espacioMAX)) {
			$id_espacio = $espacio["id_espacio"];
		}
	// var_dump($id_espacio);
	$ticketMAX = consultarMAX("ticket","id_ticket","id_espacio","=",$id_espacio);
		while ($ticket = mysql_fetch_array($ticketMAX)) {
			$id_ticket = $ticket["id_ticket"];
		}
	// var_dump($id_ticket);

	conexion();
	
	$updateE    = "UPDATE espacio SET estado_espacio='LIBRE' WHERE nombre_espacio='$nespacio'";
	$resE = mysql_query($updateE) or die (mysql_error());
	$updateT    = "UPDATE ticket SET fecha_salida_ticket='$timestamp' WHERE id_ticket='$id_ticket'";
	$resT = mysql_query($updateT) or die (mysql_error());
	
	$espaciosVacios = consultarGeneral("espacio","estado_espacio","=","LIBRE");
	while($arr = mysql_fetch_array($espaciosVacios)){ $espacios = "<th class='espacios' id='".$arr['nombre_espacio']."' valor='".$arr['nombre_espacio']."'>".$arr['nombre_espacio']."</th>";}
	conexion();
	$idpiso = "";
	// var_dump($nespacio);
	$queryIdEsp = mysql_query("SELECT * FROM espacio WHERE nombre_espacio='$nespacio'");
	while ($ides = mysql_fetch_array($queryIdEsp)) {
		$idespacio = $ides["id_espacio"]; 
		$idpiso = $ides["id_piso"]; 
	}

	salir();

	$edificio="";
	if ($idpiso > 0 and $idpiso < 6) {
		$edificio = "1";
		// $libresA = $libresA +1;
		// $ocupadosA = $ocupadosA -1;
	}elseif ($idpiso > 5 and $idpiso < 10) {
		$edificio = "2";
		// $libresB = $libresB +1;
		// $ocupadosB = $ocupadosB -1;
	}else{
		$edificio = "3";
		// $libresE = $libresE +1;
		// $ocupadosE = $ocupadosE -1;
	}
	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $nespacio,
						'placa'   => $placa,						
						'edificio'=> $edificio,
						'piso'=> $idpiso,
						'estado'=> 'OCUPADO',						
						'actualizacion' => '2'
					  );
	
	echo json_encode($arrayjson);
 ?>