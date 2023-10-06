<?php

namespace App\SRC\Classes;


class CApartamento extends AImovel
{
	const TIPO = 'apartamento';

	public function __construct(array $data)
	{
		$data['tipo'] = self::TIPO;
		parent::__construct($data);
	}
}
