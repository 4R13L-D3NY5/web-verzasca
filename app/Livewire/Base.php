<?php

namespace App\Livewire;

use Livewire\Component;

class Base extends Component
{
    public $seleccion = 'Compras'; // Default value for $seleccion
    public function render()
    {
        return view('livewire.base');
    }
}
