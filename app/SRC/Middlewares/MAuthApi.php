<?php

namespace App\SRC\Middlewares;

use App\Models\AuthApi;
use Exception;

class MAuthAPi
{
	public function __construct()
	{
		self::runRule();
	}

	private function runRule()
	{
		$token = self::getToken();
		self::verifyToken($token);
	}

	private function getToken(): string
	{
		return self::getBearerToken(getallheaders());
	}

	private function verifyToken(string $token)
	{
		$authApi = new AuthApi;
		$authApi
			->columns('1')
			->where('token = ' . $authApi->quote($token))
			->andWhere('date_expiration >= now()')
			->get();
		
		if (!$authApi->hasResult()) {
			throw new Exception('you are not authenticated to perform this action', 401);
		}
	}

	/**
	 * @param array $data
	 * 
	 * @return string
	 */
	private function getBearerToken(array $data): string
	{
		$headers = array_change_key_case($data, CASE_LOWER);
		// HEADER: Get the access token from the header
		if (!empty($headers['authorization'])) {
			if (preg_match('/Bearer\s(\S+)/', $headers['authorization'], $matches)) {
				return $matches[1];
			}
		}

		return '';
	}
}
