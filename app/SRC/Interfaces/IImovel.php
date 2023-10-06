<?php

namespace App\SRC\Interfaces;

interface IImovel
{
	const TIPO = 'imovel';

	const STATUS_DISPONIVEL = 'disponivel';
	const STATUS_ALUGADO = 'alugado';
	const STATUS_VENDIDO = 'vendido';

	/**
	 * @param string $status
	 * 
	 * @return bool
	 */
	public function acceptStatus(string $status = ''): bool;
}