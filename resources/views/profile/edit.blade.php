<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Mon Profil Médical') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9FAFB] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Section Informations Personnelles -->
            <div class="p-8 sm:p-12 bg-white shadow-xl shadow-gray-100 rounded-[2rem] border border-gray-100">

                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>


            <!-- Section Mot de Passe -->
            <div class="p-8 sm:p-12 bg-white shadow-xl shadow-gray-100 rounded-[2rem] border border-gray-100">

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


            <!-- Section Suppression (Optionnel) -->
            <div class="p-8 sm:p-12 bg-white shadow-xl shadow-gray-100 rounded-[2rem] border border-red-50">

                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

