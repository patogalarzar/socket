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

		$id_usuario = $_SESSION['id_usuario'];

		$libresA=0;$ocupadosA=0;$reservadosA=0;
		$libresB=0;$ocupadosB=0;$reservadosB=0;
		$libresE=0;$ocupadosE=0;$reservadosE=0;
		$espaciosVacios = consultarGeneral("espacio","estado_espacio","=","LIBRE");

		conexion();
		$nusuario="";
		$usuarios = mysql_query("SELECT * FROM usuario WHERE id_usuario = $id_usuario");
		while ($arr = mysql_fetch_array($usuarios)) {
			$nusuario = $arr["nombre_usuario"];
		}
		$espaciosVaciosA = mysql_query("SELECT * FROM espacio WHERE estado_espacio ='LIBRE' AND id_piso IN(1,2,3,4,5)");
		$espaciosVaciosB = mysql_query("SELECT * FROM espacio WHERE estado_espacio ='LIBRE' AND id_piso IN(6,7,8,9)");
		$espaciosVaciosE = mysql_query("SELECT * FROM espacio WHERE estado_espacio ='LIBRE' AND id_piso IN(10)");

		$tridimensional=array();
		$torreA=array();
		$as1=array();$as2=array();$ap1=array();$ap2=array();$ap3=array();
		$contas1=0;$contas2=0;$contap1=0;$contap2=0;$contap3=0;
		$torreB=array();
		$bp1=array();$bp2=array();$bp3=array();$bp4=array();
		$contbp1=0;$contbp2=0;$contbp3=0;$contbp4=0;
		$exteriores=array();
		$indice=0;	
		
		$espaciosTorreA = mysql_query("SELECT * FROM espacio WHERE id_piso IN(1,2,3,4,5)");
		while ($espacios = mysql_fetch_array($espaciosTorreA)) {
			$est = $espacios["estado_espacio"];
			$piso= $espacios["id_piso"];
			if ($est=="LIBRE") {
				$libresA = $libresA + 1;
				$torreA[$indice]= array('nespacio'=>$espacios['nombre_espacio']);
				$indice=$indice+1;
			}elseif ($est=="OCUPADO") {
				$ocupadosA = $ocupadosA + 1;

				if ($piso=="1") {
					
					$contas1++;
				}elseif ($piso=="2") {
					
					$contas2++;
				}elseif ($piso=="3") {
					
					$contap1++;
				}elseif ($piso=="4") {
					
					$contap2++;
				}else{
					
					$contap3++;
				}
			}else{
				$reservadosA = $reservadosA + 1;
			}
		}
		// var_dump($torreA);
		
		$espaciosTorreB = mysql_query("SELECT * FROM espacio WHERE id_piso IN(6,7,8,9)");
		$indice=0;
		while ($espacios = mysql_fetch_array($espaciosTorreB)) {
			$est = $espacios["estado_espacio"];
			$piso= $espacios["id_piso"];
			if ($est=="LIBRE") {
				$libresB = $libresB + 1;
				$torreB[$indice]= array('nespacio'=>$espacios['nombre_espacio']);
				$indice=$indice+1;
			}elseif ($est=="OCUPADO") {
				$ocupadosB = $ocupadosB + 1;

				if ($piso=="6") {
					
					$contbp1++;
				}elseif ($piso=="7") {
					
					$contbp2++;
				}elseif ($piso=="8") {
					
					$contbp3++;
				}else{
					
					$contbp4++;
				}
			}else{
				$reservadosB = $reservadosB + 1;
			}
		}
		$indice=0;
		$espaciosExteriores = mysql_query("SELECT * FROM espacio WHERE id_piso IN(10)");
		while ($espacios = mysql_fetch_array($espaciosExteriores)) {
			$est = $espacios["estado_espacio"];
			if ($est=="LIBRE") {
				$libresE = $libresE + 1;
				$exteriores[$indice]= array('nespacio'=>$espacios['nombre_espacio']);
				$indice=$indice+1;
			}elseif ($est=="OCUPADO") {
				$ocupadosE = $ocupadosE + 1;
			}else{
				$reservadosE = $reservadosE + 1;
			}
		}
		$tridimensional[] = array("torreA"=>$torreA,"&torreB"=>$torreB,"&exteriores"=>$exteriores);
		// var_dump($tridimensional);
		salir();
	}
 ?>
 <html>
 <head>
 	<meta charset="utf-8" />
	<title>OROMALL</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="../css/style.css">	
	<link type="text/css" rel="stylesheet"  href="../fonts/flaticon/flaticon.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <script src="../js/jquery-1.7.2.min.js"></script>
	<script src="../js/fancywebsocket.js"></script>
	<script src="../js/socket.js"></script>
	
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
 				<div><p><b>Torre A:</b> Libres = </p><p id="libresA" value="<?php echo $libresA; ?>"><?php echo " ".$libresA; ?></p> <p> / Ocupados = </p><p id="ocupadosA"><?php echo $ocupadosA; ?></p> </div>
 				<div><p><b>Torre B:</b> Libres = </p><p id="libresB" value="<?php echo $libresB; ?>"><?php echo " ".$libresB; ?></p> <p> / Ocupados = </p><p id="ocupadosB"><?php echo $ocupadosB; ?></p> </div>
 				<div><p><b>Exterior:</b> Libres = </p><p id="libresE" value="<?php echo $libresE; ?>"><?php echo " ".$libresE; ?></p> <p> / Ocupados = </p><p id="ocupadosE"><?php echo $ocupadosE; ?></p> </div> 		
 			</div>
			
 			<div class="registrar">
 				<form action="../registrar/" method=GET role="form">
	 				<input name="libresA" type="hidden" value="<?php echo $libresA; ?>"/>
	 				<input name="ocupadosA" type="hidden" value="<?php echo $ocupadosA; ?>"/>
	 				<input name="contas1" type="hidden" value="<?php echo $contas1; ?>"/>
	 				<input name="contas2" type="hidden" value="<?php echo $contas2; ?>"/>
	 				<input name="contap1" type="hidden" value="<?php echo $contap1; ?>"/>
	 				<input name="contap2" type="hidden" value="<?php echo $contap2; ?>"/>
	 				<input name="contap3" type="hidden" value="<?php echo $contap3; ?>"/>
	 				<input name="libresB" type="hidden" value="<?php echo $libresB; ?>"/>
	 				<input name="ocupadosB" type="hidden" value="<?php echo $ocupadosB; ?>"/>
	 				<input name="contbp1" type="hidden" value="<?php echo $contbp1; ?>"/>
	 				<input name="contbp2" type="hidden" value="<?php echo $contbp2; ?>"/>
	 				<input name="contbp3" type="hidden" value="<?php echo $contbp3; ?>"/>
	 				<input name="contbp4" type="hidden" value="<?php echo $contbp4; ?>"/>
	 				<input name="libresE" type="hidden" value="<?php echo $libresE; ?>"/>
	 				<input name="ocupadosE" type="hidden" value="<?php echo $ocupadosE; ?>"/>
	 				<input class="cajatexto-tablero" id="espacioSeleccionado" name="nespacio" type="text" placeholder="Espacio Seleccionado..."/>
		 			<input class="boton-tablero" type="submit" value="Registrar"/>
 				</form>
 			</div>
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

 			<h2>Seleccione el espacio de parqueo</h2>
 			<?php $edificios = consultarGeneral("edificio","id_edificio",">","0"); ?>
 			
			<?php while ( $arrE = mysql_fetch_array($edificios)) { ?>
				<div id='edificio<?php echo $arrE["id_edificio"]; ?>' class="edificios">

					<div class="info-torre">
						<div class="nombre_torre"><?php echo $arrE["nombre_edificio"]; ?></div>
	 					<div id='btnVerEdificio' id-edificio='<?php echo $arrE["id_edificio"]; ?>' data='edificios' btn-estado='ocultar' class="icono_torre flaticon-menu57"></div>
					</div>				

	 				<!-- Niveles -->	 				
	 				<div id='info-niveles<?php echo $arrE["id_edificio"]; ?>' class="info-niveles">
		 				<center>
		 				<?php $pisos = consultarGeneral("piso","id_piso",">","0");
						while ($arrP=mysql_fetch_array($pisos)) {
							if ($arrP["id_edificio"]==$arrE["id_edificio"]) { ?>
								<div id="nivel<?php echo $arrP["id_piso"] ?>" class="niveles">
				 				    <div class='flaticon-building98'><?php echo $arrP["nombre_piso"]; ?></div>
				 				    <div class='flaticon-transport122'> Libres = 30 </div>
				 				    <div class='flaticon-cars27'> Reservado = 3 </div>
				 				    <div class='flaticon-car21'> Ocupados = 32 </div>		 				    
				 					<input id='btnVerNivel<?php echo $arrP["id_piso"] ?>' id-edificio='<?php echo $arrE["id_edificio"]; ?>' id-piso='<?php echo $arrP["id_piso"]; ?>' data='niveles' type='button' class="flaticon-zoom3" value='Buscar Espacio' />
			 					</div>		 				
			 			<?php }
						} ?>		
			 			</center>
		 			</div>		
		 			<!-- Espacios -->		 			
	 				<?php $pisos = consultarGeneral("piso","id_edificio","=",$arrE["id_edificio"]);
						while ($arrP=mysql_fetch_array($pisos)) { ?>
															
							<table id='espacios<?php echo $arrP["id_piso"]; ?>' class='espacios_nivel' cellspacing="0" cellpadding="0">
								<!-- <center> -->
			   					<tr id="">
			   						<div id='opcion<?php echo $arrP["id_piso"]; ?>' class='opciones'>
										<span class='flaticon-building98'>Nivel: <?php echo $arrP["nombre_piso"]; ?></span>
										<input type='button' data='opcion' id="todos<?php echo $arrP["id_piso"]; ?>" id-edificio='<?php echo $arrE["id_edificio"]; ?>' id-piso='<?php echo $arrP["id_piso"]; ?>' value='Todos' />
										<input type='button' data='opcion' id="dispo<?php echo $arrP["id_piso"]; ?>" id-edificio='<?php echo $arrE["id_edificio"]; ?>' id-piso='<?php echo $arrP["id_piso"]; ?>' class='flaticon-transport122' value='Disponibles' />
										<input type='button' data='opcion' id="reser<?php echo $arrP["id_piso"]; ?>" id-edificio='<?php echo $arrE["id_edificio"]; ?>' id-piso='<?php echo $arrP["id_piso"]; ?>' class='flaticon-cars27' value='Reservados' />
										<input type='button' data='opcion' id="ocupa<?php echo $arrP["id_piso"]; ?>" id-edificio='<?php echo $arrE["id_edificio"]; ?>' id-piso='<?php echo $arrP["id_piso"]; ?>' class='flaticon-car21' value='Ocupados' />
										<input type='button' data='opcion' id="volve<?php echo $arrP["id_piso"]; ?>" id-edificio='<?php echo $arrE["id_edificio"]; ?>' id-piso='<?php echo $arrP["id_piso"]; ?>' value='Volver' />
									</div>
									<?php $espacios = consultarGeneral("espacio","id_espacio",">","0");
									while ($arrS=mysql_fetch_array($espacios)) {
									if ($arrS["id_piso"]==$arrP["id_piso"]) {  ?>

										<th id='espacio<?php echo $arrS["id_espacio"]; ?>' value='<?php echo $arrS["id_espacio"]; ?>' nombre='<?php echo $arrS["nombre_espacio"]; ?>' class='espacios' data-estado='DISPONIBLE'>
						                	<div class='detalle'>
						                		<div class="icono flaticon-placeholder8"></div>
						                		<div class="nombre_espacio"><?php echo $arrS["nombre_espacio"]; ?></div>
						                	</div>
						                	<div class="estado">DISPONIBLE</div>
					           			</th>
									<?php }
									} ?>
								</tr>
								<!-- </center> -->
							</table>
							
					<?php } ?>		
		 		</div>	
	 		<?php } ?>
 			
 	  	</section>
 	</div>
 </body>
 </html>