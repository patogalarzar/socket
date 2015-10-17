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
		$espaciosVacios = consultarGeneral("espacio","estado_espacio","=","LIBRE");
		$nespacio = $_GET['nespacio'];
		$nusuario = "TATTY";
		$fechaRegistro = date("Y-m-d H:i:s");
	}
 ?>
 <html>
 <head>
 	<meta charset="utf-8" />
	<title>Socket</title>
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
		.barra a{
			color: #fff;
			font-size: 24px;
			float: left;
			margin-left: 45px;
		}
		.barra a:hover{
			color: #000;
			font-size: 30px;
			margin-left: 40px;
		}
		.barra form{
			float: right;
			margin-top: 7px;
			margin-right: 20px;
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
		padding-bottom: 10px;

		}
		.barralateral-menu{
		list-style: none;
	  	margin: 0;
	  	padding-top: 53px;
	  	padding-left: 45px;
		}
		.barralateral-menu > li{
		position: relative;
	  	margin: 0;
	  	padding: 0;
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
		height: 50px;
		line-height: 50px;
		/*overflow: hidden;*/
		/*padding: 0 15px;*/
		position: fixed;
		text-align: left;
		width: 100%;
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
		padding-top: 50px;
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
    </style>
    <script language="javascript">
		function quitar()
		{	
			var nespacio = document.getElementById('espacioSeleccionado').value;
			var placa    = document.getElementById('placaVehiculo').value;
			var nusuario = document.getElementById('usuarioSistema').value;
			alert(nespacio+" "+placa+" "+nusuario);
			$.ajax({
				type: "POST",
				url: "quitar.php",
				data: "nespacio=" + nespacio + "&placa=" + placa + "&nusuario=" + nusuario,
				dataType:"html",
				success: function(data) 
				{
					alert(data);
				 	send(data);// array JSON
					document.getElementById("espacioSeleccionado").value = "";
					document.getElementById("placaVehiculo").value = "";
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
            alert(clase+" "+valor);
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
 			<a  href="../tablero/">
 				<span>Web<b>PARKING</b></span>
 			</a>
 			<!-- <form action="../registrar/" method=GET role="form">
 				<input class="cajatexto" id="espacioSeleccionado" name="nespacio" type="text" placeholder="Espacio seleccionado..."/>
	 			<input class="boton" type="submit" value="Registrar"/>
 			</form> -->
 		</div> 		
 		<!-- <nav class="navbar" role="navigation">
 			<div class="navbar-custom-menu">
 				<ul>
 				<li>
				  	<a href="#">
			            <img src="img/avatar2.png" class="user-image" alt="User Image">
			            <span>TATTY</span>
	             	</a>
 				</li>
 			</ul>
 			</div>
 		</nav> -->
 	</header>
 	<aside class="barralateral-principal">
 		<section class="barralateral">
 			<ul class="barralateral-menu">
 				<li>MENU PRINCIPAL</li>
 				<li>
 					<a href="#">
 						<i></i><span>Tickets</span><i> ></i>
 					</a>
 					<ul>
 						<!-- <li><a href="#"><span>Registrar</span></a></li> -->
 						<li><a href="../liberar/"><span>Liberar</span></a></li>
 						<li><a href="#"><span>Historial</span></a></li>
 					</ul>
 				</li>
 				<li>
 					<a href="#">
 						<i></i><span>Usuarios</span><i> ></i>
 					</a>
 					<ul>
 						<li><a href="#"><span>Login</span></a></li>
 						<li><a href="#"><span>Registrar</span></a></li>
 					</ul>
 				</li>
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
				<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." value="<?php echo $nusuario; ?>"/>
				<input class="cajatexto" id="fechaRegistro" type="text" placeholder="Usuario..." value="<?php echo $fechaRegistro; ?>"/>
				<input class="cajatexto" id="edificioEspacio" type="text" placeholder="Edificio espacio..."/>
				<input class="cajatexto" id="pisoEspacio" type="text" placeholder="Piso espacio..."/>
				<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..." value="<?php echo $nespacio; ?>"/>
				<input class="cajatexto" id="placaVehiculo" type="text" placeholder="Placa vehiculo..."/>
				<input class="boton" type="submit" value="Quitar" onclick="quitar();"/>
			</div>
 	  	</section>
 	</div>
 </body>
 </html>