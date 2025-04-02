<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Bases</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
        <button title="Registrar Base" wire:click='abrirModal("create")' class="boton-g p-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-database-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 4c4.418 0 8 1.791 8 4s-3.582 4 -8 4s-8 -1.791 -8 -4s3.582 -4 8 -4z" />
            <path d="M4 12c0 2.209 3.582 4 8 4s8 -1.791 8 -4" />
            <path d="M4 16c0 2.209 3.582 4 8 4s8 -1.791 8 -4" />
            <path d="M16 10v4m2 -2h-4" />
          </svg>
        </button>
        <input type="text" wire:model.live="search" placeholder="Buscar por base..." class="input-g" />
      </div>

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th scope="col" class="w-40 rounded-s-lg text-center p-2 p-text">Acciones</th>
              <th scope="col" class="px-6 py-3 text-center p-text">Base</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($bases as $base)
        <tr class="color-bg">
          <td class="color-bg w-40 text-center p-2">
          <div class="flex justify-center space-x-2">
            <button title="Editar Base" class="boton-g p-text" wire:click="abrirModal('edit', {{ $base->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
              <path d="M16 5l3 3" />
            </svg>
            </button>
            <button title="Detalles del Producto" class="boton-g p-text"
            wire:click="modaldetalle({{ $base->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
          <div>{{ $base->preforma ? $base->preforma->insumo : 'Sin Preforma' }}</div>
          <div>{{ $base->capacidad }}</div>
          <div>
            <span class="text-{{ $base->estado ? 'green' : 'red' }}-500">
            {{ $base->estado ? 'Activo' : 'Inactivo' }}
            </span>
          </div>
          </td>

        </tr>
      @empty
    <tr>
      <td colspan="5" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay registros de bases.</td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-4 flex justify-center">
        {{ $bases->links() }}
      </div>
    </div>
  </div>

  @if ($modal)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        <h3 class="title3">{{ $accion === 'create' ? 'Registrar Base' : 'Editar Base' }}</h3>
        <div class="over-col">
        <!-- Preforma -->
        <h3 class="title3">Preforma</h3>
        <select wire:model="preforma_id" class="p-text input-g">
          <option value="">Seleccione una Preforma</option>
          @foreach($preformas as $preforma)
        <option value="{{ $preforma->id }}">{{ $preforma->insumo }}</option>
      @endforeach
        </select>

        <!-- Capacidad -->
        <h3 class="title3">Capacidad</h3>
        <input type="text" wire:model="capacidad" class="p-text input-g">

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
        <button type="button" wire:click="guardar" class="boton-g">Guardar</button>
        <button type="button" wire:click="cerrarModal" class="boton-g">Cerrar</button>
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
        <h3 class="p-text">Detalles de la Base</h3>
        <div class="over-col">
        <p class="title3"><strong class="p-text">Preforma:</strong>
          {{ $baseSeleccionada['preforma'] ?? 'Sin Preforma' }}</p>
        <p class="title3"><strong class="p-text">Capacidad:</strong>
          {{ $baseSeleccionada['capacidad'] ?? 'No especificado' }}</p>
        <p class="title3"><strong class="p-text">Observaciones:</strong>
          {{ $baseSeleccionada['observaciones'] ?? 'Sin observaciones' }}</p>
        <p class="title3"><strong class="p-text">Estado:</strong>
          <span class="text-{{ ($baseSeleccionada['estado'] ?? false) ? 'green' : 'red' }}-500">
          {{ ($baseSeleccionada['estado'] ?? false) ? 'Activo' : 'Inactivo' }}</span>
        </p>
        </div>
        <div class="mt-6 flex justify-center w-full">
        <button type="button" wire:click="cerrarModalDetalle" class="boton-g">Cerrar</button>
        </div>
      </div>
      </div>
    </div>
    </div>
  @endif

</div>