<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Productos</h6>

            <!-- Botón de registro y buscador -->
            <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
                <button title="Registrar Producto" wire:click='abrirModal("create")'
                    class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5v14m7-7h-14" />
                    </svg>
                </button>

                <input type="text" wire:model.live="search" placeholder="Buscar producto..."
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
                        @forelse ($productos as $producto)
                            <tr class="color-bg border border-slate-200">
                                <td class="px-6 py-4 p-text text-left">
                                    <div class="mb-2">
                                        <span class="font-semibold block">Estado:</span>
                                        <span class="{{ $producto->estado ? 'bg-green-900 text-white' : 'bg-red-900 text-white' }} 
                                          px-3 py-1 rounded-full text-sm font-medium cursor-default inline-block">
                                            {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold block">Nombre:</span>
                                        <span>{{ $producto->nombre }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold block">Tipo Producto:</span>
                                        <span>{{ $producto->tipoProducto }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold block">Capacidad:</span>
                                        <span>{{ $producto->capacidad }} ml</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <button title="Editar Producto" wire:click="abrirModal('edit', {{ $producto->id }})"
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

                                        <!-- Botón de detalles -->
                                        <button title="Ver detalles" wire:click="modaldetalle({{ $producto->id }})"
                                            class="text-yellow-500 hover:text-yellow-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16v6" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $productos->links() }}
            </div>
        </div>
    </div>



    <!-- Modal de Registro/Edición -->
    @if ($modal)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="p-text">
                            {{ $accion === 'create' ? 'Registrar Producto' : 'Editar Producto' }}
                        </h3>

                        <div class="over-col">
                            <!-- Nombre del Producto -->
                            <h3 class="p-text">Nombre</h3>
                            <input type="text" wire:model="nombre" class="p-text input-g">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Capacidad -->
                            <h3 class="p-text">Capacidad</h3>
                            <input type="number" wire:model="capacidad" class="p-text input-g">
                            @error('capacidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Unidad -->
                            <h3 class="p-text">Unidad</h3>
                            <input type="text" wire:model="unidad" class="p-text input-g">
                            @error('unidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Tipo de Contenido -->
                            <h3 class="p-text">Tipo de Contenido</h3>
                            <input type="number" wire:model="tipoContenido" class="p-text input-g">
                            @error('tipoContenido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Tipo de Producto -->
                            <h3 class="p-text">Tipo de Producto</h3>
                            <input type="checkbox" wire:model="tipoProducto" class="p-text input-g">
                            @error('tipoProducto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Precio de Referencia 1 -->
                            <h3 class="p-text">Precio de Referencia 1</h3>
                            <input type="number" wire:model="precioReferencia" class="p-text input-g">
                            @error('precioReferencia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Precio de Referencia 2 -->
                            <h3 class="p-text">Precio de Referencia 2</h3>
                            <input type="number" wire:model="precioReferencia2" class="p-text input-g">
                            @error('precioReferencia2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Precio de Referencia 3 -->
                            <h3 class="p-text">Precio de Referencia 3</h3>
                            <input type="number" wire:model="precioReferencia3" class="p-text input-g">
                            @error('precioReferencia3') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Observaciones -->
                            <h3 class="p-text">Observaciones</h3>
                            <input wire:model="observaciones" class="p-text input-g"></input>
                            @error('observaciones') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Estado -->
                            <h3 class="p-text">Estado</h3>
                            <input type="checkbox" wire:model="estado" class="p-text input-g">
                            @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Imagen -->
                            <h3 class="p-text">Imagen</h3>
                            <input type="file" wire:model="imagen" class="p-text input-g">
                            @if ($imagen)
                                <img src="{{ $imagen->temporaryUrl() }}" alt="Vista previa de la imagen" class="max-w-xs mt-2">
                            @endif
                            @error('imagen') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-6 flex justify-center w-full space-x-4">
                            <button type="button" wire:click="guardar"
                                class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
                                {{ $accion === 'create' ? 'Registrar' : 'Actualizar' }}
                            </button>

                            <button type="button" wire:click="cerrarModal"
                                class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if ($modalDetalle)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="text-base font-semibold p-text" id="modal-title">Detalles del Producto</h3>
                        <div class="mt-4">
                            <dl class="grid grid-cols-2 gap-4">
                                <!-- Nombre -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Nombre</dt>
                                    <dd class="mt-1 text-sm p-text">{{ $productoSeleccionado->nombre ?? 'No especificado' }}
                                    </dd>
                                </div>

                                <!-- Tipo de Contenido -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Tipo de Contenido</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $productoSeleccionado->tipoContenido ?? 'No especificado' }}</dd>
                                </div>

                                <!-- Tipo de Producto -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Tipo de Producto</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $productoSeleccionado->tipoProducto ? 'Activo' : 'Inactivo' }}</dd>
                                </div>

                                <!-- Capacidad -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Capacidad</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $productoSeleccionado->capacidad ?? 'No especificada' }}</dd>
                                </div>

                                <!-- Unidad -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Unidad</dt>
                                    <dd class="mt-1 text-sm p-text">{{ $productoSeleccionado->unidad ?? 'No especificada' }}
                                    </dd>
                                </div>

                                <!-- Precio Referencia 1 -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Precio de Referencia</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $productoSeleccionado->precioReferencia ?? 'No especificado' }}</dd>
                                </div>

                                <!-- Precio Referencia 2 -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Precio de Referencia 2</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $productoSeleccionado->precioReferencia2 ?? 'No especificado' }}</dd>
                                </div>

                                <!-- Precio Referencia 3 -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Precio de Referencia 3</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        {{ $productoSeleccionado->precioReferencia3 ?? 'No especificado' }}</dd>
                                </div>

                                <!-- Estado -->
                                <div>
                                    <dt class="text-sm font-medium p-text">Estado</dt>
                                    <dd class="mt-1 text-sm p-text">
                                        @if (($productoSeleccionado['estado'] ?? false) == 1)
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-600 text-white">Activo</span>
                                        @else
                                            <span
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white">Inactivo</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

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