<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">

            <div
                class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                {{-- <button
                    class="px-4 py-2 font-medium text-gray-600 transition-colors duration-200 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    Crear
                </button> --}}
                <button title="Registrar cliente" wire:click='abrirModal("Registrar cliente")'
                    class="group cursor-pointer outline-none hover:rotate-90 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" viewBox="0 0 24 24"
                        class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                            stroke-width="1.5"></path>
                        <path d="M8 12H16" stroke-width="1.5"></path>
                        <path d="M12 16V8" stroke-width="1.5"></path>
                    </svg>
                </button>

                <!-- Input de búsqueda -->
                <input type="text" wire:model.live="search" placeholder="Buscar..."
                    class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
            </div>

            <div
                class="relative w-full max-w-full overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 shadow-md sm:rounded-lg">
                <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-900 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Empresa</th>
                            <th scope="col" class="px-6 py-3">NIT/CI</th>
                            <th scope="col" class="px-6 py-3">Teléfono</th>
                            <th scope="col" class="px-6 py-3">Correo</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                
                                    <button
                                        class="text-red-500 hover:text-red-600 mx-0 transition-transform duration-200 ease-in-out hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                                        <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                    </button>
                                    <button
                                        class="text-gray-600 hover:text-gray-800 mx-0 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                                        <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"
                                                stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                    </button>
                                    
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                {{ $cliente->empresa ?? 'N/A' }}</td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                {{ $cliente->nitCi ?? 'N/A' }}</td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                {{ $cliente->telefono ?? $cliente->celular ?? 'N/A' }}</td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                {{ $cliente->correo ?? 'N/A' }}</td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                @if ($cliente->estado)
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Activo</span>
                                @else
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-600">
                                No hay clientes registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4 flex justify-center">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
    <!-- Modal de registro -->
    @if ($modal)
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="false">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold text-gray-900" id="modal-title">Registrar Cliente
                                </h3>
                                <div class="mt-2">
                                    <!-- Formulario -->
                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Nombre -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                            <input type="text" wire:model="nombre"
                                                class="mt-1 block text-gray-700 w-full rounded-md border- shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            {{-- @error('nombre') <span class="text-red-600 text-xs">{{ $message
                                                }}</span> @enderror --}}
                                        </div>
                                        <!-- Empresa -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Empresa</label>
                                            <input type="text" wire:model="empresa"
                                                class="mt-1 block text-gray-700 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            {{-- @error('empresa') <span class="text-red-600 text-xs">{{ $message
                                                }}</span> @enderror --}}
                                        </div>
                                        <!-- NIT/CI -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">NIT/CI</label>
                                            <input type="text" wire:model="nitCi"
                                                class="mt-1 block text-gray-700 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            {{-- @error('nitCi') <span class="text-red-600 text-xs">{{ $message
                                                }}</span> @enderror --}}
                                        </div>
                                        <!-- Teléfono -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                                            <input type="text" wire:model="telefono"
                                                class="mt-1 block text-gray-700 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            {{-- @error('telefono') <span class="text-red-600 text-xs">{{ $message
                                                }}</span> @enderror --}}
                                        </div>
                                        <!-- Correo -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Correo</label>
                                            <input type="email" wire:model="correo"
                                                class="mt-1 block text-gray-700 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            {{-- @error('correo') <span class="text-red-600 text-xs">{{ $message
                                                }}</span> @enderror --}}
                                        </div>
                                        <!-- Estado -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                                            <select wire:model="estado"
                                                class="mt-1 block text-gray-700 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                            {{-- @error('estado') <span class="text-red-600 text-xs">{{ $message
                                                }}</span> @enderror --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" wire:click="guardarCliente"
                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 sm:ml-3 sm:w-auto">Guardar</button>
                        <button type="button" wire:click="$set('modal', false)"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>