<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css') <!-- Aquí estamos incluyendo el archivo CSS generado por Tailwind -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style (AdminLTE) -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page bg-gray-100">
    <div class="login-box">
        <div class="login-logo">
            <a href="/" class="text-xl text-indigo-600 font-bold">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            @yield('content')
        </div>
    </div>
    <!-- /.login-box -->

    @vite('resources/js/app.js')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>
</html>
