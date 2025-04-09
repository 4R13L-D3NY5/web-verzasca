<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Preformas</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
        <button title="Registrar Preforma" wire:click='abrirModal("create")'
          class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5v14m7-7h-14" />
          </svg>
        </button>

        <input type="text" wire:model.live="search" placeholder="Buscar preforma..." class="input-g w-auto sm:w-64" />
      </div>

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left border border-slate-200 dark:border-cyan-200 rounded-lg border-collapse">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th scope="col" class="px-6 py-3 p-text text-left">Información</th>
              <th scope="col" class="px-6 py-3 p-text text-right">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($preformas as $preforma)
        <tr class="color-bg border border-slate-200">
          <td class="px-6 py-4 p-text text-left">
          <div class="mb-2">
            <span class="font-semibold block">Estado:</span>
            <span class="{{ $preforma->estado ? 'bg-green-900 text-white' : 'bg-red-900 text-white' }} 
           px-3 py-1 rounded-full text-sm font-medium cursor-default inline-block">
            {{ $preforma->estado ? 'Activo' : 'Inactivo' }}
            </span>
          </div>
          <div class="mb-2">
            <span class="font-semibold block">Insumo:</span>
            <span>{{ $preforma->insumo }}</span>
          </div>
          <div>
            <span class="font-semibold block">Color:</span>
            <span>{{ $preforma->color }}</span>
          </div>
          <div>
            <span class="font-semibold block">Sucursal:</span>
            @foreach ($preforma->existencias as $existencia)
        <span>{{ $existencia->sucursal->nombre }}: {{ $existencia->cantidad }}</span><br>
      @endforeach
          </div>
          </td>

          <td class="px-6 py-4 text-right">
          <div class="flex justify-end space-x-2">
            <button title="Editar Preforma" wire:click="abrirModal('edit', {{ $preforma->id }})"
            class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
              <path d="M16 5l3 3" />
            </svg>
            </button>

            <!-- Botón de detalles -->
            <button title="Ver detalles" wire:click="modaldetalle({{ $preforma->id }})"
            class="text-yellow-500 hover:text-yellow-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
      No hay preformas registradas.
      </td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4 flex justify-center">
        {{ $preformas->links() }}
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
        {{ $accion === 'create' ? 'Registrar Preforma' : 'Editar Preforma' }}
        </h3>
        <div class="over-col">
        <h3 class="p-text">Insumo</h3>
        <input type="text" wire:model="insumo" class="p-text input-g" />
        @if ($accion === 'create')
      @error('insumo') <span class="error-message text-red-500">{{ $message }}</span> @enderror
    @endif

        <h3 class="p-text">Descripción</h3>
        <input type="text" wire:model="descripcion" class="p-text input-g" />
        @if ($accion === 'create')
      @error('descripcion') <span class="error-message text-red-500">{{ $message }}</span> @enderror
    @endif

        <h3 class="p-text">Capacidad</h3>
        <input type="number" wire:model="capacidad" class="p-text input-g" />
        @if ($accion === 'create')
      @error('capacidad') <span class="error-message text-red-500">{{ $message }}</span> @enderror
    @endif

        <h3 class="p-text">Color</h3>
        <input type="text" wire:model="color" class="p-text input-g" />
        @if ($accion === 'create')
      @error('color') <span class="error-message text-red-500">{{ $message }}</span> @enderror
    @endif

        <h3 class="p-text">Estado</h3>
        <select wire:model="estado" class="p-text input-g">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
        </div>
        <div class="mt-6 flex justify-center w-full space-x-4">
        <button type="button" wire:click="guardar"
          class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full"><svg
          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
          <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
          <path d="M14 4l0 4l-6 0l0 -4" />
          </svg>
        </button>
        <button type="button" wire:click="cerrarModal"
          class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full"><svg
          xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="icon icon-tabler icons-tabler-outline icon-tabler-x">
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

  <!-- Modal de Detalles -->
  @if ($modalDetalle)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        <h3 class="text-base font-semibold p-text" id="modal-title">Detalles de la Preforma</h3>
        <div class="mt-4">
        <dl class="grid grid-cols-2 gap-4">
          <!-- Insumo -->
          <div>
          <dt class="text-sm font-medium p-text">Insumo</dt>
          <dd class="mt-1 text-sm p-text">{{ $preformaSeleccionada->insumo ?? 'No especificado' }}</dd>
          </div>

          <!-- Descripción -->
          <div>
          <dt class="text-sm font-medium p-text">Descripción</dt>
          <dd class="mt-1 text-sm p-text">{{ $preformaSeleccionada->descripcion ?? 'No especificada' }}</dd>
          </div>

          <!-- Capacidad -->
          <div>
          <dt class="text-sm font-medium p-text">Capacidad</dt>
          <dd class="mt-1 text-sm p-text">{{ $preformaSeleccionada->capacidad ?? 'No especificada' }}</dd>
          </div>

          <!-- Color -->
          <div>
          <dt class="text-sm font-medium p-text">Color</dt>
          <dd class="mt-1 text-sm p-text">{{ $preformaSeleccionada->color ?? 'No especificado' }}</dd>
          </div>

          <!-- Estado -->
          <div>
          <dt class="text-sm font-medium p-text">Estado</dt>
          <dd class="mt-1 text-sm p-text">
            @if (($preformaSeleccionada['estado'] ?? false) == 1)
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
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="icon icon-tabler icons-tabler-outline icon-tabler-x">
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