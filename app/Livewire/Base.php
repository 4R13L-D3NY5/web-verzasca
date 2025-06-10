<?php

namespace App\Livewire;

use Livewire\Component;

class Base extends Component
{
    public $seleccion = 'Venta'; // Default value for $seleccion
    public function render()
    {
        return view('livewire.base');
    }
}
