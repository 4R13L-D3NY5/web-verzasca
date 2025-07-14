<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use Carbon\Carbon;

class Reportestock extends Component
{
    public function render()
    {
        $stocks = Stock::with(['producto', 'etiqueta', 'sucursal'])->get();
        $fecha = Carbon::now()->format('d/m/Y H:i');

        return view('livewire.reportestock', compact('stocks', 'fecha'));
    }
}
