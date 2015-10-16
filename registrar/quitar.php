<?php
	require_once("../clases/conect.php");

	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];
	$nusuario = $_POST['nusuario'];

	$timestamp = date("Y-m-d H:i:s");
	conexion();
	$idespacio = mysql_query("SELECT id_espacio FROM espacio WHERE nombre_espacio='$nespacio'");
	// var_dump($id_espacio);
	$idusuario = mysql_query("SELECT id_usuario FROM usuario WHERE alias_usuario='$nusuario'");
	$insert    = "INSERT INTO ticket values ('','$placa','$timestamp','','1','$idespacio','$idusuario')";
	$resI = mysql_query($insert) or die (mysql_error());
	$update    = "UPDATE espacio SET estado_espacio='OCUPADO' WHERE nombre_espacio='$nespacio'";
	$resU = mysql_query($update) or die (mysql_error());

	salir();

	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $nespacio,
						'placa'   => $placa,
						'nusuario'=> $nusuario,
						'actualizacion' => '1'
					  );

	echo json_encode($arrayjson);
?>