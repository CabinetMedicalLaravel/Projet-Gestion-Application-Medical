<nav x-data="{ open: false }" class="bg-white border-b border-blue-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LEFT: Logo + Nav Links --}}
            <div class="flex">
                <!-- Logo : Cabinet (Bleu Marine #0D47A1) Médical (Bleu Moyen #1E88E5) -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center transition hover:opacity-80" style="text-decoration: none;">
                        <span style="font-size: 22px; font-weight: 800; color: #0D47A1; letter-spacing: -0.5px;">Cabinet</span><span style="font-size: 22px; font-weight: 800; color: #1E88E5; letter-spacing: -0.5px;">Médical</span>
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#0D47A1] font-bold">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                </div>
            </div>
 
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Bouton de profil avec fond bleu très léger #F1F8FE -->
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-[#1565C0] bg-[#F1F8FE] hover:text-[#0D47A1] hover:bg-[#E3F2FD] transition ease-in-out duration-150">
                            
                            <!-- PHOTO DE PROFIL (Version Desktop) -->
                            <div class="me-3">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border-2 border-[#1E88E5] shadow-sm">
                                @else
                                    <div class="h-9 w-9 rounded-full bg-[#E3F2FD] flex items-center justify-center border-2 border-[#BBDEFB]">
                                        <svg class="h-5 w-5 text-[#1976D2]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="font-bold">{{ Auth::user()->name }}</div>
 
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-[#1E88E5]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
 
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-semibold text-[#1565C0] hover:bg-[#F1F8FE]">
                            {{ __('Mon Profil') }}
                        </x-dropdown-link>
 
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
 
                            <x-dropdown-link :href="route('logout')"
                                    class="font-semibold text-red-600 hover:bg-red-50"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
 
            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#1E88E5] hover:text-[#0D47A1] hover:bg-blue-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
 
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#F8FAFC]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold text-[#1976D2]">
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
        </div>
 
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-blue-100">
            <div class="flex items-center px-4">
                <!-- PHOTO DE PROFIL (Version Mobile) -->
                <div class="shrink-0 me-3">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-12 w-12 rounded-full object-cover border-2 border-[#1E88E5]">
                    @else
                        <div class="h-12 w-12 rounded-full bg-[#E3F2FD] flex items-center justify-center border-2 border-[#BBDEFB]">
                            <svg class="h-7 w-7 text-[#1565C0]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="font-bold text-base text-[#0D47A1]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#475569]">{{ Auth::user()->email }}</div>
                </div>
            </div>
 
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-semibold text-[#1976D2]">
                    {{ __('Profil') }}
                </x-responsive-nav-link>
 
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
 
                    <x-responsive-nav-link :href="route('logout')"
                            class="font-semibold text-red-600"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>