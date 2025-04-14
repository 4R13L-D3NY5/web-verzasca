<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Embotellado</h6>

      <!-- Botón y buscador -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
        <button title="Registrar Embotellado" wire:click='abrirModal'
          class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24"
            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="12" cy="12" r="9" />
            <line x1="9" y1="12" x2="15" y2="12" />
            <line x1="12" y1="9" x2="12" y2="15" />
          </svg>
        </button>
        <input type="text" wire:model.live="search" placeholder="Buscar por fecha o encargado..."
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
            @forelse ($embotellados as $emb)
            <tr class="color-bg border border-slate-200">
              <td class="px-6 py-4 p-text text-left">
                <div class="mb-2"><b>Fecha:</b> {{ $emb->fecha_embotellado }}</div>
                <div class="mb-2"><b>Encargado:</b> {{ $emb->personal->apellidos }} {{ $emb->personal->nombres }}</div>
                <div class="mb-2"><b>Base usada:</b> {{ $emb->cantidad_base_usada }}</div>
                <div class="mb-2"><b>Tapa usada:</b> {{ $emb->cantidad_tapa_usada }}</div>
                <div class="mb-2"><b>Generados:</b> {{ $emb->cantidad_generada ?? 'Pendiente' }}</div>
                @if ($emb->observaciones)
                <div class="mb-2"><b>Observaciones:</b> {{ $emb->observaciones }}</div>
                @endif
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex justify-end space-x-2">
                  <button title="Editar" wire:click="editar({{ $emb->id }})"
                    class="text-blue-500 hover:text-blue-600 mx-1 hover:scale-105 transition-transform focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                    ✏️
                  </button>
                  <button title="Detalles" wire:click="modaldetalle({{ $emb->id }})"
                    class="text-yellow-500 hover:text-yellow-600 mx-1 hover:scale-105 transition-transform focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                    👁️
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="2" class="text-left py-4 text-gray-600 dark:text-gray-400">No se registraron procesos de
                embotellado.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="mt-4 flex justify-center">
        {{ $embotellados->links() }}
      </div>
    </div>
  </div>

  @if($modal)
  <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
        <div class="center-col">
          <h3 class="p-text">{{ $accion === 'create' ? 'Registrar Embotellado' : 'Editar Embotellado' }}</h3>

          <div class="over-col">
            <!-- Fecha de Embotellado -->
            <h3 class="p-text">Fecha de Embotellado</h3>
            <input type="date" wire:model.defer="fecha_embotellado" class="p-text input-g">
            @error('fecha_embotellado') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <!-- Encargado -->
            <h3 class="p-text">Encargado</h3>
            <select wire:model.defer="personal_id" class="p-text input-g">
              <option value="">Seleccione</option>
              @foreach($personales as $personal)
              <option value="{{ $personal->id }}">{{ $personal->apellidos }} {{ $personal->nombres }}</option>
              @endforeach
            </select>
            @error('personal_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <!-- Base usada -->
            <h3 class="p-text">Base Usada</h3>
            <select wire:model.defer="existencia_base_id" class="p-text input-g">
              <option value="">Seleccione</option>
              @foreach($existencias_base as $existencia)
              <option value="{{ $existencia->id }}">ID #{{ $existencia->id }} [{{ $existencia->cantidad }}] - {{
                $existencia->descripcion ?? 'Base' }}</option>
              @endforeach
            </select>
            @error('existencia_base_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <!-- Tapa usada -->
            <h3 class="p-text">Tapa Usada</h3>
            <select wire:model.defer="existencia_tapa_id" class="p-text input-g">
              <option value="">Seleccione</option>
              @foreach($existencias_tapa as $existencia)
              <option value="{{ $existencia->id }}">ID #{{ $existencia->id }} [{{ $existencia->cantidad }}] - {{
                $existencia->descripcion ?? 'Tapa' }}</option>
              @endforeach
            </select>
            @error('existencia_tapa_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <!-- Cantidad base usada -->
            <h3 class="p-text">Cantidad de Base Usada</h3>
            <input type="number" wire:model.defer="cantidad_base_usada" class="p-text input-g">
            @error('cantidad_base_usada') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <!-- Cantidad tapa usada -->
            <h3 class="p-text">Cantidad de Tapa Usada</h3>
            <input type="number" wire:model.defer="cantidad_tapa_usada" class="p-text input-g">
            @error('cantidad_tapa_usada') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

            <!-- Cantidad generada -->
            <h3 class="p-text">Cantidad Generada (Productos)</h3>
            <input type="number" wire:model.defer="cantidad_generada" class="p-text input-g">
            @error('cantidad_generada') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

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

</div>