<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();		
	$update  = "UPDATE espacio SET estado_espacio='".$_POST['estado']."' WHERE nombre_espacio='".$_POST['nespacio']."'";
	$resU = mysql_query($update) or die (mysql_error());
	salir();
	conexion();
	$idpiso = "";
	// var_dump($nespacio);
	$queryIdEsp = mysql_query("SELECT * FROM espacio WHERE nombre_espacio='".$_POST['nespacio']."'");
	while ($ides = mysql_fetch_array($queryIdEsp)) {
		$idpiso = $ides["id_piso"]; 
	}
	salir();
	
	if ( $_POST['accion'] == 'CANCELAR_R') {
		$arrayjson = array();
		$arrayjson[] = array('nespacio'=> $_POST['nespacio'],			                
							'actualizacion' => '4',
							'piso'=> $idpiso,
							'estado'=> 'OCUPADO'
						  );		
	}else{
		$arrayjson = array();
		$arrayjson[] = array('nespacio'=> $_POST['nespacio'],			                
							'actualizacion' => '4',
							'estado'=> $_POST['estado'],
							'piso'=> $idpiso
						  );
	}
	echo json_encode($arrayjson);
?>