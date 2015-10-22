<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();
	$nombreUsuario = $_POST['nombreUsuario'];
	$aliasUsuario = $_POST['aliasUsuario'];
	$passUsuario = $_POST['passUsuario'];
	$confirmarPass = $_POST['confirmarPass'];
	
	$timestamp = date("Y-m-d H:i:s");

	
	$insert    = "INSERT INTO usuario values ('','$nombreUsuario','$aliasUsuario','$passUsuario')";
	$resI = mysql_query($insert) or die (mysql_error());

	salir();
	
	$arrayjson = array();
	$arrayjson[]=array('nombreUsuario'=> $nombreUsuario,
						'aliasUsuario'=> $aliasUsuario
					  );

	echo json_encode($arrayjson);
?>