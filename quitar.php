<?php
require_once("clases/conect.php");

$nespacio = $_POST['nespacio'];
$placa = $_POST['placa'];
$nusuario = $_POST['nusuario'];
$timestamp = date("Y-m-d H:i:s");
conexion();
$idespacio = "SELECT id_espacio FROM espacio WHERE nombre_espacio=nespacio";
$idusuario = "SELECT id_usuario FROM usuario WHERE alias_usuario=nusuario";
$insert    = "INSERT INTO ticket values ('','$placa','$timestamp','','$idespacio','$idusuario')";
$res = mysql_query($insert) or die (mysql_error());
salir();

$arrayjson = array();
$arrayjson[]=array('nespacio'=> $nespacio,
					'placa'   => $placa,
					'nusuario'=> $nusuario,
					'actualizacion' => '1'
			
		);
// $arrayjson[] = array(
// 					'tipo'          => $tipo,//tipo de actualizacion
// 					'espacio'       => $mensaje,//mensaje
// 					'fecha'         => $timestamp,//fecha de envio
// 					'actualizacion' => '1',
// 					'estado'        => $estado //prueba aumentando un elemento en el json
// );
echo json_encode($arrayjson);
?>