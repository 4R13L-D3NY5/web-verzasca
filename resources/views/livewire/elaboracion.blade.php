<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Elaboraciones</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
        <button title="Registrar Elaboración" wire:click='abrirModal' class="boton-g p-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icon-tabler-circle-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="12" cy="12" r="9" />
            <line x1="9" y1="12" x2="15" y2="12" />
            <line x1="12" y1="9" x2="12" y2="15" />
          </svg>
        </button>
        <input type="text" wire:model.live="search" placeholder="Buscar por fecha o encargado..." class="input-g" />
      </div>

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th scope="col" class="w-40 rounded-s-lg text-center p-text">Acciones</th>
              <th scope="col" class="px-6 py-3 text-center p-text">Información</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($elaboraciones as $elaboracion)
        <tr class="color-bg">
          <!-- Acciones -->
          <td class="color-bg w-40 text-center p-2">
          <div class="flex justify-center space-x-2">
            <button title="Editar Elaboración" class="boton-g p-text" wire:click="editar({{ $elaboracion->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icon-tabler-edit">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" />
              <path d="M16 5l3 3" />
            </svg>
            </button>
            <button title="Detalles" class="boton-g p-text" wire:click="modaldetalle({{ $elaboracion->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icon-tabler-info-circle">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <circle cx="12" cy="12" r="9" />
              <line x1="12" y1="9" x2="12.01" y2="9" />
              <polyline points="11 12 12 12 12 16 13 16" />
            </svg>
            </button>
          </div>
          </td>

          <!-- Información -->
          <td class="px-6 py-4 text-center p-text">
          <div>
            <div>{{ $elaboracion->fecha_elaboracion }} - {{ $elaboracion->personal->nombre }}</div>
            <div class="text-sm">
            Entrada: {{ $elaboracion->cantidad_entrada }} |
            Salida: {{ $elaboracion->cantidad_salida ?? 'Pendiente' }}
            </div>
            @if ($elaboracion->observaciones)
        <div class="text-xs italic text-gray-500 dark:text-gray-400">{{ $elaboracion->observaciones }}</div>
      @endif
          </div>
          </td>
        </tr>
      @empty
    <tr>
      <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">No se registraron procesos de
      elaboración.</td>
    </tr>
  @endforelse
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="mt-4 flex justify-center">
        {{ $elaboraciones->links() }}
      </div>
    </div>
  </div>



  <!-- Modal -->
  @if($modal)
    <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
      <div class="center-col">
        <h3 class="title3">{{ $accion === 'create' ? 'Registrar Elaboración' : 'Editar Elaboración' }}</h3>

        <div class="over-col">
        <!-- Fecha de Elaboración -->
        <h3 class="title3">Fecha de Elaboración</h3>
        <input type="date" wire:model.defer="fecha_elaboracion" class="p-text input-g">
        @error('fecha_elaboracion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Encargado -->
        <h3 class="title3">Encargado</h3>
        <select wire:model.defer="personal_id" class="p-text input-g">
          <option value="">Seleccione</option>
          @foreach($personales as $personal)
        <option value="{{ $personal->id }}">{{ $personal->nombre }}</option>
      @endforeach
        </select>
        @error('personal_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Existencia Entrada -->
        <h3 class="title3">Existencia Entrada (Preformas)</h3>
        <select wire:model.defer="existencia_entrada_id" class="p-text input-g">
          <option value="">Seleccione</option>
          @foreach($existencias_preforma as $existencia)
        <option value="{{ $existencia->id }}">ID #{{ $existencia->id }} -
        {{ $existencia->descripcion ?? 'Preforma' }}</option>
      @endforeach
        </select>
        @error('existencia_entrada_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Cantidad Entrada -->
        <h3 class="title3">Cantidad Entrada</h3>
        <input type="number" wire:model.defer="cantidad_entrada" class="p-text input-g">
        @error('cantidad_entrada') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Cantidad Salida -->
        <h3 class="title3">Cantidad Salida (Bases)</h3>
        <input type="number" wire:model.defer="cantidad_salida" class="p-text input-g">
        @error('cantidad_salida') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror

        <!-- Observaciones -->
        <h3 class="title3">Observaciones</h3>
        <textarea wire:model.defer="observaciones" class="p-text input-g"></textarea>
        @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-center w-full space-x-4">
        <button wire:click="guardar" class="boton-g">Guardar</button>
        <button wire:click="cerrarModal" class="boton-g">Cancelar</button>
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
                    <h3 class="p-text">Detalles de la Elaboración</h3>

                    <div class="over-col">
                        <p class="title3"><strong class="p-text">Fecha de Elaboración:</strong> {{ $elaboracionSeleccionada['fecha_elaboracion'] }}</p>

                        <p class="title3"><strong class="p-text">Encargado:</strong> {{ $elaboracionSeleccionada['personal']['nombre'] ?? '-' }}</p>

                        <p class="title3"><strong class="p-text">Existencia Entrada (Preformas):</strong> 
                            ID #{{ $elaboracionSeleccionada['existencia_entrada']['id'] ?? '-' }} - 
                            {{ $elaboracionSeleccionada['existencia_entrada']['descripcion'] ?? 'Sin descripción' }}
                        </p>

                        <p class="title3"><strong class="p-text">Cantidad Entrada:</strong> {{ $elaboracionSeleccionada['cantidad_entrada'] }}</p>

                        <p class="title3"><strong class="p-text">Cantidad Salida (Bases):</strong> {{ $elaboracionSeleccionada['cantidad_salida'] }}</p>

                        <p class="title3"><strong class="p-text">Observaciones:</strong> {{ $elaboracionSeleccionada['observaciones'] ?? 'Ninguna' }}</p>
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