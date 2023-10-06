<?php

namespace App\SRC\Interfaces;

interface IDataLayerRepository
{
	/**
	 * @param int $id
	 * 
	 * @return [type]
	 */
	public function find(int $id);

	/**
	 * @param object $data
	 * 
	 * @return [type]
	 */
	public function create(IDTO $data);

	/**
	 * @param array $data
	 * 
	 * @return [type]
	 */
	public function update(IDTO $data);

	/**
	 * @param int $id
	 * 
	 * @return bool
	 */
	public function delete(int $id): bool;

	/**
	 * @return [type]
	 */
	public function all();
}
