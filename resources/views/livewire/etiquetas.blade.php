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
                                <div>
                                    <span class="font-semibold block">Sucursal:</span>
                                    @forelse ($etiqueta->existencias as $existencia)
                                    <span>
                                        {{ number_format($existencia->cantidad) }}:
                                        {{ Str::limit($existencia->sucursal->nombre ?? 'Sucursal Desconocida', 15, '...') }}
                                    </span><br>
                                    @empty
                                    <span class="text-xs text-gray-500">Sin stock registrado</span>
                                    @endforelse

                                    <strong class="p-text block mt-1">
                                        {{ number_format($etiqueta->existencias->sum('cantidad')) }}: Total etiquetas
                                    </strong>
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
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded w-full max-w-md shadow-lg">
            <h2 class="text-lg font-bold mb-4">{{ $accion === 'edit' ? 'Editar Etiqueta' : 'Nueva Etiqueta' }}</h2>

            <form wire:submit.prevent="guardar" class="space-y-4">
                <div>
                    <label class="block text-sm">Imagen</label>
                    <input type="file" wire:model="imagen" accept="image/*" class="w-full border p-2 rounded" />
                    @error('imagen') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm">Capacidad</label>
                    <input type="text" wire:model="capacidad" class="w-full border p-2 rounded" />
                    @error('capacidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm">Unidad</label>
                    <select wire:model="unidad" class="w-full border p-2 rounded">
                        <option value="">Seleccione</option>
                        <option value="L">L</option>
                        <option value="ml">ml</option>
                        <option value="g">g</option>
                        <option value="Kg">Kg</option>
                        <option value="unidad">unidad</option>
                    </select>
                    @error('unidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm">Estado</label>
                    <select wire:model="estado" class="w-full border p-2 rounded">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm">Cliente</label>
                    <select wire:model="cliente_id" class="w-full border p-2 rounded">
                        <option value="">Sin cliente</option>
                        @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" wire:click="cerrarModal"
                        class="px-4 py-2 border rounded text-gray-700">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
                </div>
            </form>
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

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <!-- Columna de Imagen -->
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/' . $etiquetaSeleccionada['imagen']) }}" alt="Etiqueta"
                                class="h-52 w-52 object-cover rounded">
                        </div>

                        <!-- Columna de Información -->
                        <div class="flex flex-col gap-4">
                            <p class="text-semibold">
                                <strong class="p-text">Capacidad:</strong>
                                {{ $etiquetaSeleccionada['capacidad'] }}
                            </p>
                            <p class="text-semibold">
                                <strong class="p-text">Estado:</strong>
                                <span class="text-{{ $etiquetaSeleccionada['estado'] ? 'green' : 'red' }}-500">
                                    {{ $etiquetaSeleccionada['estado'] ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                            <!-- Agregar más datos aquí si es necesario -->
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