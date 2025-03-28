<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">
            <!-- Título bonito -->
            <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Coches</h6>

            <!-- Barra superior con botón y buscador -->
            <div class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                <button title="Registrar coche" wire:click='abrirModal("create")' class="group cursor-pointer outline-none hover:rotate-90 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke-width="1.5"></path>
                        <path d="M8 12H16" stroke-width="1.5"></path>
                        <path d="M12 16V8" stroke-width="1.5"></path>
                    </svg>
                </button>
                <input type="text" wire:model.live="search" placeholder="Buscar..." class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
            </div>

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
                        @forelse ($coches as $coche)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800">
                                    <div class="flex flex-col">
                                        <span>{{ $coche->marca }} {{ $coche->modelo }}</span>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">Placa: {{ $coche->placa }}</span>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">Estado: {{ $coche->estado ? 'Activo' : 'Inactivo' }}</span>
                                    </div>
                                </td>
                                <td class="bg-gray-50 dark:bg-gray-800 w-40 text-right p-2">
                                    <div class="flex justify-end">
                                        <button wire:click="editarCoche({{ $coche->id }})" class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.121 2.121 0 113 3L7.5 18.85 3 20l1.15-4.5L16.862 3.487z" />
                                            </svg>
                                        </button>
                                        <button wire:click="verDetalle({{ $coche->id }})" class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">
                                    No hay coches registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <div class="mt-4 flex justify-center">
                {{ $coches->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de registro y edición -->
    @if ($modal)
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex items-center justify-center">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all w-full max-w-md mx-4 sm:mx-0">
                    <div class="px-4 py-4 sm:px-5 sm:py-4">
                        <div class="w-full">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">
                                {{ $accion === 'create' ? 'Registrar Coche' : 'Editar Coche' }}
                            </h3>
                            <div class="mt-2">
                                <div class="grid grid-cols-1 gap-3">
                                    <div>
                                        <label class="label1">Móvil</label>
                                        <input type="number" wire:model="movil" class="input1">
                                        @error('movil') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="label1">Marca</label>
                                        <input type="text" wire:model="marca" class="input1">
                                        @error('marca') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="label1">Modelo</label>
                                        <input type="text" wire:model="modelo" class="input1">
                                        @error('modelo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="label1">Año</label>
                                        <input type="number" wire:model="anio" class="input1">
                                        @error('anio') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="label1">Color</label>
                                        <input type="text" wire:model="color" class="input1">
                                        @error('color') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="label1">Placa</label>
                                        <input type="text" wire:model="placa" class="input1">
                                        @error('placa') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="label1">Estado</label>
                                        <select wire:model="estado" class="select1">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                        @error('estado') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                        <button type="button" wire:click="guardarCoche" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 sm:ml-2 sm:w-auto">Guardar</button>
                        <button type="button" wire:click="cerrarModal" class="mt-2 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-600 dark:text-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 dark:ring-gray-500 ring-inset hover:bg-gray-50 dark:hover:bg-gray-500 sm:mt-0 sm:w-auto">Cancelar</button>
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
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all w-full max-w-md mx-4 sm:mx-0">
                    <div class="px-4 py-4 sm:px-5 sm:py-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">Detalles del Coche</h3>
                        <div class="mt-4">
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Móvil</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->movil }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Marca</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->marca }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Modelo</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->modelo }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Año</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->anio }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Color</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->color }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Placa</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->placa }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Estado</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cocheSeleccionado->estado ? 'Activo' : 'Inactivo' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-5">
                        <button type="button" wire:click="cerrarModal" class="inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 dark:text-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 dark:ring-gray-500 ring-inset hover:bg-gray-50 dark:hover:bg-gray-700 sm:w-auto">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>