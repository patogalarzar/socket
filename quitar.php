<?php
include("clases/conect.php");
$mensaje = $_POST['espacio'];
$tipo = $_POST['tipo'];
$estado = $_POST['estado'];
$timestamp = date("Y-m-d H:i:s");

// $q = "INSERT INTO mensajes values ('','$mensaje','$timestamp','1','$tipo')";
// $res = mysql_query($q) or die (mysql_error());


$arrayjson = array();

$arrayjson[] = array(
					'tipo'          => $tipo,//tipo de actualizacion
					'espacio'       => $mensaje,//mensaje
					'fecha'         => $timestamp,//fecha de envio
					'actualizacion' => '1',
					'estado'        => $estado //prueba aumentando un elemento en el json
);
echo json_encode($arrayjson);
?>