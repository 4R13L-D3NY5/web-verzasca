<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
      <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">
        <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Elaboraciones</h6>
  
        <div class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
          <button title="Registrar elaboración" wire:click='abrirModal' class="group cursor-pointer outline-none hover:rotate-90 duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
              <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke-width="1.5"></path>
              <path d="M8 12H16" stroke-width="1.5"></path>
              <path d="M12 16V8" stroke-width="1.5"></path>
            </svg>
          </button>
          <input type="text" wire:model.live="search" placeholder="Buscar por fecha o encargado..." class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
        </div>
  
        <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
              <tr>
                <th class="px-6 py-3">Información</th>
                <th class="w-40 text-right p-2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($elaboraciones as $elaboracion)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                  <td class="px-6 py-4 font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800">
                    <div class="flex flex-col">
                      <span>{{ $elaboracion->fecha_elaboracion }} - {{ $elaboracion->personal->nombre }}</span>
                      <span class="text-gray-500 dark:text-gray-400 text-xs">
                        Entrada: {{ $elaboracion->cantidad_entrada }} | Salida: {{ $elaboracion->cantidad_salida ?? 'Pendiente' }}
                      </span>
                      @if ($elaboracion->observaciones)
                        <span class="text-xs italic text-gray-400 dark:text-gray-500">{{ $elaboracion->observaciones }}</span>
                      @endif
                    </div>
                  </td>
                  <td class="bg-gray-50 dark:bg-gray-800 w-40 text-right p-2">
                    <div class="flex justify-end">
                      <button wire:click="editar({{ $elaboracion->id }})" class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.121 2.121 0 113 3L7.5 18.85 3 20l1.15-4.5L16.862 3.487z" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="2" class="text-center py-4 text-gray-600 dark:text-gray-400">No se registraron procesos de elaboración.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
  
        <div class="mt-4 flex justify-center">
          {{ $elaboraciones->links() }}
        </div>
      </div>
    </div>
  
    @if($modal)
      <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl mx-4 p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {{ $accion === 'create' ? 'Registrar Elaboración' : 'Editar Elaboración' }}
          </h2>
  
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="label1">Fecha de Elaboración</label>
              <input type="date" wire:model.defer="fecha_elaboracion" class="input1">
              @error('fecha_elaboracion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Encargado</label>
              <select wire:model.defer="personal_id" class="select1">
                <option value="">Seleccione</option>
                @foreach($personales as $personal)
                  <option value="{{ $personal->id }}">{{ $personal->nombre }}</option>
                @endforeach
              </select>
              @error('personal_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Existencia Entrada (Preformas)</label>
              <select wire:model.defer="existencia_entrada_id" class="select1">
                <option value="">Seleccione</option>
                @foreach($existencias_preforma as $existencia)
                  <option value="{{ $existencia->id }}">ID #{{ $existencia->id }} - {{ $existencia->descripcion ?? 'Preforma' }}</option>
                @endforeach
              </select>
              @error('existencia_entrada_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Cantidad Entrada</label>
              <input type="number" wire:model.defer="cantidad_entrada" class="input1">
              @error('cantidad_entrada') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Cantidad Salida (Bases)</label>
              <input type="number" wire:model.defer="cantidad_salida" class="input1">
              @error('cantidad_salida') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div class="md:col-span-2">
              <label class="label1">Observaciones</label>
              <textarea wire:model.defer="observaciones" class="input1"></textarea>
              @error('observaciones') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
          </div>
  
          <div class="mt-6 flex justify-end space-x-2">
            <button wire:click="guardar" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">Guardar</button>
            <button wire:click="cerrarModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
          </div>
        </div>
      </div>
    @endif
  </div>