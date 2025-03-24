<div class="text-white p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="relative flex w-full flex-col rounded-xl text-gray-700 shadow-md">
            <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Etiquetas</h6>
            <div
                class="flex overflow-hidden border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                <button title="Registrar etiqueta" wire:click='abrirModal("create")'
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
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="w-40 text-right p-2">Acciones</th>
                            <th scope="col" class="px-6 py-3">Imagen</th>
                            <th scope="col" class="px-6 py-3">Capacidad</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($etiquetas as $etiqueta)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="bg-gray-50 dark:bg-gray-800 w-40 text-right p-2">
                                    <div class="flex justify-end">
                                        <button wire:click="abrirModal('edit', {{ $etiqueta->id }})"
                                            class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 3.487a2.121 2.121 0 113 3L7.5 18.85 3 20l1.15-4.5L16.862 3.487z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($etiqueta->imagen)
                                        <img src="{{ asset('storage/' . $etiqueta->imagen) }}" alt="Imagen de etiqueta"
                                            class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span>No disponible</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $etiqueta->capacidad }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-{{ $etiqueta->estado ? 'green' : 'red' }}-500">
                                        {{ $etiqueta->estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $etiqueta->cliente ? $etiqueta->cliente->nombre : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay etiquetas
                                    registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                {{ $etiquetas->links() }}
            </div>
        </div>
    </div>

    @if ($modal)
        <div class="relative z-10 flex items-center justify-center min-h-screen" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 dark:bg-black transition-opacity" aria-hidden="true"></div>
            <div class="fixed inset-0 z-10 flex items-center justify-center w-full">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-md mx-4 sm:mx-0">
                    <div class="px-6 py-6 flex flex-col items-center">
                        <h3 id="modal-title" class="text-lg font-semibold text-black text-center">
                            {{ $accion === 'create' ? 'Registrar Etiqueta' : 'Editar Etiqueta' }}
                        </h3>
                        <div class="mt-4 w-full flex flex-col gap-3 max-h-[80vh] overflow-y-auto">
                            <div class="input-container">
                                <input type="file" wire:model="imagen" class="input-field" />
                                @if ($imagen && $imagen instanceof \Illuminate\Http\UploadedFile)
                                    <img src="{{ $imagen->temporaryUrl() }}" alt="Vista previa de la imagen"
                                        class="w-16 h-16 object-cover rounded mt-2">
                                @elseif ($imagen)
                                    <img src="{{ asset('storage/' . $imagen) }}" alt="Vista previa de la imagen"
                                        class="w-16 h-16 object-cover rounded mt-2">
                                @endif
                            </div>
                            @error('imagen') <span class="error-message">{{ $message }}</span> @enderror
                            <div class="input-container">
                                <input placeholder="Capacidad" type="number" wire:model="capacidad" class="input-field">
                            </div>
                            @error('capacidad') <span class="error-message">{{ $message }}</span> @enderror
                            <div class="input-container">
                                <select wire:model="estado" class="input-field appearance-none">
                                    <option value="1" class="option-style">Activo</option>
                                    <option value="0" class="option-style">Inactivo</option>
                                </select>
                            </div>
                            @error('estado') <span class="error-message">{{ $message }}</span> @enderror
                            <div class="input-container">
                                <select wire:model="cliente_id" class="input-field appearance-none">
                                    <option value="">Seleccionar Cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('cliente_id') <span class="error-message">{{ $message }}</span> @enderror
                            <div class="input-container h-[60px]">
                                <textarea placeholder="Observaciones" wire:model="observaciones"
                                    class="input-field resize-none"></textarea>
                            </div>
                            @error('observaciones') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-6 flex justify-center w-full space-x-4">
                            <div class="botonmodal">
                                <button type="button" wire:click="guardar">Guardar</button>
                                <button type="button" wire:click="cerrarModal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>