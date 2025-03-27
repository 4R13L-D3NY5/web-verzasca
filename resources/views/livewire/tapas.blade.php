<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Tapas</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex justify-center items-center w-full h-10 border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-700">
        <button title="Registrar tapa" wire:click='abrirModal("create")'
          class="group cursor-pointer outline-none hover:rotate-90 duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"
            class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 duration-300">
            <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
              stroke-width="1.5"></path>
            <path d="M8 12H16" stroke-width="1.5"></path>
            <path d="M12 16V8" stroke-width="1.5"></path>
          </svg>
        </button>
        <input type="text" wire:model.live="search" placeholder="Buscar..."
          class="px-4 py-2 w-full sm:w-64 p-text color-bg focus:outline-none" />
      </div>

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right ">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th scope="col" class="w-40 rounded-s-lg text-center p-2 p-text">Acciones</th>
              <th scope="col" class="px-6 py-3 text-center p-text">Color</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($tapas as $tapa)
        <tr class="color-bg">
          <td class="color-bg w-40 text-center p-2">
          <div class="flex justify-center space-x-2 ">
            <!-- Botón de edición -->
            <button wire:click="abrirModal('edit', {{ $tapa->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-edit p-text">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
              <path d="M16 5l3 3" />
            </svg>
            </button>

            <!-- Botón de detalle -->
            <button wire:click="modaldetalle({{ $tapa->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-baseline-density-small p-text">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M4 3h16" />
              <path d="M4 9h16" />
              <path d="M4 15h16" />
              <path d="M4 21h16" />
            </svg>
            </button>
          </div>
          </td>
          <td class="px-6 py-4 text-center p-text">{{ $tapa->color }}</td>
        </tr>
      @empty
    <tr>
      <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay tapas registradas.</td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-4 flex justify-center">
        {{ $tapas->links() }}
      </div>
    </div>
  </div>

  <!-- Modal de Registro/Edición -->
  @if ($modal)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        <h3 class="title3">
        {{ $accion === 'create' ? 'Registrar Tapa' : 'Editar Tapa' }}
        </h3>
        <div class="over-col">
        <h3 class="title3">Color</h3>
        <input type="text" wire:model="color" class="p-text color-bg">
        @if ($accion === 'create')
      @error('color') <span class="error-message text-red-500">{{ $message }}</span> @enderror
    @endif
        <h3 class="title3">Tipo de tapa</h3>
        <input type="text" wire:model="tipo" class="p-text color-bg">
        @if ($accion === 'create')
      @error('tipo') <span class="error-message text-red-500">{{ $message }}</span> @enderror
    @endif
        <h3 class="title3">Estado</h3>
        <select wire:model="estado" class="p-text color-bg">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
        </div>
        <div class="mt-6 flex justify-center w-full space-x-4">
        <button type="button" wire:click="guardar" class="color-bg">
          <span class="p-text">
          GUARDAR
          </span>
        </button>
        <button type="button" wire:click="cerrarModal" class="color-bg">
          <span class="p-text">
          CERRAR
          </span>
        </button>
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
        <h3 class="p-text">Detalles de la Tapa</h3>
        <div class="over-col">
        <p class="title3"><strong class="p-text">COLOR:</strong> {{ $tapaSeleccionada['color'] }}</p>
        <p class="title3"><strong class="p-text">TIPO:</strong> {{ $tapaSeleccionada['tipo'] }}</p>
        <p class="title3"><strong class="p-text">Estado:</strong>
          <span class="text-{{ $tapaSeleccionada['estado'] ? 'green' : 'red' }}-500">
          {{ $tapaSeleccionada['estado'] ? 'Activo' : 'Inactivo' }}
          </span>
        </p>
        </div>
        <div class="mt-6 flex justify-center w-full">
        <button type="button" wire:click="cerrarModalDetalle" class="color-bg">
          <span class="p-text">
          CERRAR
          </span>
        </button>
        </div>
      </div>
      </div>
    </div>
    </div>
  @endif
</div>