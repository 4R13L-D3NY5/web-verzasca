<div class="p-text p-2 mt-10 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
        <div>
            <h2 class="text-2xl font-bold p-text mb-4">Reporte de Stock</h2>
            <p class="text-gray-700 p-text mb-4">Fecha de impresión: {{ $fecha }}</p>

            <div class="mt-3 flex justify-center gap-2 mb-6">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Imprimir
                </button>
                <a href="{{ route('reportestock.pdf') }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-block text-center">
                    Descargar PDF
                </a>
            </div>

            <div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left border border-slate-200 rounded-lg border-collapse">
                    <thead class="text-x uppercase color-bg">
                        <tr>
                            <th class="px-6 py-3 p-text border">Producto</th>
                            <th class="px-6 py-3 p-text border">Etiqueta</th>
                            <th class="px-6 py-3 p-text border">Sucursal</th>
                            <th class="px-6 py-3 p-text border">Cantidad Existencias</th>
                            <th class="px-6 py-3 p-text border">Fecha Elaboración</th>
                            <th class="px-6 py-3 p-text border">Fecha Vencimiento</th>
                            <th class="px-6 py-3 p-text border">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            <tr class="color-bg border border-slate-200">
                                <td class="px-6 py-4 p-text border">{{ $stock->producto?->nombre ?? 'Sin producto' }}</td>
                                <td class="px-6 py-4 p-text border">{{ $stock->etiqueta?->descripcion ?? 'Sin etiqueta' }}</td>
                                <td class="px-6 py-4 p-text border">{{ $stock->sucursal?->nombre ?? 'Sin sucursal' }}</td>
                                <td class="px-6 py-4 p-text border">{{ $stock->existencias->count() }}</td>
                                <td class="px-6 py-4 p-text border">{{ $stock->fechaElaboracion ? \Carbon\Carbon::parse($stock->fechaElaboracion)->format('d/m/Y') : '-' }}</td>
                                <td class="px-6 py-4 p-text border">{{ $stock->fechaVencimiento ? \Carbon\Carbon::parse($stock->fechaVencimiento)->format('d/m/Y') : '-' }}</td>
                                <td class="px-6 py-4 p-text border">{{ $stock->observaciones ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
