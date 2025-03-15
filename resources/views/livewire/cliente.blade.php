<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-xl grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md">

            <div
                class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                <button
                    class="px-4 py-2 font-medium text-gray-600 transition-colors duration-200 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"
                            stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </button>

                <button
                    class="px-4 py-2 font-medium text-gray-600 transition-colors duration-200 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"
                            stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </button>

                <!-- Input de búsqueda -->
                <input type="text" placeholder="Buscar..."
                    class="px-4 py-2 w-full sm:w-64 text-gray-600 dark:text-gray-300 dark:bg-gray-900 focus:outline-none" />
            </div>


            <div
                class="relative w-full max-w-full overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 shadow-md sm:rounded-lg">
                <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-900 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Empresa</th>
                            <th scope="col" class="px-6 py-3">NIT/CI</th>
                            <th scope="col" class="px-6 py-3">Teléfono</th>
                            <th scope="col" class="px-6 py-3">Correo</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $cliente->nombre }}
                                </td>
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $cliente->empresa ?? 'N/A' }}</td>
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $cliente->nitCi ?? 'N/A' }}</td>
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $cliente->telefono ?? $cliente->celular ?? 'N/A' }}</td>
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $cliente->correo ?? 'N/A' }}</td>
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    @if ($cliente->estado)
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Activo</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($clientes->isEmpty())
                    <div class="text-center py-4 text-gray-600">
                        No hay clientes registrados.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>