<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;

/**
 * Class ClientesController
 * @package App\Http\Controllers
 */
class ClientesController extends Controller
{
    /**
     * @var Clientes
     */
    public $clientes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clientes = new Clientes();
    }

    /**
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function ListarClientes()
    {
        $result = $this->clientes::all();
        return response($result, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function SelecionarCliente($id)
    {
        $result = $this->clientes::find($id);
        return response($result, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param  Request  $data
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function CadastrarCliente(Request $data)
    {
        $result = $this->clientes::create([
            'nome' => $data->nome,
            'sobrenome' => $data->sobrenome,
            'email' => $data->email
        ]);
        return response($result, 201)->header('Content-Type', 'application/json');
    }

    /**
     * @param  Request  $data
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function AlterarCliente(Request $data)
    {
        $result = $this->clientes::find($data->id);
        $result->nome = $data->nome;
        $result->sobrenome = $data->sobrenome;
        $result->email = $data->email;
        $result->save();

        return response($result, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function DeletarCLiente($id)
    {
        $result = $this->clientes::find($id);
        $result->delete();
        return response($result, 200)->header('Content-Type', 'application/json');
    }
}
