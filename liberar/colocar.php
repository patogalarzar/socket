<?php 
	require_once("../clases/conect.php");
	require_once("../clases/consultas.php");
	
	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];
	$nusuario = $_POST['nusuario'];
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
	
	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $nespacio,
					   'placa'   => $placa,
					   'nusuario'=> $nusuario,
					   'actualizacion' => '2',
					   'espacios' => $espacios
	);
	
	echo json_encode($arrayjson);
 ?>