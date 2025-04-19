<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Gestión de Stocks</h6>

      <!-- Botón de registro y buscador -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto">
        <button title="Registrar Stock" wire:click='abrirModal("create")'
          class="text-emerald-500 hover:text-emerald-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5v14m7-7H5" />
          </svg>
        </button>

        <input type="text" wire:model.live="search" placeholder="Buscar producto..." class="input-g w-auto sm:w-64" />
      </div>

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left border border-slate-200 dark:border-cyan-200 rounded-lg border-collapse">
          <thead class="text-xs md:text-sm uppercase color-bg">
            <tr class="bg-gray-100 dark:bg-gray-800">
              <th scope="col" class="px-4 py-3 p-text text-left">DETALLES DEL PRODUCTO</th>
              <th scope="col" class="px-4 py-3 p-text text-left">STOCK Y SUCURSAL</th>
              <th scope="col" class="px-4 py-3 p-text text-right">ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($stocks as $stock)
            <tr class="color-bg border border-slate-200">
              <!-- Columna 1: Imagen + Info del producto -->
              <td class="px-4 py-4 text-left p-text align-top">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                  <div class="mb-2 sm:mb-0">
                    @if($stock->producto->imagen)
                    <img src="{{ asset('storage/' . $stock->producto->imagen) }}" alt="Producto"
                      class="h-20 w-20 sm:h-24 sm:w-24 object-cover rounded">
                    @else
                    <span class="text-xs text-gray-500">Sin imagen</span>
                    @endif
                  </div>
                  <div class="space-y-1 text-sm">
                    <div><strong>Producto:</strong> {{ $stock->producto->nombre ?? 'N/A' }}</div>
                    <div><strong>Observaciones:</strong> {{ Str::limit($stock->observaciones ?? 'Ninguna', 20, '...') }}</div>
                  </div>
                </div>
              </td>

              <!-- Columna 2: Existencias + Sucursales -->
              <td class="px-4 py-4 text-left align-top text-sm">
                <strong class="block mb-1">Sucursal:</strong>
                @forelse ($stock->existencias as $existencia)
                <span class="block">
                  {{ number_format($existencia->cantidad) }}:
                  {{ Str::limit($existencia->sucursal->nombre ?? 'Sucursal Desconocida', 18, '...') }}
                </span>
                @empty
                <span class="text-xs text-gray-500">Sin existencias registradas</span>
                @endforelse
                <strong class="p-text block mt-2">
                  {{ number_format($stock->existencias->sum('cantidad')) }}: Total existencias
                </strong>
              </td>

              <!-- Columna 3: Botones -->
              <td class="px-4 py-4 text-right align-middle">
                <div class="flex justify-end space-x-2">
                  <!-- Editar -->
                  <button title="Editar Stock" wire:click="abrirModal('edit', {{ $stock->id }})"
                    class="text-blue-500 hover:text-blue-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icon-tabler-edit">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                      <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                      <path d="M16 5l3 3" />
                    </svg>
                  </button>

                  <!-- Detalles -->
                  <button title="Ver detalles" wire:click="modaldetalle({{ $stock->id }})"
                    class="text-yellow-500 hover:text-yellow-600 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
              <td colspan="3" class="text-center py-4 text-gray-600 dark:text-gray-400 text-sm">
                No hay stocks registrados.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>


      <div class="mt-4 flex justify-center">
        {{ $stocks->links() }}
      </div>
    </div>
  </div>
  @if ($modal)
  <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
        <div class="center-col">
          <h3 class="p-text">
            {{ $accion === 'create' ? 'Registrar Stock' : 'Editar Stock' }}
          </h3>

          <div class="over-col">

            <h3 class="p-text">Producto</h3>
            <select wire:model="producto_id" class="p-text input-g">
              <option value="">Selecciona un producto</option>
              @foreach ($productos as $producto)
              <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
              @endforeach
            </select>
            @error('producto_id') <span class="error-message text-red-500">{{ $message }}</span> @enderror

            <h3 class="p-text">Etiqueta/capacidad</h3>
            <select wire:model="etiqueta_id" class="p-text input-g">
              <option value="">Sin etiqueta</option>
              @foreach ($etiquetas as $etiqueta)
              <option value="{{ $etiqueta->id }}">{{ $etiqueta->capacidad }}- ml</option>
              @endforeach
            </select>
            @error('etiqueta_id') <span class="error-message text-red-500">{{ $message }}</span> @enderror

            <div>
              <h3 class="p-text">Fecha de Elaboración</h3>
              <div class="flex items-center space-x-2">
                <input type="text" wire:model="fechaElaboracion" placeholder="YYYY-MM-DD"
                  class="p-text input-g w-full" />
                <button type="button" wire:click="setFechaActualElaboracion"
                  class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-lg text-sm">
                  Ahora
                </button>
              </div>
              @error('fechaElaboracion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
              <h3 class="p-text">Fecha de Vencimiento</h3>
              <div class="flex items-center space-x-2">
                <input type="text" wire:model="fechaVencimiento" placeholder="YYYY-MM-DD"
                  class="p-text input-g w-full" />
                <button type="button" wire:click="setFechaActualVencimiento"
                  class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-lg text-sm">
                  Ahora
                </button>
              </div>
              @error('fechaVencimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <h3 class="p-text">Observaciones</h3>
            <input wire:model="observaciones" class="p-text input-g" rows="2"></input>
            @error('observaciones') <span class="error-message text-red-500">{{ $message }}</span> @enderror
          </div>

          <div class="mt-6 flex justify-center w-full space-x-4">
            <button type="button" wire:click="guardar"
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
  @if ($modalDetalle)
  <div class="modal-first">
    <div class="modal-center">
      <div class="modal-hiden">
        <div class="center-col">
          <h3 class="text-base font-semibold p-text" id="modal-title">Detalles del Stock</h3>
          <div class="mt-4">
            <dl class="grid grid-cols-2 gap-4">
              <!-- Producto -->
              <div>
                <dt class="text-sm font-semibold p-text">Producto</dt>
                <dd class="mt-1 text-sm p-text">
                  {{ $stockSeleccionado->producto->nombre ?? 'No especificado' }}
                </dd>
              </div>

              <!-- Etiqueta -->
              <div>
                <dt class="text-sm font-semibold p-text">Etiqueta/capacidad</dt>
                <dd class="mt-1 text-sm p-text">
                  {{ $stockSeleccionado->etiqueta->capacidad ?? 'No especificada' }}
                </dd>
              </div>

              <!-- Fecha de elaboración -->
              <div>
                <dt class="text-sm font-semibold p-text">Fecha de elaboración</dt>
                <dd class="mt-1 text-sm p-text">
                  {{ $stockSeleccionado->fechaElaboracion ?? 'No especificada' }}
                </dd>
              </div>

              <!-- Fecha de vencimiento -->
              <div>
                <dt class="text-sm font-semibold p-text">Fecha de vencimiento</dt>
                <dd class="mt-1 text-sm p-text">
                  {{ $stockSeleccionado->fechaVencimiento ?? 'No especificada' }}
                </dd>
              </div>

              <!-- Observaciones -->
              <div class="col-span-2">
                <dt class="text-sm font-semibold p-text">Observaciones</dt>
                <dd class="mt-1 text-sm p-text">
                  {{ $stockSeleccionado->observaciones ?? 'Ninguna' }}
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