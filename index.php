<?php 
	require_once("clases/consultas.php");
	$espaciosVacios = consultarGeneral("espacio","estado_espacio","=","LIBRE");
 ?>
 <html>
 <head>
 	<meta charset="utf-8" />
	<title>Socket</title>
	<!-- <link rel="stylesheet" href="css/style.css"> -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/fancywebsocket.js"></script>
	<style type="text/css">
		.boton{
		background-color: #CC181E;
		border: 1px solid #fff;
		border-radius: 5px;
		color: #fff;
		padding: 10px 5px;
		text-align: center;
		vertical-align: top;
		width: 75px;
		}
		.cabecera{
		color:#fff;
		background-color: #3C8DBC;
		
		display: block;
		float: left;
		height: 50px;
		font-size: 20px;
		line-height: 50px;
		text-align: left;
		width: 97%;
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		padding: 0 15px;
		font-weight: 300;
		overflow: hidden;
		}
		.cajatexto{
		border: 1px solid #B8B8B8;
		border-radius: 5px;
		color: #B8B8B8;
		padding: 10px 5px;
		vertical-align: top;
		width: 150px;
		}
		.celeste{
		background-color: #39cccc;
		}
		.contenedor{
  		background-color: #ecf0f5;
		margin-left: 250px;
		min-height: 100%;
		padding-top: 50px;
		z-index: 820;
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
    </style>
    <script language="javascript">
		function quitar()
		{	
			var nespacio = document.getElementById('espacioSeleccionado').value;
			var placa    = document.getElementById('placaVehiculo').value;;
			var nusuario = document.getElementById('usuarioSistema').value;
			
			$.ajax({
				type: "POST",
				url: "quitar.php",
				data: "nespacio=" + nespacio + "&placa=" + placa + "&nusuario=" + nusuario,
				dataType:"html",
				success: function(data) 
				{
					alert(data);
				 	send(data);// array JSON
					//window.location.href = 'form.php'
					document.getElementById("espacioSeleccionado").value = "";
					document.getElementById("placaVehiculo").value = "";
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
 		<a href="index.php">
 			<span>Web<b>PARKING</b></span>
 		</a>
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
 	<div class="contenedor">
 		<section class="contenido">
 			<h3>Seleccione el espacio de parqueo</h3>
		 	<div>
				<table cellspacing="0" cellpadding="0">     
		            <tr>        
		                <?php  while($arr = mysql_fetch_array($espaciosVacios)){ echo "<th class='espacios' id='".$arr['nombre_espacio']."' valor='".$arr['nombre_espacio']."'>".$arr['nombre_espacio']."</th>";}?>
		            </tr>
		        </table>
			</div>
			<h3>Registrar el espacio de parqueo</h3>
			<div>
				<input class="cajatexto" id="usuarioSistema" type="text" placeholder="Usuario..." value="TATTY"/>
				<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio parqueo..."/>
				<input class="cajatexto" id="placaVehiculo" type="text" placeholder="Placa vehiculo..."/>
				<input class="boton" type="submit" value="Quitar" onclick="quitar();"/>
			</div>
 	  	</section>
 	</div>
 </body>
 </html>