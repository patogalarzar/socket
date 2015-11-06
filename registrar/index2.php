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

		$espaciosVacios = consultarGeneral("espacio","estado_espacio","=","LIBRE");
		$nespacio = $_GET['nespacio'];		
		$id_piso="";
		$id_edificio = "";
		$nombre_piso = "";
		$tipo_piso = "";
		$nombre_edificio = "";
		
		$nusuario=$id_usuario;
		
		$fechaRegistro = date("Y-m-d H:i:s");
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
		conexion();
		$nusuario="";
		$usuarios = mysql_query("SELECT * FROM usuario WHERE id_usuario = $id_usuario");
		while ($arr = mysql_fetch_array($usuarios)) {
			$nusuario = $arr["alias_usuario"];
		}
		salir();
	}
 ?>
 
 	
<h3>Registrar el espacio de parqueo</h3>
<div class="caja">
	<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." data-valor="<?php echo $nusuario; ?>" value="<?php echo "Usuario: ".$nusuario; ?>"/>
	<input class="cajatexto" id="fechaRegistro" type="text" placeholder="Usuario..." data-valor="<?php echo $fechaRegistro; ?>" value="<?php echo "Fecha: ".$fechaRegistro; ?>"/>
	<input class="cajatexto" id="edificioEspacio" type="text" placeholder="Edificio espacio..." data-valor="<?php echo $nombre_edificio; ?>" value="<?php echo "Edificio: ".$nombre_edificio; ?>"/>
	<input class="cajatexto" id="pisoEspacio" type="text" placeholder="Piso espacio..." data-valor="<?php echo $nombre_piso." / ".$tipo_piso; ?>" value="<?php echo "Piso: ".$nombre_piso. " / ".$tipo_piso; ?>"/>
	<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..." data-valor="<?php echo $nespacio; ?>" value="<?php echo "Espacio: ".$nespacio; ?>"/>
	<input class="cajatexto" id="placaVehiculo" type="text" placeholder="Placa vehiculo..." required/>
	<div id='msg'>Imprima su Ticket para continuar.</div>
	<input id='btnImprimir' class="boton" type="submit" value="Imprimir" onclick="imprimir();"/>
	<input id='btnRegistrar' class="boton" type="submit" value="Registrar" onclick="registrar();"/>		
	<input id='btnCancelar' class="boton" type="submit" value="Cancelar" onclick="cancelarRegistrar();"/>				
</div>