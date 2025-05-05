<?php

namespace App\Livewire;

use App\Models\Stock;
use App\Models\Etiqueta;
use App\Models\Producto;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Stocks extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $modalDetalle = false;
    public $stock_id = null;
    public $fechaElaboracion = '';
    public $fechaVencimiento = '';
    public $observaciones = '';
    public $etiqueta_id = '';
    public $producto_id = '';
    public $sucursal_id = '';
    public $accion = 'create';
    public $stockSeleccionado = [];

    public $etiquetas;
    public $productos;
    public $sucursales;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'fechaElaboracion' => 'required|date',
        'fechaVencimiento' => 'required|date|after_or_equal:fechaElaboracion',
        'observaciones' => 'nullable|string|max:255',
        'etiqueta_id' => 'nullable|exists:etiquetas,id',
        'producto_id' => 'nullable|exists:productos,id',
        'sucursal_id' => 'nullable|exists:sucursals,id',
    ];

    public function mount()
    {
        $this->etiquetas = Etiqueta::all();
        $this->productos = Producto::all();
        $this->sucursales = Sucursal::all();
    }

    public function render()
    {
        $stocks = Stock::with(['etiqueta', 'producto', 'sucursal'])
            ->when($this->search, function ($query) {
                $query->where('observaciones', 'like', '%' . $this->search . '%');
            })
            ->paginate(5);

        return view('livewire.stocks', compact('stocks'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->reset(['fechaElaboracion', 'fechaVencimiento', 'observaciones', 'etiqueta_id', 'producto_id', 'sucursal_id']);
        $this->accion = $accion;

        if ($accion === 'edit' && $id) {
            $this->editar($id);
        }

        $this->modal = true;
    }

    public function editar($id)
    {
        $stock = Stock::findOrFail($id);

        $this->stock_id = $stock->id;
        $this->fechaElaboracion = $stock->fechaElaboracion;
        $this->fechaVencimiento = $stock->fechaVencimiento;
        $this->observaciones = $stock->observaciones;
        $this->etiqueta_id = $stock->etiqueta_id;
        $this->producto_id = $stock->producto_id;
        $this->sucursal_id = $stock->sucursal_id;
        $this->accion = 'edit';
    }

    public function guardar()
    {
        $this->validate();

        try {
            Stock::updateOrCreate(['id' => $this->stock_id], [
                'fechaElaboracion' => $this->fechaElaboracion,
                'fechaVencimiento' => $this->fechaVencimiento,
                'observaciones' => $this->observaciones,
                'etiqueta_id' => $this->etiqueta_id ?: null,
                'producto_id' => $this->producto_id ?: null,
                'sucursal_id' => $this->sucursal_id ?: null,
            ]);

            LivewireAlert::title($this->stock_id ? 'Stock actualizado con éxito.' : 'Stock creado con éxito.')
                ->success()
                ->show();

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title('Ocurrió un error: ' . $e->getMessage())
                ->error()
                ->show();
        }
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->reset(['fechaElaboracion', 'fechaVencimiento', 'observaciones', 'etiqueta_id', 'producto_id', 'sucursal_id', 'stock_id']);
        $this->resetErrorBag();
    }

    public function modaldetalle($id)
    {
        $this->stockSeleccionado = Stock::with(['etiqueta', 'producto', 'sucursal'])->findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->stockSeleccionado = null;
    }
}
