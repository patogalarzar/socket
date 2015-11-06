<?php 
	require("/clases/consultas.php");

	$total_libres = 0;
	$total_reservados = 0;	
	$total_ocupados = 0;

	$torres = array();
	$libres = array();
	$reservados = array();
	$ocupados = array();

	$edificios = consultarGeneral("edificio","id_edificio",">","0");  			
	while ( $arrEdi = mysql_fetch_array($edificios)) { 
		array_push($torres, $arrEdi['nombre_edificio']);
		$pisos = consultarGeneral("piso","id_edificio","=",$arrEdi['id_edificio']);
		while ( $arrP = mysql_fetch_array( $pisos)) {
			$espacios = consultarGeneral("espacio","id_piso","=",$arrP['id_piso']);
			while ( $arrEsp = mysql_fetch_array($espacios)) { 
				if ( $arrEsp['estado_espacio'] == 'LIBRE' ){
					$total_libres++;	
				}
				if ( $arrEsp['estado_espacio'] == 'RESERVADO' ){
					$total_reservados++;	
				}
				if ( $arrEsp['estado_espacio'] == 'OCUPADO' ){
					$total_ocupados++;	
				}
			}			
		}
		array_push($libres, $total_libres);
		array_push($reservados, $total_reservados);
		array_push($ocupados, $total_ocupados);
		$total_libres = 0;
		$total_reservados = 0;	
		$total_ocupados = 0;	
	}

	$arrayjson = array();
	$oromall = array();
	array_push($oromall, array('edificios'=> $torres) );
	array_push($oromall, array('libres'=> $libres) );
	array_push($oromall, array('reservados'=> $reservados) );
	array_push($oromall, array('ocupados'=> $ocupados) );

	array_push($arrayjson, array('actualizacion' => '5') );
	array_push($arrayjson, $oromall );
		
	echo json_encode($arrayjson);
?>