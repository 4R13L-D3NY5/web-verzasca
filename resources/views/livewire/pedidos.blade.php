<div class="p-text p-2 mt-10 flex justify-center">
  <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
    <div>
      <h6 class="text-xl font-bold mb-4 px-4 p-text">📦 Control de Stock - Productos Terminados vs Pedidos</h6>

      <!-- Filtros -->
      <div class="flex flex-wrap justify-center items-center gap-4 w-full max-w-3xl mx-auto mb-4">
        <!-- Buscador -->
        <input type="text" wire:model.live="search" placeholder="Buscar por cliente, producto o etiqueta..." 
               class="input-g w-auto sm:w-64" />
        
        <!-- Filtro por sucursal -->
        <select wire:model.live="filtroSucursal" class="input-g w-auto">
          <option value="">Todas las sucursales</option>
          @foreach($sucursales as $sucursal)
            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
          @endforeach
        </select>

        {{-- <!-- Filtro por urgencia -->
        <select wire:model.live="filtroUrgencia" class="input-g w-auto">
          <option value="">Todas las urgencias</option>
          <option value="vencido">🔴 Vencidos</option>
          <option value="urgente">🟠 Urgentes</option>
          <option value="proximo">🟡 Próximos</option>
          <option value="normal">⚪ Normales</option>
        </select> --}}

        <!-- Toggle solo sin stock -->
        <label class="flex items-center cursor-pointer">
          <input type="checkbox" wire:model.live="mostrarSinStock" class="mr-2">
          <span class="text-sm p-text">Solo faltantes</span>
        </label>
      </div>

      <!-- Leyenda -->
      <div class="flex justify-center mb-4">
        <div class="flex flex-wrap gap-4 text-xs bg-gray-100 dark:bg-gray-800 p-2 rounded-lg">
          <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded mr-1"></span>Falta Stock</div>
          <div class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded mr-1"></span>Stock Suficiente</div>
          <div class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded mr-1"></span>Stock en Otras Sucursales</div>
        </div>
      </div>

      <!-- Tabla Principal -->
      <div class="relative mt-3 w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left border border-slate-200 dark:border-cyan-200 rounded-lg border-collapse">
          <thead class="text-xs uppercase color-bg">
            <tr>
              <th scope="col" class="px-4 py-3 p-text text-left">Producto & Etiqueta</th>
              <th scope="col" class="px-4 py-3 p-text text-center">Stock Info</th>
              <th scope="col" class="px-4 py-3 p-text text-center">Pedido Total</th>
              <th scope="col" class="px-4 py-3 p-text text-center">Stock Actual</th>
              <th scope="col" class="px-4 py-3 p-text text-center">Diferencia</th>
              <th scope="col" class="px-4 py-3 p-text text-center">A Producir</th>
              <th scope="col" class="px-4 py-3 p-text text-left">Otras Sucursales</th>
              <th scope="col" class="px-4 py-3 p-text text-center">Urgencia</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($resumenStock as $item)
            <tr class="color-bg border border-slate-200 border-l-4 {{ $this->getUrgenciaColor($item['urgencia']) }}
                     @if($item['necesita_produccion']) bg-red-50 dark:bg-red-900/20 @endif">
              
              <!-- Producto & Etiqueta -->
              <td class="px-4 py-4 p-text text-left">
                <!-- Información del Producto -->
                <div class="font-bold text-blue-600">{{ $item['producto_nombre'] }}</div>
                <div class="text-xs text-gray-600 mb-2">
                  <span class="bg-blue-100 text-blue-800 px-1 rounded">{{ $item['producto_tipo_contenido'] }}</span>
                  <span class="ml-1">{{ $item['producto_capacidad'] }}{{ $item['producto_unidad'] }}</span>
                </div>
                
                <!-- Información de la Etiqueta -->
                <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded text-xs">
                  <div class="font-medium text-purple-600">🏷️ {{ $item['etiqueta_descripcion'] }}</div>
                  <div class="text-gray-600">
                    <span>{{ $item['etiqueta_capacidad'] }} {{ $item['etiqueta_unidad'] }}</span>
                    @if($item['etiqueta_cliente'])
                      <span class="ml-2 text-green-600">👤 {{ $item['etiqueta_cliente'] }}</span>
                    @endif
                  </div>
                </div>
                
                <div class="text-xs text-gray-500 mt-1">📍 {{ $item['sucursal_principal'] }}</div>
                
                <!-- Mostrar pedidos asociados -->
                <div class="mt-2 space-y-1">
                  @foreach($item['pedidos_asociados'] as $pedido)
                    <div class="text-xs bg-yellow-100 dark:bg-yellow-700 p-1 rounded">
                      <span class="font-medium">{{ $pedido['cliente'] }}</span>
                      <span class="text-gray-600">({{ $pedido['cantidad'] }} unidades)</span>
                      @if($pedido['fecha_maxima'])
                        <span class="text-gray-500">- Límite: {{ \Carbon\Carbon::parse($pedido['fecha_maxima'])->format('d/m') }}</span>
                      @endif
                    </div>
                  @endforeach
                </div>
              </td>

              <!-- Stock Info -->
              <td class="px-4 py-4 text-center">
                <div class="text-xs space-y-1">
                  @if($item['fecha_elaboracion'])
                    <div class="bg-green-100 text-green-800 px-2 py-1 rounded">
                      📅 Elab: {{ \Carbon\Carbon::parse($item['fecha_elaboracion'])->format('d/m/Y') }}
                    </div>
                  @endif
                  @if($item['fecha_vencimiento'])
                    <div class="bg-orange-100 text-orange-800 px-2 py-1 rounded">
                      ⏰ Vence: {{ \Carbon\Carbon::parse($item['fecha_vencimiento'])->format('d/m/Y') }}
                    </div>
                  @endif
                  @if($item['observaciones_stock'])
                    <div class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                      📝 {{ Str::limit($item['observaciones_stock'], 20) }}
                    </div>
                  @endif
                </div>
              </td>

              <!-- Pedido Total -->
              <td class="px-4 py-4 text-center">
                <span class="text-lg font-bold p-text">{{ $item['total_pedido'] }}</span>
                <div class="text-xs text-gray-500">unidades</div>
              </td>

              <!-- Stock Actual -->
              <td class="px-4 py-4 text-center">
                <span class="text-lg font-medium p-text 
                  @if($item['stock_disponible'] == 0) text-red-600
                  @elseif($item['stock_disponible'] < $item['total_pedido']) text-yellow-600
                  @else text-green-600 @endif">
                  {{ $item['stock_disponible'] }}
                </span>
                <div class="text-xs text-gray-500">disponible</div>
              </td>

              <!-- Diferencia -->
              <td class="px-4 py-4 text-center">
                <span class="text-lg font-bold
                  @if($item['diferencia'] < 0) text-red-600
                  @elseif($item['diferencia'] == 0) text-yellow-600  
                  @else text-green-600 @endif">
                  {{ $item['diferencia'] > 0 ? '+' : '' }}{{ $item['diferencia'] }}
                </span>
                <div class="text-xs text-gray-500">
                  @if($item['diferencia'] < 0) faltante
                  @elseif($item['diferencia'] == 0) exacto
                  @else excedente @endif
                </div>
              </td>

              <!-- A Producir -->
              <td class="px-4 py-4 text-center">
                @if($item['cantidad_producir'] > 0)
                  <span class="text-xl font-bold text-red-600 bg-red-100 px-3 py-2 rounded-lg">
                    {{ $item['cantidad_producir'] }}
                  </span>
                  <div class="text-xs text-red-600 font-medium mt-1">¡ELABORAR YA!</div>
                @else
                  <span class="text-green-600 font-medium text-2xl">✅</span>
                  <div class="text-xs text-green-600">Stock OK</div>
                @endif
              </td>

              <!-- Otras Sucursales -->
              <td class="px-4 py-4 p-text text-left">
                @if($item['stock_otras_sucursales']->count() > 0)
                  <div class="space-y-1">
                    @foreach($item['stock_otras_sucursales'] as $otroStock)
                      <div class="text-xs bg-blue-50 dark:bg-blue-900/20 p-2 rounded border-l-2 border-blue-300">
                        <div class="flex justify-between">
                          <span class="font-medium">{{ $otroStock['sucursal'] }}:</span>
                          <span class="font-bold text-blue-600">{{ $otroStock['cantidad'] }}</span>
                        </div>
                        @if($otroStock['fecha_elaboracion'])
                          <div class="text-gray-500">Elab: {{ \Carbon\Carbon::parse($otroStock['fecha_elaboracion'])->format('d/m') }}</div>
                        @endif
                      </div>
                    @endforeach
                    <div class="text-xs font-medium text-blue-600 border-t pt-1 bg-blue-100 px-2 py-1 rounded">
                      Total Sistema: {{ $item['stock_total_sistema'] }}
                    </div>
                  </div>
                @else
                  <span class="text-gray-400 text-xs">Sin stock en otras sucursales</span>
                @endif
              </td>

              <!-- Urgencia -->
              <td class="px-4 py-4 text-center">
                <div class="font-bold text-sm
                  @if($item['urgencia'] === 'vencido') text-red-600
                  @elseif($item['urgencia'] === 'urgente') text-orange-600
                  @elseif($item['urgencia'] === 'proximo') text-yellow-600
                  @else text-gray-600 @endif">
                  {{ $this->getUrgenciaTexto($item['urgencia']) }}
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-8 text-gray-600 dark:text-gray-400">
                @if($mostrarSinStock)
                  🎉 ¡Excelente! No hay stock que necesite elaboración.
                @else
                  No hay stock de productos terminados en pedidos activos.
                @endif
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Resumen General -->
      @if($resumenStock->count() > 0)
      <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border">
          <div class="text-2xl font-bold text-blue-600">{{ $resumenStock->count() }}</div>
          <div class="text-sm text-gray-600 p-text">Stock Diferentes</div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border">
          <div class="text-2xl font-bold text-green-600">{{ $resumenStock->where('necesita_produccion', false)->count() }}</div>
          <div class="text-sm text-gray-600 p-text">Con Stock Suficiente</div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border">
          <div class="text-2xl font-bold text-red-600">{{ $resumenStock->where('necesita_produccion', true)->count() }}</div>
          <div class="text-sm text-gray-600 p-text">Requieren Elaboración</div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border">
          <div class="text-2xl font-bold text-purple-600">{{ $resumenStock->sum('cantidad_producir') }}</div>
          <div class="text-sm text-gray-600 p-text">Unidades a Elaborar</div>
        </div>
      </div>
      @endif

      <!-- Lista Prioritaria para Elaboración -->
      @if($resumenStock->where('necesita_produccion', true)->count() > 0)
      <div class="mt-6 bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200">
        <h4 class="text-lg font-bold text-red-700 mb-3">🚨 LISTA PRIORITARIA DE ELABORACIÓN</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
          @foreach($resumenStock->where('necesita_produccion', true)->sortBy('urgencia') as $urgente)
          <div class="bg-white dark:bg-gray-800 p-3 rounded border-l-4 border-red-500">
            <div class="font-medium text-sm p-text">{{ $urgente['producto_nombre'] }}</div>
            <div class="text-xs text-purple-600">🏷️ {{ $urgente['etiqueta_descripcion'] }}</div>
            <div class="text-xs text-gray-500">{{ $urgente['sucursal_principal'] }}</div>
            <div class="mt-2 flex justify-between items-center">
              <span class="text-lg font-bold text-red-600">{{ $urgente['cantidad_producir'] }}</span>
              <span class="text-xs font-medium {{ $urgente['urgencia'] === 'vencido' ? 'text-red-600' : ($urgente['urgencia'] === 'urgente' ? 'text-orange-600' : 'text-yellow-600') }}">
                {{ $this->getUrgenciaTexto($urgente['urgencia']) }}
              </span>
            </div>
            @if($urgente['fecha_vencimiento'])
              <div class="text-xs text-orange-600 mt-1">
                ⏰ Vence: {{ \Carbon\Carbon::parse($urgente['fecha_vencimiento'])->format('d/m/Y') }}
              </div>
            @endif
          </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>
  </div>
</div>