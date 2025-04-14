<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Tapas</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
        <button title="Registrar Tapa" wire:click='abrirModal("create")'
          class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5v14m7-7h-14" />
          </svg>
        </button>

        <input type="text" wire:model.live="search" placeholder="Buscar por Color o Tipo..."
          class="input-g w-auto sm:w-64" />
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
            @forelse ($tapas as $tapa)
          <tr class="color-bg border border-slate-200">
            {{-- INFO DE LA TAPA --}}
            <td class="px-6 py-4 text-left p-text">
            <span class="font-semibold block">Estado:</span>
            <span class="text-sm {{ $tapa->estado ? 'bg-green-900 text-white' : 'bg-red-900 text-white' }} 
           px-3 py-1 rounded-full text-sm font-semibold cursor-default inline-block">
              {{ $tapa->estado ? 'Activo' : 'Inactivo' }}
            </span>
            <br>
            <strong>Tapa:</strong> {{ $tapa->color }} - {{ $tapa->tipo }}<br>
            @if ($tapa->existencias->count() > 0)
        @foreach ($tapa->existencias as $existencia)
      {{ $existencia->sucursal->nombre ?? 'Sucursal Desconocida' }} :
      {{ number_format($existencia->cantidad) }} <br>
    @endforeach
        <strong class="p-text">Total Stock: {{ number_format($tapa->existencias->sum('cantidad')) }}</strong>
      @else
    <span class="text-xs text-gray-500">Sin stock registrado</span>
  @endif

            </td>

            {{-- ACCIONES --}}
            <td class="px-6 py-4 text-right">
            <div class="flex justify-end space-x-2">
              <button title="Editar Tapa" wire:click="abrirModal('edit', {{ $tapa->id }})"
              class="text-blue-500 hover:text-blue-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                <path d="M16 5l3 3" />
              </svg>
              </button>

              <button title="Ver detalles" wire:click="modaldetalle({{ $tapa->id }})"
              class="text-yellow-500 hover:text-yellow-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
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
          </tr>
      @empty
    <tr>
      <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">
      No hay tapas registradas.
      </td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>


      <!-- Paginación -->
      <div class="mt-4 flex justify-center">
        {{ $tapas->links() }}
      </div>
    </div>
  </div>
  @if ($modal)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        {{-- Título del Modal --}}
        <h3 class="p-text">
        {{ $accion === 'create' ? 'Registrar Tapa' : 'Editar Tapa' }}
        </h3>

        <div class="over-col">
        {{-- Campo Color --}}
        <h3 class="p-text">Color</h3>
        <input type="text" wire:model="color" class="p-text input-g" />
        @error('color')
      <span class="error-message text-red-500 text-xs">{{ $message }}</span>
    @enderror

        {{-- Campo Tipo --}}
        <h3 class="p-text">Tipo</h3>
        <input type="text" wire:model="tipo" class="p-text input-g" />
        @error('tipo')
      <span class="error-message text-red-500 text-xs">{{ $message }}</span>
    @enderror

        {{-- Campo Estado --}}
        <h3 class="p-text">Estado</h3>
        <select wire:model="estado" class="p-text input-g">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
        @error('estado')
      <span class="error-message text-red-500 text-xs">{{ $message }}</span>
    @enderror
        </div>

        {{-- Botones --}}
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


  @if ($modalDetalle && $tapaSeleccionada)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        {{-- Título --}}
        <h3 class="text-base font-semibold p-text" id="modal-title">Detalles de la Tapa</h3>

        <div class="mt-4">
        <dl class="grid grid-cols-2 gap-4">
          <!-- ID -->
          <div>
          <dt class="text-sm font-semibold p-text">ID</dt>
          <dd class="mt-1 text-sm p-text">{{ $tapaSeleccionada->id }}</dd>
          </div>

          <!-- Color -->
          <div>
          <dt class="text-sm font-semibold p-text">Color</dt>
          <dd class="mt-1 text-sm p-text">{{ $tapaSeleccionada->color }}</dd>
          </div>

          <!-- Tipo -->
          <div>
          <dt class="text-sm font-semibold p-text">Tipo</dt>
          <dd class="mt-1 text-sm p-text">{{ $tapaSeleccionada->tipo }}</dd>
          </div>

          <!-- Estado -->
          <div>
          <dt class="text-sm font-semibold p-text">Estado</dt>
          <dd class="mt-1 text-sm p-text">
            @if ($tapaSeleccionada->estado)
        <span
        class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-600 text-white">Activo</span>
      @else
    <span
    class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-red-600 text-white">Inactivo</span>
  @endif
          </dd>
          </div>

          <!-- Fecha de creación -->
          <div class="col-span-2">
          <dt class="text-sm font-semibold p-text">Fecha de creación</dt>
          <dd class="mt-1 text-sm p-text">{{ $tapaSeleccionada->created_at->format('d/m/Y H:i') }}</dd>
          </div>

          <!-- Fecha de actualización -->
          <div class="col-span-2">
          <dt class="text-sm font-semibold p-text">Última modificación</dt>
          <dd class="mt-1 text-sm p-text">{{ $tapaSeleccionada->updated_at->format('d/m/Y H:i') }}</dd>
          </div>

          {{-- Imagen si aplica --}}
          {{-- <div class="col-span-2">
          <dt class="text-sm font-semibold p-text">Imagen</dt>
          <dd class="mt-1 text-sm p-text">No asignada</dd>
          </div> --}}
        </dl>
        </div>

        {{-- Botón de cierre --}}
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