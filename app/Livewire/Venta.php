<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venta as ModeloVenta;
use App\Models\Cliente;
use App\Models\Existencia;
use App\Models\Itemventa;
use App\Models\Pagoventa;
use App\Models\Personal;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Venta extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $detalleModal = false;
    public $accion = 'create';
    public $ventaId = null;
    public $fechaPedido = '';
    public $fechaEntrega = '';
    public $fechaMaxima = '';
    public $estadoPedido = 1;
    public $estadoPago = 1;
    public $cliente_id = '';
    public $personal_id = '';
    public $personalEntrega_id = '';
    public $ventaSeleccionada = null;


    // Listas para selects
    public $stock_id;
    public $clientes;
    public $personales;
    public $clienteSearch = '';
    public $clientesFiltrados = [];
    protected $paginationTheme = 'tailwind';


    // Listas para pagoventa
    public $tipo;
    public $monto;
    public $codigo;
    public $fechaPago;
    public $observaciones;
    public $mostrarModalPagos = false;

    // Lista para entregar
    // Propiedades para el modal de entrega
    public $ventaSeleccionadaEntrega;
    public $mostrarModalEntrega = false;

    // Método para abrir el modal de entrega
    public function entregarVenta($ventaId)
    {
        $this->ventaSeleccionadaEntrega = ModeloVenta::with('itemventas')->findOrFail($ventaId); // Cargar itemventas
        $this->mostrarModalEntrega = true;
    }

    // Método para cerrar el modal
    public function cerrarModalEntrega()
    {
        $this->mostrarModalEntrega = false;
        $this->reset(['ventaSeleccionadaEntrega']);
    }

    // Método para abrir el modal de pagos
    // public function abrirModalPagos($ventaId)
    // {
    //     $this->ventaSeleccionada = ModeloVenta::with(['pagos', 'itemVentas'])->findOrFail($ventaId); // Asumiendo relación 'pagos'
    //     $this->reset(['tipo', 'monto', 'codigo', 'observaciones']); // Limpiar formulario
    //     $this->mostrarModalPagos = true;
    // }
    public function abrirModalPagos($ventaId)
    {
        $this->ventaSeleccionada = ModeloVenta::with(['pagos', 'itemVentas'])->findOrFail($ventaId);

        // Calcular Total a Pagar y Total Pagado
        $totalAPagar = $this->ventaSeleccionada->itemVentas->sum(function ($item) {
            return $item->cantidad * $item->precio;
        });
        $totalPagado = $this->ventaSeleccionada->pagos->sum('monto');

        // Asignar la diferencia a $monto (saldo pendiente)
        $this->monto = $totalAPagar - $totalPagado > 0 ? round($totalAPagar - $totalPagado, 1) : 0;

        // Limpiar otros campos del formulario
        $this->reset(['tipo', 'codigo', 'observaciones']);

        $this->mostrarModalPagos = true;
    }

    // Método para registrar un pago
    public function registrarPago()
    {
        $this->validate([
            'tipo' => 'required|string|max:50',
            'monto' => 'required|numeric|min:0.01',
            'codigo' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:255',
        ]);

        Pagoventa::create([
            'venta_id' => $this->ventaSeleccionada->id,
            'tipo' => $this->tipo,
            'monto' => $this->monto,
            'codigo' => $this->codigo,
            'observaciones' => $this->observaciones,
        ]);

        // Verificar si la suma de pagos cubre el total de la venta
        $totalPagos = $this->ventaSeleccionada->pagos->sum('monto');
        $totalVenta = $this->ventaSeleccionada->itemVentas->sum(fn($item) => $item->cantidad * $item->precio);

        if ($totalPagos >= $totalVenta) {
            $this->ventaSeleccionada->update(['estadoPago' => 1]); // Marcar como completo
        }

        $this->ventaSeleccionada->refresh(); // Recargar datos de la venta
        $this->reset(['tipo', 'monto', 'codigo', 'observaciones']); // Limpiar formulario
        session()->flash('message', 'Pago registrado con éxito.');
    }

    // Cerrar modal
    public function cerrarModalPagos()
    {
        $this->mostrarModalPagos = false;
        $this->reset(['ventaSeleccionada', 'tipo', 'monto', 'codigo', 'observaciones']);
    }

    // Nuevas propiedades para ítems de venta
    public $existencias; // Lista de existencias disponibles
    public $itemsVenta = []; // Arreglo para almacenar ítems seleccionados
    public $existencia_id; // ID de la existencia seleccionada
    public $cantidad = 1; // Cantidad del ítem a añadir
    public $precio = 1; // Cantidad del ítem a añadir
    public $precioTotal = 0; // Total calculado

    public $estadoFiltro = null; // Filtro para estadoPedido
    public $filtroCreditos = false; // Filtro para créditos pendientes (estadoPago = 0)

    public function filtrarPorEstado($estado)
    {
        $this->estadoFiltro = $estado;
        $this->filtroCreditos = false; // Desactiva el filtro de créditos cuando se usa estadoPedido
    }

    public function filtrarPorCreditosPendientes()
    {
        $this->estadoFiltro = null; // Desactiva el filtro de estadoPedido
        $this->filtroCreditos = true; // Activa el filtro de créditos pendientes
    }

    public function updatedClienteSearch($value)
    {
        if (!empty($value)) {
            $this->clientesFiltrados = Cliente::where('nombre', 'like', '%' . $value . '%')
                ->get(['id', 'nombre']);
        } else {
            $this->clientesFiltrados = $this->clientes;
        }
    }

    public function seleccionarCliente($id)
    {
        $this->cliente_id = $id;
        $this->clienteSearch = ''; // Limpia el campo de búsqueda
        $this->clientesFiltrados = $this->clientes; // Restaura la lista completa
    }

    protected $rules = [
        'fechaPedido' => 'nullable|date',
        'fechaEntrega' => 'nullable|date|after_or_equal:fechaPedido',
        'fechaMaxima' => 'nullable|date|after_or_equal:fechaEntrega',
        'estadoPedido' => 'required|in:0,1,2',
        'estadoPago' => 'required|in:0,1',
        'cliente_id' => 'required|exists:clientes,id',
        'personal_id' => 'required|exists:personals,id',
        'personalEntrega_id' => 'nullable|exists:personals,id',
    ];

    public function mount()
    {
        // Cargar listas para selects
        $this->clientes = Cliente::all(['id', 'nombre']);
        $this->personales = Personal::all(['id', 'nombres']);
        $this->existencias = Existencia::where('existenciable_type', 'App\Models\Stock')
            ->get();
    }

    // public function render()
    // {
    //     $ventas = ModeloVenta::with(['cliente', 'personal', 'personalEntrega'])
    //         ->when($this->search, function ($query) {
    //             $query->where('fechaPedido', 'like', '%' . $this->search . '%')
    //                   ->orWhereHas('cliente', function ($q) {
    //                       $q->where('nombre', 'like', '%' . $this->search . '%');
    //                   });
    //         })->paginate(5);

    //     return view('livewire.venta', compact('ventas'));
    // }

    public function render()
    {
        $ventas = ModeloVenta::query()
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%');
                    });
            })
            ->when(!is_null($this->estadoFiltro), function ($query) {
                $query->where('estadoPedido', $this->estadoFiltro);
            })
            ->when($this->filtroCreditos, function ($query) {
                $query->where('estadoPago', 0); // Filtra por estadoPago = 0 (créditos pendientes)
            })
            ->with(['cliente', 'personal', 'personalEntrega'])
            ->paginate(5);

        return view('livewire.venta', [
            'ventas' => $ventas,
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal($accion)
    {
        $this->reset(['fechaPedido', 'fechaEntrega', 'fechaMaxima', 'estadoPedido', 'estadoPago', 'cliente_id', 'personal_id', 'personalEntrega_id', 'ventaId']);
        $this->accion = $accion;
        $this->estadoPedido = 1;
        $this->estadoPago = 1;
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function editarVenta($id)
    {
        $venta = ModeloVenta::findOrFail($id);
        $this->ventaId = $venta->id;
        $this->fechaPedido = $venta->fechaPedido;
        $this->fechaEntrega = $venta->fechaEntrega;
        $this->fechaMaxima = $venta->fechaMaxima;
        $this->estadoPedido = $venta->estadoPedido;
        $this->estadoPago = $venta->estadoPago;
        $this->cliente_id = $venta->cliente_id;
        $this->personal_id = $venta->personal_id;
        $this->personalEntrega_id = $venta->personalEntrega_id;
        $this->accion = 'edit';
        $this->modal = true;
        $this->detalleModal = false;
    }

    public function verDetalle($id)
    {
        $this->ventaSeleccionada = ModeloVenta::with(['cliente', 'personal', 'personalEntrega', 'itemventas'])->findOrFail($id);
        $this->modal = false;
        $this->detalleModal = true;
    }

    // public function guardarVenta()
    // {
    //     $this->validate();

    //     try {
    //         if ($this->accion === 'edit' && $this->ventaId) {
    //             $venta = ModeloVenta::findOrFail($this->ventaId);
    //             $venta->update([
    //                 'fechaPedido' => $this->fechaPedido,
    //                 'fechaEntrega' => $this->fechaEntrega,
    //                 'fechaMaxima' => $this->fechaMaxima,
    //                 'estadoPedido' => $this->estadoPedido,
    //                 'estadoPago' => $this->estadoPago,
    //                 'cliente_id' => $this->cliente_id,
    //                 'personal_id' => $this->personal_id,
    //                 'personalEntrega_id' => $this->personalEntrega_id,
    //             ]);
    //             LivewireAlert::title('Venta actualizada con éxito.')
    //                 ->success()
    //                 ->show();
    //         } else {
    //             ModeloVenta::create([
    //                 'fechaPedido' => $this->fechaPedido,
    //                 'fechaEntrega' => $this->fechaEntrega,
    //                 'fechaMaxima' => $this->fechaMaxima,
    //                 'estadoPedido' => $this->estadoPedido,
    //                 'estadoPago' => $this->estadoPago,
    //                 'cliente_id' => $this->cliente_id,
    //                 'personal_id' => $this->personal_id,
    //                 'personalEntrega_id' => $this->personalEntrega_id,
    //             ]);
    //             LivewireAlert::title('Venta registrada con éxito.')
    //                 ->success()
    //                 ->show();
    //         }

    //         $this->cerrarModal();
    //     } catch (\Exception $e) {
    //         LivewireAlert::title('Ocurrió un error: ' . $e->getMessage())
    //             ->error()
    //             ->show();
    //     }
    // }

    public function obtenerPrecio()
    {
        // if ($this->existencia_id) {
        $existencia = Existencia::with('existenciable.producto')->find($this->existencia_id);
        if ($existencia && $existencia->existenciable && $existencia->existenciable->producto) {
            $this->precio = $existencia->existenciable->producto->precioReferencia;
        } else {
            $this->precio = 100; // Valor por defecto si no se encuentra el producto
        }
        // } else {
        //     $this->precio = 50; // Resetear si no hay selección
        // }
    }

    public function guardarVenta()
    {
        // $this->validate();

        if ($this->accion === 'Registrar venta') {
            $fechaActual = Carbon::now()->addDays(30)->format('Y-m-d');
            $venta = ModeloVenta::create([
                'fechaEntrega' => $fechaActual,
                'cliente_id' => $this->cliente_id,
                'personal_id' => 1,
                'estadoPago' => $this->estadoPago,
                'fechaMaxima' => $this->estadoPago == 0 ? $this->fechaMaxima : null,
                'monto' => $this->estadoPago == 0 ? $this->monto : null,
                'codigo' => $this->estadoPago == 0 ? $this->codigo : null,
                'estadoPedido' => $this->estadoPedido,
            ]);

            foreach ($this->itemsVenta as $item) {
                ItemVenta::create([
                    'venta_id' => $venta->id,
                    'existencia_id' => $item['existencia_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                ]);
                // Restar la cantidad a la existencia
                $existencia = Existencia::find($item['existencia_id']);
                if ($existencia) {
                    $existencia->decrement('cantidad', $item['cantidad']);
                }
            }
            // Calcular el total de los ítems
            $totalVenta = array_sum(array_column($this->itemsVenta, 'subtotal'));

            // Registrar el Pagoventa
            if ($this->estadoPago == 1) {
                // Contado: monto igual al total de la venta
                Pagoventa::create([
                    'venta_id' => $venta->id,
                    'tipo' => $this->tipo,
                    'monto' => $totalVenta,
                    'fechaPago' => $fechaActual,
                ]);
            } else {
                // Crédito: monto igual a monto
                Pagoventa::create([
                    'venta_id' => $venta->id,
                    'tipo' => $this->tipo,
                    'monto' => $this->monto,
                    'codigo' => $this->codigo,
                    'fechaPago' => $fechaActual,
                ]);
            }



            LivewireAlert::title('Venta registrada con éxito.')
                ->success()
                ->show();
        } else {
            $venta = ModeloVenta::findOrFail($this->venta_id);
            $venta->update([
                'cliente_id' => $this->cliente_id,
                'estadoPago' => $this->estadoPago,
                'fechaMaxima' => $this->estadoPago == 0 ? $this->fechaMaxima : null,
                'monto' => $this->estadoPago == 0 ? $this->monto : null,
                'codigo' => $this->estadoPago == 0 ? $this->codigo : null,
                'estadoPedido' => $this->estadoPedido,
            ]);

            // Eliminar ítems existentes y recrearlos
            $venta->itemVentas()->delete();
            foreach ($this->itemsVenta as $item) {
                ItemVenta::create([
                    'venta_id' => $venta->id,
                    'existencia_id' => $item['existencia_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                ]);
            }

            session()->flash('message', 'Venta actualizada con éxito.');
        }

        $this->cerrarModal();
    }

    // Añadir ítem de venta
    public function agregarItem()
    {
        $this->validate([
            'existencia_id' => 'required|exists:existencias,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $existencia = $this->existencias->find($this->existencia_id);
        $this->itemsVenta[] = [
            'existencia_id' => $this->existencia_id,
            'nombre' => $existencia->existenciable->producto->nombre,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'subtotal' => $this->cantidad * $this->precio,
        ];

        // Calcular precio total
        $this->calcularPrecioTotal();

        // Resetear campos
        $this->existencia_id = '';
        $this->cantidad = 1;
    }

    // Eliminar ítem de venta
    public function eliminarItem($index)
    {
        unset($this->itemsVenta[$index]);
        $this->itemsVenta = array_values($this->itemsVenta); // Reindexar arreglo
        $this->calcularPrecioTotal();
    }

    // Calcular precio total
    public function calcularPrecioTotal()
    {
        $this->precioTotal = array_sum(array_column($this->itemsVenta, 'subtotal'));
    }

    // // Actualizar guardarVenta para incluir itemsVenta
    // public function guardarVenta()
    // {
    //     $this->validate([
    //         'cliente_id' => 'required|exists:clientes,id',
    //         'estadoPago' => 'required|in:0,1',
    //         'estadoPedido' => 'required|in:0,1,2,3', // Ajustado para tipo de pago
    //         'fechaMaxima' => 'nullable|date|after_or_equal:fechaEntrega',
    //         'monto' => 'nullable|numeric|min:0',
    //         'codigo' => 'nullable|string|max:50',
    //         'itemsVenta' => 'required|array|min:1', // Al menos un ítem
    //         'itemsVenta.*.existencia_id' => 'required|exists:existencias,id',
    //         'itemsVenta.*.cantidad' => 'required|integer|min:1',
    //         'itemsVenta.*.precio' => 'required|numeric|min:0',
    //     ]);

    //     try {
    //         $venta = ModeloVenta::create([
    //             'cliente_id' => $this->cliente_id,
    //             'estadoPago' => $this->estadoPago,
    //             'estadoPedido' => $this->estadoPedido,
    //             'fechaMaxima' => $this->fechaMaxima,
    //         ]);

    //         foreach ($this->itemsVenta as $item) {
    //             Itemventa::create([
    //                 'venta_id' => $venta->id,
    //                 'existencia_id' => $item['existencia_id'],
    //                 'cantidad' => $item['cantidad'],
    //                 'precio' => $item['precio'],
    //                 'estado' => 1, // Por defecto "pedido"
    //             ]);
    //         }

    //         LivewireAlert::title('Venta registrada con éxito.')->success()->show();
    //         $this->cerrarModal();
    //     } catch (\Exception $e) {
    //         LivewireAlert::title('Error al guardar: ' . $e->getMessage())->error()->show();
    //     }
    // }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->detalleModal = false;
        $this->reset(['fechaPedido', 'fechaEntrega', 'fechaMaxima', 'estadoPedido', 'estadoPago', 'cliente_id', 'personal_id', 'personalEntrega_id', 'ventaId', 'ventaSeleccionada']);
        $this->resetErrorBag();
    }
}
