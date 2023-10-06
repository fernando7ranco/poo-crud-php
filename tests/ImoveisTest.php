<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;

class ImoveisTest extends TestCase
{
	const TOKEN_API = 'tttt';

	private $http;

	public function setUp(): void
	{
		$this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/teste/public/imovel']);
	}

	private function verificaRotaEstaBloqueadaParaTokenErrado(string $metodo, string $uri)
	{
		$tokenErrado = 'TOKEN-INVALIDO';

		try {
			$this->http->request($metodo, $uri, [
				'headers' => ['Authorization' => 'Bearer ' . $tokenErrado]
			]);
		} catch (ClientException $e) {
			$response = $e->getResponse();
			$this->assertEquals(401, $response->getStatusCode());
		}
	}

	private function isJsonResponse($response)
	{
		$conteudoResposta = json_decode($response->getBody()->getContents(), true);
		$this->assertNotEquals(null, $conteudoResposta, 'response is not JSON');
		return $conteudoResposta;
	}

	private function criarImovel(string $uri, array $data)
	{
		$metodo = 'POST';
		self::verificaRotaEstaBloqueadaParaTokenErrado($metodo, $uri);

		$response = $this->http->request($metodo, 'imovel/' . $uri, [
			'headers' => ['Authorization' => 'Bearer ' . self::TOKEN_API],
			GuzzleHttp\RequestOptions::JSON => $data
		]);

		$this->assertEquals(201, $response->getStatusCode());
		$conteudoResposta = self::isJsonResponse($response);
		$this->assertArrayHasKey('id', $conteudoResposta);

		return $conteudoResposta;
	}

	public function criarImovelErro(string $uri)
	{
		$this->expectException(GuzzleHttp\Exception\ClientException::class);
		self::criarImovel($uri, []);
	}


	private function editarImovel(string $uri)
	{
		$conteudoResposta = self::criarImovel($uri, [
			'endereco' => 'rua tal lugar tal',
			'preco' => 67.338,
			'status' => 'disponivel'
		]);

		$response = $this->http->request('PUT', 'imovel/' . $conteudoResposta['id'] . '/' . $uri, [
			'headers' => ['Authorization' => 'Bearer ' . self::TOKEN_API],
			GuzzleHttp\RequestOptions::JSON => [
				'endereco' => 'rua tal lugar tal editado',
				'preco' => 7.338,
				'status' => 'alugado'
			]
		]);

		$this->assertEquals(200, $response->getStatusCode());
	}

	private function removerImovel(string $uri)
	{
		$conteudoResposta = self::criarImovel($uri, [
			'endereco' => 'rua tal lugar tal',
			'preco' => 67.338,
			'status' => 'disponivel'
		]);

		$response = $this->http->request('DELETE', 'imovel/' . $conteudoResposta['id'] . '/' . $uri, [
			'headers' => ['Authorization' => 'Bearer ' . self::TOKEN_API],
		]);

		$this->assertEquals(204, $response->getStatusCode());
	}

	public function testListarTodosImoveis()
	{
		self::verificaRotaEstaBloqueadaParaTokenErrado('GET', 'imovel');

		$response = $this->http->request('GET', 'imovel', [
			'headers' => ['Authorization' => 'Bearer ' . self::TOKEN_API]
		]);

		$this->assertEquals(200, $response->getStatusCode());
		$conteudoResposta = self::isJsonResponse($response);
		$this->assertArrayHasKey('id', $conteudoResposta[0]);
	}

	public function testPegarImovel()
	{
		self::verificaRotaEstaBloqueadaParaTokenErrado('GET', 'imovel/1');

		$response = $this->http->request('GET', 'imovel/1', [
			'headers' => ['Authorization' => 'Bearer ' . self::TOKEN_API]
		]);

		$this->assertEquals(200, $response->getStatusCode());
		$conteudoResposta = self::isJsonResponse($response);
		$this->assertArrayHasKey('id', $conteudoResposta);
	}

	public function testCriarCasa()
	{
		self::criarImovel(
			'casa',
			[
				'endereco' => 'rua tal lugar tal',
				'preco' => 67.338,
				'status' => 'disponivel'
			]
		);
	}

	public function testCriarCasaErro()
	{
		self::criarImovelErro('casa');
	}

	public function testCriarApartamento()
	{
		self::criarImovel(
			'apartamento',
			[
				'endereco' => 'rua tal lugar tal',
				'preco' => 67.338,
				'status' => 'disponivel'
			]
		);
	}

	public function testCriarApartamentoErro()
	{
		self::criarImovelErro('apartamento');
	}

	public function testCriarTerreno()
	{
		self::criarImovel(
			'terreno',
			[
				'endereco' => 'rua tal lugar tal',
				'preco' => 67.338,
				'status' => 'disponivel'
			]
		);
	}

	public function testCriarTerrenoErro()
	{
		self::criarImovelErro('terreno');
	}

	public function testRemoverCasa()
	{
		self::removerImovel('casa');
	}

	public function testRemoverApartamento()
	{
		self::removerImovel('apartamento');
	}

	public function testRemoverTerreno()
	{
		self::removerImovel('terreno');
	}

	public function testEditarCasa()
	{
		self::editarImovel('casa');
	}

	public function testEditarApartamento()
	{
		self::editarImovel('apartamento');
	}

	public function testEditarTerreno()
	{
		self::editarImovel('terreno');
	}
}
