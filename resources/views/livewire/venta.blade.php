<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Ventas</h6>

            <!-- Botones de registro y búsqueda -->
            <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
                <button title="Registrar Venta" wire:click='abrirModal("Registrar venta")'
                    class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-building-store">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 21l18 0" />
                        <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                        <path d="M5 21l0 -10.15" />
                        <path d="M19 21l0 -10.15" />
                        <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                    </svg>
                </button>
                <button title="Registrar pedido" wire:click='abrirModal("Registrar pedido")'
                    class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                        <path d="M3 9l4 0" />
                    </svg>
                </button>

                <input type="text" wire:model.live="search" placeholder="Buscar venta..."
                    class="input-g w-auto sm:w-64" />
            </div>

            <!-- Filtros de estado -->
            <div class="mt-4 flex rounded-md shadow-sm justify-center">
                <button wire:click="filtrarPorEstado(null)"
                    class="flex-1 bg-gray-600 hover:bg-gray-300 text-white font-semibold py-1 px-3 rounded-l-md text-xs transition-colors focus:outline-none">
                    Todos
                </button>
                <button wire:click="filtrarPorEstado(1)"
                    class="flex-1 bg-yellow-600 hover:bg-yellow-300 text-white font-semibold py-1 px-3 text-xs transition-colors focus:outline-none">
                    Pedidos
                </button>
                <button wire:click="filtrarPorEstado(2)"
                    class="flex-1 bg-green-600 hover:bg-green-300 text-white font-semibold py-1 px-3 text-xs transition-colors focus:outline-none">
                    Vendidos
                </button>
                <button wire:click="filtrarPorEstado(0)"
                    class="flex-1 bg-red-600 hover:bg-red-300 text-white font-semibold py-1 px-3 text-xs transition-colors focus:outline-none">
                    Cancelados
                </button>
                <button wire:click="filtrarPorCreditosPendientes"
                    class="flex-1 bg-orange-600 hover:bg-orange-300 text-white font-semibold py-1 px-3 rounded-r-md text-xs transition-colors focus:outline-none">
                    Cré. Pen.
                </button>
            </div>

            <!-- Tabla de ventas -->
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table
                    class="w-full text-sm text-left border border-slate-200 dark:border-cyan-200 rounded-lg border-collapse">
                    <thead class="text-x uppercase color-bg">
                        <tr>
                            <th scope="col" class="px-6 py-3 p-text text-left">Información</th>
                            <th scope="col" class="px-6 py-3 p-text text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                        <tr class="color-bg border border-slate-200">
                            <td class="px-6 py-4 p-text text-left">
                                <div class="mb-2">
                                    <span class="font-semibold block">Estado:</span>
                                    @if ($venta->estadoPedido == 0)
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white">Cancelado</span>
                                    @elseif ($venta->estadoPedido == 1)
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-600 text-white">Pedido</span>
                                    @elseif ($venta->estadoPedido == 2)
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-600 text-white">Vendido</span>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold block">Fecha:</span>
                                    <span>{{ $venta->fechaPedido ?? 'Sin fecha' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold block">Cliente:</span>
                                    <span>{{ $venta->cliente->empresa ? $venta->cliente->empresa :($venta->cliente->nombre ?? 'Cliente no registrado') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    @if ($venta->estadoPedido == 1)
                                    <button wire:click="entregarVenta({{ $venta->id }})" title="Entregar"
                                        class="text-gray-600 hover:text-gray-800 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-truck-return" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v6h-5l2 2m0 -4l-2 2" />
                                            <path d="M9 17l6 0" />
                                            <path d="M13 6h5l3 5v6h-2" />
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="abrirModalPagos({{ $venta->id }})" title="Estado de pago"
                                        class="transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                        @if ($venta->estadoPago == 1)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @endif
                                    </button>

                                    <button wire:click="editarVenta({{ $venta->id }})"
                                        class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </button>

                                    <button wire:click="verDetalle({{ $venta->id }})"
                                        class="text-indigo-500 hover:text-indigo-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-info-circle">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                            <path d="M12 9h.01" />
                                            <path d="M11 12h1v4h1" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-left py-4 text-gray-600 dark:text-gray-400">No hay ventas
                                registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de registro y edición -->
    @if ($modal)
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4 bg-gray-500/50 dark:bg-gray-900/75" aria-modal="true" role="dialog" aria-labelledby="modal-title" aria-describedby="modal-description">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full shadow-lg overflow-auto max-h-[90vh]">
            <div class="px-6 py-5">
                <h3 id="modal-title" class="p-text text-base font-semibold text-gray-900 dark:text-white">
                    {{ $accion }}
                </h3>

                <div class="mt-4 space-y-6">
                    <!-- Cliente con búsqueda -->
                    <div>
                        <label class="p-text block mb-1">Cliente</label>
                        <div class="relative">
                            <input type="text" wire:model.live="clienteSearch" class="input-g w-full" placeholder="Busca un cliente..." autocomplete="off" />
                            <br>
                            @error('cliente_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            @if (!empty($clienteSearch))
                            <div class="absolute z-20 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded max-h-60 overflow-auto">
                                @forelse ($clientesFiltrados as $cliente)
                                <br>
                                <div wire:click="seleccionarCliente({{ $cliente->id }})"
                                    class="p-text px-4 py-2 cursor-pointer p-text">
                                    {{ $cliente->nombre }}
                                </div>
                                @empty
                                <div class="p-text px-4 py-2 text-gray-500 dark:text-gray-400">No se encontraron clientes.</div>
                                @endforelse
                            </div>
                            @endif
                        </div>

                        @if ($cliente_id)
                        <p class="p-text input-g">
                            Seleccionado: {{ $clientes->find($cliente_id)->nombre }}
                        </p>
                        @endif
                    </div>

                    <!-- Botones estadoPago -->
                    <div class="flex rounded-md overflow-hidden">
                        <button wire:click="$set('estadoPago', 0)"
                            class="flex-1 p-2 bg-yellow-500 text-white font-semibold hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            Crédito
                        </button>
                        <button wire:click="$set('estadoPago', 1)"
                            class="flex-1 p-2 bg-green-500 text-white font-semibold hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Contado
                        </button>
                    </div>

                    <!-- Detalle Crédito -->
                    @if ($estadoPago == 0)
                    <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded border border-gray-200 dark:border-gray-700">
                        <h4 class="p-text font-semibold mb-3 text-gray-900 dark:text-white">Detalle Crédito</h4>

                        <div class="space-y-4">
                            <div>
                                <label class="p-text block mb-1">Fecha Máxima (crédito)</label>
                                <input type="date" wire:model="fechaMaxima" class="input-g w-full" />
                                @error('fechaMaxima') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="p-text block mb-1">A cuenta</label>
                                <input type="number" step="0.01" wire:model="monto" class="input-g w-full" placeholder="0.00" />
                                @error('monto') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="p-text block mb-1">Código de pago</label>
                                <input type="text" wire:model="codigo" class="input-g w-full" placeholder="Ej. 12345" />
                                @error('codigo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Tipo de pago -->
                    <div>
                        <label class="p-text block mb-1">Tipo de pago</label>
                        <select wire:model="tipo" class="input-g w-full">
                            <option value="0">Efectivo</option>
                            <option value="1">QR</option>
                            <option value="2">Cheque</option>
                            <option value="3">Transferencia bancaria</option>
                        </select>
                        @error('tipo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Agregar Ítems de Venta -->
                    <div>
                        <h4 class="p-text font-semibold ">Agregar Ítems de Venta</h4>
                        <div>
                            <label for="producto" class="p-text block mb-1">Producto</label>
                            <select id="producto" wire:change="obtenerPrecio()" wire:model.lazy="existencia_id" class="input-g w-full">
                                <option value="">Seleccione un producto</option>
                                @foreach ($existencias as $existencia)
                                <option value="{{ $existencia->id }}">
                                    {{ $existencia->existenciable->producto->nombre }}
                                    [Cant:{{ $existencia->cantidad }}]
                                    [Etiq:{{ $existencia->existenciable->etiqueta->cliente->empresa ?? $existencia->existenciable->etiqueta->cliente->nombre }}]
                                </option>
                                @endforeach
                            </select>
                            @error('existencia_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mt-3">
                            <div>
                                <label class="p-text block mb-1">Cantidad</label>
                                <input type="number" wire:model="cantidad" class="input-g w-full" min="1" />
                                @error('cantidad') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="p-text block mb-1">Precio</label>
                                <input type="number" wire:model="precio" class="input-g w-full" min="1" />
                                @error('precio') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-end h-full pt-6 sm:pt-0">
                                <button wire:click="agregarItem"
                                    class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5v14m7-7h-14" />
                                    </svg>
                                </button>
                            </div>
                        </div>


                        @if (!empty($itemsVenta))
                        <div class="mt-4 overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-4 py-2">Producto</th>
                                        <th scope="col" class="px-4 py-2">Cantidad</th>
                                        <th scope="col" class="px-4 py-2">Precio Unitario</th>
                                        <th scope="col" class="px-4 py-2">Subtotal</th>
                                        <th scope="col" class="px-4 py-2">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itemsVenta as $index => $item)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="px-4 py-2">{{ $item['nombre'] }}</td>
                                        <td class="px-4 py-2">{{ $item['cantidad'] }}</td>
                                        <td class="px-4 py-2">{{ number_format($item['precio'], 2) }}</td>
                                        <td class="px-4 py-2">{{ number_format($item['subtotal'], 2) }}</td>
                                        <td class="px-4 py-2">
                                            <button wire:click="eliminarItem({{ $index }})" class="text-red-500 hover:text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <span class="p-text text-sm font-semibold text-gray-900 dark:text-white">
                                Total: {{ number_format($precioTotal, 2) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 flex justify-end gap-2">
                <button type="button" wire:click="guardarVenta"
                    class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M14 4l0 4l-6 0l0 -4" />
                    </svg>
                </button>
                <button type="button" wire:click="cerrarModal"
                    class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif


    <!-- Modal de detalle -->
    @if ($detalleModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-slate-800 w-full max-w-4xl mx-4 sm:mx-6 md:mx-auto rounded-xl shadow-lg overflow-y-auto max-h-[90vh] p-4">
            <h3 class="text-base font-semibold text-center p-text mb-4">Detalles de la Venta</h3>

            <!-- Información general -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium p-text">Fecha del Pedido</dt>
                    <dd class="mt-1 text-sm p-text">{{ $ventaSeleccionada->fechaPedido ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Fecha de Entrega</dt>
                    <dd class="mt-1 text-sm p-text">{{ $ventaSeleccionada->fechaEntrega ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Fecha Máxima</dt>
                    <dd class="mt-1 text-sm p-text">{{ $ventaSeleccionada->fechaMaxima ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Estado del Pedido</dt>
                    <dd class="mt-1 text-sm p-text">
                        @if ($ventaSeleccionada->estadoPedido == 0) Cancelado
                        @elseif ($ventaSeleccionada->estadoPedido == 1) Pedido
                        @else Vendido @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Estado del Pago</dt>
                    <dd class="mt-1 text-sm p-text">
                        {{ $ventaSeleccionada->estadoPago ? 'Completo' : 'Parcial' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Cliente</dt>
                    <dd class="mt-1 text-sm p-text">{{ $ventaSeleccionada->cliente->nombre ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Personal (Responsable)</dt>
                    <dd class="mt-1 text-sm p-text">{{ $ventaSeleccionada->personal->nombres ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium p-text">Personal (Entrega)</dt>
                    <dd class="mt-1 text-sm p-text">{{ $ventaSeleccionada->personalEntrega->nombre ?? 'N/A' }}</dd>
                </div>
            </div>

            <!-- Detalle de ítems -->
            <div class="mt-6">
                <h4 class="text-sm font-medium p-text text-center mb-2">Detalle de Venta</h4>
                <div class="bg-gray-50 dark:bg-slate-700 rounded-xl p-2">
                    @forelse ($ventaSeleccionada->itemVentas as $item)
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 dark:border-slate-600 py-2 last:border-none">
                        <div class="text-sm p-text space-y-1 sm:w-1/2">
                            <p><span class="font-semibold">Estado:</span>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200">
                                    @if ($item->estado == 0) Cancelado
                                    @elseif ($item->estado == 1) Pedido
                                    @else Vendido @endif
                                </span>
                            </p>
                            <p><span class="font-semibold">Cantidad:</span> {{ $item->cantidad }}</p>
                            <p><span class="font-semibold">Precio Unitario:</span> {{ number_format($item->precio, 2) }}</p>
                            <p><span class="font-semibold">Subtotal:</span> {{ number_format($item->cantidad * $item->precio, 2) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center py-4">
                        No hay ítems registrados para esta venta.
                    </p>
                    @endforelse

                    <!-- Total -->
                    <div class="mt-4 flex justify-between items-center text-right">
                        <span class="text-base font-semibold text-gray-800 dark:text-gray-100">
                            Total:
                        </span>
                        <span class="text-xl font-bold text-gray-800 dark:text-gray-100">
                            {{ number_format($ventaSeleccionada->itemVentas->sum(fn($item) => $item->cantidad * $item->precio), 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Botón cerrar -->
            <div class="mt-6 flex justify-end">
                <button type="button" wire:click="cerrarModal"
                    class="text-red-500 hover:text-red-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif



    <!-- Modal de pagos -->
    @if ($mostrarModalPagos && $ventaSeleccionada)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div
            class="bg-white dark:bg-gray-800 w-full max-w-lg mx-4 sm:mx-6 md:mx-auto rounded-lg shadow-lg overflow-y-auto max-h-[90vh] p-5">
            <h3 class="text-base font-semibold text-center text-gray-900 dark:text-white p-text" id="modal-title">
                Pagos de la Venta #{{ $ventaSeleccionada->id }}
            </h3>

            <!-- Lista de pagos -->
            <div class="mt-6">
                <h4 class="text-sm font-medium p-text text-center mb-2">Pagos Registrados</h4>
                <div class="bg-gray-50 dark:bg-slate-700 rounded-xl p-4 space-y-4">
                    @forelse ($ventaSeleccionada->pagos as $pago)
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 dark:border-slate-600 py-2 last:border-none text-sm p-text">
                        <div class="sm:w-1/4">
                            <span class="font-semibold">Tipo:</span> {{ $pago->tipo }}
                        </div>
                        <div class="sm:w-1/4">
                            <span class="font-semibold">Monto:</span> {{ number_format($pago->monto, 2) }}
                        </div>
                        <div class="sm:w-1/4">
                            <span class="font-semibold">Código:</span> {{ $pago->codigo ?? 'N/A' }}
                        </div>
                        <div class="sm:w-1/4">
                            <span class="font-semibold">Observaciones:</span> {{ $pago->observaciones ?? 'N/A' }}
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center py-4">
                        No hay pagos registrados.
                    </p>
                    @endforelse

                    <!-- Totales -->
                    <div class="mt-4 flex justify-between items-center text-right text-gray-800 dark:text-gray-100 font-semibold p-text">
                        <span>
                            Total a Pagar: {{ number_format($ventaSeleccionada->itemVentas->sum(fn($item) => $item->cantidad * $item->precio), 2) }}
                        </span>
                        <span>
                            Total Pagado: {{ number_format($ventaSeleccionada->pagos->sum('monto'), 2) }}
                        </span>
                    </div>
                </div>
            </div>


            <!-- Formulario para registrar pago (si estadoPago = 0) -->
            @if ($ventaSeleccionada->estadoPago == 0)
            <div class="modal-first">
                <div class="modal-center">
                    <div class="modal-hiden">
                        <div class="center-col">

                            <h3 class="p-text mb-4">Registrar Pago</h3>

                            <form class="over-col space-y-4">
                                <div>
                                    <label for="tipoPago" class="p-text block mb-1">Tipo de Pago</label>
                                    <select wire:model="tipo" id="tipoPago" class="p-text input-g w-full">
                                        <option value="">Seleccione tipo</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="QR">QR</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Transferencia">Transferencia</option>
                                    </select>
                                    @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="montoPago" class="p-text block mb-1">Monto</label>
                                    <input type="number" step="0.01" wire:model="monto" id="montoPago" placeholder="0.00" class="p-text input-g w-full" />
                                    @error('monto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="codigoPago" class="p-text block mb-1">Código</label>
                                    <input type="text" wire:model="codigo" id="codigoPago" placeholder="Ej. 12345" class="p-text input-g w-full" />
                                    @error('codigo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="observacionesPago" class="p-text block mb-1">Observaciones</label>
                                    <textarea wire:model="observaciones" id="observacionesPago" rows="3" placeholder="Notas adicionales" class="p-text input-g w-full"></textarea>
                                    @error('observaciones') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </form>

                            <div class="mt-6 flex justify-center space-x-6">
                                <button wire:click="registrarPago" type="button"
                                    class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full"
                                    title="Registrar Pago">
                                    <!-- Ícono de guardar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M14 4l0 4l-6 0l0 -4" />
                                    </svg>
                                </button>

                                <button wire:click="cerrarModalPagos" type="button"
                                    class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full"
                                    title="Cancelar">
                                    <!-- Ícono de cerrar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-6 flex justify-end">
                <button type="button" wire:click="cerrarModalPagos"
                    class="text-red-500 hover:text-red-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>



        </div>
    </div>
    @endif


    <!-- Modal de entrega -->
    @if ($mostrarModalEntrega && $ventaSeleccionadaEntrega)
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all w-full max-w-lg mx-4 sm:mx-0">
                <div class="px-4 py-4 sm:px-5 sm:py-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">Entrega de la
                        Venta #{{ $ventaSeleccionadaEntrega->id }}</h3>

                    <!-- Lista de itemventas -->
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Ítems de la Venta</h4>
                        <div class="mt-2 overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-4 py-2">Producto</th>
                                        <th scope="col" class="px-4 py-2">Cantidad</th>
                                        <th scope="col" class="px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ventaSeleccionadaEntrega->itemVentas as $index => $item)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="px-4 py-2">
                                            {{ $item->existencia->nombre ?? 'Producto no encontrado'
                                                                                                                                                                    }}
                                        </td>
                                        <td class="px-4 py-2">{{ $item->cantidad }}</td>
                                        <td class="px-4 py-2 flex space-x-2">
                                            <!-- Botón para aumentar cantidad -->
                                            <button wire:click="aumentarCantidad({{ $index }})"
                                                class="text-green-500 hover:text-green-600" title="Aumentar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                            <!-- Botón para disminuir cantidad -->
                                            <button wire:click="disminuirCantidad({{ $index }})"
                                                class="text-yellow-500 hover:text-yellow-600" title="Disminuir">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <!-- Botón para quitar ítem -->
                                            <button wire:click="quitarItem({{ $index }})"
                                                class="text-red-500 hover:text-red-600" title="Quitar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center">No hay ítems registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                    <button type="button" wire:click="cerrarModalEntrega"
                        class="inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 dark:text-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 dark:ring-gray-500 ring-inset hover:bg-gray-50 dark:hover:bg-gray-700 sm:w-auto">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


    {{-- <br>
    <br>
    <!-- Pie de página anclado -->
    <footer
        class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 py-2">
        <div class="flex justify-around items-center max-w-screen-xl mx-auto">
            <!-- Botón Clientes -->
            <button title="Clientes" class="text-gray-600 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                </svg>
            </button>
            <!-- Botón Pedidos -->
            <button title="Pedidos" class="text-gray-600 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 5h14v4l-3 3 3 3v4H5v-4l3-3-3-3V5zm2 2v2.586L9.586 12 7 14.586V17h10v-2.586L14.414 12 17 9.586V7H7z" />
                </svg>
            </button>
            <!-- Botón Ventas -->
            <button title="Ventas" class="text-gray-600 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 5h18v2H3V5zm2 4h14v2H5V9zm4 4h6v2H9v-2zm-6 6h18v2H3v-2z" />
                </svg>
            </button>
            <!-- Botón Créditos -->
            <button title="Créditos" class="text-gray-600 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M3 6h18M9 14h6v4H9v-4zm3-12c-4.97 0-9 4.03-9 9v6c0 4.97 4.03 9 9 9s9-4.03 9-9v-6c0-4.97-4.03-9-9-9z" />
                </svg>
            </button>
        </div>
    </footer> --}}
</div>