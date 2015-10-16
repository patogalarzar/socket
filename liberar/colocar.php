<?php 
	require_once("../clases/consultas.php");
	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];
	$nusuario = $_POST['nusuario'];
	$timestamp = date("Y-m-d H:i:s");
	
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