<?php

namespace App\SRC\Classes;

use App\SRC\Interfaces\IDTO;
use App\SRC\Interfaces\IImovel;
use App\SRC\Traits\TDTO;

class AImovel implements IImovel, IDTO
{
	use TDTO;

	protected $data;

	protected $fields = [
		'id',
		'endereco',
		'preco',
		'status',
		'tipo'
	];

	public function __construct(array $data)
	{
		self::setData($data);
	}

	/**
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @param string $status
	 * 
	 * @return bool
	 */
	public function acceptStatus(string $status = ''): bool
	{
		if (empty($status)) {
			$status = $this->data['status'] ?? '';
		}
		return in_array($status, [
			self::STATUS_ALUGADO,
			self::STATUS_DISPONIVEL,
			self::STATUS_VENDIDO
		]);
	}
}
