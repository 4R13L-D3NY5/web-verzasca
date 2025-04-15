<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mapa de Clientes</title>

    {{-- CSS de Tailwind y Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite(['resources/css/app.css'])

    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Mapa de Clientes</h1>
        <div id="mapa" class="w-full h-[600px] rounded shadow-lg"></div>
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
