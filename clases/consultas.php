<?php 
	require_once("conect.php");
	conexion();
	function consultarGeneral($tabla,$campo,$condicion,$parametro){
		conexion();
		$query = "SELECT * FROM ".$tabla." WHERE ".$campo.$condicion."'".$parametro."'";
		// echo $query."<br>";
		$resultado = mysql_query($query);
		salir();
		return $resultado;		
	}

 ?>