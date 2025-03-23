<?php

namespace App\Livewire;

use App\Models\Stock;
use App\Models\Producto;
use App\Models\Etiqueta;
use Livewire\Component;

class Stocks extends Component
{
    public $stocks, $fechaElaboracion, $fechaVencimiento, $observaciones, $producto_id, $etiqueta_id, $stock_id, $modal = false;

    public function mount()
    {
        // Inicializa los valores necesarios al cargar el componente
        $this->stocks = Stock::with('producto', 'etiqueta')->get();
    }

    public function render()
    {
        // Obtener productos y etiquetas disponibles para el modal
        $productos = Producto::all();
        $etiquetas = Etiqueta::all();

        return view('livewire.stocks', compact('productos', 'etiquetas'));
    }

    public function abrirModal()
    {
        $this->limpiarCampos();
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function limpiarCampos()
    {
        $this->stock_id = null;
        $this->fechaElaboracion = '';
        $this->fechaVencimiento = '';
        $this->observaciones = '';
        $this->producto_id = '';
        $this->etiqueta_id = '';
    }

    public function guardar()
    {
        $this->validate([
            'fechaElaboracion' => 'required|date',
            'fechaVencimiento' => 'required|date',
            'producto_id' => 'required|exists:productos,id',
            'etiqueta_id' => 'nullable|exists:etiquetas,id',
            'observaciones' => 'nullable|string',
        ]);

        Stock::updateOrCreate(['id' => $this->stock_id], [
            'fechaElaboracion' => $this->fechaElaboracion,
            'fechaVencimiento' => $this->fechaVencimiento,
            'observaciones' => $this->observaciones,
            'producto_id' => $this->producto_id,
            'etiqueta_id' => $this->etiqueta_id,
        ]);

        session()->flash('message', $this->stock_id ? 'Stock actualizado' : 'Stock creado');
        $this->cerrarModal();
        $this->stocks = Stock::with('producto', 'etiqueta')->get(); // Refresca la lista de stocks
    }

    public function editar($id)
    {
        $stock = Stock::findOrFail($id);
        $this->stock_id = $id;
        $this->fechaElaboracion = $stock->fechaElaboracion;
        $this->fechaVencimiento = $stock->fechaVencimiento;
        $this->observaciones = $stock->observaciones;
        $this->producto_id = $stock->producto_id;
        $this->etiqueta_id = $stock->etiqueta_id;

        $this->modal = true;
    }
}
