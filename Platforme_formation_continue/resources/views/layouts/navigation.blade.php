{{-- navigation.blade.php --}}
<nav x-data="{ open: false, isScrolled: false }" 
    x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 10 })"
    :class="{ 'shadow-md': isScrolled }"
    class="w-full bg-white py-4 px-6 transition-all duration-300 border-b border-gray-100 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      {{-- Logo --}}
      <div class="flex items-center space-x-2">
         <a href="{{ route('welcome') }}" class="flex items-center space-x-2">
            <i class="fas fa-graduation-cap text-cyan-500 text-2xl"></i>
            <span class="text-xl font-bold">FormationPro BM</span>
         </a>
      </div>

       {{-- Desktop Navigation Links --}}
       <div class="hidden md:flex items-center space-x-8 pointer-events-auto">
          <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')"
             class="font-medium hover:text-cyan-600 transition-colors">
             {{ __('Accueil') }}
          </x-nav-link>
          <x-nav-link :href="route('formations')" :active="request()->routeIs('formations')"
             class="font-medium hover:text-cyan-600 transition-colors">
             {{ __('Formations') }}
          </x-nav-link>
          <x-nav-link :href="route('plans')" :active="request()->routeIs('plans')"
             class="font-medium hover:text-cyan-600 transition-colors">
             {{ __('Plans') }}
          </x-nav-link>
          <x-nav-link :href="route('about')" :active="request()->routeIs('about')"
             class="font-medium hover:text-cyan-600 transition-colors">
             {{ __('À propos') }}
          </x-nav-link>
       </div>

       {{-- Right side: Auth --}}
       <div class="flex items-center space-x-4">
          {{-- Authentication links for desktop --}}
          <div class="hidden md:flex items-center space-x-3">
             @auth
                @if(Auth::user()->role === 'admin')
                    <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard')"
                       class="font-medium hover:text-cyan-600 transition-colors">
                       {{ __('Tableau de bord') }}
                    </x-nav-link>
                @endif
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                       <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                          <div>{{ Auth::user()->name }}</div>
                          <div class="ml-1">
                             <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                             </svg>
                          </div>
                       </button>
                    </x-slot>

                    <x-slot name="content">
                       <x-dropdown-link :href="route('profile.index')">
                          {{ __('Profil') }}
                       </x-dropdown-link>
                       <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                             {{ __('Déconnexion') }}
                          </x-dropdown-link>
                       </form>
                    </x-slot>
                </x-dropdown>
             @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-cyan-600 border border-cyan-600 rounded-md hover:bg-cyan-50 transition-colors">
                    {{ __('Connexion') }}
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700 transition-colors">
                    {{ __('Inscription') }}
                </a>
             @endauth
          </div>

          {{-- Mobile menu button --}}
          <button @click="open = !open" class="md:hidden p-2 rounded-md text-gray-700 hover:text-cyan-600 hover:bg-gray-100 focus:outline-none"
                aria-expanded="false" aria-label="Toggle mobile menu">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
             </svg>
          </button>
       </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="md:hidden fixed inset-0 z-40 bg-white pt-20 px-6 pb-6 overflow-y-auto">
       <div class="flex flex-col space-y-6">
          <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')"
             class="text-lg font-medium p-2 rounded-md">
             {{ __('Accueil') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('formations')" :active="request()->routeIs('formations')"
             class="text-lg font-medium p-2 rounded-md">
             {{ __('Formations') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('plans')" :active="request()->routeIs('plans')"
             class="text-lg font-medium p-2 rounded-md">
             {{ __('Plans') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')"
             class="text-lg font-medium p-2 rounded-md">
             {{ __('À propos') }}
          </x-responsive-nav-link>

          <div class="border-t border-gray-200 pt-6 flex flex-col space-y-3">
             @auth
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard')"
                       class="w-full py-2 px-4 text-cyan-600 border border-cyan-600 rounded-md hover:bg-cyan-50 transition-colors">
                       {{ __('Tableau de bord') }}
                    </x-responsive-nav-link>
                @endif
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-3">
                    <x-responsive-nav-link :href="route('profile.index')"
                       class="w-full py-2 px-4 text-cyan-600 border border-cyan-600 rounded-md hover:bg-cyan-50 transition-colors">
                       {{ __('Profil') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                       @csrf
                       <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                          class="w-full py-2 px-4 text-center bg-cyan-600 text-white rounded-md hover:bg-cyan-700 transition-colors">
                          {{ __('Déconnexion') }}
                       </x-responsive-nav-link>
                    </form>
                </div>
             @else
                <a href="{{ route('login') }}" class="w-full py-2 px-4 text-center text-cyan-600 border border-cyan-600 rounded-md hover:bg-cyan-50 transition-colors">
                    {{ __('Connexion') }}
                </a>
                <a href="{{ route('register') }}" class="w-full py-2 px-4 text-center bg-cyan-600 text-white rounded-md hover:bg-cyan-700 transition-colors">
                    {{ __('Inscription') }}
                </a>
             @endauth
          </div>
       </div>

       {{-- Close button --}}
       <button @click="open = false" class="absolute top-4 right-4 p-2 rounded-md text-gray-700 hover:text-red-600 hover:bg-gray-100 focus:outline-none"
             aria-label="Close mobile menu">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
       </button>
    </div>
</nav>
