<div>
    <header
        class="bg-slate-900 bg-opacity-95 backdrop-blur-md rounded-full px-6 py-3 shadow-lg w-[calc(100%-1cm)] mx-auto mt-4 transition-all duration-300 hover:shadow-xl hover:bg-opacity-100 max-w-full fixed top-0 left-0 right-0 z-50">
        <div class="flex justify-between items-center">
            <!-- Menú Toggle -->
            <button id="menu-toggle"
                class="text-white hover:text-red-400 transition-transform duration-200 ease-in-out hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full p-2 md:p-3"
                title="Menú">
                <svg class="w-6 h-6 md:w-8 md:h-8" viewBox="0 0 24 24" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

        
            <div class="flex justify-center items-center flex-grow">
                <img src="{{ asset('images/ejemplo.jpg') }}" alt="Logo" class="h-12 md:h-14">
            </div>

            <!-- Botón de Logout -->
            <button
                class="text-white hover:text-red-400 transition-transform duration-200 ease-in-out hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full p-2 md:p-3"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                title="Cerrar sesión">
                <svg class="w-6 h-6 md:w-8 md:h-8" viewBox="0 0 512 512" fill="currentColor">
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

    <div class="min-h-screen flex flex-col md:flex-row">
        <nav>
            <ul id="menu" class="mt-4 hidden">
                <h3 class="text-yellow-500">GESTION DE USUARIOS</h3>
                <li class="nav-item @if($seleccion == 'Personal') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Personal')" class="flex items-center space-x-2">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                                <path
                                    d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
                            </svg>
                        </span>
                        <span class="text-custom">PERSONAL</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Roles') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Roles')" class="flex items-center space-x-2">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                            </svg>
                        </span>
                        <span class="text-custom">ROLES</span>
                    </a>
                </li>
                <h3 class="text-emerald-500">GESTION DE COMPRAS</h3>
                <li class="nav-item @if($seleccion == 'Compras') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Compras')" class="flex items-center space-x-2">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17h-11v-14h-2" />
                                <path d="M6 5l14 1l-1 7h-13" />
                            </svg>
                        </span>
                        <span class="text-custom">COMPRAS</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Proveedores') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Proveedores')" class="flex items-center space-x-2">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-parking-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -20 0l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72m1.334 5h-3.334a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1l.117 -.007a1 1 0 0 0 .883 -.993v-3h2.334c1.516 0 2.666 -1.38 2.666 -3s-1.15 -3 -2.666 -3m0 2c.323 0 .666 .411 .666 1s-.343 1 -.666 1h-2.334v-2z" />
                            </svg>
                        </span>
                        <span class="text-custom">PROVEEDORES</span>
                    </a>
                </li>
                <h3 class="text-red-500">GESTION DE PRODUCCION</h3>
                <li class="nav-item @if($seleccion == 'Elaboracion') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Elaboracion')" class="flex items-center space-x-2">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-blocks">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 4a1 1 0 0 1 1 -1h5a1 1 0 0 1 1 1v5a1 1 0 0 1 -1 1h-5a1 1 0 0 1 -1 -1z" />
                                <path
                                    d="M3 14h12a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h3a2 2 0 0 1 2 2v12" />
                            </svg>
                        </span>
                        <span class="text-custom">ELABORACION</span>
                    </a>
                </li>

                <li class="nav-item @if($seleccion == 'Etiquetas') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Etiquetas')" class="flex items-center space-x-2">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-tag">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path
                                    d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" />
                            </svg>
                        </span>
                        <span class="text-custom">ETIQUETAS</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Preformas') bg-emerald-500 @endif">
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
                        <span class="text-custom">PREFORMAS</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Tapas') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Tapas')" class="flex items-center space-x-2">
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
                        <span class="text-custom">TAPAS</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Raiz') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Raiz')" class="flex items-center space-x-2">
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
                        <span class="text-custom">BASES</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Productos') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Productos')" class="flex items-center space-x-2">
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
                        <span class="text-custom">PRODUCTOS</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Embotellado') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Embotellado')" class="flex items-center space-x-2">
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
                        <span class="text-custom">EMBOTELLADO</span>
                    </a>
                </li>
                <h3 class="text-violet-500">GESTION DE ALMACEN</h3>
                <li class="nav-item @if($seleccion == 'Stock') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Stock')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Stock</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Egresoingreso') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Egresoingreso')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Egresoingreso</span>
                    </a>
                </li>
                <h3 class="text-violet-500">GESTION DE VENTAS</h3>
                <li class="nav-item @if($seleccion == 'Cliente') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Cliente')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Cliente</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Venta') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Venta')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Venta</span>
                    </a>
                </li>
                <h3 class="text-violet-500">GESTION DE DISTRIBUCION</h3>
                <li class="nav-item @if($seleccion == 'Distribucion') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Distribucion')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Distribucion</span>
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
                <li class="nav-item @if($seleccion == 'Coche') bg-emerald-500 @endif">
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
                <h3 class="text-violet-500">GESTION DE SUCURSALES</h3>
                <li class="nav-item @if($seleccion == 'Empresa') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Empresa')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Empresa</span>
                    </a>
                </li>
                <li class="nav-item @if($seleccion == 'Sucursal') bg-emerald-500 @endif">
                    <a wire:click="$set('seleccion', 'Sucursal')" class="flex items-center space-x-2">
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
                        <span class="text-custom">Sucursal</span>
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
            </ul>
        </nav>
        
        <main class="w-full min-h-screen dark:bg-gray-900 p-2 mt-20"> <!-- Agregado margen superior -->
    <div class="w-full p-2">
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
        @if ($seleccion == 'Stock')
            @livewire('stock')
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
    </div>
        </main>

    </div>
</div>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        let menu = document.getElementById("menu");
        menu.classList.toggle("hidden");
    });
</script>