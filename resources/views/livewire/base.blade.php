<div>
    <header
        class="bg-slate-900 bg-opacity-95 backdrop-blur-md rounded-full px-6 py-1 shadow-lg w-[95%] max-w-[1700px] mx-auto transition-all duration-300 hover:shadow-xl hover:bg-opacity-100 fixed top-[5px] left-0 right-0 z-10">
        <div class="flex justify-between items-center">
            <!-- Menú Toggle -->
            <button id="menu-toggle"
                class="text-white hover:text-red-400 transition-transform duration-200 ease-in-out hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full p-1 md:p-2"
                title="Menú">
                <svg class="w-6 h-6 md:w-5 md:h-5" viewBox="0 0 24 24" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <div class="flex justify-center items-center flex-grow">
                <h5 class="text-white">VERZASCA</h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white"
                    class="icon icon-tabler icons-tabler-filled icon-tabler-bottle">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M13 1a2 2 0 0 1 1.995 1.85l.005 .15v.5c0 1.317 .381 2.604 1.094 3.705l.17 .25l.05 .072a9.093 9.093 0 0 1 1.68 4.92l.006 .354v6.199a3 3 0 0 1 -2.824 2.995l-.176 .005h-6a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-6.2a9.1 9.1 0 0 1 1.486 -4.982l.2 -.292l.05 -.069a6.823 6.823 0 0 0 1.264 -3.957v-.5a2 2 0 0 1 1.85 -1.995l.15 -.005h2zm.362 5h-2.724a8.827 8.827 0 0 1 -1.08 2.334l-.194 .284l-.05 .069a7.091 7.091 0 0 0 -1.307 3.798l-.003 .125a3.33 3.33 0 0 1 1.975 -.61a3.4 3.4 0 0 1 2.833 1.417c.27 .375 .706 .593 1.209 .583a1.4 1.4 0 0 0 1.166 -.583a3.4 3.4 0 0 1 .81 -.8l.003 .183c0 -1.37 -.396 -2.707 -1.137 -3.852l-.228 -.332a8.827 8.827 0 0 1 -1.273 -2.616z" />
                </svg>
                <!-- <img src="{{ asset('images/ejemplo.jpg') }}" alt="Logo" class="h-5 md:h-5"> -->
            </div>

            <!-- Botón de Logout -->
            <button
                class="text-white hover:text-red-400 transition-transform duration-200 ease-in-out hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full p-1 md:p-2"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                title="Cerrar sesión">
                <svg class="w-6 h-6 md:w-5 md:h-5" viewBox="0 0 512 512" fill="currentColor">
                    <path
                        d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                    </path>
                </svg>
            </button>

            <!-- Formulario de logout oculto -->
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </header>
    <nav id="menu" class="w-[95%]  max-w-[1700px] p-text color-bg px-6 py-4 shadow-lg 
       fixed left-1/2 -translate-x-1/2 top-[65px] hidden transition-all duration-300 
       rounded-xl opacity-0 backdrop-blur-md z-20">
        <div class="max-h-[80vh] overflow-y-auto">
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                <!-- Gestión de Usuarios -->
                <div>
                    <h3 class="text-yellow-500">GESTION DE USUARIOS</h3>
                    <li class="nav-item @if($seleccion == 'Personal') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Personal')" class="flex items-center space-x-2">
                            <span class="icon">
                                <!-- Icono de Personal -->
                            </span>
                            <span class="text-custom">PERSONAL</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Roles') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Roles')" class="flex items-center space-x-2">
                            <span class="icon">
                                <!-- Icono de Roles -->
                            </span>
                            <span class="text-custom">ROLES</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Pruebaestilo') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Pruebaestilo')" class="flex items-center space-x-2">
                            <span class="icon">
                                <!-- Icono de Roles -->
                            </span>
                            <span class="text-custom">Pruebaestilo</span>
                        </a>
                    </li>
                </div>
                <!-- Gestión de Compras -->
                <div>
                    <h3 class="text-emerald-500">GESTION DE COMPRAS</h3>
                    <li class="nav-item @if($seleccion == 'Compras') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Compras')" class="flex items-center space-x-2">
                            <span class="icon">
                                <!-- Icono de Compras -->
                            </span>
                            <span class="text-custom">COMPRAS</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Proveedores') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Proveedores')" class="flex items-center space-x-2">
                            <span class="icon">
                                <!-- Icono de Proveedores -->
                            </span>
                            <span class="text-custom">PROVEEDORES</span>
                        </a>
                    </li>
                </div>


                <div>
                    <h3 class="text-violet-500">ALMACEN</h3>
                    <li class="nav-item @if($seleccion == 'Stocks') color-bg @endif">
                        <a wire:click="$set('seleccion', 'Stocks')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-stack-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M20.894 15.553a1 1 0 0 1 -.447 1.341l-8 4a1 1 0 0 1 -.894 0l-8 -4a1 1 0 0 1 .894 -1.788l7.553 3.774l7.554 -3.775a1 1 0 0 1 1.341 .447m0 -4a1 1 0 0 1 -.447 1.341l-8 4a1 1 0 0 1 -.894 0l-8 -4a1 1 0 0 1 .894 -1.788l7.552 3.775l7.554 -3.775a1 1 0 0 1 1.341 .447m-8.887 -8.552q .056 0 .111 .007l.111 .02l.086 .024l.012 .006l.012 .002l.029 .014l.05 .019l.016 .009l.012 .005l8 4a1 1 0 0 1 0 1.788l-8 4a1 1 0 0 1 -.894 0l-8 -4a1 1 0 0 1 0 -1.788l8 -4l.011 -.005l.018 -.01l.078 -.032l.011 -.002l.013 -.006l.086 -.024l.11 -.02l.056 -.005z" />
                                </svg>
                            </span>
                            <span class="p-text">STOCK</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Tapas') color-bg @endif">
                        <a wire:click="$set('seleccion', 'Tapas')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-pepsi ">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M4 16c5.713 -2.973 11 -3.5 13.449 -11.162" />
                                    <path d="M5 17.5c5.118 -2.859 15 0 14 -11" />
                                </svg>
                            </span>
                            <span class="p-text">TAPAS</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Etiquetas') color-bg @endif">
                        <a wire:click="$set('seleccion', 'Etiquetas')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-ticket">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 5l0 2" />
                                    <path d="M15 11l0 2" />
                                    <path d="M15 17l0 2" />
                                    <path
                                        d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
                                </svg>
                            </span>
                            <span class="p-text">ETIQUETAS</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Productos') color-bg @endif">
                        <a wire:click="$set('seleccion', 'Productos')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-building-store">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21l18 0" />
                                    <path
                                        d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                                    <path d="M5 21l0 -10.15" />
                                    <path d="M19 21l0 -10.15" />
                                    <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                                </svg>
                            </span>
                            <span class="p-text">PRODUCTOS</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Bases') color-bg @endif">
                        <a wire:click="$set('seleccion', 'Bases')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-medicine-syrup">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M8 21h8a1 1 0 0 0 1 -1v-10a3 3 0 0 0 -3 -3h-4a3 3 0 0 0 -3 3v10a1 1 0 0 0 1 1z" />
                                    <path d="M10 14h4" />
                                    <path d="M12 12v4" />
                                    <path d="M10 7v-3a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3" />
                                </svg>
                            </span>
                            <span class="p-text">BASES</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Preformas') color-bg @endif">
                        <a wire:click="$set('seleccion', 'Preformas')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-terraform">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M15 15.5l-11.476 -6.216a1 1 0 0 1 -.524 -.88v-4.054a1.35 1.35 0 0 1 2.03 -1.166l9.97 5.816v10.65a1.35 1.35 0 0 1 -2.03 1.166l-3.474 -2.027a1 1 0 0 1 -.496 -.863v-11.926" />
                                    <path
                                        d="M15 15.5l5.504 -3.21a1 1 0 0 0 .496 -.864v-3.576a1.35 1.35 0 0 0 -2.03 -1.166l-3.97 2.316" />
                                </svg>
                            </span>
                            <span class="p-text">PREFORMAS</span>
                        </a>
                    </li>

                </div>
                <div>
                    <h3 class="text-violet-500 mt-4">GESTIÓN DE PRODUCCIÓN</h3>

                    <li class="nav-item @if($seleccion == 'Elaboracion') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Elaboracion')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-settings">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M10 21l2 -4l2 4" />
                                    <path d="M4 12l4 -2l-4 -2" />
                                    <path d="M20 12l-4 -2l4 -2" />
                                </svg>
                            </span>
                            <span class="text-custom">Elaboración</span>
                        </a>
                    </li>

                    <li class="nav-item @if($seleccion == 'Embotellado') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Embotellado')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-bottle">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 5v1a2 2 0 0 1 -2 2v11a2 2 0 0 0 2 2h4a2 2 0 0 0 2 -2v-11a2 2 0 0 1 -2 -2v-1" />
                                    <path d="M10 3h4" />
                                </svg>
                            </span>
                            <span class="text-custom">Embotellado</span>
                        </a>
                    </li>

                    <li class="nav-item @if($seleccion == 'Etiquetado') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Etiquetado')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-tag">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 4h6l10 10a2.828 2.828 0 1 1 -4 4l-10 -10v-6" />
                                    <path d="M7 7h.01" />
                                </svg>
                            </span>
                            <span class="text-custom">Etiquetado</span>
                        </a>
                    </li>

                    <li class="nav-item @if($seleccion == 'Traspaso') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Traspaso')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-transfer">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7h16" />
                                    <path d="M4 17h16" />
                                    <path d="M10 11l-2 2l2 2" />
                                    <path d="M14 11l2 2l-2 2" />
                                </svg>
                            </span>
                            <span class="text-custom">Traspaso</span>
                        </a>
                    </li>
                </div>

                <div>
                    <h3 class="text-violet-500">GESTION DE VENTAS</h3>
                    <li class="nav-item @if($seleccion == 'Cliente') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Cliente')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>
                            </span>
                            <span class="text-custom">CLIENTE</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Venta') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Venta')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-report-money">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                    <path
                                        d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                    <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                    <path d="M12 17v1m0 -8v1" />
                                </svg>
                            </span>
                            <span class="text-custom">VENTA</span>
                        </a>
                    </li>
                </div>
                <div>
                    <h3 class="text-violet-500">GESTION DE DISTRIBUCION</h3>
                    <li class="nav-item @if($seleccion == 'Distribucion') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Distribucion')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin-share">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    <path
                                        d="M12.02 21.485a1.996 1.996 0 0 1 -1.433 -.585l-4.244 -4.243a8 8 0 1 1 13.403 -3.651" />
                                    <path d="M16 22l5 -5" />
                                    <path d="M21 21.5v-4.5h-4.5" />
                                </svg>
                            </span>
                            <span class="text-custom">DISTRIBUCIOIN</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Pedidos') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Pedidos')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Pedidos</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Asignacion') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Asignacion')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Asignacion</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Coche') bg-indigo-500 @endif">
                        <a wire:click="$set('seleccion', 'Coche')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Coche</span>
                        </a>
                    </li>
                </div>
                <div>
                    <h3 class="text-violet-500">SUCURSALES</h3>
                    <li class="nav-item @if($seleccion == 'Empresa') bg-indigo-500 @endif">
                        <a wire:click="$set('seleccion', 'Empresa')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-presentation">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 4l18 0" />
                                    <path d="M4 4v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-10" />
                                    <path d="M12 16l0 4" />
                                    <path d="M9 20l6 0" />
                                    <path d="M8 12l3 -3l2 2l3 -3" />
                                </svg>
                            </span>
                            <span class="text-custom">EMPRESA</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Sucursal') bg-indigo-500 @endif">
                        <a wire:click="$set('seleccion', 'Sucursal')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-building">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21l18 0" />
                                    <path d="M5 21v-14l8 -4v18" />
                                    <path d="M19 21v-10l-6 -4" />
                                    <path d="M9 9l0 .01" />
                                    <path d="M9 12l0 .01" />
                                    <path d="M9 15l0 .01" />
                                    <path d="M13 9l0 .01" />
                                    <path d="M13 12l0 .01" />
                                    <path d="M13 15l0 .01" />
                                </svg>
                            </span>
                            <span class="text-custom">SUCURSAL</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Trabajador') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Trabajador')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Trabajador</span>
                        </a>
                    </li>
                </div>
                <div>
                    <h3 class="text-violet-500">GESTION DE TESORERIA</h3>
                    <li class="nav-item @if($seleccion == 'Ingreso') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Ingreso')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Ingreso</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Credito') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Credito')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Credito</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Salario') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Salario')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Salario</span>
                        </a>
                    </li>
                </div>
                <div>
                    <h3 class="text-violet-500">REPORTES</h3>
                    <li class="nav-item @if($seleccion == 'Reporteventa') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Reporteventa')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Reporteventa</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Reportecompra') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Reportecompra')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Reportecompra</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Reportestock') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Reportestock')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Reportestock</span>
                        </a>
                    </li>
                    <li class="nav-item @if($seleccion == 'Reportecredito') bg-emerald-500 @endif">
                        <a wire:click="$set('seleccion', 'Reportecredito')" class="flex items-center space-x-2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-stackoverflow">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-1" />
                                    <path d="M8 16h8" />
                                    <path d="M8.322 12.582l7.956 .836" />
                                    <path d="M8.787 9.168l7.826 1.664" />
                                    <path d="M10.096 5.764l7.608 2.472" />
                                </svg>
                            </span>
                            <span class="text-custom">Reportecredito</span>
                        </a>
                    </li>
                </div>

            </ul>
        </div>
    </nav>

    <main class="w-full min-h-screen dark:bg-gray-900" id="main-content">
        <div class="w-full p-2  dark:bg-gray-900">
            @if ($seleccion == 'Compras')
                @livewire('compras')
            @endif
            @if ($seleccion == 'Personal')
                @livewire('personal')
            @endif
            @if ($seleccion == 'Proveedores')
                @livewire('proveedores')
            @endif
            @if ($seleccion == 'Roles')
                @livewire('roles')
            @endif
            @if ($seleccion == 'Elaboracion')
                @livewire('elaboracion')
            @endif
            @if ($seleccion == 'Etiquetas')
                @livewire('Etiquetas')
            @endif
            @if ($seleccion == 'Preformas')
                @livewire('preformas')
            @endif
            @if ($seleccion == 'Tapas')
                @livewire('tapas')
            @endif
            @if ($seleccion == 'Raiz')
                @livewire('raiz')
            @endif
            @if ($seleccion == 'Productos')
                @livewire('productos')
            @endif
            @if ($seleccion == 'Embotellado')
                @livewire('embotellado')
            @endif
            @if ($seleccion == 'Stocks')
                @livewire('stocks')
            @endif
            @if ($seleccion == 'Egresoingreso')
                @livewire('egresoingreso')
            @endif
            @if ($seleccion == 'Cliente')
                @livewire('cliente')
            @endif
            @if ($seleccion == 'Venta')
                @livewire('venta')
            @endif
            @if ($seleccion == 'Distribucion')
                @livewire('distribucion')
            @endif
            @if ($seleccion == 'Pedidos')
                @livewire('pedidos')
            @endif
            @if ($seleccion == 'Asignacion')
                @livewire('asignacion')
            @endif
            @if ($seleccion == 'Coche')
                @livewire('coche')
            @endif
            @if ($seleccion == 'Empresa')
                @livewire('empresa')
            @endif
            @if ($seleccion == 'Sucursal')
                @livewire('sucursal')
            @endif
            @if ($seleccion == 'Trabajador')
                @livewire('trabajador')
            @endif
            @if ($seleccion == 'Ingreso')
                @livewire('ingreso')
            @endif
            @if ($seleccion == 'Credito')
                @livewire('credito')
            @endif
            @if ($seleccion == 'Salario')
                @livewire('salario')
            @endif
            @if ($seleccion == 'Reporteventa')
                @livewire('reporteventa')
            @endif
            @if ($seleccion == 'Reportecompra')
                @livewire('reportecompra')
            @endif
            @if ($seleccion == 'Reportestock')
                @livewire('reportestock')
            @endif
            @if ($seleccion == 'Reportecredito')
                @livewire('reportecredito')
            @endif
            @if ($seleccion == 'Pruebaestilo')
                @livewire('pruebaestilo')
            @endif
            @if ($seleccion == 'Bases')
                @livewire('bases')
            @endif


        </div>
    </main>


</div>

<script>
    const menuToggleButton = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");
    const mainContent = document.getElementById("main-content");

    // Función para alternar la visibilidad del menú
    menuToggleButton.addEventListener("click", function () {
        let header = document.querySelector("header");

        // Ajustar la posición del menú en relación con el header
        let headerHeight = header ? header.offsetHeight : 0;
        menu.style.top = `${headerHeight + 6}px`;

        // Alternar visibilidad y efectos de animación
        if (menu.classList.contains("hidden")) {
            menu.classList.remove("hidden", "opacity-0");
            menu.classList.add("opacity-100", "backdrop-blur-md", "z-20"); // Aplicar desenfoque y mostrar el menú

            // Restablecer el scroll del contenido al principio
            mainContent.scrollTop = 0;
        } else {
            menu.classList.add("opacity-0");
            menu.classList.remove("backdrop-blur-md", "z-20"); // Eliminar desenfoque y z-index cuando se oculta
            setTimeout(() => menu.classList.add("hidden"), 300);
        }
    });

    // También puedes agregar un evento para cerrar el menú si se hace clic fuera de él
    document.addEventListener("click", function (event) {
        if (!menu.contains(event.target) && !menuToggleButton.contains(event.target)) {
            menu.classList.add("opacity-0");
            menu.classList.remove("backdrop-blur-md", "z-20"); // Eliminar desenfoque y z-index cuando se oculta
            setTimeout(() => menu.classList.add("hidden"), 300);
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('mapa').setView([19.4326, -99.1332], 13); // Coordenadas iniciales (CDMX)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([19.4326, -99.1332], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var latlng = marker.getLatLng();
            Livewire.emit('actualizarUbicacion', latlng.lat, latlng.lng); // Enviar datos a Livewire
        });
    });
</script>