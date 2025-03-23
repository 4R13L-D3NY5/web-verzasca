<div class="p-6 bg-white shadow-md rounded-lg max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Lista de Stocks</h2>
        <button wire:click="abrirModal" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 sm:mt-0">Agregar Stock</button>
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
                    <th class="border px-4 py-2">Producto</th>
                    <th class="border px-4 py-2">Etiqueta</th>
                    <th class="border px-4 py-2">Fecha de Elaboración</th>
                    <th class="border px-4 py-2">Fecha de Vencimiento</th>
                    <th class="border px-4 py-2">Observaciones</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $stock->producto->nombre }}</td>
                        <td class="border px-4 py-2">{{ $stock->etiqueta ? $stock->etiqueta->nombre : 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $stock->fechaElaboracion }}</td>
                        <td class="border px-4 py-2">{{ $stock->fechaVencimiento }}</td>
                        <td class="border px-4 py-2">{{ $stock->observaciones }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="editar({{ $stock->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
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
                    <h2 class="text-xl font-bold mb-4">{{ $stock_id ? 'Editar Stock' : 'Nuevo Stock' }}</h2>

                    <!-- Grilla de una sola columna -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block">Producto:</label>
                            <select wire:model="producto_id" class="w-full border p-2 rounded">
                                <option value="">Seleccionar Producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block">Etiqueta:</label>
                            <select wire:model="etiqueta_id" class="w-full border p-2 rounded">
                                <option value="">Seleccionar Etiqueta</option>
                                @foreach($etiquetas as $etiqueta)
                                    <option value="{{ $etiqueta->id }}">{{ $etiqueta->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block">Fecha de Elaboración:</label>
                            <input type="date" wire:model="fechaElaboracion" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="block">Fecha de Vencimiento:</label>
                            <input type="date" wire:model="fechaVencimiento" class="w-full border p-2 rounded">
                        </div>
                        <div>
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
