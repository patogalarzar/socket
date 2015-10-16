<?php 
	require_once("../clases/consultas.php");
	if (isset($_GET["numespacio"]) && !empty($_GET["numespacio"])) {
		$espacioMAX = consultarMAX("espacio","id_espacio","nombre_espacio","=",$_GET["numespacio"]);
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
		echo $placa_ticket;	
	}else{
		echo "campo vacio";
	}
 ?>