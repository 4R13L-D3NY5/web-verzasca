<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- ========== All CSS files linkup ========= -->
    <!-- <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" /> -->
    @vite('resources/css/app.css')
    @livewireStyles()
</head>
<body>
    @livewire('base')
    <div id="mapa" class="w-99 h-80 rounded-lg shadow-md"></div>
<!-- ========= All Javascript files linkup ======== -->
@vite('resources/js/app.js')
<!-- <script src="{{ asset('js/main.js') }}"></script> -->
@livewireScripts()


  {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  
</body>
</html>