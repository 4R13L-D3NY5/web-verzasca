<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Clientes</h6>

            <!-- Botón de registro y buscador -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                <button title="Registrar Cliente" wire:click='abrirModal("create")' class="boton-g p-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-user-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 0 8a4 4 0 0 0 0 -8z" />
                        <path d="M16 11h6m-3 -3v6" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h1" />
                    </svg>
                </button>
                <input type="text" wire:model.live="search" placeholder="Buscar por cliente..." class="input-g" />
            </div>

            <!-- Tabla -->
            <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-x uppercase color-bg">
                        <tr>
                            <th scope="col" class="w-40 rounded-s-lg text-center p-2 p-text">Acciones</th>
                            <th scope="col" class="px-6 py-3 text-center p-text">Información</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr class="color-bg">
                                <td class="color-bg w-40 text-center p-2">
                                    <div class="flex justify-center space-x-2">
                                        <button title="Editar Cliente" class="boton-g p-text"
                                            wire:click="editarCliente({{ $cliente->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </button>
                                        <button title="Ver Detalles" class="boton-g p-text"
                                            wire:click="verDetalle({{ $cliente->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icon-tabler-info-circle">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                <path d="M12 9h.01" />
                                                <path d="M11 12h1v4h1" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center p-text">
                                    <div>CLIENTE :{{ $cliente->nombre }}</div>
                                    <div>EMPRESA :{{ $cliente->empresa ?? 'N/A' }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay clientes
                                    registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de registro y edición -->
    @if ($modal)
        <div class="modal-first">
            <div class="modal-center">
                <div class="modal-hiden">
                    <div class="center-col">
                        <h3 class="title3">{{ $accion === 'create' ? 'Registrar Cliente' : 'Editar Cliente' }}</h3>
                        <div class="over-col">

                            <!-- Nombre -->
                            <h3 class="title3">Nombre</h3>
                            <input type="text" wire:model="nombre" class="p-text input-g">
                            @error('nombre') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Empresa -->
                            <h3 class="title3">Empresa</h3>
                            <input type="text" wire:model="empresa" class="p-text input-g">
                            @error('empresa') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- NIT/CI -->
                            <h3 class="title3">NIT/CI</h3>
                            <input type="number" wire:model="nitCi" class="p-text input-g">
                            @error('nitCi') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Teléfono -->
                            <h3 class="title3">Teléfono</h3>
                            <input type="number" wire:model="telefono" class="p-text input-g">
                            @error('telefono') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Correo -->
                            <h3 class="title3">Correo</h3>
                            <input type="email" wire:model="correo" class="p-text input-g">
                            @error('correo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                            <!-- Estado -->
                            <h3 class="title3">Estado</h3>
                            <select wire:model="estado" class="p-text input-g">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            @error('estado') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

                        </div>

                        <!-- Botones -->
                        <div class="mt-6 flex justify-center w-full space-x-4">
                            <button type="button" wire:click="guardarCliente" class="boton-g">Guardar</button>
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
        <h3 class="p-text">Detalles del Cliente</h3>
        <div class="over-col">

          <p class="title3">
            <strong class="p-text">Nombre:</strong>
            {{ $clienteSeleccionado->nombre ?? 'No disponible' }}
          </p>

          <p class="title3">
            <strong class="p-text">Empresa:</strong>
            {{ $clienteSeleccionado->empresa ?? 'N/A' }}
          </p>

          <p class="title3">
            <strong class="p-text">NIT/CI:</strong>
            {{ $clienteSeleccionado->nitCi ?? 'N/A' }}
          </p>

          <p class="title3">
            <strong class="p-text">Teléfono:</strong>
            {{ $clienteSeleccionado->telefono ?? 'N/A' }}
          </p>

          <p class="title3">
            <strong class="p-text">Correo:</strong>
            {{ $clienteSeleccionado->correo ?? 'N/A' }}
          </p>

          <p class="title3">
            <strong class="p-text">Estado:</strong>
            <span class="text-{{ $clienteSeleccionado->estado ? 'green' : 'red' }}-500">
              {{ $clienteSeleccionado->estado ? 'Activo' : 'Inactivo' }}
            </span>
          </p>

        </div>

        <div class="mt-6 flex justify-center w-full">
          <button type="button" wire:click="cerrarModal" class="boton-g">Cerrar</button>
        </div>

      </div>
    </div>
  </div>
</div>
@endif

</div>