<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapa de Clientes</title>

    {{-- CSS de Tailwind y Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite(['resources/css/app.css'])

    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Mapa de Clientes</h1>
            <a href="{{ route('home') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                ← Volver al inicio
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Mapa -->
            <div id="mapa" class="w-full h-[400px] lg:h-[600px] rounded shadow-lg"></div>

            <!-- Tabla de Clientes -->
            <div class="overflow-auto rounded shadow-lg bg-white p-4">
                <h2 class="text-xl font-semibold mb-4">Lista de Clientes</h2>
                <table class="min-w-full text-sm text-left border">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-2 px-4 border-b">Nombre</th>
                            <th class="py-2 px-4 border-b">Empresa</th>
                            <th class="py-2 px-4 border-b">Celular</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b">{{ $cliente->nombre }}</td>
                                <td class="py-2 px-4 border-b">{{ $cliente->empresa }}</td>
                                <td class="py-2 px-4 border-b">{{ $cliente->celular }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- JS de Leaflet y Vite --}}
    @vite('resources/js/app.js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('mapa').setView([-17.7833, -63.1821], 13); // Cambia las coordenadas según tu ubicación inicial preferida

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            }).addTo(map);

            @foreach ($clientes as $cliente)
                L.marker([{{ $cliente->latitud }}, {{ $cliente->longitud }}])
                    .addTo(map)
                    .bindPopup(`
                                <strong>{{ $cliente->nombre }}</strong><br>
                                {{ $cliente->empresa ?? '' }}<br>
                                {{ $cliente->celular ?? '' }}
                            `);
            @endforeach
        });
    </script>
</body>

</html>