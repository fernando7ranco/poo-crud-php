<?php

namespace App\SRC\Classes;

use App\SRC\Interfaces\IDataLayerRepository;
use Exception;

abstract class ADataLayerRepository implements IDataLayerRepository
{
	protected $model;

	protected function objectName()
	{
		$namespaceArray = explode('\\', get_class($this->model));
		return end($namespaceArray);
	}

	public function find(int $id)
	{
		$model = $this->model->findById($id);

		if (!$model->hasResult()) {
			throw new Exception('Not found ' . $this->objectName() . ' for id ' . $id);
		}

		$this->model = $model;

		return $this->model;
	}

	public function all()
	{
		return $this->model->all();
	}

	public function delete(int $id): bool
	{
		return $this->model->delete('id = '. $id);
	}
}
