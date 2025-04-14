<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapaClienteController extends Controller
{
    public function mostrar()
    {
        return view('clientes.mapa'); // asegúrate de que esta vista exista
    }
}
