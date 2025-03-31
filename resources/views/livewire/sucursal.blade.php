<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
      <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">
        <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Sucursales</h6>
  
        <div class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
          <button title="Registrar sucursal" wire:click='abrirModal("create")' class="group cursor-pointer outline-none hover:rotate-90 duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
              <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke-width="1.5"></path>
              <path d="M8 12H16" stroke-width="1.5"></path>
              <path d="M12 16V8" stroke-width="1.5"></path>
            </svg>
          </button>
          <input type="text" wire:model.live="search" placeholder="Buscar..." class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
        </div>
  
        <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
              <tr>
                <th class="px-6 py-3">Información</th>
                <th class="px-6 py-3">Empresa</th>
                <th class="w-40 text-right p-2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($sucursales as $sucursal)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                  <td class="px-6 py-4 font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800">
                    <div class="flex flex-col">
                      <span>{{ $sucursal->nombre }}</span>
                      <span class="text-gray-500 dark:text-gray-400 text-xs">{{ $sucursal->direccion }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">{{ $sucursal->empresa->nombre ?? 'N/A' }}</td>
                  <td class="bg-gray-50 dark:bg-gray-800 w-40 text-right p-2">
                    <div class="flex justify-end">
                      <button wire:click="editarSucursal({{ $sucursal->id }})" class="text-gray-600 hover:text-gray-800 mx-1 transition-all duration-200 ease-in-out hover:rotate-12 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.121 2.121 0 113 3L7.5 18.85 3 20l1.15-4.5L16.862 3.487z" />
                        </svg>
                      </button>
                      <button wire:click="verDetalle({{ $sucursal->id }})" class="text-blue-500 hover:text-blue-600 mx-1 transition-transform duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center py-4 text-gray-600 dark:text-gray-400">No hay sucursales registradas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
  
        <div class="mt-4 flex justify-center">
          {{ $sucursales->links() }}
        </div>
      </div>
    </div>
  
    @if ($modal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
          {{ $accion === 'create' ? 'Registrar Sucursal' : 'Editar Sucursal' }}
        </h2>
  
        <div class="space-y-4">
          <div>
            <label class="label1">Nombre</label>
            <input type="text" wire:model.defer="nombre" class="input1">
            @error('nombre') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
  
          <div>
            <label class="label1">Dirección</label>
            <input type="text" wire:model.defer="direccion" class="input1">
            @error('direccion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
  
          <div>
            <label class="label1">Teléfono</label>
            <input type="text" wire:model.defer="telefono" class="input1">
            @error('telefono') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
  
          <div>
            <label class="label1">Zona</label>
            <input type="text" wire:model.defer="zona" class="input1">
            @error('zona') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
  
          <div>
            <label class="label1">Empresa</label>
            <select wire:model.defer="empresa_id" class="select1">
              <option value="">Seleccione una empresa</option>
              @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
              @endforeach
            </select>
            @error('empresa_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
        </div>
  
        <div class="mt-6 flex justify-end space-x-2">
          <button wire:click="guardarSucursal" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">Guardar</button>
          <button wire:click="cerrarModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
        </div>
      </div>
    </div>
    @endif
  </div>