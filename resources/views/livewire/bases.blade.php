<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Bases</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
        <button title="Registrar Base" wire:click='abrirModal("create")'
          class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5v14m7-7h-14" />
          </svg>
        </button>

        <input type="text" wire:model.live="search" placeholder="Buscar por capacidad o preforma..."
          class="input-g w-auto sm:w-64" />
      </div>

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left border border-slate-200 dark:border-cyan-200 rounded-lg border-collapse">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th scope="col" class="px-6 py-3 p-text text-left">BASE</th>
              <th scope="col" class="px-6 py-3 p-text text-right">OPCIONES</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($bases as $base)
            <tr class="color-bg border border-slate-200">
              <td class="px-6 py-4 p-text text-left">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                  <!-- Imagen (si decides incluirla en el futuro) -->
                  <div class="flex justify-center items-center">
                    <img src="{{ asset('images/base-placeholder.png') }}" alt="base"
                      class="h-24 w-24 object-cover rounded">
                  </div>

                  <!-- Información (solo en escritorio) -->
                  <div class="hidden md:block">
                    <div>
                      <span class="font-semibold">Capacidad:</span>
                      <span>{{ $base->capacidad }} {{ $base->unidad }}</span>
                    </div>
                    <div>
                      <span class="font-semibold">Preforma:</span>
                      <span>{{ $base->preforma->insumo ?? 'Sin preforma' }}</span>
                    </div>
                    <div>
                      <span class="font-semibold">Sucursal:</span>
                      @forelse ($base->existencias as $existencia)
                      <span>
                        {{ number_format($existencia->cantidad) }}:
                        {{ Str::limit($existencia->sucursal->nombre ?? 'Sucursal Desconocida', 15, '...') }}
                      </span><br>
                      @empty
                      <span class="text-xs text-gray-500">Sin stock registrado</span>
                      @endforelse

                      <strong class="p-text block mt-1">
                        {{ number_format($base->existencias->sum('cantidad')) }}: Total bases
                      </strong>
                    </div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 text-right">
                <div class="flex justify-end space-x-2">
                  <!-- Editar -->
                  <button title="Editar Base" wire:click="abrirModal('edit', {{ $base->id }})"
                    class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icon-tabler-edit">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                      <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                      <path d="M16 5l3 3" />
                    </svg>
                  </button>

                  <!-- Detalles -->
                  <button title="Ver detalles" wire:click="modaldetalle({{ $base->id }})"
                    class="text-yellow-500 hover:text-yellow-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icon-tabler-eye-plus">
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
                No hay bases registradas.
              </td>
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
          <h3 class="p-text">
            {{-- Título del modal adaptado --}}
            {{ $accion === 'create' ? 'Registrar Base' : 'Editar Base' }}
          </h3>
          <div class="over-col">

            {{-- Campo Capacidad --}}
            <h3 class="p-text">Capacidad (ml)</h3>
            <input type="number" wire:model="capacidad" class="p-text input-g" min="0" />
            @error('capacidad') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

            {{-- Campo Preforma Asociada (Dropdown) --}}
            <h3 class="p-text">Preforma Asociada (Opcional)</h3>
            <select wire:model="preforma_id" class="p-text input-g">
              <option value="">-- Ninguna --</option>
              @foreach($todasLasPreformas as $preforma)
              <option value="{{ $preforma->id }}">{{ $preforma->insumo }} [{{ $preforma->capacidad }}ml -
                {{ $preforma->color }}]
              </option>
              @endforeach
            </select>
            @error('preforma_id') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

            {{-- Campo Estado --}}
            <h3 class="p-text">Estado</h3>
            <select wire:model="estado" class="p-text input-g">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
            @error('estado') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

            {{-- Campo Observaciones --}}
            <h3 class="p-text">Observaciones</h3>
            <input wire:model="observaciones" class="p-text input-g" rows="3"></input>
            @error('observaciones') <span class="error-message text-red-500 text-xs">{{ $message }}</span> @enderror

            {{-- Falta campo para 'imagen' si se requiere --}}

          </div>
          <div class="mt-6 flex justify-center w-full space-x-4">
            {{-- Botón Guardar --}}
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
            {{-- Botón Cerrar Modal --}}
            <button type="button" wire:click="cerrarModal"
              class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
              </svg>
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
          <h3 class="text-base font-semibold p-text">Detalles de la Base</h3>
          <div class="mt-4">
            <dl class="grid grid-cols-2 gap-4">
              <!-- ID -->
              <div>
                <dt class="text-sm font-semibold p-text">ID</dt>
                <dd class="mt-1 text-sm p-text">{{ $baseSeleccionada->id }}</dd>
              </div>

              <!-- Capacidad -->
              <div>
                <dt class="text-sm font-semibold p-text">Capacidad</dt>
                <dd class="mt-1 text-sm p-text">{{ $baseSeleccionada->capacidad }} ml</dd>
              </div>

              <!-- Preforma asociada -->
              <div class="col-span-2">
                <dt class="text-sm font-semibold p-text">Preforma Asociada</dt>
                <dd class="mt-1 text-sm p-text">
                  {{ $baseSeleccionada->preforma ? $baseSeleccionada->preforma->insumo . ' [' .
                  $baseSeleccionada->preforma->capacidad . 'ml]' : 'Ninguna' }}
                </dd>
              </div>

              <!-- Estado -->
              <div>
                <dt class="text-sm font-semibold p-text">Estado</dt>
                <dd class="mt-1 text-sm p-text">
                  @if ($baseSeleccionada->estado)
                  <span
                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-600 text-white">Activo</span>
                  @else
                  <span
                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-red-600 text-white">Inactivo</span>
                  @endif
                </dd>
              </div>

              <!-- Observaciones -->
              <div>
                <dt class="text-sm font-semibold p-text">Observaciones</dt>
                <dd class="mt-1 text-sm p-text">{{ $baseSeleccionada->observaciones ?: 'N/A' }}</dd>
              </div>

              <!-- Fecha creación -->
              <div>
                <dt class="text-sm font-semibold p-text">Fecha Creación</dt>
                <dd class="mt-1 text-sm p-text">{{ $baseSeleccionada->created_at->format('d/m/Y H:i') }}</dd>
              </div>

              <!-- Última modificación -->
              <div>
                <dt class="text-sm font-semibold p-text">Última Modificación</dt>
                <dd class="mt-1 text-sm p-text">{{ $baseSeleccionada->updated_at->format('d/m/Y H:i') }}</dd>
              </div>
            </dl>
          </div>

          <div class="mt-6 flex justify-center w-full">
            <button type="button" wire:click="cerrarModalDetalle"
              class="text-red-500 hover:text-red-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-x">
                <path stroke="none" d="M0 0h24v24H0z" />
                <path d="M18 6L6 18" />
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