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
	 				<input class="cajatexto" id="espacioSeleccionado" name="nespacio" type="text" placeholder="Espacio Seleccionado..."/>
		 			<input class="boton" type="submit" value="Registrar"/>
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
 			
			<?php while ($arrE=mysql_fetch_array($edificios)) { ?>
				<div id='edificio<?php echo $arrE["id_edificio"]; ?>' class="edificios">				
	 				<div class="nombre_torre"><?php echo $arrE["nombre_edificio"]; ?></div>
	 				<div id='btnEdificio<?php echo $arrE["id_edificio"]; ?>' class="icono_torre flaticon-menu57"></div>

	 				<!-- Niveles -->
	 				<center>
	 				<?php $pisos = consultarGeneral("piso","id_piso",">","0");
					while ($arrP=mysql_fetch_array($pisos)) {
						if ($arrP["id_edificio"]==$arrE["id_edificio"]) { ?>
							<div id="<?php echo $arrP["id_piso"] ?>" class="niveles">
			 				    <div class='flaticon-building98'><?php echo $arrP["nombre_piso"]; ?></div>
			 				    <div class='flaticon-transport122'> Libres = 30 </div>
			 				    <div class='flaticon-cars27'> Reservado = 3 </div>
			 				    <div class='flaticon-car21'> Ocupados = 32 </div>		 				    
			 					<input id='btnNivel<?php echo $arrP["id_piso"] ?>' id-piso='<?php echo $arrP["id_piso"] ?>' type='button' class="flaticon-zoom3" value='Buscar Espacio' />
		 					</div>		 				
		 			<?php }
					} ?>		
		 			</center>		
		 			<!-- Espacios -->		 			
	 				<?php $pisos = consultarGeneral("piso","id_edificio","=",$arrE["id_edificio"]);
						while ($arrP=mysql_fetch_array($pisos)) { ?>
															
							<table id='espacios<?php echo $arrP["id_piso"]; ?>' class='espacios_nivel' cellspacing="0" cellpadding="0">
								<center>
			   					<tr id="">
								<?php $espacios = consultarGeneral("espacio","id_espacio",">","0");
									while ($arrS=mysql_fetch_array($espacios)) {
									if ($arrS["id_piso"]==$arrP["id_piso"]) {  ?>														
										<th class='espacios' id='<?php echo $arrS["id_espacio"]; ?>'>			                	
						                	<div class='detalle'>
						                		<div class="icono flaticon-placeholder8"></div>
						                		<div class="nombre_espacio"><?php echo $arrS["nombre_espacio"]; ?></div>
						                	</div>
						                	<div class="estado">DISPONIBLE</div>
					           			</th>
									<?php }
									} ?>
								</tr>
								</center>
							</table>
							
					<?php } ?>		
		 		</div>	
	 		<?php } ?>
 			

				
 				
 			<!-- <div class="edificios">
 				<h2>Torre A:</h2>

 				<div id="AS1" class="niveles"> 				   
 				    <div class='flaticon-building98'>Subsuelo - AS1</div>
 				    <div class='flaticon-transport122'> Libres = 30 </div>
 				    <div class='flaticon-cars27'> Reservado = 3 </div>
 				    <div class='flaticon-car21'> Ocupados = 32 </div>
 				    
 					<input type='button' class="flaticon-zoom3" value='Buscar Espacio' />
 				</div>

 				<div class="niveles">
 					<h3 id="AS2" class='flaticon-building98'> <?php echo "AS2: Libres = ".(80-$contas2)." / Ocupados = ".$contas2 ; ?></h3>
 				</div>
 				<div class="niveles">
 					<h3 id="AP1" class='flaticon-building98'> <?php echo "AP1: Libres = ".(100-$contap1)." / Ocupados = ".$contap1 ; ?></h3>
 				</div>
 				<div class="niveles">
 					<h3 id="AP2" class='flaticon-building98'> <?php echo "AP2: Libres = ".(100-$contap2)." / Ocupados = ".$contap2 ; ?></h3>
 				</div>
 				<div class="niveles">
 					<h3 id="AP3" class='flaticon-building98'> <?php echo "AP3: Libres = ".(100-$contap3)." / Ocupados = ".$contap3 ; ?></h3>
 				</div>

 				<div class="tablero">
 					<center>
					<table cellspacing="0" cellpadding="0">     
			            <tr id="espaciosVaciosA">
			                <?php while (list(,$val) = each($torreA)) { ?>
   									
								<th class='espacios' id='<?php echo $val['nespacio'] ?>'>			                	
				                	<div class='detalle'>
				                		<div class="icono flaticon-placeholder8"></div>
				                		<div class="nombre_espacio"><?php echo $val['nespacio'] ?></div>
				                	</div>
				                	<div class="estado">DISPONIBLE</div>
		               			</th>
			               			
							<?php } ?>
			            </tr>
			        </table>
			        </center>
				</div>
 			</div>
 			<div class="edificios">
 				<h2>Torre B:</h2>
 				<h3 id="BP1"> <?php echo "BP1: Libres = ".(100-$contbp1)." / Ocupados = ".$contbp1 ; ?></h3>
 				<h3 id="BP2"> <?php echo "BP2: Libres = ".(120-$contbp2)." / Ocupados = ".$contbp2 ; ?></h3>
 				<h3 id="BP3"> <?php echo "BP3: Libres = ".(120-$contbp3)." / Ocupados = ".$contbp3 ; ?></h3>
 				<h3 id="BP4"> <?php echo "BP4: Libres = ".(120-$contbp4)." / Ocupados = ".$contbp4 ; ?></h3>
 				
 				<div class="tablero">
					<table cellspacing="0" cellpadding="0">     
			            <tr id="espaciosVaciosB">        
			                <?php  
			                	while (list(,$val) = each($torreB)) {
			                		// echo $val["nespacio"];
   									 echo "<th class='espacios' id='".$val['nespacio']."' valor='".$val['nespacio']."'>".$val['nespacio']."</th>";
								}
			                ?>
			            </tr>
			        </table>
				</div>
 			</div>
 			<div class="edificios">
 				<h2>Exteriores:</h2>
 				<h3 id="E1"> <?php echo "E1: Libres = ".$libresE." / Ocupados = ".$ocupadosE ; ?></h3>
 				<div class="tablero">
					<table cellspacing="0" cellpadding="0">     
			            <tr id="espaciosVaciosC">        
			                <?php  
				                while (list(,$val) = each($exteriores)) {
			                		// echo $val["nespacio"];
   									 echo "<th class='espacios' id='".$val['nespacio']."' valor='".$val['nespacio']."'>".$val['nespacio']."</th>";
								}
			             	?>
			            </tr>
			        </table>
				</div>
 			</div> -->
		 	
			<!-- <h3>Registrar el espacio de parqueo</h3>
			<div>
				<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." value="TATTY"/>
				<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..."/>
				<input class="cajatexto" id="placaVehiculo" type="text" placeholder="Placa vehiculo..."/>
				<input class="boton" type="submit" value="Quitar" onclick="quitar();"/>
			</div> -->
 	  	</section>
 	</div>
 </body>
 </html>