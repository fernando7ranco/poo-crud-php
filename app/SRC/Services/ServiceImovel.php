<?php

namespace App\SRC\Services;

use App\Models\Imovel as ModelImovel;
use App\Repositories\RepositoryImovel;
use App\SRC\Classes\AImovel;
use App\SRC\Classes\CApartamento;
use App\SRC\Classes\CCasa;
use App\SRC\Classes\CTerreno;
use Exception;

class ServiceImovel
{
	/** @var RepositoryImovel */
	private $repository;

	public function __construct()
	{
		$this->repository = new RepositoryImovel(new ModelImovel);
	}

	private function validateImovelData(AImovel $imovel)
	{
		$data = $imovel->getData();

		$emptys = fieldsRequireds($data, [
			'endereco',
			'preco',
			'status'
		]);

		if (!empty($emptys)) {
			throw new Exception('fields requireds (' . implode(', ', $emptys) . ')');
		}

		if (!is_numeric($data['preco']) || $data['preco'] < 0) {
			throw new Exception('field preco is not number valid');
		}

		if (!$imovel->acceptStatus()) {
			throw new Exception('field status is not valid');
		}
	}

	/**
	 * @param int $id
	 * @param AImovel $imovel
	 * 
	 * @return void
	 */
	private function validateTypeImovel(int $id, AImovel $imovel): void
	{
		$imovelDB = self::get($id);

		if ($imovelDB['tipo'] !== $imovel::TIPO) {
			throw new Exception('type of imovel  is not compatible');
		}
	}

	/**
	 * @param int $id
	 * 
	 * @return array
	 */
	public function get(int $id): array {
		try {
			$imovel = $this->repository->find($id);
			return current($imovel->toArray());
		} catch (Exception $e) {
			throw new Exception('Imovel id: ' . $id . ' not found', 404);
		}
	}

	/**
	 * @return array
	 */
	public function getAll(): array {
		return $this->repository->all()->toArray();
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function createCasa(array $data): array
	{
		$casa = new CCasa($data);
		self::validateImovelData($casa);

		return $this->repository->create($casa);
	}

	public function createApartamento(array $data): array
	{
		$apartamento = new CApartamento($data);
		self::validateImovelData($apartamento);

		return $this->repository->create($apartamento);
	}

	public function createTerreno(array $data): array
	{
		$terreno = new CTerreno($data);
		self::validateImovelData($terreno);

		return $this->repository->create($terreno);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function updateCasa(int $id, array $data): array
	{
		$data['id'] = $id;
		$casa = new CCasa($data);
		self::validateImovelData($casa);
		self::validateTypeImovel($id, $casa);

		return $this->repository->update($casa);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function updateApartamento(int $id, array $data): array
	{
		$data['id'] = $id;
		$apartamento = new CApartamento($data);
		self::validateImovelData($apartamento);
		self::validateTypeImovel($id, $apartamento);

		return $this->repository->update($apartamento);
	}

	/**
	 * @param array $data
	 * 
	 * @return array
	 */
	public function updateTerreno(int $id, array $data): array
	{
		$data['id'] = $id;
		$terreno = new CTerreno($data);
		self::validateImovelData($terreno);
		self::validateTypeImovel($id, $terreno);

		return $this->repository->update($terreno);
	}

	/**
	 * @param array $data
	 * 
	 * @return void
	 */
	public function deleteCasa(int $id): void
	{
		$casa = new CCasa(['id' => $id]);
		self::validateTypeImovel($id, $casa);

		if (!$this->repository->delete($id)) {
			throw new Exception('it was not possible to exclude the casa');
		}
	}

	/**
	 * @param array $data
	 * 
	 * @return void
	 */
	public function deleteApartamento(int $id): void
	{
		$apartamento = new CApartamento(['id' => $id]);
		self::validateTypeImovel($id, $apartamento);

		if (!$this->repository->delete($id)) {
			throw new Exception('it was not possible to exclude the apartamento');
		}
	}

	/**
	 * @param array $data
	 * 
	 * @return void
	 */
	public function deleteTerreno(int $id): void
	{
		$terreno = new CTerreno(['id' => $id]);
		self::validateTypeImovel($id, $terreno);

		if (!$this->repository->delete($id)) {
			throw new Exception('it was not possible to exclude the terreno');
		}
	}
}
