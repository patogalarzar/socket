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
 <style type="text/css">
 		@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300);
		.boton{
		background-color: #FF656D;
		border: 1px solid #fff;
		border-radius: 5px;
		color: #fff;
		display: block;
		margin: 10px auto;
		padding: 10px 5px;
		text-align: center;
		/*vertical-align: top;*/
		width: 100px;
		}
		.caja{
		background: #FFFFFF;
		border-radius: 3px;
		border-top: 5px solid #FF656D;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
		margin: 10px auto;
		margin-bottom: 20px;
		padding: 15px 15px;
 		/*position: relative;*/
		width: 350px;
		}
		.cajatexto{
		border: 1px solid #B8B8B8;
		border-radius: 5px;
		color: #B8B8B8;
		display: block;
		margin: 10px auto;
		padding: 10px 5px;
		/*vertical-align: top;*/
		width: 85%;
		}
		.etiqueta{
			color:#FF656D;
			display: block;
			font-family: 'Source Sans Pro', sans-serif;
			margin: 15px auto;
			padding: 10px 5px;
			text-align: center;
			width: 97%;
		}
    </style>
 <!DOCTYPE html>
 <html lang="es">
	 <head>
	 	<title>OROMALL</title>
	 </head>
	 <body style="bacground='#52C3A5">
	 	<h1 class="etiqueta">Bienvenido</b></h1>
	 	
	 	<div class="caja" id="login">
	 		<form action="index.php" method="POST">
	 			<input class="cajatexto"type="text" name="usuario" placeholder="Usuario">
	 			<input class="cajatexto"type="password" name="password" placeholder="Password">
				<button class="boton"id="entrar" name="entrar" value="1">Entrar</button>
	 		</form>
	 	</div>
	 </body>
 </html>