<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">
            <!-- Título bonito -->
            <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Ventas</h6>

            <!-- Barra superior con botón y buscador -->
            <div
                class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                <!-- Botón Ventas -->
                <button title="Filtrar ventas" wire:click='abrirModal("Registrar venta")' class="cursor-pointer ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"
                        class="stroke-blue-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                            stroke-width="1.5"></path>
                        <path d="M8 12H16" stroke-width="1.5"></path>
                        <path d="M12 16V8" stroke-width="1.5"></path>
                    </svg> <small class="text-blue-400"> Venta&nbsp;</small>
                </button>

                <!-- Botón Pedidos -->
                <button title="Filtrar pedidos" wire:click='abrirModal("Registrar pedido")' class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"
                        class="stroke-green-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                            stroke-width="1.5"></path>
                        <path d="M8 12H16" stroke-width="1.5"></path>
                        <path d="M12 16V8" stroke-width="1.5"></path>
                    </svg> <small class="text-green-400">Pedido</small>
                </button>
                <input type="text" wire:model.live="search" placeholder="Buscar..."
                    class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
            </div>

            <!-- Grupo de botones para filtrar -->
            <div class="mt-4 flex rounded-md shadow-sm">
                <button wire:click="filtrarPorEstado(null)"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-l-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <small>Tod.</small>
                </button>
                <button wire:click="filtrarPorEstado(1)"
                    class="flex-1 bg-yellow-200 hover:bg-yellow-300 text-gray-800 font-semibold py-2 px-4 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <small>Ped.</small>
                </button>
                <button wire:click="filtrarPorEstado(2)"
                    class="flex-1 bg-green-200 hover:bg-green-300 text-gray-800 font-semibold py-2 px-4 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <small>Ven.</small>
                </button>
                <button wire:click="filtrarPorEstado(0)"
                    class="flex-1 bg-red-200 hover:bg-red-300 text-gray-800 font-semibold py-2 px-4 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <small>Can.</small>
                </button>
                <button wire:click="filtrarPorCreditosPendientes"
                    class="flex-1 bg-orange-200 hover:bg-orange-300 text-gray-800 font-semibold py-2 px-4 rounded-r-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <small>Cré.<br>Pen.</small>
                </button>
            </div>

            {{-- @foreach ($existencias as $item)
            {{$item->existenciable->producto->nombre}}
            @endforeach --}}


            <!-- Tabla con 2 columnas -->
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Información</th>
                            <th scope="col" class="w-40 text-right p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800">
                                <div class="flex flex-col">
                                    <span class="text-xs mt-1">
                                        <!-- Label para estadoPedido -->
                                        @if ($venta->estadoPedido == 0)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelado</span>
                                        @elseif ($venta->estadoPedido == 1)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pedido</span>
                                        @elseif ($venta->estadoPedido == 2)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Vendido</span>
                                        @endif
                                    </span>
                                    <span>{{ $venta->fechaPedido ?? 'Sin fecha' }}</span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">{{ $venta->cliente->nombre
                                        }}</span>
                                </div>
                            </td>
                            <td class="bg-gray-50 dark:bg-gray-800 w-40 text-right p-2">
                                <div class="flex justify-end">
                                    <!-- Botón de entrega (solo si estadoPedido es 1) -->
                                    @if ($venta->estadoPedido == 1)
                                    <button wire:click="entregarVenta({{ $venta->id }})"
                                        class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full"
                                        title="Entregar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-truck-return">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v6h-5l2 2m0 -4l-2 2" />
                                            <path d="M9 17l6 0" />
                                            <path d="M13 6h5l3 5v6h-2" />
                                        </svg>
                                    </button>
                                    @endif
                                    <!-- Botón de estadoPago -->
                                    <button wire:click="abrirModalPagos({{ $venta->id }})"
                                        class="mx-1 transition-all duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full"
                                        title="{{ $venta->estadoPago ? 'Marcar como parcial' : 'Marcar como completo' }}">
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
                                    <!-- Botones de editar y detalle -->
                                    <button wire:click="editarVenta({{ $venta->id }})"
                                        class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.121 2.121 0 113 3L7.5 18.85 3 20l1.15-4.5L16.862 3.487z" />
                                        </svg>
                                    </button>
                                    <button wire:click="verDetalle({{ $venta->id }})"
                                        class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">
                                No hay ventas registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <div class="mt-4 flex justify-center">
                {{ $ventas->links() }}
            </div>

        </div>
    </div>

    <!-- Modal de registro y edición -->
    @if ($modal)
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all w-full max-w-md mx-4 sm:mx-0">
                <div class="px-4 py-4 sm:px-5 sm:py-4">
                    <div class="w-full">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">
                            {{ $accion }}
                        </h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-1 gap-3">
                                <!-- Cliente con búsqueda -->
                                <div>
                                    <label class="label1">Cliente</label>
                                    <div class="relative">
                                        <input type="text" wire:model.live="clienteSearch" class="input1"
                                            placeholder="Busca un cliente..." autocomplete="off">
                                        @error('cliente_id') <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror

                                        @if (!empty($clienteSearch))
                                        <div
                                            class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                            @forelse ($clientesFiltrados as $cliente)
                                            <div wire:click="seleccionarCliente({{ $cliente->id }})"
                                                class="px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                                {{ $cliente->nombre }}
                                            </div>
                                            @empty
                                            <div class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                                No se encontraron clientes.
                                            </div>
                                            @endforelse
                                        </div>
                                        @endif
                                    </div>
                                    @if ($cliente_id)
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                        Seleccionado: {{ $clientes->find($cliente_id)->nombre }}
                                    </div>
                                    @endif
                                </div>

                                <!-- Grupo de botones -->
                                <div class="flex rounded-md shadow-sm">
                                    <button wire:click="$set('estadoPago', 0)"
                                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-l-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                        Crédito
                                    </button>
                                    <button wire:click="$set('estadoPago', 1)"
                                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-r-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        Contado
                                    </button>
                                </div>

                                <!-- Card para Detalle Crédito -->
                                <div>
                                    @if ($estadoPago == 0)
                                    <div
                                        class="m-1 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Detalle
                                            Crédito</h4>
                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <label class="label1">Fecha Máxima (crédito)</label>
                                                <input type="date" wire:model="fechaMaxima" class="input1">
                                                @error('fechaMaxima') <span class="text-red-600 text-xs">{{ $message
                                                    }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="label1">A cuenta</label>
                                                <input type="number" step="0.01" wire:model="montoACuenta"
                                                    class="input1" placeholder="0.00">
                                                @error('montoACuenta') <span class="text-red-600 text-xs">{{ $message
                                                    }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="label1">Código de pago</label>
                                                <input type="text" wire:model="codigoPago" class="input1"
                                                    placeholder="Ej. 12345">
                                                @error('codigoPago') <span class="text-red-600 text-xs">{{ $message
                                                    }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Tipo de pago -->
                                <div>
                                    <label class="label1">Tipo de pago</label>
                                    <select wire:model="estadoPedido" class="select1">
                                        <option value="0">Efectivo</option>
                                        <option value="1">QR</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                    </select>
                                    @error('estadoPedido') <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Sección para agregar ítems de venta -->
                                <div class="mt-4">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Agregar Ítems
                                        de Venta</h4>
                                    <div>
                                        <label class="label1">Producto</label>
                                        <select wire:model="existencia_id" class="select1">
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($existencias as $existencia)
                                            <option value="{{ $existencia->id }}">{{
                                                $existencia->existenciable->producto->nombre }} 
                                                [Cant:{{ $existencia->cantidad }}]
                                                [Etiq: {{ $existencia->existenciable->etiqueta->cliente->empresa ?? $existencia->existenciable->etiqueta->cliente->nombre }}]
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('existencia_id') <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <div>
                                            <label class="label1">Cantidad</label>
                                            <input type="number" wire:model="cantidad" class="input1" min="1">
                                            @error('cantidad') <span class="text-red-600 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="label1">Precio</label>
                                            <input type="number" wire:model="precio" class="input1" min="1">
                                            @error('precio') <span class="text-red-600 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex items-end">
                                            <button wire:click="agregarItem"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md w-full">
                                                +
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabla de ítems añadidos -->
                                    @if (!empty($itemsVenta))
                                    <div class="mt-4 overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead
                                                class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
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
                                                        <button wire:click="eliminarItem({{ $index }})"
                                                            class="text-red-500 hover:text-red-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Precio Total -->
                                    <div class="mt-4 flex justify-end">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            Total: {{ number_format($precioTotal, 2) }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                    <button type="button" wire:click="guardarVenta"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 sm:ml-2 sm:w-auto">Guardar</button>
                    <button type="button" wire:click="cerrarModal"
                        class="mt-2 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-600 dark:text-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 dark:ring-gray-500 ring-inset hover:bg-gray-50 dark:hover:bg-gray-500 sm:mt-0 sm:w-auto">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de detalle -->
    @if ($detalleModal)
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all w-full max-w-md mx-4 sm:mx-0">
                <div class="px-4 py-4 sm:px-5 sm:py-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">Detalles de la
                        Venta</h3>
                    <div class="mt-4">
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Fecha del Pedido</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $ventaSeleccionada->fechaPedido ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Fecha de Entrega</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $ventaSeleccionada->fechaEntrega ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Fecha Máxima (crédito)
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $ventaSeleccionada->fechaMaxima ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Estado del Pedido</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if ($ventaSeleccionada->estadoPedido == 0) Cancelado
                                    @elseif ($ventaSeleccionada->estadoPedido == 1) Pedido
                                    @else Vendido @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Estado del Pago</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $ventaSeleccionada->estadoPago ? 'Completo' : 'Parcial' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Cliente</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $ventaSeleccionada->cliente->nombre }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Personal (Responsable)
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $ventaSeleccionada->personal->nombres }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Personal (Entrega)</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $ventaSeleccionada->personalEntrega->nombre ?? 'N/A' }}</dd>
                            </div>
                        </dl>

                        <!-- Sección de ítems de la venta -->
                        <div class="mt-6">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Ítems de la Venta</h4>
                            <div class="mt-2 overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th scope="col" class="px-4 py-2">Cantidad</th>
                                            <th scope="col" class="px-4 py-2">Precio Unitario</th>
                                            <th scope="col" class="px-4 py-2">Subtotal</th>
                                            <th scope="col" class="px-4 py-2">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ventaSeleccionada->itemVentas as $item)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="px-4 py-2">{{ $item->cantidad }}</td>
                                            <td class="px-4 py-2">{{ number_format($item->precio, 2) }}</td>
                                            <td class="px-4 py-2">{{ number_format($item->cantidad * $item->precio, 2)
                                                }}</td>
                                            <td class="px-4 py-2">
                                                @if ($item->estado == 0) Cancelado
                                                @elseif ($item->estado == 1) Pedido
                                                @else Vendido @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-4 py-2 text-center text-gray-600 dark:text-gray-400">
                                                No hay ítems registrados para esta venta.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Total -->
                            <div class="mt-4 flex justify-end">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Total: {{ number_format($ventaSeleccionada->itemVentas->sum(fn($item) =>
                                    $item->cantidad * $item->precio), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                    <button type="button" wire:click="cerrarModal"
                        class="inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 dark:text-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 dark:ring-gray-500 ring-inset hover:bg-gray-50 dark:hover:bg-gray-700 sm:w-auto">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de pagos -->
    @if ($mostrarModalPagos && $ventaSeleccionada)
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all w-full max-w-lg mx-4 sm:mx-0">
                <div class="px-4 py-4 sm:px-5 sm:py-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">Pagos de la Venta
                        #{{ $ventaSeleccionada->id }}</h3>

                    <!-- Lista de pagos -->
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Pagos Registrados</h4>
                        <div class="mt-2 overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-4 py-2">Tipo</th>
                                        <th scope="col" class="px-4 py-2">Monto</th>
                                        <th scope="col" class="px-4 py-2">Código</th>
                                        <th scope="col" class="px-4 py-2">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ventaSeleccionada->pagos as $pago)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="px-4 py-2">{{ $pago->tipo }}</td>
                                        <td class="px-4 py-2">{{ number_format($pago->monto, 2) }}</td>
                                        <td class="px-4 py-2">{{ $pago->codigo ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $pago->observaciones ?? 'N/A' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center">No hay pagos registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Total de pagos -->
                        <div class="mt-2 flex justify-end">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                Total Pagado: {{ number_format($ventaSeleccionada->pagos->sum('monto'), 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Formulario para registrar pago (si estadoPago = 0) -->
                    @if ($ventaSeleccionada->estadoPago == 0)
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Registrar Pago</h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="label1">Tipo de Pago</label>
                                <select wire:model="tipo" class="select1">
                                    <option value="">Seleccione tipo</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="QR">QR</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                                @error('tipo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="label1">Monto</label>
                                <input type="number" step="0.01" wire:model="monto" class="input1" placeholder="0.00">
                                @error('monto') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="label1">Código</label>
                                <input type="text" wire:model="codigo" class="input1" placeholder="Ej. 12345">
                                @error('codigo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="label1">Observaciones</label>
                                <textarea wire:model="observaciones" class="input1" rows="3"
                                    placeholder="Notas adicionales"></textarea>
                                @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button wire:click="registrarPago"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                                Registrar Pago
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                    <button type="button" wire:click="cerrarModalPagos"
                        class="inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 dark:text-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 dark:ring-gray-500 ring-inset hover:bg-gray-50 dark:hover:bg-gray-700 sm:w-auto">
                        Cerrar
                    </button>
                </div>
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
                                        <td class="px-4 py-2">{{ $item->existencia->nombre ?? 'Producto no encontrado'
                                            }}</td>
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