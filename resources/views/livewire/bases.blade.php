<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      {{-- Título adaptado para Bases --}}
      <h6 class="text-center text-xl font-bold mb-4 px-4 p-text">Gestión de Bases</h6>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
        {{-- Botón adaptado para Bases --}}
        <button title="Registrar Base" wire:click='abrirModal("create")' class="boton-g p-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5v14m7-7h-14" />
          </svg>
        </button>
        {{-- Buscador: Busca por capacidad o preforma asociada --}}
        <input type="text" wire:model.live="search" placeholder="Buscar por Capacidad o Preforma..." class="input-g" />
      </div>


      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right">
          <thead class="text-x uppercase color-bg">
            <tr>
              {{-- Cabecera de Acciones --}}
              <th scope="col" class="w-40 rounded-s-lg text-center p-2 p-text">Acciones</th>
              {{-- Cabecera adaptada para Bases --}}
              <th scope="col" class="px-6 py-3 text-center p-text">Capacidad / Preforma / Stock</th>
              {{-- Puedes añadir más cabeceras si necesitas mostrar más datos directamente en la tabla --}}
              {{-- <th scope="col" class="px-6 py-3 text-center p-text rounded-e-lg">Estado</th> --}}
            </tr>
          </thead>
          <tbody>
            {{-- Loop adaptado para $bases --}}
            @forelse ($bases as $base)
            <tr class="color-bg">
              <td class="color-bg w-40 text-center p-2">
                <div class="flex justify-center space-x-2">
                  {{-- Botón de edición adaptado --}}
                  <button title="Editar Base" class="boton-g p-text"
                    wire:click="abrirModal('edit', {{ $base->id }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                      <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                      <path d="M16 5l3 3" />
                    </svg>
                  </button>

                  {{-- Botón de detalles adaptado --}}
                  <button title="Ver detalles" class="boton-g p-text" wire:click="modaldetalle({{ $base->id }})">
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
              {{-- Columna de datos adaptada para Bases --}}
              <td class="px-6 py-4 text-center p-text">
                  <strong>Capacidad:</strong> {{ $base->capacidad }} ml<br>
                  <strong>Preforma:</strong> {{ $base->preforma ? $base->preforma->insumo : 'N/A' }} <br>
                  <hr class="my-1 border-gray-500">
                  {{-- Mostrar existencias (igual que en preformas) --}}
                  @if ($base->existencias->count() > 0)
                      @foreach ($base->existencias as $existencia)
                          {{$existencia->sucursal->nombre ?? 'Sucursal Desconocida' }} : {{ number_format($existencia->cantidad) }} <br>
                      @endforeach
                      <strong class="p-text">Total Stock: {{ number_format($base->existencias->sum('cantidad')) }}</strong>
                  @else
                      <span class="text-xs text-gray-500">Sin stock registrado</span>
                  @endif
              </td>
              {{-- Puedes añadir más columnas si es necesario, por ejemplo, el estado --}}
              {{-- <td class="px-6 py-4 text-center p-text">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $base->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                      {{ $base->estado ? 'Activo' : 'Inactivo' }}
                  </span>
              </td> --}}
            </tr>
          {{-- Mensaje si no hay bases --}}
          @empty
          <tr>
            <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay bases registradas.
            </td>
            {{-- Ajusta el colspan si añadiste más columnas a la tabla --}}
          </tr>
        @endforelse
          </tbody>
        </table>
      </div>
      {{-- Paginación adaptada --}}
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
            <h3 class="title3">
              {{-- Título del modal adaptado --}}
              {{ $accion === 'create' ? 'Registrar Base' : 'Editar Base' }}
            </h3>
            <div class="over-col">

              {{-- Campo Capacidad --}}
              <h3 class="title3">Capacidad (ml)</h3>
              <input type="number" wire:model="capacidad" class="p-text input-g" min="0" />
              @error('capacidad') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

              {{-- Campo Preforma Asociada (Dropdown) --}}
              <h3 class="title3">Preforma Asociada (Opcional)</h3>
              <select wire:model="preforma_id" class="p-text input-g">
                  <option value="">-- Ninguna --</option>
                  @foreach($todasLasPreformas as $preforma)
                      <option value="{{ $preforma->id }}">{{ $preforma->insumo }} [{{ $preforma->capacidad }}ml - {{ $preforma->color }}]</option>
                  @endforeach
              </select>
              @error('preforma_id') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

              {{-- Campo Estado --}}
              <h3 class="title3">Estado</h3>
              <select wire:model="estado" class="p-text input-g">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
              @error('estado') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

              {{-- Campo Observaciones --}}
              <h3 class="title3">Observaciones</h3>
              <textarea wire:model="observaciones" class="p-text input-g" rows="3"></textarea>
              @error('observaciones') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

              {{-- Falta campo para 'imagen' si se requiere --}}

            </div>
            <div class="mt-6 flex justify-center w-full space-x-4">
              {{-- Botón Guardar --}}
              <button type="button" wire:click="guardar" class="boton-g">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                  <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M14 4l0 4l-6 0l0 -4" />
                </svg>
              </button>
              {{-- Botón Cerrar Modal --}}
              <button type="button" wire:click="cerrarModal" class="boton-g">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                  class="icon icon-tabler icons-tabler-filled icon-tabler-square-x">
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

  @if ($modalDetalle && $baseSeleccionada)
    <div class="modal-first">
      <div class="modal-center">
        <div class="modal-hiden">
          <div class="center-col">
            {{-- Título modal detalles --}}
            <h3 class="p-text text-lg font-semibold mb-4">Detalles de la Base</h3>
            <div class="over-col text-left space-y-2">
              {{-- Detalles de la Base --}}
              <p class="title3"><strong class="p-text">ID:</strong> {{ $baseSeleccionada->id }}</p>
              <p class="title3"><strong class="p-text">Capacidad:</strong> {{ $baseSeleccionada->capacidad }} ml</p>
              {{-- Mostrar preforma asociada --}}
              <p class="title3"><strong class="p-text">Preforma Asociada:</strong> {{ $baseSeleccionada->preforma ? $baseSeleccionada->preforma->insumo . ' [' . $baseSeleccionada->preforma->capacidad . 'ml]' : 'Ninguna' }}</p>
              <p class="title3"><strong class="p-text">Estado:</strong>
                <span class="font-semibold {{ $baseSeleccionada->estado ? 'text-green-600' : 'text-red-600' }}">
                  {{ $baseSeleccionada->estado ? 'Activo' : 'Inactivo' }}
                </span>
              </p>
              <p class="title3"><strong class="p-text">Observaciones:</strong> {{ $baseSeleccionada->observaciones ?: 'N/A' }}</p>
              <p class="title3"><strong class="p-text">Fecha Creación:</strong> {{ $baseSeleccionada->created_at->format('d/m/Y H:i') }}</p>
              <p class="title3"><strong class="p-text">Última Modificación:</strong> {{ $baseSeleccionada->updated_at->format('d/m/Y H:i') }}</p>
              {{-- Detalles de la imagen si se implementa --}}
              {{-- <p class="title3"><strong class="p-text">Imagen:</strong> {{ $baseSeleccionada->imagen ?: 'No asignada' }}</p> --}}
            </div>
            <div class="mt-6 flex justify-center w-full">
              {{-- Botón Cerrar Modal Detalles --}}
              <button type="button" wire:click="cerrarModalDetalle" class="boton-g color-bg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                  class="icon icon-tabler icons-tabler-filled icon-tabler-square-x">
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