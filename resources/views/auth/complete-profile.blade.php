<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Logo et Titre -->
        <div class="mb-8 text-center">
            <div class="flex items-center justify-center text-3xl font-bold text-blue-600">
                <span class="mr-2">➕</span> CabinetMédical
            </div>
            <p class="text-gray-500 text-sm mt-2">Portail de gestion des consultations</p>
        </div>

        <!-- Carte Blanche -->
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Compléter votre profil Médecin</h2>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('complete-profile.store') }}">
                @csrf

                <!-- Sélection de la spécialité -->
                <div class="mb-4">
                    <label for="specialite" class="block text-sm font-medium text-gray-700 mb-2">Votre Spécialité</label>
                    <select name="specialite" id="specialite" 
                            onchange="toggleOtherField()"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm h-12">
                        <option value="Généraliste">Généraliste</option>
                        <option value="Pédiatre">Pédiatre</option>
                        <option value="Cardiologue">Cardiologue</option>
                        <option value="Dermatologue">Dermatologue</option>
                        <option value="autre">Autre spécialité...</option>
                    </select>
                </div>

                <!-- Champ "Autre" (Caché par défaut) -->
                <div id="other_specialty_div" class="mb-4 hidden transition-all duration-300">
                    <label for="autre_specialite" class="block text-sm font-medium text-gray-700 mb-2">Précisez votre spécialité</label>
                    <input type="text" name="autre_specialite" id="autre_specialite" 
                           class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm h-12"
                           placeholder="Ex: Ophtalmologue">
                </div>

                <!-- Bouton de validation (C'est ce qui permet d'accéder au dashboard) -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform transition active:scale-95">
                        Finaliser et accéder au Dashboard
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript pour afficher le champ "Autre" -->
    <script>
        function toggleOtherField() {
            const select = document.getElementById('specialite');
            const otherDiv = document.getElementById('other_specialty_div');
            const otherInput = document.getElementById('autre_specialite');

            if (select.value === 'autre') {
                otherDiv.classList.remove('hidden'); // On montre le champ
                otherInput.focus();
            } else {
                otherDiv.classList.add('hidden'); // On cache le champ
            }
        }
    </script>
</x-guest-layout>