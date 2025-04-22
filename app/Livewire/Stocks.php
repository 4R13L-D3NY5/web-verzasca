<?php

namespace App\Livewire;

use App\Models\Stock;
use App\Models\Existencia;
use App\Models\Producto;
use App\Models\Etiqueta;
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
    public $etiqueta_id = null;
    public $producto_id = null;
    public $sucursal_id = null;
    public $cantidad = null;
    public $accion = 'create';
    public $stockSeleccionado = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'fechaElaboracion' => 'required|date_format:Y-m-d',
        'fechaVencimiento' => 'required|date_format:Y-m-d',
        'observaciones' => 'nullable|string',
        'etiqueta_id' => 'nullable|exists:etiquetas,id',
        'producto_id' => 'required|exists:productos,id',
        'sucursal_id' => 'required|exists:sucursals,id',
        'cantidad' => 'required|integer|min:1',
    ];


    public function render()
    {
        $stocks = Stock::with(['producto', 'etiqueta', 'existencias', 'sucursal'])
            ->when($this->search, function ($query) {
                $query->whereHas('producto', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(4);

        $productos = Producto::all();
        $etiquetas = Etiqueta::all();
        $sucursales = Sucursal::all();

        return view('livewire.stocks', compact('stocks', 'productos', 'etiquetas', 'sucursales'));
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
        $stock = Stock::with('existencias')->findOrFail($id);
        $this->stock_id = $stock->id;
        $this->fechaElaboracion = $stock->fechaElaboracion;
        $this->fechaVencimiento = $stock->fechaVencimiento;
        $this->observaciones = $stock->observaciones;
        $this->etiqueta_id = $stock->etiqueta_id;
        $this->producto_id = $stock->producto_id;
        $this->sucursal_id = $stock->sucursal_id;  // Verifica si este campo está correcto

        $existencia = $stock->existencias->first();
        $this->cantidad = $existencia ? $existencia->cantidad : 0;
    }

    public function guardar()
    {
        $this->validate();

        try {
            // Guardar o actualizar el Stock
            $stock = Stock::updateOrCreate(['id' => $this->stock_id], [
                'fechaElaboracion'   => $this->fechaElaboracion ?: null,
                'fechaVencimiento'   => $this->fechaVencimiento ?: null,
                'observaciones'      => $this->observaciones,
                'etiqueta_id'        => $this->etiqueta_id,
                'producto_id'        => $this->producto_id,
                'sucursal_id'        => $this->sucursal_id,
            ]);

            // Verificar si ya existe una existencia asociada
            $existencia = $stock->existencias()
                ->where('sucursal_id', $this->sucursal_id)
                ->first();

            if ($existencia) {
                // Actualizar cantidad
                $existencia->update([
                    'cantidad' => $this->cantidad,
                ]);
            } else {
                // Crear nueva existencia
                $stock->existencias()->create([
                    'cantidad'    => $this->cantidad,
                    'sucursal_id' => $this->sucursal_id,  // Asegúrate de que esto no sea null
                ]);
            }

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
        $this->stockSeleccionado = Stock::with(['producto', 'etiqueta', 'sucursal', 'distribucion', 'existencias'])->findOrFail($id);
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
            'sucursal_id',
            'cantidad',
            'stock_id',
        ]);
    }
}
