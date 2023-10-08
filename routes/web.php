<?php

use App\Router;

$router = new Router();

$router->get('home', 'ControllerImovelView@home')->name('homepage');

$router->group('imovel', function ($route) {
	$route->get('/new', 'ControllerImovelView@new')->name('newimovel');
	$route->get('/edit/{id}:(\d+)', 'ControllerImovelView@edit')->name('editimovel');

	$route->post('/casa', 'ControllerImovel@createCasa')->name('createcasa');
	$route->post('/apartamento', 'ControllerImovel@createApartamento')->name('createapartamento');
	$route->post('/terreno', 'ControllerImovel@createTerreno')->name('createterreno');

	$route->get('', 'ControllerImovel@showAllImovel')->name('showallimovel');
})->group('imovel/{id}:(\d+)', function ($route) {
	$route->put('/casa', 'ControllerImovel@updateCasa')->name('updatecasa');
	$route->put('/apartamento', 'ControllerImovel@updateApartamento')->name('updateapartamento');
	$route->put('/terreno', 'ControllerImovel@updateTerreno')->name('updateterreno');

	$route->delete('/casa', 'ControllerImovel@deleteCasa')->name('deletecasa');
	$route->delete('/apartamento', 'ControllerImovel@deleteApartamento')->name('deleteapartamento');
	$route->delete('/terreno', 'ControllerImovel@deleteTerreno')->name('deleteterreno');

	$route->get('', 'ControllerImovel@showImovel')->name('showimovel');
});

//die($router);
echo $router($router->method(), $router->uri());
