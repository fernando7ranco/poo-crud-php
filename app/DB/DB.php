<?php

namespace App\DB;

use PDO;
use PDOException;

class DB{
	
	private $conexao;
	const USUARIO = 'root';
	const SENHA = '';
	const BANCO = 'test';
	
	public function __construct()
	{
		try{
			$this->conexao = new PDO("mysql:host=localhost;dbname=". SELF::BANCO, SELF::USUARIO, SELF::SENHA,  [
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