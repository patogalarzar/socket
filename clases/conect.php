<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','');
	define('DB','web_parking');
	function conexion(){
		mysql_connect(HOST, USER, PASS) or die("ERROR DE CONEXIÓN".mysql_error());
		mysql_select_db(DB);
	}
		
	function salir(){
		mysql_close();
	}
?>