<div class="container mx-auto px-4 py-8">
    <!-- Success Alert (Alpine.js) -->
    <div x-data="{ showAlert: false }" @alert-show.window="showAlert = true">
        <div x-show="showAlert" 
             x-init="setTimeout(() => showAlert = false, 8000)" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-4"
             class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="flex items-center p-5 bg-white rounded-lg shadow-xl border-l-4 border-l-green-500">
                <!-- Checkmark icon with animated circle -->
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
                
                <!-- Message with title and content -->
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-bold text-gray-800 mb-0.5">Success!</h4>
                    <p class="text-sm text-gray-600">L'application a été supprimée avec succès.</p>
                </div>
            </div>
        </div>
    </div>

    @if($wishlist->count() > 0)
        <div class="bg-white rounded-lg shadow-sm">
            <div class="flex justify-between items-center py-4 px-6 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Wishlist ({{ $wishlist->count() }})</h2>
                <button id="devis-button" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm transition-colors duration-200">
                    Demande De Devis
                </button>
            </div>

            <div class="divide-y">
                <!-- Table Header -->
                <div class="grid grid-cols-12 py-3 px-6 bg-gray-50 text-sm font-medium text-gray-600">
                    <div class="col-span-6">FORMATION</div>
                    <div class="col-span-3 text-center">NOMBRE DE PERSONNE</div>
                    <div class="col-span-3 text-center">ACTION</div>
                </div>

                <!-- Wishlist Items -->
                <div id="wishlist-items">
                    @foreach($wishlist as $item)
                        @if($item->formation)
                            <div class="grid grid-cols-12 py-4 px-6 items-center wishlist-item" data-item-id="{{ $item->id }}">
                                <!-- Formation Info -->
                                <div class="col-span-6 flex items-center space-x-4">
                                    <div class="w-20 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($item->formation->image)
                                            <img src="{{ asset('storage/' . $item->formation->image) }}" 
                                                 alt="{{ $item->formation->nom }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                <span class="text-xs text-gray-500">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 mb-1">
                                            {{ $item->formation->nom }}
                                        </h3>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->formation->etablissement->nom ?? 'ISTA NTIC' }}
                                        </p>
                                        <div class="flex items-center mt-1">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="ml-1 text-sm text-gray-600">{{ $item->formation->rating ?? '4.6' }}</span>
                                            <span class="ml-2 text-xs text-gray-400">({{ $item->formation->reviews_count ?? '451k' }} avis)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Participant Count -->
                                <div class="col-span-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="decrement-btn border border-gray-300 rounded-md p-1 hover:bg-gray-50">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               name="participants[{{ $item->formation->id }}]" 
                                               class="participant-count w-12 text-center border-0 bg-transparent text-sm font-medium"
                                               value="0" 
                                               min="0" 
                                               data-formation-id="{{ $item->formation->id }}"
                                               data-formation-name="{{ $item->formation->nom }}"
                                               data-formation-etablissement="{{ $item->formation->etablissement->nom ?? 'ISTA NTIC' }}"
                                               readonly>
                                        <button class="increment-btn border border-gray-300 rounded-md p-1 hover:bg-gray-50">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-span-3 flex items-center justify-center space-x-3">
                                    <div class="formation-checkbox" data-formation-id="{{ $item->formation->id }}">
                                        <button type="button" class="check-btn w-9 h-9 flex items-center justify-center rounded-md border-2 border-gray-300 hover:border-blue-500 transition-colors duration-200">
                                            <svg class="w-5 h-5 text-white check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="remove-btn text-gray-400 hover:text-red-600 p-2 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Votre wishlist est vide</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par ajouter des formations à votre wishlist</p>
        </div>
    @endif
</div>

<script>

    // Initialize selected formations and participants
    const selectedFormations = new Map();
    const participantCounts = new Map();

    // Increment/Decrement Buttons
    document.querySelectorAll('.increment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            
            // Update participant count in the map
            const formationId = input.dataset.formationId;
            participantCounts.set(formationId, currentValue + 1);
        });
    });

    document.querySelectorAll('.decrement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const currentValue = parseInt(input.value);
            if (currentValue > 0) {
                input.value = currentValue - 1;
                
                // Update participant count in the map
                const formationId = input.dataset.formationId;
                participantCounts.set(formationId, currentValue - 1);
            }
        });
    });

    // Check Button Functionality
    document.querySelectorAll('.check-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const checkboxDiv = this.closest('.formation-checkbox');
            const formationId = checkboxDiv.dataset.formationId;
            const isSelected = checkboxDiv.classList.contains('selected');
            
            if (isSelected) {
                // Deselect
                checkboxDiv.classList.remove('selected');
                this.classList.remove('bg-blue-500', 'border-blue-500');
                this.classList.add('border-gray-300');
                this.querySelector('.check-icon').classList.add('text-white');
                this.querySelector('.check-icon').classList.remove('text-blue-500');
                
                // Remove from selected formations
                selectedFormations.delete(formationId);
            } else {
                // Select
                checkboxDiv.classList.add('selected');
                this.classList.add('bg-blue-500', 'border-blue-500');
                this.classList.remove('border-gray-300');
                this.querySelector('.check-icon').classList.remove('text-white');
                this.querySelector('.check-icon').classList.add('text-white');
                
                // Add to selected formations
                const inputEl = document.querySelector(`input[data-formation-id="${formationId}"]`);
                const formationInfo = {
                    id: formationId,
                    name: inputEl.dataset.formationName,
                    etablissement: inputEl.dataset.formationEtablissement
                };
                selectedFormations.set(formationId, formationInfo);
            }
        });
    });

    // Remove Item Functionality
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const item = this.closest('.wishlist-item');
            const itemId = item.dataset.itemId;

            // Visual feedback
            item.style.opacity = '0.5';
            item.style.pointerEvents = 'none';

            try {
                const response = await fetch('{{ route("wishlist.removeItem") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ item_id: itemId })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to remove item');
                }

                if (data.success) {
                    // Show success alert
                    window.dispatchEvent(new CustomEvent('alert-show'));

                    // Remove item from DOM after 500ms animation
                    setTimeout(() => {
                        item.remove();
                        
                        // Update wishlist count
                        const countElement = document.querySelector('h2.text-xl');
                        if (countElement) {
                            const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]);
                            countElement.textContent = `Wishlist (${currentCount - 1})`;
                        }
                        
                        // Reload if last item
                        if (document.querySelectorAll('.wishlist-item').length === 0) {
                            window.location.reload();
                        }
                    }, 500);
                } else {
                    throw new Error(data.message || 'Failed to remove item');
                }

            } catch (error) {
                // Restore item visibility
                item.style.opacity = '1';
                item.style.pointerEvents = 'auto';
                
                // Show error message
                alert('Error: ' + error.message);
            }
        });
    });

    // Demand Devis Button
    document.getElementById('devis-button').addEventListener('click', function() {
        // Collect data
        const devisData = [];
        
        selectedFormations.forEach((formationInfo, formationId) => {
            const participants = participantCounts.get(formationId) || 0;
            
            if (participants > 0) {
                devisData.push({
                    formation_id: formationId,
                    formation_name: formationInfo.name,
                    etablissement: formationInfo.etablissement,
                    participants: participants
                });
            }
        });
        
        // Check if any formations are selected with participants
        if (devisData.length === 0) {
            alert('Veuillez sélectionner au moins une formation et spécifier le nombre de participants.');
            return;
        }
        
        // Create form and submit it to download the devis
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("devis.download") }}';
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add formation data
        const formationsInput = document.createElement('input');
        formationsInput.type = 'hidden';
        formationsInput.name = 'formations';
        formationsInput.value = JSON.stringify(devisData);
        form.appendChild(formationsInput);
        
        // Append to body and submit
        document.body.appendChild(form);
        form.submit();
    });

</script>