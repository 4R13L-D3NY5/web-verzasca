<?php

namespace App\Livewire;

use Livewire\Component;

class Base extends Component
{
    public $seleccion = 'Reportestock'; // Default value for $seleccion
    public $roles = ['', 'Super administrador', 'Administrador', 'Distribuidor', 'Planta', 'Cliente'];
    public function render()
    {
        return view('livewire.base');
    }
}
