<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedidos;
use App\Models\Clientes;

class PedidosController extends Controller
{
    /**
     * @var Pedidos
     */
    public $pedidos;
    public $clientes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pedidos = new Pedidos();
        $this->clientes = new Clientes();
    }

    /**
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function ListarPedidos()
    {
        $result = $this->pedidos::all();
        foreach ($result as $key => $item){
            $item->cliente = $this->clientes::find($item->id_cliente);
        }
        return response($result, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function SelecionarPedido($id)
    {
        $result = $this->pedidos::find($id);
        $result->cliente = $this->clientes::find($result->id_cliente);
        return response($result, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param  Request  $data
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function CadastrarPedido(Request $data)
    {
        $result = $this->pedidos::create([
            'status' => $data->status,
            'id_cliente' => $data->id_cliente,
            'valor' => $data->valor
        ]);
        return response($result, 201)->header('Content-Type', 'application/json');
    }

    /**
     * @param  Request  $data
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function AlterarPedido(Request $data)
    {
        $result = $this->pedidos::find($data->id);
        $result->status = $data->status;
        $result->valor = $data->valor;
        $result->save();

        return response($result, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function DeletarPedido($id)
    {
        $result = $this->pedidos::find($id);
        $result->delete();
        return response($result, 200)->header('Content-Type', 'application/json');
    }
}
