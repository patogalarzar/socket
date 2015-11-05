<?php 
//INICIAMOS LA SESION
	session_start();

	//boton salir desconatamosy borramos la sesion
	if (!empty($_GET['salir'])) {
		//limpiar las varibles de sesion t destruirla
		$_SESSION['id_usuario'] = "";
		session_unset();
		session_destroy();
	}

	//
	if (empty($_SESSION['id_usuario'])) {
		header("Location: /socket/");
	}else{
		require_once("../clases/consultas.php");
		date_default_timezone_set("America/Guayaquil");
		$id_usuario = $_SESSION['id_usuario'];
		$nespacio = "";
		$placa = "";
		$espaciosOcupados = consultarGeneral("espacio","estado_espacio","=","OCUPADO");
		$fechaSalida = date("Y-m-d H:i:s");		
		
		$id_piso="";
		$id_edificio = "";
		$nombre_piso = "";
		$tipo_piso = "";
		$nombre_edificio = "";
		$espacioMAX = consultarMAX("espacio","id_espacio","nombre_espacio","=",$_GET["nespacio"]);
		while ($espacio = mysql_fetch_array($espacioMAX)) {
			$id_espacio = $espacio["id_espacio"];
		}
		$ticketMAX = consultarMAX("ticket","id_ticket","id_espacio","=",$id_espacio);
		while ($ticket = mysql_fetch_array($ticketMAX)) {
			$id_ticket = $ticket["id_ticket"];
		}
		$ticketGNRL = consultarGeneral("ticket","id_ticket","=",$id_ticket);
		while ($ticket = mysql_fetch_array($ticketGNRL)) {
			$placa_ticket = $ticket["placa_ticket"];
		}
		$espacios  = consultarGeneral("espacio","nombre_espacio","=",$_GET['nespacio']);
		while ($espacio=mysql_fetch_array($espacios)) {
			$id_piso=$espacio["id_piso"];
		}
		$pisos = consultarGeneral("piso","id_piso","=",$id_piso);
		while ($piso = mysql_fetch_array($pisos)) {
			$id_edificio= $piso["id_edificio"];
			$nombre_piso = $piso["nombre_piso"];
			$tipo_piso = $piso["tipo_piso"];
		}
		$edificios = consultarGeneral("edificio","id_edificio","=",$id_edificio);
		while ($edificio = mysql_fetch_array($edificios)) {
			$nombre_edificio = $edificio["nombre_edificio"];
		}
	}
 ?>

<h3>Liberar el espacio de parqueo</h3>
<div class="caja">
	<input name="libresA" type="hidden" value="<?php echo $libresA; ?>"/>
	<input name="ocupadosA" type="hidden" value="<?php echo $ocupadosA; ?>"/>
	<input name="libresB" type="hidden" value="<?php echo $libresB; ?>"/>
	<input name="ocupadosB" type="hidden" value="<?php echo $ocupadosB; ?>"/>
	<input name="libresE" type="hidden" value="<?php echo $libresE; ?>"/>
	<input name="ocupadosE" type="hidden" value="<?php echo $ocupadosE; ?>"/>
	<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." value="<?php echo "Usuario: ".$nusuario; ?>"/>
	<input class="cajatexto" id="fechaSalida" type="text" placeholder="Usuario..." value="<?php echo "Fecha Salida: ".$fechaSalida; ?>"/>
	<input class="cajatexto" id="edificioEspacio" type="text" placeholder="Edificio espacio..." value='<?php echo "Edificio: ".$nombre_piso; ?>'/>
	<input class="cajatexto" id="pisoEspacio" type="text" placeholder="Piso espacio..." value="<?php echo "Piso: ".$nombre_piso. " / ".$tipo_piso; ?>"/>
	<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..." value="<?php echo "Espacio: ".$_GET['nespacio']; ?>"/>
	<input class="cajatexto" id="espacioOculto" type="hidden"/>
	<input class="cajatexto" id="placaVehiculo" type="text" placeholder="Placa vehiculo..." valor='<?php echo $placa_ticket; ?>' value="<?php echo "Placa: ".$placa_ticket; ?>"/>
	<input class="cajatexto" id="placaOculta" type="hidden"/>	
	<input class="boton" type="submit" value="Liberar" onclick="liberar();"/>
	<input class="boton" type="submit" value="Cancelar" onclick="cancelarLiberar();"/>
</div>
