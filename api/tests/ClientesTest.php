<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Clientes;

class ClientesTest extends TestCase
{

    public function testCriarCliente()
    {
        $params = [
            'email' => 'test@test.com',
            'nome' => 'Test',
            'sobrenome' => 'Tested'
        ];

        /*
        * test POST json response 201
        */
        $response = $this->call('POST', '/clientes', $params);
        $json = json_decode($response->getContent());
        $this->assertResponseStatus(201);

        /*
         * test database data
         */
        $cliente = Clientes::where('email', 'test@test.com')->first();
        $this->assertTrue(!empty($cliente));
        $this->assertTrue(isset($cliente->email));
        $this->assertEquals('test@test.com', $cliente->email);
    }

    public function testAlterarCliente()
    {
        /*
        * test PUT response 200
        */
        $id_cliente = Clientes::max('id');

        $params = [
            'id' => $id_cliente,
            'email' => 'test_1@test.com',
            'nome' => 'Test1',
            'sobrenome' => 'Tested1'
        ];

        $response = $this->call('PUT', '/clientes', $params);
        $this->assertEquals(200, $response->status());
    }

    public function testListarClientes()
    {
        /*
        * test GET response 200
        */
        $response = $this->call('GET', '/clientes');
        $this->assertEquals(200, $response->status());
    }

    public function testListarCliente()
    {
        /*
        * test GET response 200
        */
        $id_cliente = Clientes::max('id');
        $response = $this->call('GET', '/clientes/'.$id_cliente);
        $this->assertEquals(200, $response->status());
    }

    public function testDeletarClientes()
    {
        /*
        * test DELETE response 200
        */
        $id_cliente = Clientes::max('id');
        $response = $this->call('DELETE','/clientes/'.$id_cliente);
        $this->assertEquals(200, $response->getStatusCode());
    }

}
