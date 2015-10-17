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
		header("Location: login.php");
	}
 ?>
 <html lang="es">
	 <head>
	 	<title>Sesiones PHP</title>
	 </head>
	 <body>
	 	<?php echo "<h1>Fue direccioinado con la varible de sesion ".$_SESSION['id_usuario']."</h1>"; ?>
	 	<form action="park.php" method="GET">	 			
			<button id="salir" name="salir" value="1">Salir</button>
	 	</form>	 	
	 </body>
 </html>