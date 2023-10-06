<?php

namespace App\Controllers;

use App\SRC\Middlewares\MAuthAPi;
use App\SRC\Services\ServiceImovel;
use Exception;

final class ControllerImovel
{
	/** @var ServiceImovel */
	private $service;

	public function __construct()
	{
		new MAuthAPi;
		$this->service = new ServiceImovel;
	}

	/**
	 * @param callable $callback
	 * @param int $codeSuccess
	 * 
	 * @return array
	 */
	private function runAction(callable $callback, int $code = 201): array
	{
		try {
			$response = $callback();
		} catch (Exception $e) {
			$code = $e->getCode() ?: 400;
			$response = ['error' => $e->getMessage()];
		}
		http_response_code($code);
		return $response ?? [];
	}

	/**
	 * @param mixed $data
	 * 
	 * @return array
	 */
	public function showImovel($data): array {
		return self::runAction(function () use ($data) {
			return $this->service->get($data['args']['id']);
		}, 200);
	}

	/**
	 * @return array
	 */
	public function showAllImovel(): array {
		return self::runAction(function () {
			return $this->service->getAll();
		}, 200);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function createCasa(array $data): array
	{
		return self::runAction(function () use ($data) {
			return $this->service->createCasa($data['data']);
		});
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function createApartamento(array $data): array
	{
		return self::runAction(function () use ($data) {
			return $this->service->createApartamento($data['data']);
		});
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function createTerreno(array $data): array
	{
		return self::runAction(function () use ($data) {
			return $this->service->createTerreno($data['data']);
		});
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function updateCasa(array $data): array
	{
		return self::runAction(function () use ($data) {
			return $this->service->updateCasa($data['args']['id'], $data['data']);
		}, 200);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function updateApartamento(array $data): array
	{
		return self::runAction(function () use ($data) {
			return $this->service->updateApartamento($data['args']['id'], $data['data']);
		}, 200);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function updateTerreno(array $data): array
	{
		return self::runAction(function () use ($data) {
			return $this->service->updateTerreno($data['args']['id'], $data['data']);
		}, 200);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function deleteCasa(array $data)
	{
		return self::runAction(function () use ($data) {
			return $this->service->deleteCasa($data['args']['id']);
		}, 204);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function deleteApartamento(array $data)
	{
		return self::runAction(function () use ($data) {
			return $this->service->deleteApartamento($data['args']['id']);
		}, 204);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function deleteTerreno(array $data)
	{
		return self::runAction(function () use ($data) {
			return $this->service->deleteTerreno($data['args']['id']);
		}, 204);
	}
}
