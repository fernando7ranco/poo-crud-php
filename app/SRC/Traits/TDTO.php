<?php

namespace App\SRC\Traits;

trait TDTO {

	/**
	 * @param array $data
	 * 
	 * @return void
	 */
	public function setData(array $data): void {
		foreach ($this->fields as $key => $value) {
			if ($key === 'disabled') {
				continue;
			}
			$this->data[$value] = $data[$value] ?? null;
		}
	}
}