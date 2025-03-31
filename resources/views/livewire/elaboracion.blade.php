<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
    <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">
      <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4 px-4">Gestión de Elaboraciones</h6>

      <!-- Botón + buscador -->
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

      <!-- Tabla -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
            <tr>
              <th class="px-4 py-2">Fecha</th>
              <th class="px-4 py-2">Encargado</th>
              <th class="px-4 py-2">Entrada</th>
              <th class="px-4 py-2">Salida</th>
              <th class="px-4 py-2">Observaciones</th>
              <th class="w-40 text-right p-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($elaboraciones as $elaboracion)
              <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="px-4 py-2">{{ $elaboracion->fecha_elaboracion }}</td>
                <td class="px-4 py-2">{{ $elaboracion->personal->nombre }}</td>
                <td class="px-4 py-2">{{ $elaboracion->cantidad_entrada }} Preformas</td>
                <td class="px-4 py-2">{{ $elaboracion->cantidad_salida ?? 'Pendiente' }} Bases</td>
                <td class="px-4 py-2">{{ $elaboracion->observaciones ?? '---' }}</td>
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
                <td colspan="6" class="text-center py-4 text-gray-600 dark:text-gray-400">No se registraron procesos de elaboración.</td>
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
    @include('livewire.elaboracions-modal')
  @endif
</div>
