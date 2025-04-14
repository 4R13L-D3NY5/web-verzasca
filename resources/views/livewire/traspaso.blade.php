<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
      <div>
        <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Traspasos</h6>
  
        <!-- Botón y buscador -->
        <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
          <button title="Registrar Traspaso" wire:click='abrirModal'
            class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
            ➕
          </button>
          <input type="text" wire:model.live="search" placeholder="Buscar por fecha o encargado..." class="input-g w-auto sm:w-64" />
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
              @forelse ($traspasos as $tr)
              <tr class="color-bg border border-slate-200">
                <td class="px-6 py-4 p-text text-left">
                  <div class="mb-2"><b>Fecha:</b> {{ $tr->fecha_traspaso }}</div>
                  <div class="mb-2"><b>Encargado:</b> {{ $tr->personal->apellidos }} {{ $tr->personal->nombres }}</div>
                  <div class="mb-2"><b>Desde:</b> ID {{ $tr->existencia_origen_id }} → <b>Hacia:</b> ID {{ $tr->existencia_destino_id }}</div>
                  <div class="mb-2"><b>Cantidad:</b> {{ $tr->cantidad }}</div>
                  @if ($tr->observaciones)
                  <div class="mb-2"><b>Observaciones:</b> {{ $tr->observaciones }}</div>
                  @endif
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex justify-end space-x-2">
                    <button title="Editar" wire:click="editar({{ $tr->id }})"
                      class="text-blue-500 hover:text-blue-600 mx-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                      ✏️
                    </button>
                    <button title="Detalles" wire:click="modaldetalle({{ $tr->id }})"
                      class="text-yellow-500 hover:text-yellow-600 mx-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                      👁️
                    </button>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="2" class="text-left py-4 text-gray-600 dark:text-gray-400">No se registraron traspasos.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
  
        <!-- Paginación -->
        <div class="mt-4 flex justify-center">
          {{ $traspasos->links() }}
        </div>
      </div>
    </div>
  
    <!-- Modal Registro/Edición -->
    @if($modal)
    <div class="modal-first">
      <div class="modal-center">
        <div class="modal-hiden">
          <div class="center-col">
            <h3 class="p-text">{{ $accion === 'create' ? 'Registrar Traspaso' : 'Editar Traspaso' }}</h3>
  
            <div class="over-col">
              <!-- Fecha -->
              <h3 class="p-text">Fecha de Traspaso</h3>
              <input type="date" wire:model.defer="fecha_traspaso" class="p-text input-g">
              @error('fecha_traspaso') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
  
              <!-- Encargado -->
              <h3 class="p-text">Encargado</h3>
              <select wire:model.defer="personal_id" class="p-text input-g">
                <option value="">Seleccione</option>
                @foreach($personales as $personal)
                <option value="{{ $personal->id }}">{{ $personal->apellidos }} {{ $personal->nombres }}</option>
                @endforeach
              </select>
              @error('personal_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
  
              <!-- Existencia Origen -->
              <h3 class="p-text">Existencia Origen</h3>
              <select wire:model.defer="existencia_origen_id" class="p-text input-g">
                <option value="">Seleccione</option>
                @foreach($existencias_origen as $existencia)
                <option value="{{ $existencia->id }}">ID #{{ $existencia->id }} ({{ $existencia->cantidad }}) - Sucursal {{ $existencia->sucursal_id }}</option>
                @endforeach
              </select>
              @error('existencia_origen_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
  
              <!-- Existencia Destino -->
              <h3 class="p-text">Existencia Destino</h3>
              <select wire:model.defer="existencia_destino_id" class="p-text input-g">
                <option value="">Seleccione</option>
                @foreach($existencias_destino as $existencia)
                <option value="{{ $existencia->id }}">ID #{{ $existencia->id }} ({{ $existencia->cantidad }}) - Sucursal {{ $existencia->sucursal_id }}</option>
                @endforeach
              </select>
              @error('existencia_destino_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
  
              <!-- Cantidad -->
              <h3 class="p-text">Cantidad a Traspasar</h3>
              <input type="number" wire:model.defer="cantidad" class="p-text input-g">
              @error('cantidad') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
  
              <!-- Observaciones -->
              <h3 class="p-text">Observaciones</h3>
              <textarea wire:model.defer="observaciones" class="p-text input-g"></textarea>
              @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <!-- Botones -->
            <div class="mt-6 flex justify-center w-full space-x-4">
              <button type="button" wire:click="guardar"
                class="text-indigo-500 hover:text-indigo-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
                💾
              </button>
              <button type="button" wire:click="cerrarModal"
                class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                ❌
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  
    <!-- Modal Detalle -->
    @if ($modalDetalle)
    <div class="modal-first">
      <div class="modal-center">
        <div class="modal-hiden">
          <div class="center-col">
            <h3 class="text-base font-semibold p-text">Detalles del Traspaso</h3>
  
            <div class="mt-4">
              <dl class="grid grid-cols-2 gap-4">
                <div><dt class="text-sm font-medium p-text">Fecha</dt><dd class="mt-1 p-text">{{ $traspasoSeleccionado['fecha_traspaso'] ?? '-' }}</dd></div>
                <div><dt class="text-sm font-medium p-text">Encargado</dt><dd class="mt-1 p-text">{{ $traspasoSeleccionado['personal']['nombres'] ?? '-' }}</dd></div>
                <div><dt class="text-sm font-medium p-text">Origen</dt><dd class="mt-1 p-text">{{ $traspasoSeleccionado['existencia_origen_id'] ?? '-' }}</dd></div>
                <div><dt class="text-sm font-medium p-text">Destino</dt><dd class="mt-1 p-text">{{ $traspasoSeleccionado['existencia_destino_id'] ?? '-' }}</dd></div>
                <div><dt class="text-sm font-medium p-text">Cantidad</dt><dd class="mt-1 p-text">{{ $traspasoSeleccionado['cantidad'] ?? '0' }}</dd></div>
                <div class="col-span-2"><dt class="text-sm font-medium p-text">Observaciones</dt><dd class="mt-1 p-text">{{ $traspasoSeleccionado['observaciones'] ?? 'Ninguna' }}</dd></div>
              </dl>
            </div>
  
            <!-- Botón cerrar -->
            <div class="mt-6 flex justify-center">
              <button type="button" wire:click="cerrarModalDetalle"
                class="text-red-500 hover:text-red-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
                ❌
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
  