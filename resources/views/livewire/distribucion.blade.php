<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">
            <!-- Título bonito -->
            <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Distribuciones
            </h6>

            <!-- Barra superior con botón y buscador -->
            <div
                class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                <button title="Registrar distribución" wire:click='abrirModal("create")'
                    class="group cursor-pointer outline-none hover:rotate-90 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"
                        class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                            stroke-width="1.5"></path>
                        <path d="M8 12H16" stroke-width="1.5"></path>
                        <path d="M12 16V8" stroke-width="1.5"></path>
                    </svg>
                </button>
                <input type="text" wire:model.live="search" placeholder="Buscar..."
                    class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
            </div>

            <!-- Tabla con columnas -->
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Información</th>
                            <th scope="col" class="w-40 text-right p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($distribucions as $distribucion)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800">
                                <div class="flex flex-col">
                                    <span>Fecha: {{ $distribucion->fecha }}</span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">
                                        Estado: 
                                        <span class="{{ $distribucion->estado == 1 ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white' }} inline-block px-2 py-1 rounded-full text-xs">
                                            {{ $distribucion->estado == 1 ? 'En distribución' : 'Concluido' }}
                                        </span>
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">
                                        Asignación ID: {{ $distribucion->asignacion->personal->apellidos.' '.$distribucion->asignacion->personal->nombres }}
                                    </span>
                                </div>
                            </td>
                            <td class="bg-gray-50 dark:bg-gray-800 w-40 text-right p-2">
                                <div class="flex justify-end">
                                    <button wire:click="editarDistribucion({{ $distribucion->id }})"
                                        class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.121 2.121 0 113 3L7.5 18.85 3 20l1.15-4.5L16.862 3.487z" />
                                        </svg>
                                    </button>
                                    <button wire:click="retornarStock({{ $distribucion->id }})"
                                        class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h10M3 14h18m-9-8l-7 7m0 0l7 7" />
                                        </svg>
                                    </button>
                                    <button wire:click="verDetalle({{ $distribucion->id }})"
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
                                No hay distribuciones registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <div class="mt-4 flex justify-center">
                {{ $distribucions->links() }}
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
                            {{ $accion === 'create' ? 'Registrar Distribución' : 'Editar Distribución' }}
                        </h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <label class="label1">Fecha</label>
                                    <input type="date" wire:model="fecha" class="input1">
                                    @error('fecha') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="label1">Estado</label>
                                    <select wire:model="estado" class="select1">
                                        <option value="1">En distribución</option>
                                        <option value="2">Concluido</option>
                                    </select>
                                    @error('estado') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="label1">Observaciones</label>
                                    <textarea wire:model="observaciones" class="input1"></textarea>
                                    @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="label1">Asignación</label>
                                    <select wire:model="asignacion_id" class="select1">
                                        <option value="">Seleccione una asignación</option>
                                        @foreach ($asignaciones as $asignacion)
                                        <option value="{{ $asignacion->id }}">Asignación #{{ $asignacion->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('asignacion_id') <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="label1">Venta (Opcional)</label>
                                    <select wire:model="venta_id" wire:change="cargarStocksVenta" class="select1">
                                        <option value="">Seleccione una venta (estado Contado)</option>
                                        @foreach ($ventasContado as $venta)
                                        <option value="{{ $venta->id }}">Venta #{{ $venta->id }} - Cliente: {{
                                            $venta->cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('venta_id') <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($stocksVenta && $venta_id)
                                <div>
                                    <label class="label1">Stocks de la Venta</label>
                                    <select wire:model="stock_ids" multiple class="select1">
                                        @foreach ($stocksVenta as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->producto->nombre }} (Cantidad: {{
                                            $stock->cantidad }})</option>
                                        @endforeach
                                    </select>
                                    @error('stock_ids') <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                    <button type="button" wire:click="guardarDistribucion"
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
                        Distribución</h3>
                    <div class="mt-4">
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Fecha</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $distribucionSeleccionada->fecha }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Estado</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $distribucionSeleccionada->estado == 1 ? 'En distribución' : 'Concluido' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Observaciones</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $distribucionSeleccionada->observaciones ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Asignación ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{
                                    $distribucionSeleccionada->asignacion_id }}</dd>
                            </div>
                            @if ($distribucionSeleccionada->stocks->isNotEmpty())
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Stocks Asociados</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <ul class="list-disc pl-5">
                                        @foreach ($distribucionSeleccionada->stocks as $stock)
                                        <li>{{ $stock->producto->nombre }} (Cantidad: {{ $stock->cantidad }})</li>
                                        @endforeach
                                    </ul>
                                </dd>
                            </div>
                            @endif
                        </dl>
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
</div>