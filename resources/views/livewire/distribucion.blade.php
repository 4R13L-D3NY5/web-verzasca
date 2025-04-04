<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Distribuciones</h6>

            <!-- Botón de registro y buscador -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                <button title="Registrar Distribución" wire:click='abrirModal("create")' class="boton-g p-text">
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
                <input type="text" wire:model.live="search" placeholder="Buscar distribución..." class="input-g" />
            </div>

            <!-- Tabla -->
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-x uppercase color-bg">
                        <tr>
                            <th scope="col" class="w-40 rounded-s-lg text-center p-2 p-text">Acciones</th>
                            <th scope="col" class="px-6 py-3 text-center p-text">Distribución</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($distribucions as $distribucion)
                            <tr class="color-bg">
                                <td class="color-bg w-40 text-center p-2">
                                    <div class="flex justify-center space-x-2">
                                        <button title="Editar Distribución" class="boton-g p-text"
                                            wire:click="abrirModal('edit', {{ $distribucion->id }})">
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
                                        <button title="Ver Detalle" class="boton-g p-text"
                                            wire:click="verDetalle({{ $distribucion->id }})">
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
                                        <button title="Retornar Stock" class="boton-g p-text"
                                            wire:click="retornarStock({{ $distribucion->id }})">
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
                                <td class="px-6 py-4 text-center p-text">
                                    <div>Fecha: {{ $distribucion->fecha }}</div>
                                    <div>Asignado a: {{ $distribucion->asignacion->personal->apellidos }}
                                        {{ $distribucion->asignacion->personal->nombres }}
                                    </div>
                                    <div>
                                        <span class="text-{{ $distribucion->estado ? 'green' : 'red' }}-500">
                                            {{ $distribucion->estado ? 'En Distribución' : 'Concluido' }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay registros
                                    de
                                    distribuciones.</td>
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
                        <h3 class="title3">{{ $accion === 'create' ? 'Registrar Distribución' : 'Editar Distribución' }}
                        </h3>
                        <div class="over-col">
                            <!-- Fecha -->
                            <h3 class="title3">Fecha</h3>
                            <input type="date" wire:model="fecha" class="p-text input-g">
                            @error('fecha') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Estado -->
                            <h3 class="title3">Estado</h3>
                            <select wire:model="estado" class="p-text input-g">
                                <option value="1">En distribución</option>
                                <option value="2">Concluido</option>
                            </select>
                            @error('estado') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Observaciones -->
                            <h3 class="title3">Observaciones</h3>
                            <textarea wire:model="observaciones" class="p-text input-g"></textarea>
                            @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Asignación -->
                            <h3 class="title3">Asignación</h3>
                            <select wire:model="asignacion_id" class="p-text input-g">
                                <option value="">Seleccione una asignación</option>
                                @foreach ($asignaciones as $asignacion)
                                    <option value="{{ $asignacion->id }}">Asignación #{{ $asignacion->id }}</option>
                                @endforeach
                            </select>
                            @error('asignacion_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Venta (Opcional) -->
                            <h3 class="title3">Venta (Opcional)</h3>
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
                                <h3 class="title3">Stocks de la Venta</h3>
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
                            <button type="button" wire:click="guardarDistribucion" class="boton-g">Guardar</button>
                            <button type="button" wire:click="cerrarModal" class="boton-g">Cerrar</button>
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
                        <h3 class="p-text">Detalles de la Distribución</h3>
                        <div class="over-col">
                            <!-- Fecha -->
                            <p class="title3"><strong class="p-text">Fecha:</strong>
                                {{ $distribucionSeleccionada['fecha'] ?? 'No especificado' }}</p>

                            <!-- Estado -->
                            <p class="title3"><strong class="p-text">Estado:</strong>
                                <span
                                    class="text-{{ ($distribucionSeleccionada['estado'] ?? false) == 1 ? 'green' : 'red' }}-500">
                                    {{ ($distribucionSeleccionada['estado'] ?? false) == 1 ? 'En distribución' : 'Concluido' }}
                                </span>
                            </p>

                            <!-- Observaciones -->
                            <p class="title3"><strong class="p-text">Observaciones:</strong>
                                {{ $distribucionSeleccionada['observaciones'] ?? 'Sin observaciones' }}
                            </p>

                            <!-- Asignación -->
                            <p class="title3"><strong class="p-text">Asignación ID:</strong>
                                {{ $distribucionSeleccionada['asignacion_id'] ?? 'No asignado' }}
                            </p>

                            <!-- Stocks Asociados -->
                            @if (!empty($distribucionSeleccionada['stocks']))
                                <h3 class="title3">Stocks Asociados</h3>
                                <ul class="list-disc pl-5">
                                    @foreach ($distribucionSeleccionada['stocks'] as $stock)
                                        <li>{{ $stock['producto']['nombre'] }} (Cantidad: {{ $stock['cantidad'] }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <!-- Botón de cierre -->
                        <div class="mt-6 flex justify-center w-full">
                            <button type="button" wire:click="cerrarModal" class="boton-g">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>