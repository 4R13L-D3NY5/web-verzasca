<div class="p-6 bg-white shadow-md rounded-lg max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Lista de Productos</h2>
        <button wire:click="abrirModal" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 sm:mt-0">Agregar Producto</button>
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
                    <th class="border px-4 py-2">Nombre</th>
                    <th class="border px-4 py-2">Imagen</th>
                    <th class="border px-4 py-2">Tipo</th>
                    <th class="border px-4 py-2">Capacidad</th>
                    <th class="border px-4 py-2">Precio</th>
                    <th class="border px-4 py-2">Estado</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                        <td class="border px-4 py-2">
                            @if ($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="h-10">
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $producto->tipoContenido }}</td>
                        <td class="border px-4 py-2">{{ $producto->capacidad }} ml</td>
                        <td class="border px-4 py-2">${{ $producto->precioReferencia }}</td>
                        <td class="border px-4 py-2">
                            <span class="{{ $producto->estado ? 'text-green-600' : 'text-red-600' }}">
                                {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">
                            <button wire:click="editar({{ $producto->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
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
                    <h2 class="text-xl font-bold mb-4">{{ $producto_id ? 'Editar Producto' : 'Nuevo Producto' }}</h2>

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Campos del formulario -->
                        <div>
                            <label class="block">Nombre:</label>
                            <input type="text" wire:model="nombre" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="block">Imagen:</label>
                            <input type="file" wire:model="imagen" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="block">Tipo de Contenido:</label>
                            <input type="number" wire:model="tipoContenido" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="block">Tipo de Producto:</label>
                            <select wire:model="tipoProducto" class="w-full border p-2 rounded">
                                <option value="0">Sin Retorno</option>
                                <option value="1">Con Retorno</option>
                            </select>
                        </div>
                        <div>
                            <label class="block">Capacidad:</label>
                            <input type="number" wire:model="capacidad" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="block">Precio de Referencia:</label>
                            <input type="number" step="0.01" wire:model="precioReferencia" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="block">Base:</label>
                            <select wire:model="base_id" class="w-full border p-2 rounded">
                                <option value="">Seleccione una base</option>
                                @foreach ($bases as $base)
                                    <option value="{{ $base->id }}">{{ $base->capacidad }} ml</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block">Tapa:</label>
                            <select wire:model="tapa_id" class="w-full border p-2 rounded">
                                <option value="">Seleccione una tapa</option>
                                @foreach ($tapas as $tapa)
                                    <option value="{{ $tapa->id }}">{{ $tapa->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block">Observaciones:</label>
                            <textarea wire:model="observaciones" class="w-full border p-2 rounded"></textarea>
                        </div>
                        <div class="col-span-1">
                            <label class="block">Estado:</label>
                            <select wire:model="estado" class="w-full border p-2 rounded">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
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
