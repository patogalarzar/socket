<?php

if( basename( $_SERVER['PHP_SELF'] )== "conect.php" )
exit;

class conect
{
	private $host;
	private $root;
	private $pass;
	private $db;

	public function dbconect($host,$root,$pass,$db)
	{
		$this->host = $host;
		$this->root = $root;
		$this->pass = $pass;
		$this->db   = $db;
		$this->conexion = mysql_connect($this->host,$this->root,$this->pass);
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db( $this->db, $this->conexion );
	}

	//se cierra la conexión
	public function dbcerrar()
	{
		mysql_close($this->conexion);
	}
//
}

$conex=new conect();
$conex->dbconect("localhost","root","","web_parking");
?>