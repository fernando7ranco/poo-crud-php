<?php

namespace App\SRC\Classes;

class CTerreno extends AImovel
{
	const TIPO = 'terreno';

	public function __construct(array $data)
	{
		$data['tipo'] = self::TIPO;
		parent::__construct($data);
	}
}
