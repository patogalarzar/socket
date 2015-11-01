<?php
	require_once("../clases/conect.php");
	date_default_timezone_set("America/Guayaquil");

	conexion();
	$nespacio = $_POST['nespacio'];
	$placa = $_POST['placa'];
	$nusuario = $_POST['nusuario'];
	$libresA = $_POST['libresA'];
	$ocupadosA = $_POST['ocupadosA'];
	$libresB = $_POST['libresB'];
	$ocupadosB = $_POST['ocupadosB'];
	$libresE = $_POST['libresE'];
	$ocupadosE = $_POST['ocupadosE'];
	$timestamp = date("Y-m-d H:i:s");

	$contas1=$_POST['contas1'];
	$contas2=$_POST['contas2'];
	$contap1=$_POST['contap1'];
	$contap2=$_POST['contap2'];
	$contap3=$_POST['contap3'];
	$contbp1=$_POST['contbp1'];
	$contbp2=$_POST['contbp2'];
	$contbp3=$_POST['contbp3'];
	$contbp4=$_POST['contbp4'];

	$idespacio = "";
	$idpiso = "";

	$queryIdEsp = mysql_query("SELECT * FROM espacio WHERE nombre_espacio='$nespacio'");
	while ($ides = mysql_fetch_array($queryIdEsp)) {
		$idespacio = $ides["id_espacio"]; 
		$idpiso = $ides["id_piso"]; 
	}

	// $idusuario = "";

	// $queryIdUs = mysql_query("SELECT id_usuario FROM usuario WHERE alias_usuario='$nusuario'");
	// while ($idus = mysql_fetch_array($queryIdUs)) {
	// 	$idusuario = $idus["id_usuario"];
	// }

	$insert    = "INSERT INTO ticket values ('','$placa','$timestamp','','1','$idespacio','$nusuario')";
	$resI = mysql_query($insert) or die (mysql_error());

	$update    = "UPDATE espacio SET estado_espacio='OCUPADO' WHERE nombre_espacio='".$nespacio."'";
	$resU = mysql_query($update) or die (mysql_error());
	
	salir();
	
	$edificio="";
	if ($idpiso > 0 and $idpiso < 6) {
		$edificio = "1";
		$libresA = $libresA -1;
		$ocupadosA = $ocupadosA +1;
		if ($idpiso==1) {
			$contas1++;
		}elseif ($idpiso==2) {
			$contas2++;
		}elseif ($idpiso==3) {
			$contap1++;
		}elseif ($idpiso==4) {
			$contap2++;
		}elseif ($idpiso==5) {
			$contap3++;
		}
	}elseif ($idpiso > 5 and $idpiso < 10) {
		$edificio = "2";
		$libresB = $libresB -1;
		$ocupadosB = $ocupadosB +1;
		if ($idpiso==6) {
			$contbp1++;
		}elseif ($idpiso==7) {
			$contbp2++;
		}elseif ($idpiso==8) {
			$contbp3++;
		}elseif ($idpiso==9) {
			$contbp4++;
		}
	}else{
		$edificio = "3";
		$libresE = $libresE -1;
		$ocupadosE = $ocupadosE +1;
	}
	$arrayjson = array();
	$arrayjson[]=array('nespacio'=> $nespacio,
						'placa'   => $placa,
						'nusuario'=> $nusuario,
						'edificio'=> $edificio,
						'libresA' => $libresA,
						'ocupadosA' => $ocupadosA,
						'libresB' => $libresB,
						'ocupadosB' => $ocupadosB,
						'libresE' => $libresE,
						'ocupadosE' => $ocupadosE,
						'actualizacion' => '1',
						'contas1'=>$contas1,
						'contas2'=>$contas2,
						'contap1'=>$contap1,
						'contap2'=>$contap2,
						'contap3'=>$contap3,
						'contbp1'=>$contbp1,
						'contbp2'=>$contbp2,
						'contbp3'=>$contbp3,
						'contbp4'=>$contbp4
					  );
	echo json_encode($arrayjson);
?>