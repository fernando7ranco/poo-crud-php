# poo-crud-php


### Highlights

- PSR-2 compliant (Compatível com PSR-2)
- PSR-4 compliant (Compatível com PSR-4)

## Instalação de dependecias

via Composer:

##### Requisitos
- PHP 7.2+
- Mysql 5.6+

##### Inicio do sistema
localhost/public/home

##### Testes
`composer test --verbose tests/ImoveisTest.php`

#### Configurações
ajustar as contantes no arquivo tests\ImoveisTest.php

```php
const TOKEN_API = 'seu token api aqui';
const URL_SERVER = 'caminho/dominio onde esta o projeto'; # http://localhost/projeto
```
no arquivo app\asserts\js\main.js ajustar o token na `getBearerToken`

```js
function getBearerToken() {
	return 'seu token api aqui';
}
```

###### Para começar a usar a camada de dados, você precisa se conectar ao banco de dados (MariaDB / MySql). Para mais conexões [PDO connections manual on PHP.net](https://www.php.net/manual/pt_BR/pdo.drivers.php)

The MIT License (MIT). Please see [License File](https://github.com/fernando7ranco/poo-crud-php/blob/master/LICENSE.md) for more information.