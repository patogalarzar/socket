<?php 
	require_once("../clases/consultas.php");
	if (isset($_GET["nespacio"]) && !empty($_GET["nespacio"])) {

		$id_piso="";
		$id_edificio = "";
		$nombre_piso = "";
		$tipo_piso = "";
		$nombre_edificio = "";

		$espacioMAX = consultarMAX("espacio","id_espacio","nombre_espacio","=",$_GET["nespacio"]);
		while ($espacio = mysql_fetch_array($espacioMAX)) {
			$id_espacio = $espacio["id_espacio"];
		}
		$ticketMAX = consultarMAX("ticket","id_ticket","id_espacio","=",$id_espacio);
		while ($ticket = mysql_fetch_array($ticketMAX)) {
			$id_ticket = $ticket["id_ticket"];
		}
		$ticketGNRL = consultarGeneral("ticket","id_ticket","=",$id_ticket);
		while ($ticket = mysql_fetch_array($ticketGNRL)) {
			$placa_ticket = $ticket["placa_ticket"];
		}
		$espacios  = consultarGeneral("espacio","nombre_espacio","=",$_GET['nespacio']);
		while ($espacio=mysql_fetch_array($espacios)) {
			$id_piso=$espacio["id_piso"];
		}
		$pisos = consultarGeneral("piso","id_piso","=",$id_piso);
		while ($piso = mysql_fetch_array($pisos)) {
			$id_edificio= $piso["id_edificio"];
			$nombre_piso = $piso["nombre_piso"];
			$tipo_piso = $piso["tipo_piso"];
		}
		$edificios = consultarGeneral("edificio","id_edificio","=",$id_edificio);
		while ($edificio = mysql_fetch_array($edificios)) {
			$nombre_edificio = $edificio["nombre_edificio"];
		}
		$resultado   = array();
		$resultado[] = array(	'placa' => $placa_ticket,
								'nombre_piso' => $nombre_piso,
								'tipo_piso' => $tipo_piso,
								'nombre_edificio' => $nombre_edificio
					   		);
		// var_dump($resultado);
		echo json_encode($resultado);	
	}else{
		echo "campo vacio";
	}
 ?>