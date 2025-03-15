<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente as modelocliente; // Importamos el modelo Cliente

class Cliente extends Component
{
    // El método render obtiene los clientes de la base de datos
    public function render()
    {
        // Obtener todos los clientes
        $clientes = modelocliente::all();

        // Pasar los clientes a la vista
        return view('livewire.cliente', compact('clientes'));
    }
}
