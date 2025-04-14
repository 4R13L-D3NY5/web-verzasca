<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Etiquetas</h6>

            <!-- Botón de registro y buscador -->
            <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
                <button title="Registrar etiqueta" wire:click='abrirModal("create")'
                    class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-droplet-bolt">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M18.628 12.076a6.653 6.653 0 0 0 -.564 -1.199l-4.89 -7.26c-.42 -.625 -1.287 -.803 -1.936 -.397a1.376 1.376 0 0 0 -.41 .397l-4.893 7.26c-1.695 2.838 -1.035 6.441 1.567 8.546c1.7 1.375 3.906 1.852 5.958 1.431" />
                        <path d="M19 16l-2 3h4l-2 3" />
                    </svg>
                </button>

                <input type="text" wire:model.live="search" placeholder="Buscar etiqueta..."
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
                        @forelse ($etiquetas as $etiqueta)
                            <tr class="color-bg border border-slate-200">
                                <td class="px-6 py-4 p-text text-left">
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $etiqueta->imagen) }}" alt="Etiqueta"
                                            class="h-24 w-24 object-cover rounded">
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold block">Capacidad:</span>
                                        <span>{{ $etiqueta->capacidad }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold block">Estado:</span>
                                        <span
                                            class="{{ $etiqueta->estado ? 'bg-green-900 text-white' : 'bg-red-900 text-white' }} 
                                                     px-3 py-1 rounded-full text-sm font-medium cursor-default inline-block">
                                            {{ $etiqueta->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <button title="Editar etiqueta" wire:click="abrirModal('edit', {{ $etiqueta->id }})"
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
                                        <button title="Ver Detalles" wire:click="modaldetalle({{ $etiqueta->id }})"
                                            class="text-yellow-500 hover:text-yellow-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
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
                                <td colspan="2" class="text-left py-4 text-gray-600 dark:text-gray-400">
                                    No hay etiquetas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4 flex justify-center">
                {{ $etiquetas->links() }}
            </div>
        </div>
    </div>



    <!-- Modal de Registro/Edición -->
    @if ($modal)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="p-text">{{ $accion === 'create' ? 'Registrar Etiqueta' : 'Editar Etiqueta' }}</h3>
                        <div class="over-col">
                            <h3 class="p-text">Imagen</h3>
                            <input type="file" wire:model="imagen" class="p-text input-g">
                            <h3 class="p-text">Capacidad</h3>
                            <input type="text" wire:model="capacidad" class="p-text input-g">
                            <h3 class="p-text">Estado</h3>
                            <select wire:model="estado" class="p-text input-g">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mt-6 flex justify-center w-full space-x-4">
                            <button type="button" wire:click="guardar"
                                class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
                                <!-- Icono Guardar -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                    class="icon icon-tabler icon-tabler-device-floppy">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M14 4l0 4l-6 0l0 -4" />
                                </svg></button>
                            <button type="button" wire:click="cerrarModal"
                                class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                                <!-- Icono Cancelar -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                    class="icon icon-tabler icon-tabler-x">
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

    <!-- Modal de Detalle -->
    @if ($modalDetalle)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="p-text mb-4">Detalles de la Etiqueta</h3>

                        <div class="flex flex-row gap-6 items-start">
                            <!-- Columna de Imagen -->
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $etiquetaSeleccionada['imagen']) }}" alt="Etiqueta"
                                    class="h-52 w-52 object-cover rounded">
                            </div>

                            <!-- Columna de Información -->
                            <div class="flex flex-col gap-4">
                                <p class="title3">
                                    <strong class="p-text">Capacidad:</strong>
                                    {{ $etiquetaSeleccionada['capacidad'] }}
                                </p>
                                <p class="title3">
                                    <strong class="p-text">Estado:</strong>
                                    <span class="text-{{ $etiquetaSeleccionada['estado'] ? 'green' : 'red' }}-500">
                                        {{ $etiquetaSeleccionada['estado'] ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Botón de Cerrar Modal -->
                        <div class="mt-6 flex justify-center w-full">
                            <button type="button" wire:click="cerrarModalDetalle"
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