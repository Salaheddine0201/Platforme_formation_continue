<div class="account-settings-container ">
    <h1 class="text-xl font-medium mb-6">Paramètres du compte</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
        <!-- Left Column - Profile Photo Section -->
        <div class="profile-photo-section">
            <div class="relative w-full aspect-square bg-gray-100">
                <div id="image-preview-container">
                    @if($user->image)
                        <img id="current-image" src="{{ asset('storage/'.$user->image) }}" class="w-full aspect-square object-cover" alt="Photo de Profil">
                    @else
                        <div class="w-full aspect-square bg-gray-200"></div>
                    @endif
                </div>
                
                <label for="image" class="absolute inset-0 flex items-end justify-center cursor-pointer">
                    <div class="w-full bg-black bg-opacity-70 text-white py-2 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Télécharger Photo
                    </div>
                </label>
            </div>
            <p class="text-xs text-gray-500 text-center mt-2">
                La taille de l'image doit être inférieure à 1 Mo et<br>
                le ratio de l'image doit être 1:1
            </p>
        </div>

        <!-- Right Column - Form Fields -->
        <div class="form-fields-section col-span-2">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6 ">
                @csrf
                @method('patch')
                
                <!-- Hidden image input that gets triggered by the label -->
                <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />

                <!-- Full name (Two inputs side by side) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-text-input id="prenom" name="prenom" type="text" class="block w-full" placeholder="Prénom" :value="old('prenom', $user->prenom)" />
                            <x-input-error class="mt-1" :messages="$errors->get('prenom')" />
                        </div>
                        <div>
                            <x-text-input id="nom" name="nom" type="text" class="block w-full" placeholder="Nom" :value="old('nom', $user->nom)" />
                            <x-input-error class="mt-1" :messages="$errors->get('nom')" />
                        </div>
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <x-input-label for="name" :value="__('Nom d\'utilisateur')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Entrez votre nom d'utilisateur" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Adresse e-mail')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="Adresse e-mail" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-1" :messages="$errors->get('email')" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Téléphone')" />
                    <x-text-input id="phone" name="phone" type="tel" pattern="[0-9]{10}" class="mt-1 block w-full" placeholder="Votre numéro de téléphone" :value="old('phone', $user->phone)" />
                    <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" :value="__('Statut')" />
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="individuel" {{ $user->status === 'individuel' ? 'selected' : '' }}>Individuel</option>
                        <option value="entreprise" {{ $user->status === 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('status')" />
                </div>

                <!-- Save Button -->
                <div class="mt-8">
                <button type="submit" class="w-full py-2 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-md transition-colors">
                        {{ __('Enregistrer les modifications') }}
                </button>
                 @if (session('success'))
                    <div x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 5000)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform translate-y-4"
                        class="fixed top-4 right-4 z-50 max-w-sm w-full">
                        <div class="flex items-center p-5 bg-white rounded-lg shadow-xl border-l-4 border-l-green-500">
                            <!-- Icône de coche avec cercle animé -->
                            <div class="flex-shrink-0 relative">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <svg class="w-8 h-8 absolute top-0 left-0 text-green-500 animate-[spin_4s_ease-in-out_infinite]" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1" stroke-dasharray="1 3" />
                                </svg>
                            </div>
                            
                            <!-- Message avec titre et contenu -->
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-bold text-gray-800 mb-0.5">Succès !</h4>
                                <p class="text-sm text-gray-600">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for image preview -->
    <script>
        function previewImage(input) {
            const container = document.getElementById('image-preview-container');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Remove current image
                    while (container.firstChild) {
                        container.removeChild(container.firstChild);
                    }
                    
                    // Create new image with preview
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full aspect-square object-cover';
                    img.alt = 'Aperçu de la Photo';
                    container.appendChild(img);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</div>