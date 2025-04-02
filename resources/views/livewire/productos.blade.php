<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Productos</h6>

            <!-- Botón de registro y buscador -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                <button title="Registrar Producto" wire:click='abrirModal("create")' class="boton-g p-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-droplet-bolt">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M18.628 12.076a6.653 6.653 0 0 0 -.564 -1.199l-4.89 -7.26c-.42 -.625 -1.287 -.803 -1.936 -.397a1.376 1.376 0 0 0 -.41 .397l-4.893 7.26c-1.695 2.838 -1.035 6.441 1.567 8.546c1.7 1.375 3.906 1.852 5.958 1.431" />
                        <path d="M19 16l-2 3h4l-2 3" />
                    </svg>
                </button>
                <input type="text" wire:model.live="search" placeholder="Buscar..." class="input-g" />
            </div>

            <!-- Tabla -->
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-x uppercase color-bg">
                        <tr>
                            <th scope="col" class="w-40 rounded-s-lg text-center p-2 p-text">Acciones</th>
                            <th scope="col" class="px-6 py-3 text-center p-text">Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr class="color-bg">
                                <td class="color-bg w-40 text-center p-2">
                                    <div class="flex justify-center space-x-2">
                                        <button title="Editar Producto" class="boton-g p-text"
                                            wire:click="abrirModal('edit', {{ $producto->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </button>
                                        <button title="Detalles del Producto" class="boton-g p-text"
                                            wire:click="modaldetalle({{ $producto->id }})">
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
                                <td class="px-6 py-4 text-center p-text">
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Producto"
                                        class="h-24 w-24 object-cover mx-auto">
                                    <div class="text-sm font-semibold">{{ $producto->nombre }}</div>
                                    <div class="text-sm">{{ $producto->tipoContenido == 1 ? 'Líquido' : 'Sólido' }}</div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-600 dark:text-gray-400">
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


    @if ($modal)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="title3">{{ $accion === 'create' ? 'Registrar Producto' : 'Editar Producto' }}</h3>
                        <div class="over-col">
                            <!-- Imagen -->
                            <h3 class="title3">Imagen</h3>
                            <input type="file" wire:model="imagen" class="p-text input-g">

                            <!-- Nombre -->
                            <h3 class="title3">Nombre</h3>
                            <input type="text" wire:model="nombre" class="p-text input-g">

                            <!-- Tipo de Contenido -->
                            <h3 class="title3">Tipo de Contenido</h3>
                            <select wire:model="tipoContenido" class="p-text input-g">
                                <option value="1">Líquido</option>
                                <option value="0">Sólido</option>
                            </select>

                            <!-- Tipo de Producto -->
                            <h3 class="title3">Tipo de Producto</h3>
                            <input type="text" wire:model="tipoProducto" class="p-text input-g">

                            <!-- Capacidad -->
                            <h3 class="title3">Capacidad</h3>
                            <input type="text" wire:model="capacidad" class="p-text input-g">

                            <!-- Precio de Referencia -->
                            <h3 class="title3">Precio de Referencia</h3>
                            <input type="text" wire:model="precioReferencia" class="p-text input-g">

                            <!-- Observaciones -->
                            <h3 class="title3">Observaciones</h3>
                            <textarea wire:model="observaciones" class="p-text input-g"></textarea>

                            <!-- Estado -->
                            <h3 class="title3">Estado</h3>
                            <select wire:model="estado" class="p-text input-g">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        
                        </div>

                        <div class="mt-6 flex justify-center w-full space-x-4">
                            <button type="button" wire:click="guardar" class="boton-g">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M14 4l0 4l-6 0l0 -4" />
                                </svg>
                            </button>
                            <button type="button" wire:click="cerrarModal" class="boton-g">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-square-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M19 2h-14a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3 -3v-14a3 3 0 0 0 -3 -3zm-9.387 6.21l.094 .083l2.293 2.292l2.293 -2.292a1 1 0 0 1 1.497 1.32l-.083 .094l-2.292 2.293l2.292 2.293a1 1 0 0 1 -1.32 1.497l-.094 -.083l-2.293 -2.292l-2.293 2.292a1 1 0 0 1 -1.497 -1.32l.083 -.094l2.292 -2.293l-2.292 -2.293a1 1 0 0 1 1.32 -1.497z" />
                                </svg>
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
                        <h3 class="p-text">Detalles del Producto</h3>
                        <div class="over-col">
                            <p class="title3"><strong class="p-text">Imagen:</strong></p>
                            <img src="{{ asset('storage/' . $productoSeleccionado['imagen']) }}" alt="Producto"
                                class="h-52 w-52 object-cover mx-auto">

                            <p class="title3"><strong class="p-text">Nombre:</strong>
                                {{ $productoSeleccionado['nombre'] }}</p>
                            <p class="title3"><strong class="p-text">Tipo de Contenido:</strong>
                                {{ $productoSeleccionado['tipoContenido'] == 1 ? 'Líquido' : 'Sólido' }}</p>
                            <p class="title3"><strong class="p-text">Tipo de Producto:</strong>
                                {{ $productoSeleccionado['tipoProducto'] }}</p>
                            <p class="title3"><strong class="p-text">Capacidad:</strong>
                                {{ $productoSeleccionado['capacidad'] }}</p>
                            <p class="title3"><strong class="p-text">Precio de Referencia:</strong>
                                {{ $productoSeleccionado['precioReferencia'] }}</p>
                            <p class="title3"><strong class="p-text">Observaciones:</strong>
                                {{ $productoSeleccionado['observaciones'] }}</p>
                            <p class="title3"><strong class="p-text">Estado:</strong>
                                <span class="text-{{ $productoSeleccionado['estado'] ? 'green' : 'red' }}-500">
                                    {{ $productoSeleccionado['estado'] ? 'Activo' : 'Inactivo' }}</span>
                            </p>
                        </div>

                        <div class="mt-6 flex justify-center w-full">
                            <button type="button" wire:click="cerrarModalDetalle" class="boton-g">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-square-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M19 2h-14a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3 -3v-14a3 3 0 0 0 -3 -3zm-9.387 6.21l.094 .083l2.293 2.292l2.293 -2.292a1 1 0 0 1 1.497 1.32l-.083 .094l-2.292 2.293l2.292 2.293a1 1 0 0 1 -1.32 1.497l-.094 -.083l-2.293 -2.292l-2.293 2.292a1 1 0 0 1 -1.497 -1.32l.083 -.094l2.292 -2.293l-2.292 -2.293a1 1 0 0 1 1.32 -1.497z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>