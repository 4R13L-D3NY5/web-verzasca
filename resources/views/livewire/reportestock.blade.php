<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">Reporte de Movimiento de Inventario</h6>

      <!-- Date Filters -->
      <div class="flex justify-center items-center gap-4 w-full max-w-2xl mx-auto mb-4">
        <input type="date" wire:model.live="fechaInicio" class="input-g w-auto sm:w-64" />
        <input type="date" wire:model.live="fechaFinal" class="input-g w-auto sm:w-64" />
      </div>

      <!-- Initial and Final Quantities -->
      <div class="mb-4 p-4 bg-gray-100 rounded-lg">
        <h6 class="text-lg font-semibold">Cantidades Iniciales y Finales (Periodo: {{ $fechaInicio }} a {{ $fechaFinal }})</h6>
        <div class="grid grid-cols-2 gap-4 mt-2">
          <div>Preformas: Inicial: {{ $initialPreformas }} - Final: {{ $finalPreformas }}</div>
          <div>Bases: Inicial: {{ $initialBases }} - Final: {{ $finalBases }}</div>
          <div>Tapas: Inicial: {{ $initialTapas }} - Final: {{ $finalTapas }}</div>
          <div>Productos: Inicial: {{ $initialProductos }} - Final: {{ $finalProductos }}</div>
          <div>Etiquetas: Inicial: {{ $initialEtiquetas }} - Final: {{ $finalEtiquetas }}</div>
          <div>Stocks: Inicial: {{ $initialStocks }} - Final: {{ $finalStocks }}</div>
        </div>
      </div>

      <!-- Tables for Each Process (Based on Existencias) -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <h6 class="text-lg font-semibold mb-2">Proceso de Soplado</h6>
        <table class="w-full text-sm text-left border border-slate-200 rounded-lg border-collapse">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th class="px-6 py-3 p-text">Preforma</th>
              <th class="px-6 py-3 p-text">Cant. Entrada</th>
              <th class="px-6 py-3 p-text">Merma</th>
              <th class="px-6 py-3 p-text">Base (Salida)</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($existenciasPreformas as $existencia)
              <tr class="color-bg border border-slate-200">
                <td class="px-6 py-4">{{ $existencia->existenciable->insumo ?? 'N/A' }}</td> <!-- Usamos insumo para Preforma -->
                <td class="px-6 py-4">{{ $existencia->cantidad }}</td>
                <td class="px-6 py-4">0</td> <!-- Merma no disponible -->
                <td class="px-6 py-4">{{ $existencia->existenciable->base->insumo ?? 'N/A' }}</td> <!-- Relación aproximada -->
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-4 text-gray-600">No hay movimientos de soplado.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <h6 class="text-lg font-semibold mb-2">Proceso de Embotellado</h6>
        <table class="w-full text-sm text-left border border-slate-200 rounded-lg border-collapse">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th class="px-6 py-3 p-text">Base</th>
              <th class="px-6 py-3 p-text">Cant. Entrada</th>
              <th class="px-6 py-3 p-text">Merma</th>
              <th class="px-6 py-3 p-text">Tapa</th>
              <th class="px-6 py-3 p-text">Cant.</th>
              <th class="px-6 py-3 p-text">Merma</th>
              <th class="px-6 py-3 p-text">Producto (Salida)</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($existenciasBases as $existencia)
              <tr class="color-bg border border-slate-200">
                <td class="px-6 py-4">{{ $existencia->existenciable->insumo ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $existencia->cantidad }}</td>
                <td class="px-6 py-4">0</td>
                <td class="px-6 py-4">{{ $existencia->existenciable->tapa->insumo ?? 'N/A' }}</td>
                <td class="px-6 py-4">0</td> <!-- Cantidad tapa no disponible -->
                <td class="px-6 py-4">0</td>
                <td class="px-6 py-4">{{ $existencia->existenciable->producto->insumo ?? 'N/A' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-gray-600">No hay movimientos de embotellado.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <h6 class="text-lg font-semibold mb-2">Proceso de Etiquetado</h6>
        <table class="w-full text-sm text-left border border-slate-200 rounded-lg border-collapse">
          <thead class="text-x uppercase color-bg">
            <tr>
              <th class="px-6 py-3 p-text">Producto</th>
              <th class="px-6 py-3 p-text">Cant. Entrada</th>
              <th class="px-6 py-3 p-text">Merma</th>
              <th class="px-6 py-3 p-text">Etiqueta</th>
              <th class="px-6 py-3 p-text">Cant.</th>
              <th class="px-6 py-3 p-text">Merma</th>
              <th class="px-6 py-3 p-text">Stock (Salida)</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($existenciasProductos as $existencia)
              <tr class="color-bg border border-slate-200">
                <td class="px-6 py-4">{{ $existencia->existenciable->insumo ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $existencia->cantidad }}</td>
                <td class="px-6 py-4">0</td>
                <td class="px-6 py-4">{{ $existencia->existenciable->etiqueta->insumo ?? 'N/A' }}</td>
                <td class="px-6 py-4">0</td>
                <td class="px-6 py-4">0</td>
                <td class="px-6 py-4">{{ $existencia->existenciable->stock->insumo ?? 'N/A' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-gray-600">No hay movimientos de etiquetado.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>