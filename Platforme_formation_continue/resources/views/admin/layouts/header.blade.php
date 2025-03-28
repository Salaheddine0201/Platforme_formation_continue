<!-- admin/layouts/header.blade.php -->
<header x-data="{ dropdownOpen: false }" class="bg-blue-500 shadow">
    <div class="flex items-center justify-between px-4 py-4">
        <!-- Mobile menu button -->
        <button @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar" class="lg:hidden p-2 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Navigation Links -->
        
            <nav class="flex space-x-4">
                <a href="{{ route('welcome') }}" class="text-white hover:text-gray-200 font-medium transition-colors duration-200">Acceuil</a>
  
            </nav>
        

        <!-- Right Side Icons -->
        <div class="flex items-center">
            <!-- Notification Icon -->
            
            @include('admin.layouts.partials.notifications')



            <!-- User Profile -->
            <div class="ml-4 relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" 
                        @click.away="dropdownOpen = false"
                        aria-label="User menu" 
                        class="flex items-center text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @if(Auth::user()->image)
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" 
                            alt="{{ Auth::user()->name }}" 
                            class="h-8 w-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-xl font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="dropdownOpen" 
                     x-transition 
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20"
                     style="display: none;">
                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>