<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Mapa</title>

    <!-- Incluir el archivo CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Agregar tus estilos personalizados aquí -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        #map {
            width: 100%;
            height: 500px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            display: block;
            width: 200px;
            margin: 20px auto 0;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Mapa de Clientes</h1>
        <p class="text-center">Aquí puedes ver la ubicación de los clientes en el mapa.</p>

        <!-- Contenedor del mapa -->
        <div id="map"></div>

        <!-- Botón para ir al home -->
        <a href="{{ route('home') }}" class="btn">Volver al Inicio</a>
    </div>

    <!-- Incluir el archivo JS de Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Inicializar el mapa con coordenadas de ejemplo (Ciudad de México)
        var map = L.map('map').setView([19.4326, -99.1332], 13); // Coordenadas de Ciudad de México

        // Añadir el "tile layer" del mapa (mapa de OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Añadir un marcador en las coordenadas iniciales
        L.marker([19.4326, -99.1332]).addTo(map)
            .bindPopup("<b>¡Estás aquí!</b><br>Ciudad de México")
            .openPopup();

        // Puedes agregar más marcadores con diferentes coordenadas de clientes
        L.marker([19.4231, -99.1658]).addTo(map)
            .bindPopup("<b>Cliente A</b><br>Ubicación Cliente A")
            .openPopup();

        L.marker([19.4400, -99.1427]).addTo(map)
            .bindPopup("<b>Cliente B</b><br>Ubicación Cliente B")
            .openPopup();
    </script>

</body>
</html>
