<?php 
	session_start();
	if (!empty($_POST['entrar'])) {
		$id_usuario="";
		$alias = $_POST['usuario'];
		$pass = $_POST['password'];
		require_once("clases/consultas.php");
		conexion();
		$usuarios = mysql_query("SELECT * FROM usuario WHERE alias_usuario='$alias' AND password_usuario='$pass'");

		$count = mysql_num_rows($usuarios);
		if ($count>0) {
			while ($arr=mysql_fetch_array($usuarios)) {
				$id_usuario=$arr["id_usuario"];
			}
			$_SESSION['id_usuario'] = $id_usuario;
			header('Location: /socket/tablero/');
		}

		// if ( $_POST['usuario'] == "TATTY" && $_POST['password'] == "MATHEW123") {
		// 	$_SESSION['id_usuario'] = 1;
		// 	header('Location: /socket/tablero/');
		// }
	}
 ?>
 
 <!DOCTYPE html>
 <html lang="es">
	 <head>
	 	<title>OROMALL</title>
	 	<link rel="stylesheet" href="css/style.css">
	 </head>
	 <body style="bacground='#52C3A5">
	 	<h1 class="etiqueta"><b>Bienvenido</b></h1>
	 	
	 	<div class="caja" id="login">
	 		<form action="index.php" method="POST">
	 			<input class="cajatexto"type="text" name="usuario" placeholder="Usuario">
	 			<input class="cajatexto"type="password" name="password" placeholder="Password">
				<button class="boton"id="entrar" name="entrar" value="1">Entrar</button>
	 		</form>
	 	</div>
	 </body>
 </html>