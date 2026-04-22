<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LEFT: Logo + Nav Links --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">

                    {{-- ── PATIENT links ── --}}
                    @if(Auth::user()->role === 'patient')
                        <x-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Accueil
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.mes-rdv')" :active="request()->routeIs('rdv.mes-rdv')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Mes RDV
                            @php $nbRdv = \App\Models\Appointment::where('patient_id', Auth::id())->whereIn('status', ['en_attente','confirme'])->count(); @endphp
                            @if($nbRdv > 0)
                                <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold leading-none bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full">{{ $nbRdv }}</span>
                            @endif
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.create')" :active="request()->routeIs('rdv.create')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Prendre RDV
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.calendrier')" :active="request()->routeIs('rdv.calendrier')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Calendrier
                        </x-nav-link>

                    {{-- ── MÉDECIN links ── --}}
                    @elseif(Auth::user()->role === 'medecin')
                        <x-nav-link :href="route('medecin.dashboard')" :active="request()->routeIs('medecin.dashboard')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Accueil
                        </x-nav-link>
                        <x-nav-link :href="route('medecin.agenda')" :active="request()->routeIs('medecin.agenda')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Mon agenda
                            @php $nbAttente = \App\Models\Appointment::where('doctor_id', Auth::id())->where('status','en_attente')->count(); @endphp
                            @if($nbAttente > 0)
                                <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold leading-none bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 rounded-full">{{ $nbAttente }}</span>
                            @endif
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.planning')" :active="request()->routeIs('rdv.planning')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Planning
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.calendrier')" :active="request()->routeIs('rdv.calendrier')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Disponibilités
                        </x-nav-link>

                    {{-- ── SECRÉTAIRE links ── --}}
                    @elseif(Auth::user()->role === 'secretaire')
                        <x-nav-link :href="route('secretaire.dashboard')" :active="request()->routeIs('secretaire.dashboard')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Accueil
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.calendrier')" :active="request()->routeIs('rdv.calendrier')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Agenda
                            @php $nbAttenteSecr = \App\Models\Appointment::where('status','en_attente')->count(); @endphp
                            @if($nbAttenteSecr > 0)
                                <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold leading-none bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 rounded-full">{{ $nbAttenteSecr }}</span>
                            @endif
                        </x-nav-link>
                        <x-nav-link :href="route('secretaire.rdv.create')" :active="request()->routeIs('secretaire.rdv.create')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Nouveau RDV
                        </x-nav-link>
                        <x-nav-link :href="route('rdv.planning')" :active="request()->routeIs('rdv.planning')">
                            <svg class="w-4 h-4 mr-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Planning
                        </x-nav-link>

                    {{-- ── FALLBACK ── --}}
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                    @endif

                </div>
            </div>

            {{-- RIGHT: Dark toggle + User dropdown --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">

                {{-- Dark Mode Toggle --}}
                <button
                    @click="dark = !dark"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150"
                    :title="dark ? 'Mode clair' : 'Mode sombre'"
                >
                    <svg x-show="dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg x-show="!dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                {{-- Role badge --}}
                @php
                    $roleBadge = ['patient' => ['bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300', 'Patient'],
                                  'medecin' => ['bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300', 'Médecin'],
                                  'secretaire' => ['bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300', 'Secrétaire']];
                    $rb = $roleBadge[Auth::user()->role] ?? ['bg-gray-100 text-gray-600', Auth::user()->role];
                @endphp
                <span class="hidden lg:inline-flex text-xs font-semibold px-2.5 py-1 rounded-full {{ $rb[0] }}">{{ $rb[1] }}</span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mon profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Se déconnecter') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- MOBILE Hamburger + Dark toggle --}}
            <div class="-me-2 flex items-center sm:hidden gap-2">
                <button
                    @click="dark = !dark"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150"
                >
                    <svg x-show="dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg x-show="!dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            @if(Auth::user()->role === 'patient')
                <x-responsive-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">Accueil</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.mes-rdv')" :active="request()->routeIs('rdv.mes-rdv')">Mes rendez-vous</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.create')" :active="request()->routeIs('rdv.create')">Prendre un RDV</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.calendrier')" :active="request()->routeIs('rdv.calendrier')">Calendrier</x-responsive-nav-link>

            @elseif(Auth::user()->role === 'medecin')
                <x-responsive-nav-link :href="route('medecin.dashboard')" :active="request()->routeIs('medecin.dashboard')">Accueil</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('medecin.agenda')" :active="request()->routeIs('medecin.agenda')">Mon agenda</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.planning')" :active="request()->routeIs('rdv.planning')">Planning</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.calendrier')" :active="request()->routeIs('rdv.calendrier')">Disponibilités</x-responsive-nav-link>

            @elseif(Auth::user()->role === 'secretaire')
                <x-responsive-nav-link :href="route('secretaire.dashboard')" :active="request()->routeIs('secretaire.dashboard')">Accueil</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.calendrier')" :active="request()->routeIs('rdv.calendrier')">Agenda</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rdv.planning')" :active="request()->routeIs('rdv.planning')">Planning</x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Mon profil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Se déconnecter
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
