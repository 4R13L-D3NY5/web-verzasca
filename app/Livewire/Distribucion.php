<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Distribucion as ModeloDistribucion;
use App\Models\Asignacion;
use App\Models\Venta;
use App\Models\Stock;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Distribucion extends Component
{
    use WithPagination;
    // use LivewireAlert;

    public $search = '';
    public $modal = false;
    public $detalleModal = false; // Aseguro que esté definida aquí
    public $accion = 'create';
    public $distribucionId = null;
    public $fecha;
    public $estado = 1;
    public $observaciones = '';
    public $asignacion_id;
    public $venta_id;
    public $stock_ids = [];
    public $asignaciones;
    public $ventasContado;
    public $stocksVenta;
    public $distribucionSeleccionada = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'fecha' => 'required|date',
        'estado' => 'required|in:1,2',
        'observaciones' => 'nullable|string|max:500',
        'asignacion_id' => 'required|exists:asignacions,id',
        'venta_id' => 'nullable|exists:ventas,id',
        'stock_ids' => 'nullable|array',
        'stock_ids.*' => 'exists:stocks,id',
    ];

    public function mount()
    {
        $this->asignaciones = Asignacion::all();
        $this->ventasContado = Venta::where('estadoPedido', 1)->with('cliente')->get();
    }

    public function render()
    {
        $distribucions = ModeloDistribucion::when($this->search, function ($query) {
            $query->where('fecha', 'like', '%' . $this->search . '%')
                  ->orWhere('observaciones', 'like', '%' . $this->search . '%');
        })->paginate(5);

        return view('livewire.distribucion', compact('distribucions'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion)
    {
        $this->reset(['fecha', 'estado', 'observaciones', 'asignacion_id', 'venta_id', 'stock_ids', 'distribucionId', 'stocksVenta']);
        $this->accion = $accion;
        $this->fecha = now()->format('Y-m-d');
        $this->estado = 1;
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function editarDistribucion($id)
    {
        $distribucion = ModeloDistribucion::findOrFail($id);
        $this->distribucionId = $distribucion->id;
        $this->fecha = $distribucion->fecha;
        $this->estado = $distribucion->estado;
        $this->observaciones = $distribucion->observaciones;
        $this->asignacion_id = $distribucion->asignacion_id;
        $this->venta_id = $distribucion->venta_id; // Suponiendo que haya una relación con venta
        $this->stock_ids = $distribucion->stocks ? $distribucion->stocks->pluck('id')->toArray() : [];
        $this->cargarStocksVenta();
        $this->accion = 'edit';
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function verDetalle($id)
    {
        $this->distribucionSeleccionada = ModeloDistribucion::with('stocks.producto')->findOrFail($id);
        $this->modal = false;
        $this->detalleModal = true;
    }

    public function cargarStocksVenta()
    {
        if ($this->venta_id) {
            $venta = Venta::with('itemVentas.existencia.existenciable')->find($this->venta_id);
            $this->stocksVenta = $venta ? Stock::whereIn('id', $venta->itemVentas->pluck('existencia.existenciable.id'))->get() : [];
        } else {
            $this->stocksVenta = null;
            $this->stock_ids = [];
        }
    }

    public function guardarDistribucion()
    {
        $this->validate();

        try {
            if ($this->accion === 'edit' && $this->distribucionId) {
                $distribucion = ModeloDistribucion::findOrFail($this->distribucionId);
                $distribucion->update([
                    'fecha' => $this->fecha,
                    'estado' => $this->estado,
                    'observaciones' => $this->observaciones,
                    'asignacion_id' => $this->asignacion_id,
                ]);
                if ($this->stock_ids) {
                    $distribucion->stocks()->sync($this->stock_ids);
                }
                LivewireAlert::title('Distribución actualizada con éxito.')
                    ->success()
                    ->show();
            } else {
                $distribucion = ModeloDistribucion::create([
                    'fecha' => $this->fecha,
                    'estado' => $this->estado,
                    'observaciones' => $this->observaciones,
                    'asignacion_id' => $this->asignacion_id,
                ]);
                if ($this->stock_ids) {
                    $distribucion->stocks()->attach($this->stock_ids);
                }
                LivewireAlert::title('Distribución registrada con éxito.')
                    ->success()
                    ->show();
            }

            $this->cerrarModal();
        } catch (\Exception $e) {
            LivewireAlert::title('Ocurrió un error: ' . $e->getMessage())
                ->error()
                ->show();
        }
    }

    public function retornarStock($id)
    {
        $distribucion = ModeloDistribucion::findOrFail($id);
        LivewireAlert::title('Funcionalidad de retorno de stock aún no implementada para Distribución #' . $distribucion->id)
            ->info()
            ->show();
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->detalleModal = false;
        $this->reset(['fecha', 'estado', 'observaciones', 'asignacion_id', 'venta_id', 'stock_ids', 'distribucionId', 'stocksVenta', 'distribucionSeleccionada']);
        $this->resetErrorBag();
    }
}