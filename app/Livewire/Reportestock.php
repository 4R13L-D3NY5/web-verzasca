<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Elaboracion;
use App\Models\Embotellado;
use App\Models\Etiquetado;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Reportestock extends Component
{
    use WithPagination;

    public $search = '';
    public $fechaInicio = '';
    public $fechaFinal = '';
    public $sucursalId = 1;
    public $mostrarReporte = false;
    public $sucursales = '';
    public $elaboraciones;
    public $embotellados;
    public $etiquetados;
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->fechaInicio = '2000-01-01';
        $this->fechaFinal = '2025-12-31';
    }

    public function generarReporte()
    {
        $this->mostrarReporte = true;


        // Obtener elaboraciones (soplado) con relaciones
        $this->elaboraciones = Elaboracion::with([
            'existenciaEntrada.existenciable',
            'existenciaSalida.existenciable'
        ])
            ->where('sucursal_id', $this->sucursalId)
            ->whereBetween('fecha_elaboracion', [$this->fechaInicio, $this->fechaFinal])
            ->get();

        // Obtener embotellados con relaciones
        $this->embotellados = Embotellado::with([
            'existenciaBase.existenciable',
            'existenciaTapa.existenciable',
            'existenciaProducto.existenciable'
        ])
            ->where('sucursal_id', $this->sucursalId)
            ->whereBetween('fecha_embotellado', [$this->fechaInicio, $this->fechaFinal])
            ->get();

        // Obtener etiquetados con relaciones
        $this->etiquetados = Etiquetado::with([
            'existenciaProducto.existenciable',
            'existenciaEtiqueta.existenciable',
            'existenciaStock.existenciable'
        ])
            ->where('sucursal_id', $this->sucursalId)
            ->whereBetween('fecha_etiquetado', [$this->fechaInicio, $this->fechaFinal])
            ->get();

        // $this->resetPage();
    }

    public function render()
    {
        $this->sucursales = Sucursal::all();

        return view('livewire.reportestock');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}