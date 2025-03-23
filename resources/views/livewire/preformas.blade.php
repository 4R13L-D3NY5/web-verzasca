<div class="p-6 bg-white shadow-md rounded-lg max-w-7xl mx-auto">
  <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Lista de Preformas</h2>
    <button wire:click="abrirModal" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 sm:mt-0">Agregar
      Preforma</button>
  </div>

  @if(session()->has('message'))
    <div class="bg-green-200 text-green-800 p-2 rounded mb-2">
    {{ session('message') }}
    </div>
  @endif

  <div class="overflow-x-auto">
    <table class="w-full border-collapse border border-gray-300 text-sm">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="border px-4 py-2">Insumo</th>
          <th class="border px-4 py-2">Capacidad</th>
          <th class="border px-4 py-2">Color</th>
          <th class="border px-4 py-2">Cantidad</th>
          <th class="border px-4 py-2">Estado</th>
          <th class="border px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($preformas as $preforma)
      <tr class="hover:bg-gray-50">
        <td class="border px-4 py-2">{{ $preforma->insumo }}</td>
        <td class="border px-4 py-2">{{ $preforma->capacidad }}</td>
        <td class="border px-4 py-2">{{ $preforma->color }}</td>
        <td class="border px-4 py-2">{{ $preforma->cantidad }}</td>
        <td class="border px-4 py-2">
        <span class="{{ $preforma->estado ? 'text-green-600' : 'text-red-600' }}">
          {{ $preforma->estado ? 'Activo' : 'Inactivo' }}
        </span>
        </td>
        <td class="border px-4 py-2">
        <button wire:click="editar({{ $preforma->id }})"
          class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
        </td>
      </tr>
    @endforeach
      </tbody>
    </table>
  </div>

  @if($modal)
    <!-- Fondo Oscuro (NO cierra al hacer clic fuera) -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Modal (Siempre por encima del header) -->
    <div class="fixed inset-0 flex items-center justify-center p-4 z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
      <div class="p-6 max-h-[80vh] overflow-y-auto">
      <h2 class="text-xl font-bold mb-4">{{ $preforma_id ? 'Editar Preforma' : 'Nueva Preforma' }}</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
        <label class="block">Insumo:</label>
        <input type="text" wire:model="insumo" class="w-full border p-2 rounded">
        </div>
        <div>
        <label class="block">Capacidad:</label>
        <input type="number" wire:model="capacidad" class="w-full border p-2 rounded">
        </div>
        <div>
        <label class="block">Color:</label>
        <input type="text" wire:model="color" class="w-full border p-2 rounded">
        </div>
        <div>
        <label class="block">Cantidad:</label>
        <input type="number" wire:model="cantidad" class="w-full border p-2 rounded">
        </div>
        <div class="col-span-2">
        <label class="block">Descripción:</label>
        <textarea wire:model="descripcion" class="w-full border p-2 rounded"></textarea>
        </div>
        <div class="col-span-2">
        <label class="block">Estado:</label>
        <select wire:model="estado" class="w-full border p-2 rounded">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
        </div>
        <div class="col-span-2">
        <label class="block">Observaciones:</label>
        <textarea wire:model="observaciones" class="w-full border p-2 rounded"></textarea>
        </div>
      </div>
      </div>

      <!-- Botones (Siempre visibles abajo) -->
      <div class="p-4 bg-gray-100 flex justify-end">
      <button wire:click="cerrarModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
      <button wire:click="guardar" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
      </div>
    </div>
    </div>
  @endif
</div>