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
		$libresA = $_GET['libresA'];
		$ocupadosA = $_GET['ocupadosA'];
		$contas1=$_GET['contas1'];
		$contas2=$_GET['contas2'];
		$contap1=$_GET['contap1'];
		$contap2=$_GET['contap2'];
		$contap3=$_GET['contap3'];
		$libresB = $_GET['libresB'];
		$ocupadosB = $_GET['ocupadosB'];
		$contbp1=$_GET['contbp1'];
		$contbp2=$_GET['contbp2'];
		$contbp3=$_GET['contbp3'];
		$contbp4=$_GET['contbp4'];
		$libresE = $_GET['libresE'];
		$ocupadosE = $_GET['ocupadosE'];
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
			$nusuario = $arr["nombre_usuario"];
		}
		salir();
	}
 ?>
 <html>
 <head>
 	<meta charset="utf-8" />
	<title>OROMALL</title>
	<!-- <link rel="stylesheet" href="css/style.css"> -->
	<script src="../js/jquery-1.7.2.min.js"></script>
	<script src="../js/fancywebsocket.js"></script>
	<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300);
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		.barra{
			/*display: inline-block;
			vertical-align: top;*/
		}
		
		.barralateral-principal{
		/*position: absolute;*/
		/*top: 0;
		left: 0;*/
		padding-top: 15;
		min-height: 100%;
		width: 19%;
		z-index: -1;
		}
		.barralateral{
		background-color: #3E474F;
		color: #fff;
		padding-bottom: 10px;

		}
		.barralateral-menu{
		font-family: 'Source Sans Pro', sans-serif;
		font-size: 18px;
		list-style: none;
	  	margin: 5px;
	  	padding-top: 60px;
	  	/*padding-left: 45px;*/
		}
		.barralateral-menu h3 {
		margin: 0 auto;
		padding: 0 0 18px;
		}
		.barralateral-menu li{
		position: relative;
	  	margin: 5px;
	  	padding: 0;
	  	list-style: none;
		}
		.barralateral-menu a {
		color: #fff;
		margin-left: 10px;
		text-decoration: none;
		}
		.boton{
		background-color: #00AB6B;
		border: 1px solid #fff;
		border-radius: 5px;
		color: #fff;
		display: block;
		margin: 10px auto;
		padding: 10px 5px;
		text-align: center;
		/*vertical-align: top;*/
		width: 160px;
		}
		.cabecera{
		background-color: #FF656D;
		color:#fff;
		/*display: block;*/
		/*float: left;*/
		font-family: 'Source Sans Pro', sans-serif;
		font-size: 20px;
		font-weight: 300;
		height: 65px;
		/*line-height: 50px;*/
		/*overflow: hidden;*/
		/*padding: 0 15px;*/
		position: fixed;
		text-align: left;
		width: 100%;
		z-index: 1;
		}
		.caja{
		background: #ffffff;
		border-radius: 3px;
		border-top: 5px solid #FF656D;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
		margin: 10px auto;
		margin-bottom: 20px;
		padding: 15px 15px;
 		/*position: relative;*/
		width: 50%;
		}
		.caja-menu{
		border-radius: 3px;
		border-top: 5px solid #FFF;
		/*box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);*/
		margin: 0 auto;
		/*margin-bottom: 20px;*/
		padding: 10px 5px;
		}
		.cajatexto{
		border: 1px solid #B8B8B8;
		border-radius: 5px;
		color: #B8B8B8;
		display: block;
		margin: 10px auto;
		padding: 10px 5px;
		vertical-align: top;
		width: 85%;
		}
		.celeste{
		background-color: #39cccc;
		}
		.contenedor, .barralateral-principal{
			display: inline-block;
			vertical-align: top;
		}
		.contenedor{
  		background-color: #ecf0f5;
  		font-family: 'Source Sans Pro', sans-serif;
		/*margin-left: 225px;*/
		min-height: 100%;
		padding-top: 80px;
		width: 80%;
		/*z-index: 820;*/
		}
		.contenido{
		min-height: 250px;
		padding: 15px;
		margin-right: auto;
		margin-left: auto;
		padding-left: 15px;
		padding-right: 15px;
		}
		.espacios:hover {
		background-color: #ff5000;
		}
		.espacios{
		background-color: #39cccc;
		border: 1px solid #fff;
		color: #fff;
		cursor: pointer;
		display: inline-block;
		padding: 10px 5px;
		vertical-align: top;
		text-align: center;
		width: 50px;
		}
		.naranja{
		background-color: #ff5000;
		}
		.tablero{
			padding-top: 15px;
			margin-bottom: 30px;
		}
		.logo{
		display: inline-block;
		width: 19%;
		}
		.logo a{
		color: #fff;
		font-size: 24px;
		float: left;
		margin-left: 45px;
		margin-top: 10px;
		}
		.logo a:hover{
		color: #000;
		font-size: 30px;
		margin-left: 40px;
		}
		
		.valores{
			display: inline-block;
			font-size: 16px;
			margin-left: 25px;
			/*margin-top: 10px;*/
			width: 30%;
		}
		.valores div{
			display: block;
		}
		.valores p{
			display: inline-block;
		}
		.registrar{
			display: inline-block;
			width: 50%;
		}
		.registrar form{
			float: right;
			margin-right: 20px;
			margin-top: 14px;
		}
    </style>
    <script language="javascript">
		function quitar()
		{	

			var nespacio = "<?php echo $nespacio; ?>";
			var placa    = document.getElementById('placaVehiculo').value;
			var nusuario = "<?php echo $nusuario; ?>";
			var libresA = "<?php echo $libresA ?>";
			var ocupadosA = "<?php echo $ocupadosA ?>";
			var libresB = "<?php echo $libresB ?>";
			var ocupadosB = "<?php echo $ocupadosB ?>";
			var libresE = "<?php echo $libresE ?>";
			var ocupadosE = "<?php echo $ocupadosE ?>";
			var contas1="<?php echo $contas1 ?>";
			var contas2="<?php echo $contas2 ?>";
			var contap1="<?php echo $contap1 ?>";
			var contap2="<?php echo $contap2 ?>";
			var contap3="<?php echo $contap3 ?>";
			var contbp1="<?php echo $contbp1 ?>";
			var contbp2="<?php echo $contbp2 ?>";
			var contbp3="<?php echo $contbp3 ?>";
			var contbp4="<?php echo $contbp4 ?>";
			// alert(nespacio+" "+placa+" "+nusuario);
			$.ajax({
				type: "POST",
				url: "quitar.php",
				data: "nespacio="+nespacio+"&placa="+placa+"&nusuario="+nusuario+"&libresA="+libresA+"&ocupadosA="+ocupadosA+"&libresB="+libresB+"&ocupadosB="+ocupadosB+"&libresE="+libresE+"&ocupadosE="+ocupadosE+"&contas1="+contas1+"&contas2="+contas2+"&contap1="+contap1+"&contap2="+contap2+"&contap3="+contap3+"&contbp1="+contbp1+"&contbp2="+contbp2+"&contbp3="+contbp3+"&contbp4="+contbp4,
				dataType:"html",
				success: function(data) 
				{
					// alert(data);
				 	send(data);// array JSON
				 	// window.location="../tablero/";
					// document.getElementById("espacioSeleccionado").value = "";
					// document.getElementById("placaVehiculo").value = "";
				},
				error:function(data){
					alert(data);
				}
			});
			var fechaRegistro = document.getElementById('fechaRegistro').value;
			var edificioEspacio = document.getElementById('edificioEspacio').value;
			var pisoEspacio = document.getElementById('pisoEspacio').value;

			$.ajax({
				type: "POST",
				url: "imprimirpdf.php",
				data: "nusuario="+nusuario+"&fechaRegistro="+fechaRegistro+"&edificioEspacio="+edificioEspacio+"&pisoEspacio="+pisoEspacio+"&nespacio="+nespacio+"&placa="+placa,
				dataType:"html",
				success: function(data) 
				{
					// alert(data);
				 	// send(data);// array JSON
				 	// window.location="../tablero/";
					// document.getElementById("espacioSeleccionado").value = "";
					// document.getElementById("placaVehiculo").value = "";
				},
				error:function(data){
					alert(data);
				}
			});
		}
	</script>
	<script type="text/javascript">
      $(document).on("ready",function(){
        $('th').click(function(){
            
            removerClase('th', 'celeste');
            removerClase('th', 'naranja');
            var clase=$(this).attr('class');
            var valor=$(this).attr('valor');
            
            if (clase=='espacios naranja') {
              //cambio de color espacio
              $(this).addClass('celeste').removeClass('naranja');
              
            }else{
              //cambio de color espacio
              $(this).addClass('naranja').removeClass('celeste');
            };
            document.getElementById("espacioSeleccionado").value = valor;
            // alert(clase+" "+valor);
        });
        
        function removerClase(tag, clase){
          $(tag).removeClass(clase);
        }
      });
    </script>
 </head>
 <body>
 	<header class="cabecera">
 		<div class="barra">
 			<div class="logo">
 				<a  href="../tablero/">
 					<span>Web<b>PARKING</b></span>
 				</a>
 			</div>
 			
 			<div class="valores">
 				<div><b>Torre A:</b> Libres = </p><p id="libresA" value="<?php echo $libresA; ?>"><?php echo " ".$libresA; ?></p> <p> / Ocupados = </p><p id="ocupadosA"><?php echo $ocupadosA; ?></p> </div>
 				<div><b>Torre B:</b> Libres = </p><p id="libresB" value="<?php echo $libresB; ?>"><?php echo " ".$libresB; ?></p> <p> / Ocupados = </p><p id="ocupadosB"><?php echo $ocupadosB; ?></p> </div>
 				<div><p><b>Exterior:</b> Libres = </p><p id="libresE" value="<?php echo $libresE; ?>"><?php echo " ".$libresE; ?></p> <p> / Ocupados = </p><p id="ocupadosE"><?php echo $ocupadosE; ?></p> </div> 		
 			</div>
			
 			<!-- <div class="registrar">
 				<form action="../registrar/" method=GET role="form">
	 				<input name="libresA" type="hidden" value="<?php echo $libresA; ?>"/>
	 				<input name="ocupadosA" type="hidden" value="<?php echo $ocupadosA; ?>"/>
	 				<input name="libresB" type="hidden" value="<?php echo $libresB; ?>"/>
	 				<input name="ocupadosB" type="hidden" value="<?php echo $ocupadosB; ?>"/>
	 				<input name="libresE" type="hidden" value="<?php echo $libresE; ?>"/>
	 				<input name="ocupadosE" type="hidden" value="<?php echo $ocupadosE; ?>"/>
	 				<input class="cajatexto" id="espacioSeleccionado" name="nespacio" type="text" placeholder="Espacio Seleccionado..."/>
		 			<input class="boton" type="submit" value="Registrar"/>
 				</form>
 			</div> -->
 		</div> 		
 	</header>
 	<aside class="barralateral-principal">
 		<section class="barralateral">
 			<ul class="barralateral-menu">
 				<h3><?php echo($nusuario); ?></h3>
 				<div class="caja-menu">
 					<li>MENU PRINCIPAL</li>
 				</div>
 				<div class="caja-menu">
 					<li>
	 					<i></i><span>TICKETS</span><i></i>
	 					<ul>
	 						<!-- <li><a href="registrar/index.php"><span>Registrar</span></a></li> -->
	 						<li><a href="../liberar/"><span>Liberar</span></a></li>
	 						<li><a href="../historial/"><span>Historial</span></a></li>
	 						<li><a href="../vehiculos/"><span>Vehiculos</span></a></li>
	 					</ul>
	 				</li>
 				</div>
 				<div class="caja-menu">
 					<li>
	 					<i></i><span>USUARIOS</span><i></i>
	 					<ul>
	 						<li><a href="../"><span>Login</span></a></li>
	 						<li><a href="../usuario/"><span>Registrar</span></a></li>
	 						<li><a href="../"><span>Salir</span></a></li>
	 					</ul>
	 				</li>
 				</div>
 			</ul>
 		</section>
 	</aside>
 	<div class="contenedor">
 		<section class="contenido">
 			<!-- <h3>Seleccione el espacio de parqueo</h3> -->
		 	<!-- <div>
				<table cellspacing="0" cellpadding="0">     
		            <tr id="espaciosVacios">        
		                <?php  while($arr = mysql_fetch_array($espaciosVacios)){ echo "<th class='espacios' id='".$arr['nombre_espacio']."' valor='".$arr['nombre_espacio']."'>".$arr['nombre_espacio']."</th>";}?>
		            </tr>
		        </table>
			</div> -->
			<h3>Registrar el espacio de parqueo</h3>
			<div class="caja">
				<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." value="<?php echo "Usuario: ".$nusuario; ?>"/>
				<input class="cajatexto" id="fechaRegistro" type="text" placeholder="Usuario..." value="<?php echo "Fecha: ".$fechaRegistro; ?>"/>
				<input class="cajatexto" id="edificioEspacio" type="text" placeholder="Edificio espacio..." value="<?php echo "Edificio: ".$nombre_edificio; ?>"/>
				<input class="cajatexto" id="pisoEspacio" type="text" placeholder="Piso espacio..." value="<?php echo "Piso: ".$nombre_piso. " / ".$tipo_piso; ?>"/>
				<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..." value="<?php echo "Espacio: ".$nespacio; ?>"/>
				<input class="cajatexto" id="placaVehiculo" type="text" placeholder="Placa vehiculo..."/>
				<input class="boton" type="submit" value="Registrar" onclick="quitar();"/>
			</div>
 	  	</section>
 	</div>
 </body>
 </html>