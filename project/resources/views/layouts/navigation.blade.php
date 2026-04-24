<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <span class="text-lg font-semibold text-gray-800">Bloom Café</span>
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                        Menu
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        Panier
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                            Produits
                        </x-nav-link>
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index') || request()->routeIs('orders.show')">
                            Mes commandes
                        </x-nav-link>
                        <x-nav-link :href="route('orders.manage.index')" :active="request()->routeIs('orders.manage.*')">
                            Gestion commandes
                        </x-nav-link>
                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            Messages
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 me-3">Connexion</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900">Inscription</a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" @click="open = ! open" class="p-2 text-gray-400 hover:bg-gray-100 rounded-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('menu')">Menu</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')">Panier</x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('products.index')">Produits</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')">Mes commandes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.manage.index')">Gestion commandes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')">Messages</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')">Connexion</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">Inscription</x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
