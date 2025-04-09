<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Distribuciones</h6>

            <!-- Botón de registro y buscador -->
            <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
                <button title="Registrar Distribución" wire:click='abrirModal("create")'
                    class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-package">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3l8 4l-8 4l-8 -4z" />
                        <path d="M8 10v11" />
                        <path d="M16 10v11" />
                        <path d="M4 15l8 4l8 -4" />
                    </svg>
                </button>

                <input type="text" wire:model.live="search" placeholder="Buscar distribución..."
                    class="input-g w-auto sm:w-64" />
            </div>

            <!-- Tabla -->
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
                        @forelse ($distribucions as $distribucion)
                            <tr class="color-bg border border-slate-200">
                                <td class="px-6 py-4 p-text text-left">
                                    <div class="mb-2">
                                        <span class="font-semibold block">Fecha:</span>
                                        <span>{{ $distribucion->fecha }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold block">Asignado a:</span>
                                        <span>{{ $distribucion->asignacion->personal->apellidos }}
                                            {{ $distribucion->asignacion->personal->nombres }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold block">Estado:</span>
                                        @if ($distribucion->estado == 0)
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-600 text-white">Concluido</span>
                                        @elseif ($distribucion->estado == 1)
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-600 text-white">En
                                                Distribución</span>
                                        @endif
                                    </div>

                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <button title="Editar" wire:click="abrirModal('edit', {{ $distribucion->id }})"
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
                                        <button title="Ver Detalle" wire:click="verDetalle({{ $distribucion->id }})"
                                            class="text-yellow-500 hover:text-yellow-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12 4.5c-7 0 -10 7.5 -10 7.5s3 7.5 10 7.5s10 -7.5 10 -7.5s-3 -7.5 -10 -7.5z" />
                                                <path d="M12 9a3 3 0 1 0 3 3" />
                                            </svg>
                                        </button>
                                        <button title="Retornar Stock" wire:click="retornarStock({{ $distribucion->id }})"
                                            class="text-rose-500 hover:text-rose-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-rose-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12h14" />
                                                <path d="M5 12l4 4" />
                                                <path d="M5 12l4 -4" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-left py-4 text-gray-600 dark:text-gray-400">
                                    No hay registros de distribuciones.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $distribucions->links() }}
            </div>
        </div>
    </div>




    <!-- Modal de registro y edición -->
    @if ($modal)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="p-text">{{ $accion === 'create' ? 'Registrar Distribución' : 'Editar Distribución' }}
                        </h3>
                        <div class="over-col">
                            <!-- Fecha -->
                            <h3 class="p-text">Fecha</h3>
                            <input type="date" wire:model="fecha" class="p-text input-g">
                            @error('fecha') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Estado -->
                            <h3 class="p-text">Estado</h3>
                            <select wire:model="estado" class="p-text input-g">
                                <option value="1">En distribución</option>
                                <option value="2">Concluido</option>
                            </select>
                            @error('estado') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Observaciones -->
                            <h3 class="p-text">Observaciones</h3>
                            <input wire:model="observaciones" class="p-text input-g"></input>
                            @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Asignación -->
                            <h3 class="p-text">Asignación</h3>
                            <select wire:model="asignacion_id" class="p-text input-g">
                                <option value="">Seleccione una asignación</option>
                                @foreach ($asignaciones as $asignacion)
                                    <option value="{{ $asignacion->id }}">Asignación #{{ $asignacion->id }}</option>
                                @endforeach
                            </select>
                            @error('asignacion_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Venta (Opcional) -->
                            <h3 class="p-text">Venta (Opcional)</h3>
                            <select wire:model="venta_id" wire:change="cargarStocksVenta" class="p-text input-g">
                                <option value="">Seleccione una venta (estado Contado)</option>
                                @foreach ($ventasContado as $venta)
                                    <option value="{{ $venta->id }}">Venta #{{ $venta->id }} - Cliente:
                                        {{ $venta->cliente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('venta_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Stocks de la Venta -->
                            @if ($stocksVenta && $venta_id)
                                <h3 class="p-text">Stocks de la Venta</h3>
                                <select wire:model="stock_ids" multiple class="p-text input-g">
                                    @foreach ($stocksVenta as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->producto->nombre }} (Cantidad:
                                            {{ $stock->cantidad }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('stock_ids') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            @endif
                        </div>

                        <!-- Botones -->
                        <div class="mt-6 flex justify-center w-full space-x-4">
                            <button type="button" wire:click="guardarDistribucion"
                                class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M14 4l0 4l-6 0l0 -4" />
                                </svg></button>
                            <button type="button" wire:click="cerrarModal"
                                class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de detalle -->
    @if ($detalleModal)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="text-base font-semibold p-text" id="modal-title">Detalles de la Distribución</h3>
                        <div class="mt-4">
                            <dl class="grid grid-cols-2 gap-4">

                                <!-- Fecha -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Fecha</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $distribucionSeleccionada['fecha'] ?? 'No especificado' }}
                                    </dd>
                                </div>

                                <!-- Estado -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Estado</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        @if (($distribucionSeleccionada['estado'] ?? false) == 1)
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-600 text-white">En
                                                distribución</span>
                                        @else
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-600 text-white">Concluido</span>
                                        @endif
                                    </dd>
                                </div>

                                <!-- Observaciones -->
                                <div class="col-span-2">
                                    <dt class="text-sm font-medium p-text">Observaciones</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $distribucionSeleccionada['observaciones'] ?? 'Sin observaciones' }}
                                    </dd>
                                </div>

                                <!-- Personal asignado -->
                                <div class="col-span-2">
                                    <dt class="text-sm font-medium p-text">Asignado a</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $distribucionSeleccionada['asignacion']['personal']['apellidos'] ?? '' }}
                                        {{ $distribucionSeleccionada['asignacion']['personal']['nombres'] ?? 'No asignado' }}
                                    </dd>
                                </div>

                                <!-- Lista de Stocks Asociados -->
                                @if (!empty($distribucionSeleccionada['stocks']))
                                    <div class="col-span-2">
                                        <dt class="text-sm font-medium p-text">Stocks Asociados</dt>
                                        <dd class="mt-1 text-sm p-text">
                                            <ul class="list-disc pl-5">
                                                @foreach ($distribucionSeleccionada['stocks'] as $stock)
                                                    <li>{{ $stock['producto']['nombre'] }} (Cantidad: {{ $stock['cantidad'] }})</li>
                                                @endforeach
                                            </ul>
                                        </dd>
                                    </div>
                                @endif

                            </dl>
                        </div>

                        <!-- Botón de cierre -->
                        <div class="mt-4 flex justify-center w-full">
                            <button type="button" wire:click="cerrarModal"
                                class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
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


</div>