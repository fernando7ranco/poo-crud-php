<?php

if (!function_exists('view')) {

	function view($file)
	{
		ob_start();
		require dirname(__DIR__) . "/view/{$file}.php";
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}

if (!function_exists('fieldsRequireds')) {

	function fieldsRequireds(array $data, array $required): array
	{
		$emptys = [];

		foreach ($required as $field) {
			if (empty($data[$field])) {
				$emptys[] = $field;
			}
		}

		return $emptys;
	}
}