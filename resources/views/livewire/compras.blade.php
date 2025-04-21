<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Compras</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
        <button title="Registrar Compra" wire:click='abrirModal("create")'
          class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24"
            height="24" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="6" cy="19" r="2" />
            <circle cx="17" cy="19" r="2" />
            <path d="M17 17H6V3H4" />
            <path d="M6 5l14 1l-1 7H6" />
          </svg>
        </button>

        <input type="text" wire:model.live="search" placeholder="Buscar compra..." class="input-g w-auto sm:w-64" />
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
            @forelse ($compras as $compra)
        <tr class="color-bg border border-slate-200">
          <td class="px-6 py-4 p-text text-left">
          <div class="mb-2">
            <span class="font-semibold block">Fecha de compra:</span>
            <span>{{ $compra->fecha }}</span>
          </div>
          <div class="mb-2">
            <span class="font-semibold block">Proveedor:</span>
            <span>{{ $compra->proveedor->razonSocial }}</span>
          </div>
          <div class="mb-2">
            <span class="font-semibold block">Personal:</span>
            <span>{{ $compra->personal->apellidos }}</span>
          </div>
          <div>
            <span class="font-semibold block">Observaciones:</span>
            <span>{{ $compra->observaciones ?? 'Ninguna' }}</span>
          </div>
          </td>
          <td class="px-6 py-4 text-right">
          <div class="flex justify-end space-x-2">
            <button title="Editar" wire:click="editarCompra({{ $compra->id }})"
            class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
              <path d="M16 5l3 3" />
            </svg>
            </button>
            <button title="Ver Detalle" wire:click="verDetalle({{ $compra->id }})"
            class="text-yellow-500 hover:text-yellow-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24"
              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <circle cx="12" cy="12" r="2" />
              <path d="M22 12c0 5.523 -4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10s10 4.477 10 10z" />
            </svg>
            </button>
          </div>
          </td>
        </tr>
      @empty
    <tr>
      <td colspan="2" class="text-left py-4 text-gray-600 dark:text-gray-400">
      No hay compras registradas.
      </td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4 flex justify-center">
        {{ $compras->links() }}
      </div>
    </div>
  </div>
  @if ($modal)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        <h3 class="p-text">{{ $accion === 'create' ? 'Registrar Compra' : 'Editar Compra' }}</h3>
        <div class="over-col">

        <!-- Fecha -->
        <h3 class="p-text">Fecha</h3>
        <input type="date" wire:model.defer="fecha" class="p-text input-g">
        @error('fecha') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Observaciones -->
        <h3 class="p-text">Observaciones</h3>
        <textarea wire:model.defer="observaciones" class="p-text input-g" rows="3"></textarea>
        @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Proveedor -->
        <h3 class="p-text">Proveedor</h3>
        <select wire:model.defer="proveedor_id" class="p-text text-sm sm:text-base input-g">
          <option value="">Seleccione un proveedor</option>
          @foreach ($proveedors as $proveedor)
        <option value="{{ $proveedor->id }}">{{ $proveedor->razonSocial }}</option>
      @endforeach
        </select>
        @error('proveedor_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Personal -->
        <h3 class="p-text">Personal</h3>
        <select wire:model.defer="personal_id" class="p-text text-sm sm:text-base input-g">
          <option value="">Seleccione un personal</option>
          @foreach ($personals as $personal)
        <option value="{{ $personal->id }}">{{ $personal->nombres }}</option>
      @endforeach
        </select>
        @error('personal_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-center w-full space-x-4">
        <button type="button" wire:click="guardarCompra"
          class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
          <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
          <path d="M14 4l0 4l-6 0l0 -4" />
          </svg>
        </button>
        <button type="button" wire:click="cerrarModal"
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
  @if ($detalleModal)
  <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
        <div class="center-col">
          <h3 class="text-base font-semibold p-text" id="modal-title">Detalles de la Compra</h3>
          <div class="mt-4">
            <dl class="grid grid-cols-2 gap-4">
              <!-- Fecha -->
              <div>
                <dt class="text-sm font-medium p-text">Fecha</dt>
                <dd class="mt-1 text-sm p-text">{{ $compraSeleccionada->fecha ?? 'No especificada' }}</dd>
              </div>

              <!-- Proveedor -->
              <div>
                <dt class="text-sm font-medium p-text">Proveedor</dt>
                <dd class="mt-1 text-sm p-text">{{ $compraSeleccionada->proveedor->nombre ?? 'No especificado' }}</dd>
              </div>

              <!-- Personal -->
              <div>
                <dt class="text-sm font-medium p-text">Personal</dt>
                <dd class="mt-1 text-sm p-text">{{ $compraSeleccionada->personal->nombre ?? 'No asignado' }}</dd>
              </div>

              <!-- Observaciones -->
              <div>
                <dt class="text-sm font-medium p-text">Observaciones</dt>
                <dd class="mt-1 text-sm p-text">{{ $compraSeleccionada->observaciones ?? 'No especificadas' }}</dd>
              </div>
            </dl>
          </div>

          <div>
            <button type="button" wire:click="cerrarModal"
              class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full"><svg
              xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-x">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M18 6l-12 12" />
              <path d="M6 6l12 12" />
              </svg></button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

</div>