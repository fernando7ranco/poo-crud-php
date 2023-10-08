<?php

namespace App\DB;

use PDO;
use PDOException;

class DB{
	
	private $conexao;
	
	public function __construct()
	{
		try{
			$name = configs('DB_NAME');
			$user = configs('DB_USER');
			$password = configs('DB_PASSWORD');

			$this->conexao = new PDO("mysql:host=localhost;dbname=". $name, $user, $password, [
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_CASE => PDO::CASE_NATURAL
			]);
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}

	}
	
	public function getConexao()
	{
		return $this->conexao;
	}
}