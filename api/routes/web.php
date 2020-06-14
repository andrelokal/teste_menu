<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//End Point Clientes
$router->get('/clientes','ClientesController@ListarClientes');
$router->get('/clientes/{id}','ClientesController@SelecionarCliente');
$router->post('/clientes','ClientesController@CadastrarCliente');
$router->delete('/clientes/{id}','ClientesController@DeletarCliente');
$router->put('/clientes','ClientesController@AlterarCliente');

//End Point Pedidos
$router->get('/pedidos','PedidosController@ListarPedidos');
$router->get('/pedidos/{id}','PedidosController@SelecionarPedido');
$router->post('/pedidos','PedidosController@CadastrarPedido');
$router->delete('/pedidos/{id}','PedidosController@DeletarPedido');
$router->put('/pedidos','PedidosController@AlterarPedido');
