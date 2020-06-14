<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function teste()
    {
        $json = [
            'nome' => 'Teste'
        ];

        return response($json,201)->header('Content-Type', 'application/json');
    }

    //
}
