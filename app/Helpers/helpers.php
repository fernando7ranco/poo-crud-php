<?php

if (!function_exists('configs')) {

	function configs(string $element)
	{
		$env = parse_ini_file((__DIR__ . "/../../") . "/.env");
		return $env[$element] ?? '';
	}
}

if (!function_exists('view')) {

	function view(string $file, array $data = [])
	{
		if (!empty($data)) {
			extract($data);
		}

		ob_start();
		require (__DIR__ . "/../View") . "/{$file}.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
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
