<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class MapaClienteController extends Controller
{
    public function mostrar()
    {
        // Utilizamos paginate para paginar los resultados
        $clientes = Cliente::whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->paginate(5); // Cambié get() por paginate(5)

        return view('clientes.mapa', compact('clientes'));
    }

    public function index()
    {
        // Si tenés una vista para listar clientes
        $clientes = Cliente::paginate(5);
        return view('clientes.index', compact('clientes'));
    }
}
