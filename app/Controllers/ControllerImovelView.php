<?php

namespace App\Controllers;

use App\SRC\Classes\CApartamento;
use App\SRC\Classes\CCasa;
use App\SRC\Classes\CTerreno;
use App\SRC\Interfaces\IImovel;

final class ControllerImovelView
{
	/**
	 * @return string
	 */
	public function home(): string
	{
		$data = [
			'typesImoveis' => [
				CCasa::TIPO,
				CApartamento::TIPO,
				CTerreno::TIPO
			],
			'statusImoveis' => [
				IImovel::STATUS_DISPONIVEL,
				IImovel::STATUS_ALUGADO,
				IImovel::STATUS_VENDIDO
			]
		];

		return view('home', $data);
	}

	/**
	 * @return string
	 */
	public function new(): string
	{
		$data = [
			'typesImoveis' => [
				CCasa::TIPO,
				CApartamento::TIPO,
				CTerreno::TIPO
			],
			'statusImoveis' => [
				IImovel::STATUS_DISPONIVEL,
				IImovel::STATUS_ALUGADO,
				IImovel::STATUS_VENDIDO
			]
		];

		return view('form', $data);
	}

	/**
	 * @return string
	 */
	public function edit($dataParam): string
	{
		$data = [
			'typesImoveis' => [
				CCasa::TIPO,
				CApartamento::TIPO,
				CTerreno::TIPO
			],
			'statusImoveis' => [
				IImovel::STATUS_DISPONIVEL,
				IImovel::STATUS_ALUGADO,
				IImovel::STATUS_VENDIDO
			],
			'idImovel' => $dataParam['args']['id']
		];

		return view('form', $data);
	}
}
