<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venta;
use App\Models\ItemVenta;
use App\Models\Existencia;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Pedidos extends Component
{
    use WithPagination;

    public $search = '';
    public $filtroSucursal = '';
    public $filtroUrgencia = '';
    public $mostrarSinStock = false;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $resumenStock = $this->obtenerResumenStock();
        $sucursales = \App\Models\Sucursal::all();
        
        return view('livewire.pedidos', compact('resumenStock', 'sucursales'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function obtenerResumenStock()
    {
        // Obtener solo items de pedidos que son STOCK (productos terminados)
        $itemsStock = ItemVenta::with([
            'venta.cliente',
            'existencia.existenciable.producto',
            'existencia.existenciable.etiqueta.cliente',
            'existencia.sucursal'
        ])
        ->whereHas('venta', function($query) {
            $query->where('estadoPedido', 1); // Solo pedidos
        })
        ->whereHas('existencia', function($query) {
            $query->where('existenciable_type', 'App\\Models\\Stock'); // Solo existencias de Stock
        })
        ->where('estado', 1) // Solo items activos
        ->when($this->search, function($query) {
            $query->whereHas('venta.cliente', function($clienteQuery) {
                $clienteQuery->where('nombre', 'like', '%' . $this->search . '%')
                          ->orWhere('empresa', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('existencia.existenciable.producto', function($productoQuery) {
                $productoQuery->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('existencia.existenciable.etiqueta', function($etiquetaQuery) {
                $etiquetaQuery->where('descripcion', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->filtroSucursal, function($query) {
            $query->whereHas('existencia', function($existenciaQuery) {
                $existenciaQuery->where('sucursal_id', $this->filtroSucursal);
            });
        })
        ->get();

        // Agrupar por existencia de stock para consolidar pedidos del mismo stock
        $resumenConsolidado = $itemsStock->groupBy('existencia_id')->map(function($items, $existenciaId) {
            $primerItem = $items->first();
            $existencia = $primerItem->existencia;
            $stock = $existencia->existenciable; // El stock
            
            if (!$existencia || !$stock) {
                return null;
            }

            $totalPedido = $items->sum('cantidad');
            $stockDisponible = $existencia->cantidad;
            $diferencia = $stockDisponible - $totalPedido;
            
            // Obtener stock del mismo producto en otras sucursales
            $stockOtrasSucursales = Existencia::where('existenciable_type', 'App\\Models\\Stock')
                ->whereHas('existenciable', function($query) use ($stock) {
                    $query->where('producto_id', $stock->producto_id)
                          ->where('etiqueta_id', $stock->etiqueta_id);
                })
                ->where('id', '!=', $existenciaId)
                ->with(['sucursal', 'existenciable'])
                ->get()
                ->map(function($otherStock) {
                    return [
                        'sucursal' => $otherStock->sucursal->nombre ?? 'Sin sucursal',
                        'cantidad' => $otherStock->cantidad,
                        'fecha_elaboracion' => $otherStock->existenciable->fechaElaboracion ?? null,
                        'fecha_vencimiento' => $otherStock->existenciable->fechaVencimiento ?? null,
                    ];
                });

            $urgencia = $this->calcularUrgenciaPedidos($items);

            return [
                'existencia_id' => $existenciaId,
                'stock_id' => $stock->id,
                
                // Información del producto
                'producto_nombre' => $stock->producto->nombre ?? 'Sin nombre',
                'producto_tipo_contenido' => $this->getTipoContenidoTexto($stock->producto->tipoContenido ?? 0),
                'producto_capacidad' => $stock->producto->capacidad ?? 0,
                'producto_unidad' => $stock->producto->unidad ?? 'ml',
                
                // Información de la etiqueta
                'etiqueta_descripcion' => $stock->etiqueta->descripcion ?? 'Sin descripción',
                'etiqueta_capacidad' => $stock->etiqueta->capacidad ?? '',
                'etiqueta_unidad' => $stock->etiqueta->unidad ?? '',
                'etiqueta_cliente' => $stock->etiqueta->cliente->nombre ?? 'Sin cliente',
                
                // Información del stock
                'fecha_elaboracion' => $stock->fechaElaboracion,
                'fecha_vencimiento' => $stock->fechaVencimiento,
                'observaciones_stock' => $stock->observaciones,
                
                'sucursal_principal' => $existencia->sucursal->nombre ?? 'Sin sucursal',
                'total_pedido' => $totalPedido,
                'stock_disponible' => $stockDisponible,
                'diferencia' => $diferencia,
                'necesita_produccion' => $diferencia < 0,
                'cantidad_producir' => $diferencia < 0 ? abs($diferencia) : 0,
                'stock_otras_sucursales' => $stockOtrasSucursales,
                'stock_total_sistema' => $stockDisponible + $stockOtrasSucursales->sum('cantidad'),
                'urgencia' => $urgencia,
                'pedidos_asociados' => $items->groupBy('venta.id')->map(function($ventaItems, $ventaId) {
                    $venta = $ventaItems->first()->venta;
                    return [
                        'venta_id' => $ventaId,
                        'cliente' => $venta->cliente->nombre,
                        'fecha_pedido' => $venta->fechaPedido,
                        'fecha_maxima' => $venta->fechaMaxima,
                        'cantidad' => $ventaItems->sum('cantidad')
                    ];
                })->values()
            ];
        })->filter()->values();

        // Aplicar filtros adicionales
        if ($this->filtroUrgencia) {
            $resumenConsolidado = $resumenConsolidado->filter(function($item) {
                return $item['urgencia'] === $this->filtroUrgencia;
            });
        }

        if ($this->mostrarSinStock) {
            $resumenConsolidado = $resumenConsolidado->filter(function($item) {
                return $item['necesita_produccion'];
            });
        }

        // Ordenar por urgencia y luego por cantidad a producir
        return $resumenConsolidado->sortBy([
            ['urgencia', 'asc'],
            ['cantidad_producir', 'desc']
        ])->values();
    }

    private function getTipoContenidoTexto($tipoContenido)
    {
        return match($tipoContenido) {
            1 => 'Agua Natural',
            2 => 'Agua Saborizada',
            3 => 'Gaseosa',
            4 => 'Jugo',
            default => 'No definido'
        };
    }

    private function calcularUrgenciaPedidos($items)
    {
        $urgenciaMinima = 'normal';
        
        foreach ($items as $item) {
            $venta = $item->venta;
            if (!$venta->fechaMaxima) continue;
            
            $hoy = Carbon::today();
            $fechaMaxima = Carbon::parse($venta->fechaMaxima);
            
            if ($fechaMaxima->lt($hoy)) {
                return 'vencido'; // Más urgente
            } elseif ($fechaMaxima->eq($hoy) && $urgenciaMinima !== 'vencido') {
                $urgenciaMinima = 'urgente';
            } elseif ($fechaMaxima->lte($hoy->copy()->addDays(3)) && !in_array($urgenciaMinima, ['vencido', 'urgente'])) {
                $urgenciaMinima = 'proximo';
            }
        }
        
        return $urgenciaMinima;
    }

    public function getUrgenciaColor($urgencia)
    {
        return match($urgencia) {
            'vencido' => 'border-l-red-500 bg-red-50',
            'urgente' => 'border-l-orange-500 bg-orange-50',
            'proximo' => 'border-l-yellow-500 bg-yellow-50',
            default => 'border-l-gray-300'
        };
    }

    public function getUrgenciaTexto($urgencia)
    {
        return match($urgencia) {
            'vencido' => '🔴 VENCIDO',
            'urgente' => '🟠 URGENTE',
            'proximo' => '🟡 PRÓXIMO',
            default => '⚪ NORMAL'
        };
    }
}