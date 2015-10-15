<?php
include("clases/conect.php");
$mensaje = $_POST['espacio'];
$tipo = $_POST['tipo'];

$timestamp = date("Y-m-d H:i:s");

// $q = "INSERT INTO mensajes values ('','$mensaje','$timestamp','1','$tipo')";
// $res = mysql_query($q) or die (mysql_error());


$arrayjson = array();

$arrayjson[] = array(
					'tipo'          => $tipo,//tipo de actualizacion
					'espacio'      => $mensaje,//mensaje
					'fecha'         => $timestamp,//fecha de envio
					'actualizacion' => '1'
);
var_dump($arrayjson);
echo json_encode($arrayjson);
?>