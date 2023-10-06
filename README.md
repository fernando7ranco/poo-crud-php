# datalayer-mysql-pdo


###### Camada de abstração de dados componentes de persistente do banco de dados mysql com PDO, aplicando prepared statements para executar rotinas comuns, como registrar, ler, editar e remover dados.


### Highlights

- PSR-2 compliant (Compatível com PSR-2)
- PSR-4 compliant (Compatível com PSR-4)

## Instalação de dependecias

via Composer:

## Documentação

###### Para começar a usar a camada de dados, você precisa se conectar ao banco de dados (MariaDB / MySql). Para mais conexões [PDO connections manual on PHP.net](https://www.php.net/manual/pt_BR/pdo.drivers.php)

```php
class DB{
	
	private $conexao;
	const USUARIO = 'root';
	const SENHA = '';
	const BANCO = 'test';
	
	public function __construct()
	{
		try{
			$this->conexao = new PDO("mysql:host=localhost;dbname=". SELF::BANCO, SELF::USUARIO, SELF::SENHA,  [
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_CASE => PDO::CASE_NATURAL
			]);
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}

	}
	
	public function getConexao()
	{
		return $this->conexao;
	}
}
```

#### seus models

###### A data layer é baseada em uma estrutura MVC e padrões de design. para consumir, é necessário criar o modelo da sua tabela e herdar a Camada de Dados.

###### Nomes de tabela

Observe que quando não informamos ao data layer qual tabela usar para o nosso 'teste'. è usado por convenção o proprio nome da model, convertendo para "snake case", nome da classe para o plural, será usado como o nome da tabela, a menos que outro nome seja especificado explicitamente. Portanto, nesse caso, o data layer assumirá que nome da tabela é 'testes'. Você pode especificar uma tabela customizada definindo uma propriedade table em seu modelo:

```php
class Teste extends DataLayer
{
    // auto nomenclatura de tabela para 'testes'
}

class Testes extends DataLayer
{
    $protected $table = 'teste';// caso sua tabela possua nomenclatura 'teste'
}

class TestesMesa extends DataLayer
{
    // auto conversão de nomenclatura para tabela testes_mesas
}

```

###### Timestamps

Por padrão, o data layer espera created_ate updated_at colunas existam em suas tabelas. Se você não deseja que essas colunas sejam gerenciadas automaticamente pelo data layer, configure a propriedade $timestamps em seu modelo para false:

```php
class Teste extends DataLayer
{
   protected $timestamps = false;
}

```

#### findById

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->findById(2);
echo $teste->id;
```
#### firts

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->firts(); // retorna primeira linha da tabela
echo $teste->id;
```
#### last

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->last(); // retorna ultima linha da tabela
echo $teste->id;
```
#### all

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste->all(); // retorna todas as linhas da tabela

foreach($teste as $value){
	echo $value->id;
}
```

#### columns

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data')->firts();
// ou parametros por vetor ->columns(['id', 'descricao', 'data'])
```

#### where

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data')
			->where('id > 1')
				->get();
// ou parametros por vetor ->columns(['id', 'descricao', 'data'])

```

#### group

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data, flag')
			->where('id > 1')
				->group('data, flag')
					->get();
// ou parametros por vetor ->group(['data', 'flag'])

```

#### order

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data, flag')
			->where('id > 1')
				->order('data, id')
					->get();
// ou parametros por vetor ->order(['data', 'id'])

```
#### having

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data, flag, count(1) as flag_count')
			->where('id > 1')
				->group('flag')
					->having('flag_count > 1')
						->get();

```
#### limit

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data, flag, count(1) as flag_count')
			->where('id > 1')
				->limit(5)
					->get();

```

#### offset

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste = $teste->columns('id, descricao, data, flag, count(1) as flag_count')
			->where('id > 1')
				->limit(5)
					->offset(4)
						->get();

```

#### save create

```php
<?php
use App\Models\Teste;

$teste = new Teste();
$teste->descricao = "descricao";
$testeID = $teste->save();
```

#### save update

```php
<?php
use App\Models\Teste;
$teste = (new Teste())->findById(2);

$teste->descricao = "descricao de alguma coisa";
$testeID = $teste->save();
```

#### delete

```php
<?php
use App\Models\Teste;
$teste = (new Teste())->findById(2);

$teste->delete();
```
#### count

```php
<?php
use App\Models\Teste;

$count = (new Teste())->where('id > 1')->count()

```

#### showSql

```php
<?php
use App\Models\Teste;

$teste = (new Teste())->where('id > 1')->get();
echo $teste->showSql(); // select * from testes where id > 1;
```
#### toArray

```php
<?php
use App\Models\Teste;

$teste = (new Teste())->where('id > 1')->get();
$lista = $teste->toArray(); // vetor dos dados selecionados na condição;
```
#### toJson

```php
<?php
use App\Models\Teste;

$teste = (new Teste())->where('id > 1')->get();
$lista = $teste->toJson(); // texto json dos dados selecionados na condição;
```
#### buffer class

```php
<?php
use App\Models\Teste;

$teste = (new Teste())->where('id > 1')->get();
echo $teste; // texto json dos dados selecionados na condição;
print_r($teste) // vetor dos dados selecionados na condição;
```
## Creditos

- [Fernando Soares Franco](https://github.com/fernando7ranco) (Developer)

## License

The MIT License (MIT). Please see [License File](https://github.com/fernando7ranco/datalayer-mysql-pdo/blob/master/LICENSE.md) for more information.
