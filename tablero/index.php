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
		$exteriores=array();$ep1=array();
		$indice=0;	
		
		$espaciosTorreA = mysql_query("SELECT * FROM espacio WHERE id_piso IN(1,2,3,4,5)");
		while ($espacios = mysql_fetch_array($espaciosTorreA)) {
			$est = $espacios["estado_espacio"];
			$piso= $espacios["id_piso"];

			if ($piso=="1") {
				$as1= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contas1++;
			}elseif ($piso=="2") {
				$as2= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contas2++;
			}elseif ($piso=="3") {
				$ap1= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contap1++;
			}elseif ($piso=="4") {
				$ap2= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contap2++;
			}else{
				$ap3= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contap3++;
			}
			
			if ($est=="LIBRE") {
				$libresA = $libresA + 1;
				$torreA[$indice]= array('nespacio'=>$espacios['nombre_espacio']);
				$indice=$indice+1;
			}elseif ($est=="OCUPADO") {
				$ocupadosA = $ocupadosA + 1;
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

			if ($piso=="6") {
				$bp1= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contbp1++;
			}elseif ($piso=="7") {
				$bp2= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contbp2++;
			}elseif ($piso=="8") {
				$bp3= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contbp3++;
			}else{
				$bp4= array('nespacio'=>$espacios['nombre_espacio'],
							'estado'=>$espacios["estado_espacio"]);
				$contbp4++;
			}

			if ($est=="LIBRE") {
				$libresB = $libresB + 1;
				$torreB[$indice]= array('nespacio'=>$espacios['nombre_espacio']);
				$indice=$indice+1;
			}elseif ($est=="OCUPADO") {
				$ocupadosB = $ocupadosB + 1;
			}else{
				$reservadosB = $reservadosB + 1;
			}
		}
		$indice=0;
		$espaciosExteriores = mysql_query("SELECT * FROM espacio WHERE id_piso IN(10)");
		while ($espacios = mysql_fetch_array($espaciosExteriores)) {
			$est = $espacios["estado_espacio"];
			$ep1= array('nespacio'=>$espacios['nombre_espacio'],
						'estado'=>$espacios["estado_espacio"]);
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
			/*display: block;
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
	  	/*box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);*/
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
		padding: 10px 5px;
		text-align: center;
		vertical-align: top;
		width: 100px;
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
		padding: 10px 5px;
		vertical-align: top;
		width: 150px;
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
		width: 80%;
		/*z-index: 820;*/
		}
		.contenido{
		min-height: 250px;
		padding: 5px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 15px;
		padding-right: 15px;
		padding-top: 79px;
		width: 100%
		}
		.contenido h2{
		text-align: center;
		}
		.edificios{
		background: #ffffff;
		border-radius: 3px;
		border-top: 5px solid #FF656D;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
		margin: 15px auto;
		margin-bottom: 20px;
		padding: 15px 15px;
 		/*position: relative;*/
		width: 98%;
		}
		.edificios h3 {
	    display: inline-block;
	    margin: 0px;
	    padding: 10px;
	    background-color: #3E474F;
	    width: 207px;
	    color: #fff;
		}
		.pisos{
		background: #ffffff;
		border-radius: 3px;
		border-top: 5px solid #384047;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
		display: block;
		margin: 15px auto;
		margin-bottom: 20px;
		padding: 15px 15px;
 		/*position: relative;*/
		width: 32%;	
		}
		.espacios:hover {
		background-color: #ff5000;
		}
		.espacios{
		display: inline-block;
		vertical-align: top;
		width: 50px;
		text-align: center;
		background-color: #39cccc;
		border: 1px solid #fff;
		color: #fff;
		cursor: pointer;
		padding: 10px 5px;
		}
		.naranja{
		background-color: #ff5000;
		}
		.libre{
		background-color: #39cccc;
		}
		.ocupado{
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
		width: 45%;
		}
		.registrar form{
		float: right;
		margin-right: 20px;
		margin-top: 14px;
		}
    </style>
    
	<script type="text/javascript">
      $(document).on("ready",function(){
        $('th').click(function(){
            
            removerClase('th', 'libre');
            removerClase('th', 'naranja');
            var clase=$(this).attr('class');
            var valor=$(this).attr('valor');
            
            if (clase=='espacios naranja') {
              //cambio de color espacio
              $(this).addClass('libre').removeClass('naranja');
              
            }else{
              //cambio de color espacio
              $(this).addClass('naranja').removeClass('libre');
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
 				
 			<div class="edificios">
 				<h2>Torre A:</h2>
 				<h3 id="AS1"> <?php echo "AS1: Libres = ".(80-$contas1)." / Ocupados = ".$contas1 ; ?></h3>
 				<div class="pisos">
 					<div class="tablero">
						<table cellspacing="0" cellpadding="0">     
				            <tr id="espaciosVaciosA">        
				                <?php  
				                	while (list(,$val) = each($as1)) {
				                		// echo $val["nespacio"];
	   									echo "<th class='espacios ".$val['estado']."' id='".$val['nespacio']."' valor='".$val['nespacio']."'>".$val['nespacio']."</th>";
									}
				                ?>
				            </tr>
				        </table>
					</div>
 				</div>
 				<h3 id="AS2"> <?php echo "AS2: Libres = ".(80-$contas2)." / Ocupados = ".$contas2 ; ?></h3>
 				<h3 id="AP1"> <?php echo "AP1: Libres = ".(100-$contap1)." / Ocupados = ".$contap1 ; ?></h3>
 				<h3 id="AP2"> <?php echo "AP2: Libres = ".(100-$contap2)." / Ocupados = ".$contap2 ; ?></h3>
 				<h3 id="AP3"> <?php echo "AP3: Libres = ".(100-$contap3)." / Ocupados = ".$contap3 ; ?></h3>
 				<div class="tablero">
					<table cellspacing="0" cellpadding="0">     
			            <tr id="espaciosVaciosA">        
			                <?php  
			                	while (list(,$val) = each($torreA)) {
			                		// echo $val["nespacio"];
   									echo "<th class='espacios' id='".$val['nespacio']."' valor='".$val['nespacio']."'>".$val['nespacio']."</th>";
								}
			                ?>
			            </tr>
			        </table>
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
 			</div>
		 	
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