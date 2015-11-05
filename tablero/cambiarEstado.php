<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();
		
	$update  = "UPDATE espacio SET estado_espacio='".$_POST['estado']."' WHERE nombre_espacio='".$_POST['nespacio']."'";
	$resU = mysql_query($update) or die (mysql_error());

	salir();
	
	if ( $_POST['accion'] == 'CANCELAR_R') {
		$arrayjson = array();
		$arrayjson[] = array('nespacio'=> $_POST['nespacio'],			                
							'actualizacion' => '4',
							'estado'=> 'OCUPADO'
						  );		
	}else{
		$arrayjson = array();
		$arrayjson[] = array('nespacio'=> $_POST['nespacio'],			                
							'actualizacion' => '4',
							'estado'=> $_POST['estado']
						  );
	}
	echo json_encode($arrayjson);

	// header('Location: ../tablero/');
?>