<footer class="bg-light text-center text-lg-start mt-5 py-3">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/map.js') }}"></script>
    <div class="container">
        <div class="bg-gray-100 border-t border-gray-200 py-8 mt-8">
            <div class="container mx-auto max-w-screen-xl px-4">
                <!-- Footer Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-gray-700">
                    <!-- Bedrijfsinformatie -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Over Ons</h2>
                        <p class="mt-2 text-sm">
                            Wij zijn een bedrijf dat zich inzet voor hoogwaardige koffie en tevreden klanten.
                        </p>
                        <img src="{{ asset('img/logo1_groot.png') }}" alt="Logo" class="h-12 mt-4">
                    </div>

                    <!-- Snelle Links -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Snelkoppelingen</h2>
                        <ul class="mt-2 space-y-2 text-sm">
                            <li><a href="#" class="hover:text-gray-900">Home</a></li>
                            <li><a href="#" class="hover:text-gray-900">Diensten</a></li>
                            <li><a href="#" class="hover:text-gray-900">Over Ons</a></li>
                            <li><a href="{{ url('/contact') }}" class="hover:text-gray-900">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contactinformatie -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Contact</h2>
                        <p class="mt-2 text-sm">1234 Koffiestraat, Tilburg</p>
                        <p class="mt-1 text-sm">Telefoon: +31 6 1234 5678</p>
                        <p class="mt-1 text-sm">Email: info@barrocintens.nl</p>
                    </div>

                    <!-- Sociale Media -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Volg Ons</h2>
                        <div class="flex space-x-4 mt-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-gray-900">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-gray-900">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-gray-900">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="map" style="height: 500px;"></div>
                @vite('resources/js/map.js')

                <div class="text-center text-sm text-gray-600 mt-8">
                    &copy; {{ date('Y') }} Barroc intens. Alle rechten voorbehouden.
                </div>
            </div>
        </div>

    </div>
</footer>