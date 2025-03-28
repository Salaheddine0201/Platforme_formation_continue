@extends('admin.layouts.admin')

@section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des domaines') }}
        </h2>
    </x-slot>

    <div class="py-12">
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

        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Bouton d'ajout -->
                    <div class="mb-6">
                        <button 
                            type="button" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 inline-flex items-center"
                            onclick="openCreateModal()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Ajouter un domaine
                        </button>
                    </div>

                    <!-- Filtres -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Filtres</h3>
                        <form action="{{ route('admin.domaines.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                                <input type="text" name="search" id="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" placeholder="Nom du domaine..." value="{{ request('search') }}">
                            </div>
                            
                            <div class="flex items-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Filtrer
                                </button>
                                <a href="{{ route('admin.domaines.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                    Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Tableau des domaines -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nom
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Image
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Icône
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($domaines as $domaine)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $domaine->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $domaine->nom }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex-shrink-0 h-16 w-16">
                                                @if ($domaine->image)
                                                    <img class="h-16 w-16 rounded-md object-cover" src="{{ asset('storage/domaines/' . $domaine->image) }}" alt="{{ $domaine->nom }}">
                                                @else
                                                    <div class="h-16 w-16 rounded-md bg-blue-100 flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium">{{ substr($domaine->nom, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($domaine->icon)
                                                <i class="{{ $domaine->icon }} text-xl"></i>
                                            @else
                                                <span class="text-gray-400">{{ substr($domaine->icon,7) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <button 
                                                type="button" 
                                                class="text-yellow-600 hover:text-yellow-900 inline-flex items-center" 
                                                onclick="openUpdateModal({{ $domaine->id }})"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Modifier
                                            </button>
                                            
                                            <button 
                                                type="button" 
                                                class="text-red-600 hover:text-red-900 inline-flex items-center" 
                                                onclick="confirmDelete({{ $domaine->id }})"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Aucun domaine trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $domaines->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de création -->
    <div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Ajouter un domaine</h3>
                    <button type="button" onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="createForm" method="POST" action="{{ route('admin.domaines.index') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="create_nom" class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" id="create_nom" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="create_icon" class="block text-sm font-medium text-gray-700">Icône</label>
                        <div class="input-group">
                            <input data-placement="bottomRight" class="form-control icp icp-auto block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" type="text" name="icon" id="create_icon" value="fas fa-book" />
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="create_image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="create_image" class="mt-1 block w-full">
                        <div id="create_image_preview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="create_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="create_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal de mise à jour -->
    <div id="updateModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Modifier le domaine</h3>
                    <button type="button" onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <form id="updateForm" method="POST" action="{{ route('admin.domaines.index')}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" id="nom" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="icon" class="block text-sm font-medium text-gray-700">Icône</label>
                        <div class="input-group">
                            <input data-placement="bottomRight" class="form-control icp icp-auto block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500" type="text" name="icon" id="icon" />
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full">
                        <div id="currentImage" class="mt-2"></div>
                        <div id="newImagePreview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-60 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Confirmation de suppression</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-sm text-gray-500">
                    Êtes-vous sûr de vouloir supprimer ce domaine ? Cette action est irréversible.
                </p>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Annuler
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Load FontAwesome IconPicker on document ready
        try {
    $(function() {
        $('.icp-auto').iconpicker();
    });
} catch (e) {
    console.error("IconPicker failed to initialize", e);
}
        
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            // Reinitialize the icon picker for the create form
            try {
    $(function() {
        $('.icp-auto').iconpicker();
    });
} catch (e) {
    console.error("IconPicker failed to initialize", e);
}
            const createImagePreview = document.getElementById('create_image_preview');
            const createImageInput = document.getElementById('create_image');

            createImageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        createImagePreview.innerHTML = `
                            <div class="text-sm text-gray-500 mb-2">Aperçu de l'image:</div>
                            <img src="${e.target.result}" class="h-24 w-24 object-cover rounded-md">
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    createImagePreview.innerHTML = '';
                }
            });
        }
        
        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }
        
        function openUpdateModal(domaineId) {
            // Fetch the domaine data
            fetch(`/dashboarddomaines/${domaineId}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch domaine data.');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate the form fields
                    document.getElementById('nom').value = data.nom;
                    document.getElementById('description').value = data.description || '';
                    
                    // Set the icon and update the icon picker for update form
                    document.getElementById('icon').value = data.icon || 'fas fa-book';
                    $('.icp-auto').iconpicker('update', data.icon || 'fas fa-book');

                    // Show current image if exists
                    const currentImageDiv = document.getElementById('currentImage');
                    if (data.image) {
                        currentImageDiv.innerHTML = `
                            <div class="text-sm text-gray-500 mb-2">Image actuelle:</div>
                            <img src="/storage/domaines/${data.image}" class="h-24 w-24 object-cover rounded-md" alt="${data.nom}">
                        `;
                    } else {
                        currentImageDiv.innerHTML = '';
                    }
                    const newImageInput = document.getElementById('image');
                    const newImagePreview = document.getElementById('newImagePreview');

                    newImageInput.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                newImagePreview.innerHTML = `
                                    <div class="text-sm text-gray-500 mb-2">Nouvelle image:</div>
                                    <img src="${e.target.result}" class="h-24 w-24 object-cover rounded-md">
                                `;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            newImagePreview.innerHTML = '';
                        }
                    });

                    // Set the form action URL for updating
                    document.getElementById('updateForm').action = `/dashboarddomaines/${domaineId}`;
                })
                .catch(error => {
                    console.error(error);
                    alert('Une erreur est survenue lors de la récupération des données.');
                });
            
            document.getElementById('updateModal').classList.remove('hidden');
        }
        
        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
        
        function confirmDelete(domaineId) {
            // Set the form action to the delete route
            document.getElementById('deleteForm').action = `/dashboarddomaines/${domaineId}`;
            
            // Show the delete modal
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        
        // Real-time search functionality
        document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const nomCell = row.querySelector('td:nth-child(2)');
            if (!nomCell) return; // Skip if not a data row
            const nomText = nomCell.textContent.toLowerCase();
            row.style.display = nomText.includes(searchTerm) ? '' : 'none';
        });
    });
});

    </script>
@endsection