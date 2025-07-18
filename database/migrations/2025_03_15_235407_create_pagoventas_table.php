<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venta;
use App\Models\Cliente;

class ReporteVentasPendientes extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Fetch clients with pending sales (estadoPago = 0)
        $clientes = Cliente::whereHas('ventas', function ($query) {
            $query->where('estadoPago', 0)
                  ->when($this->search, function ($subQuery) {
                      $subQuery->whereHas('cliente', function ($q) {
                          $q->where('nombres', 'like', '%' . $this->search . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                      });
                  });
        })
        ->with(['ventas' => function ($query) {
            $query->where('estadoPago', 0)
                  ->with(['sucursal', 'personal', 'personalEntrega', 'pagos'])
                  ->orderBy('fechaMaxima', 'asc'); // Sort sales by fechaMaxima
        }])
        ->get()
        ->map(function ($cliente) {
            // Calculate total pending amount for each client
            $cliente->totalPendiente = $cliente->ventas->sum(function ($venta) {
                return $venta->total - $venta->pagos->sum('monto');
            });
            return $cliente;
        });

        return view('livewire.reporte-ventas-pendientes', compact('clientes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}