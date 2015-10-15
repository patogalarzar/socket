<?php 

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
			
			$.ajax({
				type: "POST",
				url: "quitar.php",
				data: "espacio=" + espacio + "&tipo=" + tipo,
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
                <th class="espacios" id="A1" valor="A1">A1</th>
                <th class="espacios" id="A2" valor="A2">A2</th>
                <th class="espacios" id="A3" valor="A3">A3</th>
                <th class="espacios" id="A4" valor="A4">A4</th>
                <th class="espacios" id="A5" valor="A5">A5</th>
                <th class="espacios" id="A6" valor="A6">A6</th>
                <th class="espacios" id="A7" valor="A7">A7</th>
                <th class="espacios" id="A8" valor="A8">A8</th>
                <th class="espacios" id="A9" valor="A9">A9</th>
                <th class="espacios" id="A10" valor="A10">A10</th>
                <th class="espacios" id="B1" valor="B1">B1</th>
                <th class="espacios" id="B2" valor="B2">B2</th>
                <th class="espacios" id="B3" valor="B3">B3</th>
                <th class="espacios" id="B4" valor="B4">B4</th>
                <th class="espacios" id="B5" valor="B5">B5</th>
                <th class="espacios" id="B6" valor="B6">B6</th>
                <th class="espacios" id="B7" valor="B7">B7</th>
                <th class="espacios" id="B8" valor="B8">B8</th>
                <th class="espacios" id="B9" valor="B9">B9</th>
                <th class="espacios" id="B10" valor="B10">B10</th>
                <th class="espacios" id="E1" valor="E1">E1</th>
                <th class="espacios" id="E2" valor="E2">E2</th>
                <th class="espacios" id="E3" valor="E3">E3</th>
                <th class="espacios" id="E4" valor="E4">E4</th>
                <th class="espacios" id="E5" valor="E5">E5</th>
                <th class="espacios" id="E6" valor="E6">E6</th>
                <th class="espacios" id="E7" valor="E7">E7</th>
                <th class="espacios" id="E8" valor="E8">E8</th>
                <th class="espacios" id="E9" valor="E9">E9</th>
                <th class="espacios" id="E10" valor="E10">E10</th>
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