<?php

if (!function_exists('view')) {

	function view(string $file, array $data = [])
	{
		if (!empty($data)) {
			extract($data);
		}

		ob_start();
		require __APP_ROOT__ . "/app/view/{$file}.php";
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