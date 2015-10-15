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
		.celeste{
		background-color: #39cccc;
		}
		.naranja{
		background-color: #ff5000;
		}
		.cajatexto{
		border: 1px solid #B8B8B8;
		border-radius: 5px;
		color: #B8B8B8;
		padding: 10px 5px;
		vertical-align: top;
		width: 150px;
		}
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
    </style>
    <script language="javascript">
		function quitar()
		{	
			var espacio = document.getElementById('espacioSeleccionado').value;
			var tipo    = "1";
			var estado  = "LIBRES"
			
			$.ajax({
				type: "POST",
				url: "quitar.php",
				data: "espacio=" + espacio + "&tipo=" + tipo +"&estado=" + estado,
				dataType:"html",
				success: function(data) 
				{
					alert(data);
				 	send(data);// array JSON
					//window.location.href = 'form.php'
					document.getElementById("espacioSeleccionado").value = "";
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
 	<h3>Seleccione el espacio de parqueo</h3>
 	<div>
		<table cellspacing="0" cellpadding="0">     
            <tr>        
                <?php  while($arr = mysql_fetch_array($espaciosVacios)){ echo "<th class='espacios' id='".$arr['nombre_espacio']."' valor='".$arr['nombre_espacio']."'>".$arr['nombre_espacio']."</th>";}?>
            </tr>
        </table>
	</div>
	<h3>Quitar el espacio de parqueo</h3>
	<div>
		<input class="cajatexto" id="espacioSeleccionado" type="text" placeholder="Espacio.."/>
		<input class="boton" type="submit" value="Quitar" onclick="quitar();"/>
	</div>
 </body>
 </html>