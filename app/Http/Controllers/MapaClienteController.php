<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class MapaClienteController extends Controller
{
    public function mostrar()
    {
        $clientes = Cliente::whereNotNull('latitud')->whereNotNull('longitud')->get();

        return view('clientes.mapa', compact('clientes'));
    }

    public function index()
    {
        // Si tenés una vista para listar clientes
        $clientes = Cliente::paginate(10);
        return view('clientes.index', compact('clientes'));
    }
}
