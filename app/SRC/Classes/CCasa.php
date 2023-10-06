<?php

namespace App\SRC\Classes;

class CCasa extends AImovel
{
	const TIPO = 'casa';

	public function __construct(array $data)
	{
		$data['tipo'] = self::TIPO;
		parent::__construct($data);
	}
}
