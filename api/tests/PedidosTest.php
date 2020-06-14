<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Pedidos;
use App\Models\Clientes;

class PedidosTest extends TestCase
{
    public function testCriarPedidos()
    {
        $id_cliente = Clientes::max('id');
        $params = [
            'status' => 'new',
            'id_cliente' => $id_cliente,
            'valor' => '10.50'
        ];

        /*
        * test POST json response 201
        */
        $response = $this->call('POST', '/pedidos', $params);
        $json = json_decode($response->getContent());
        $this->assertResponseStatus(201);

        /*
         * test database data
         */
        $pedidos = Pedidos::where('id', $json->id)->first();
        $this->assertTrue(!empty($pedidos));
        $this->assertTrue(isset($pedidos->status));
        $this->assertEquals('new', $pedidos->status);
    }

    public function testAlterarCliente()
    {
        /*
        * test PUT response 200
        */
        $id_pedido = Pedidos::max('id');

        $params = [
            'id' => $id_pedido,
            'status' => 'pending',
            'valor' => '10.50'
        ];

        $response = $this->call('PUT', '/pedidos', $params);
        $this->assertEquals(200, $response->status());
    }

    public function testListarPedidos()
    {
        /*
        * test GET response 200
        */
        $response = $this->call('GET', '/pedidos');
        $this->assertEquals(200, $response->status());
    }

    public function testListarPedido()
    {
        /*
        * test GET response 200
        */
        $id_pedido = Pedidos::max('id');
        $response = $this->call('GET', '/pedidos/'.$id_pedido);
        $this->assertEquals(200, $response->status());
    }

    public function testDeletarPedidos()
    {
        /*
        * test DELETE response 200
        */
        $id_pedido = Pedidos::max('id');
        $response = $this->call('DELETE','/pedidos/'.$id_pedido);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
