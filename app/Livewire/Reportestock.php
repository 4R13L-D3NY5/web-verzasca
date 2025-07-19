<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Preforma;
use App\Models\Base;
use App\Models\Tapa;
use App\Models\Producto;
use App\Models\Etiqueta;
use App\Models\Stock;
use App\Models\Existencia;
use Carbon\Carbon;

class Reportestock extends Component
{
    use WithPagination;

    public $search = '';
    public $fechaInicio = '';
    public $fechaFinal = '';
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fechaFinal = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        // Filtrar movimientos basados en existencias (usando created_at/updated_at como proxy)
        $existenciasPreformas = Existencia::where('existenciable_type', Preforma::class)
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFinal])
            ->with('existenciable')
            ->get();

        $existenciasBases = Existencia::where('existenciable_type', Base::class)
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFinal])
            ->with('existenciable')
            ->get();

        $existenciasTapas = Existencia::where('existenciable_type', Tapa::class)
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFinal])
            ->with('existenciable')
            ->get();

        $existenciasProductos = Existencia::where('existenciable_type', Producto::class)
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFinal])
            ->with('existenciable')
            ->get();

        $existenciasEtiquetas = Existencia::where('existenciable_type', Etiqueta::class)
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFinal])
            ->with('existenciable')
            ->get();

        $existenciasStocks = Existencia::where('existenciable_type', Stock::class)
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFinal])
            ->with('existenciable')
            ->get();

        // Cantidades iniciales y finales (basadas en existencias)
        $initialPreformas = Existencia::where('existenciable_type', Preforma::class)
            ->where('created_at', '<', $this->fechaInicio)
            ->sum('cantidad');
        $finalPreformas = Existencia::where('existenciable_type', Preforma::class)
            ->where('updated_at', '<=', $this->fechaFinal)
            ->sum('cantidad');
        $initialBases = Existencia::where('existenciable_type', Base::class)
            ->where('created_at', '<', $this->fechaInicio)
            ->sum('cantidad');
        $finalBases = Existencia::where('existenciable_type', Base::class)
            ->where('updated_at', '<=', $this->fechaFinal)
            ->sum('cantidad');
        $initialTapas = Existencia::where('existenciable_type', Tapa::class)
            ->where('created_at', '<', $this->fechaInicio)
            ->sum('cantidad');
        $finalTapas = Existencia::where('existenciable_type', Tapa::class)
            ->where('updated_at', '<=', $this->fechaFinal)
            ->sum('cantidad');
        $initialProductos = Existencia::where('existenciable_type', Producto::class)
            ->where('created_at', '<', $this->fechaInicio)
            ->sum('cantidad');
        $finalProductos = Existencia::where('existenciable_type', Producto::class)
            ->where('updated_at', '<=', $this->fechaFinal)
            ->sum('cantidad');
        $initialEtiquetas = Existencia::where('existenciable_type', Etiqueta::class)
            ->where('created_at', '<', $this->fechaInicio)
            ->sum('cantidad');
        $finalEtiquetas = Existencia::where('existenciable_type', Etiqueta::class)
            ->where('updated_at', '<=', $this->fechaFinal)
            ->sum('cantidad');
        $initialStocks = Existencia::where('existenciable_type', Stock::class)
            ->where('created_at', '<', $this->fechaInicio)
            ->sum('cantidad');
        $finalStocks = Existencia::where('existenciable_type', Stock::class)
            ->where('updated_at', '<=', $this->fechaFinal)
            ->sum('cantidad');

        return view('livewire.reportestock', [
            'existenciasPreformas' => $existenciasPreformas,
            'existenciasBases' => $existenciasBases,
            'existenciasTapas' => $existenciasTapas,
            'existenciasProductos' => $existenciasProductos,
            'existenciasEtiquetas' => $existenciasEtiquetas,
            'existenciasStocks' => $existenciasStocks,
            'initialPreformas' => $initialPreformas,
            'finalPreformas' => $finalPreformas,
            'initialBases' => $initialBases,
            'finalBases' => $finalBases,
            'initialTapas' => $initialTapas,
            'finalTapas' => $finalTapas,
            'initialProductos' => $initialProductos,
            'finalProductos' => $finalProductos,
            'initialEtiquetas' => $initialEtiquetas,
            'finalEtiquetas' => $finalEtiquetas,
            'initialStocks' => $initialStocks,
            'finalStocks' => $finalStocks,
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}