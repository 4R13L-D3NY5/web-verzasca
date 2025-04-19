<?php

namespace App\Livewire;

use App\Models\Stock;
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
    public $etiqueta_id = null;
    public $producto_id = null;
    public $accion = 'create';
    public $stockSeleccionado = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'fechaElaboracion' => 'nullable|date_format:Y-m-d',
        'fechaVencimiento' => 'nullable|date_format:Y-m-d',
        'observaciones' => 'nullable|string',
        'etiqueta_id' => 'nullable|exists:etiquetas,id',
        'producto_id' => 'required|exists:productos,id',
    ];

    public function render()
    {
        $stocks = Stock::with(['producto', 'etiqueta', 'existencias']) // Pre-carga relaciones, incluyendo 'existencias'
            ->when($this->search, function ($query) {
                $query->whereHas('producto', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(4);
    
        $productos = \App\Models\Producto::all();
        $etiquetas = \App\Models\Etiqueta::all();
    
        return view('livewire.stocks', compact('stocks', 'productos', 'etiquetas'));
    }
    public function setFechaActualElaboracion()
    {
        $this->fechaElaboracion = now()->format('Y-m-d');
    }
    
    public function setFechaActualVencimiento()
    {
        $this->fechaVencimiento = now()->format('Y-m-d');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion = 'create', $id = null)
    {
        $this->resetInputFields();
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
                'etiqueta_id' => $this->etiqueta_id,
                'producto_id' => $this->producto_id,
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
        $this->resetInputFields();
        $this->resetErrorBag();
    }

    public function modaldetalle($id)
    {
        $this->stockSeleccionado = Stock::with(['producto', 'etiqueta', 'sucursal', 'distribucion'])->findOrFail($id);
        $this->modalDetalle = true;
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalle = false;
        $this->stockSeleccionado = null;
    }

    private function resetInputFields()
    {
        $this->reset([
            'fechaElaboracion',
            'fechaVencimiento',
            'observaciones',
            'etiqueta_id',
            'producto_id',
            'stock_id',
        ]);
    }
}
