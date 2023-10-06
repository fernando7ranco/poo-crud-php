<?php

namespace App\Repositories;

use App\Models\Imovel as ModelImovel;
use App\SRC\Classes\ADataLayerRepository;
use App\SRC\Classes\AImovel;
use App\SRC\Interfaces\IDTO;
use Exception;

class RepositoryImovel extends ADataLayerRepository
{
	public function __construct(ModelImovel $model)
	{
		$this->model = $model;
	}

	/**
	 * @param IDTO $imovel
	 * 
	 * @return array
	 */
	public function create(IDTO $imovel): array
	{
		if (!$this->model->create($imovel->getData())) {
			throw new Exception('create erro verify your data send');
		}

		return $this->model->toArray();
	}

	/**
	 * @param AImovel $imovel
	 * 
	 * @return array
	 */
	public function update(IDTO $imovel): array
	{
		if (!$this->model->update($imovel->getData())) {
			throw new Exception('update error verify your data send');
		}

		return $this->model->toArray();
	}
}
