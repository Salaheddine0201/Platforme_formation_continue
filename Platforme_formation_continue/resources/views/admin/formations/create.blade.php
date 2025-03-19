<!-- Add Formation Modal -->
<div id="add-formation-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
    
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-4xl rounded-lg bg-white shadow-xl transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between rounded-t-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h3 class="text-xl font-medium text-white">Add New Formation</h3>
                <button type="button" id="close-modal" class="rounded-md bg-transparent text-white hover:bg-white hover:bg-opacity-20 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="max-h-[calc(100vh-200px)] overflow-y-auto p-6">
                <form id="add-formation-form" action="{{ route('admin.formations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Basic Information -->
                        <div class="space-y-4 md:col-span-2">
                            <h4 class="text-lg font-medium text-gray-700">Basic Information</h4>
                            
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="nom" id="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label for="etablissement_id" class="block text-sm font-medium text-gray-700">Établissement</label>
                                    <select name="etablissement_id" id="etablissement_id" class=" mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 " required>
                                        <option value="">Select an établissement</option>
                                        @foreach($etablissements as $etablissement)
                                            <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="domaine_id" class="block text-sm font-medium text-gray-700">Domaine</label>
                                    <select name="domaine_id" id="domaine_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 " required>
                                        <option value="">Select a domaine</option>
                                        @foreach($domaines as $domaine)
                                            <option value="{{ $domaine->id }}">{{ $domaine->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                            </div>
                            
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <div class="mt-1 flex items-center">
                                    <div id="image-preview" class="relative h-32 w-32 overflow-hidden rounded-md border-2 border-dashed border-gray-300 bg-gray-100">
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <img id="preview-image" class="absolute inset-0 h-full w-full object-cover" style="display: none;" alt="Preview">
                                    </div>
                                    <label for="image-upload" class="ml-5 cursor-pointer rounded-md bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Select Image
                                    </label>
                                    <input id="image-upload" name="image" type="file" accept="image/*" class="hidden" onchange="previewImage(this)">
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="trend" id="trend" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="trend" class="ml-2 block text-sm text-gray-700">Mark as trending</label>
                            </div>
                        </div>
                        
                        <!-- Sub Titles Section -->
                        <div class="space-y-4 rounded-lg bg-gray-50 p-4">
                            <h4 class="text-lg font-medium text-gray-700">Sub Titles</h4>
                            
                            <div class="flex">
                                <input type="text" id="sub-title-input" class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Add a sub title">
                                <button type="button" id="add-sub-title" class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add
                                </button>
                            </div>
                            
                            <div>
                                <ul id="sub-titles-list" class="mt-2 list-inside list-disc space-y-1 text-sm text-gray-700">
                                    <!-- Sub titles will be added here dynamically -->
                                </ul>
                            </div>
                            
                            <!-- Hidden input to store JSON data -->
                            <input type="hidden" name="sub_titles" id="sub-titles-json">
                        </div>
                        
                        <!-- Requirements Section -->
                        <div class="space-y-4 rounded-lg bg-gray-50 p-4">
                            <h4 class="text-lg font-medium text-gray-700">Requirements</h4>
                            
                            <div class="flex">
                                <input type="text" id="requirement-input" class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Add a requirement">
                                <button type="button" id="add-requirement" class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add
                                </button>
                            </div>
                            
                            <div>
                                <ul id="requirements-list" class="mt-2 list-inside list-disc space-y-1 text-sm text-gray-700">
                                    <!-- Requirements will be added here dynamically -->
                                </ul>
                            </div>
                            
                            <!-- Hidden input to store JSON data -->
                            <input type="hidden" name="requirements" id="requirements-json">
                        </div>
                        
                        <!-- Includes Section -->
                        <div class="space-y-4 rounded-lg bg-gray-50 p-4 md:col-span-2">
                            <h4 class="text-lg font-medium text-gray-700">Includes</h4>
                            
                            <div class="flex">
                                <input type="text" id="include-input" class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Add what's included">
                                <button type="button" id="add-include" class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add
                                </button>
                            </div>
                            
                            <div>
                                <ul id="includes-list" class="mt-2 list-inside list-disc space-y-1 text-sm text-gray-700">
                                    <!-- Includes will be added here dynamically -->
                                </ul>
                            </div>
                            
                            <!-- Hidden input to store JSON data -->
                            <input type="hidden" name="includes" id="includes-json">
                        </div>
                        
                        <!-- Languages Section (Optional) -->
                        <div class="space-y-4 rounded-lg bg-gray-50 p-4 md:col-span-2">
                            <h4 class="text-lg font-medium text-gray-700">Languages</h4>
                            
                            <div class="flex flex-wrap gap-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="French" id="lang-fr" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="lang-fr" class="ml-2 text-sm text-gray-700">French</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="English" id="lang-en" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="lang-en" class="ml-2 text-sm text-gray-700">English</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="Arabic" id="lang-ar" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="lang-ar" class="ml-2 text-sm text-gray-700">Arabic</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="Spanish" id="lang-es" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="lang-es" class="ml-2 text-sm text-gray-700">Spanish</label>
                                </div>
                                <!-- Add more languages as needed -->
                            </div>
                        </div>
                        
                        <!-- For Who Section -->
                        <div class="space-y-4 rounded-lg bg-gray-50 p-4 md:col-span-2">
                            <h4 class="text-lg font-medium text-gray-700">Who Is This Formation For?</h4>
                            
                            <div class="flex">
                                <input type="text" id="for-who-input" class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Add target audience">
                                <button type="button" id="add-for-who" class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add
                                </button>
                            </div>
                            
                            <div>
                                <ul id="for-whos-list" class="mt-2 list-inside list-disc space-y-1 text-sm text-gray-700">
                                    <!-- For who entries will be added here dynamically -->
                                </ul>
                            </div>
                            
                            <!-- Hidden input to store JSON data -->
                            <input type="hidden" name="for_whos" id="for-whos-json">
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-3 border-t border-gray-200 pt-5">
                        <button type="button" id="cancel-add-formation" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Formation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Array storage for dynamic lists
let subTitles = [];
let requirements = [];
let includes = [];
let forWhos = [];

document.addEventListener('DOMContentLoaded', function() {
    // Open & Close Modal
    const openModalButton = document.getElementById('open-add-modal');
    const closeModalButton = document.getElementById('close-modal');
    const cancelButton = document.getElementById('cancel-add-formation');
    const modal = document.getElementById('add-formation-modal');

    if (openModalButton) {
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    }

    if (closeModalButton) {
        closeModalButton.addEventListener('click', closeModal);
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', closeModal);
    }

    document.getElementById('etablissement_id').addEventListener('change',(event)=>{
        event.preventDefault();
    });
    
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        // Reset form
        document.getElementById('add-formation-form').reset();
        resetLists();
    }

    // Handle image preview
    window.previewImage = function(input) {
        const preview = document.getElementById('preview-image');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    };

    // Sub Titles
    const addSubTitleBtn = document.getElementById('add-sub-title');
    const subTitleInput = document.getElementById('sub-title-input');
    const subTitlesList = document.getElementById('sub-titles-list');
    const subTitlesJson = document.getElementById('sub-titles-json');

    addSubTitleBtn.addEventListener('click', () => {
        addItemToList(subTitleInput, subTitlesList, subTitles, subTitlesJson);
    });
    
    subTitleInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addItemToList(subTitleInput, subTitlesList, subTitles, subTitlesJson);
        }
    });

    // Requirements
    const addRequirementBtn = document.getElementById('add-requirement');
    const requirementInput = document.getElementById('requirement-input');
    const requirementsList = document.getElementById('requirements-list');
    const requirementsJson = document.getElementById('requirements-json');

    addRequirementBtn.addEventListener('click', () => {
        addItemToList(requirementInput, requirementsList, requirements, requirementsJson);
    });
    
    requirementInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addItemToList(requirementInput, requirementsList, requirements, requirementsJson);
        }
    });

    // Includes
    const addIncludeBtn = document.getElementById('add-include');
    const includeInput = document.getElementById('include-input');
    const includesList = document.getElementById('includes-list');
    const includesJson = document.getElementById('includes-json');

    addIncludeBtn.addEventListener('click', () => {
        addItemToList(includeInput, includesList, includes, includesJson);
    });
    
    includeInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addItemToList(includeInput, includesList, includes, includesJson);
        }
    });

    // For Who
    const addForWhoBtn = document.getElementById('add-for-who');
    const forWhoInput = document.getElementById('for-who-input');
    const forWhosList = document.getElementById('for-whos-list');
    const forWhosJson = document.getElementById('for-whos-json');

    addForWhoBtn.addEventListener('click', () => {
        addItemToList(forWhoInput, forWhosList, forWhos, forWhosJson);
    });
    
    forWhoInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addItemToList(forWhoInput, forWhosList, forWhos, forWhosJson);
        }
    });

    // Form submission
    const form = document.getElementById('add-formation-form');
    form.addEventListener('submit', function(e) {
        // Prevent the default form submission
        e.preventDefault();
        
        // Make sure all JSON fields are updated before submitting
        updateJsonField(subTitles, subTitlesJson);
        updateJsonField(requirements, requirementsJson);
        updateJsonField(includes, includesJson);
        updateJsonField(forWhos, forWhosJson);
        
        // Now submit the form programmatically
        this.submit();
    });

    // Common function to add items to any list
    function addItemToList(input, listElement, array, jsonField) {
        const value = input.value.trim();
        if (value === '') return;

        // Add to array
        array.push(value);
        
        // Update the hidden JSON field
        updateJsonField(array, jsonField);
        
        // Create list item with delete button
        const li = document.createElement('li');
        li.className = 'flex items-center justify-between';
        
        const textSpan = document.createElement('span');
        textSpan.textContent = value;
        
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'ml-2 text-red-500 hover:text-red-700';
        deleteBtn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        
        deleteBtn.addEventListener('click', function() {
            // Remove from array
            const index = array.indexOf(value);
            if (index > -1) {
                array.splice(index, 1);
            }
            
            // Update JSON
            updateJsonField(array, jsonField);
            
            // Remove list item
            li.remove();
        });
        
        li.appendChild(textSpan);
        li.appendChild(deleteBtn);
        listElement.appendChild(li);
        
        // Clear input
        input.value = '';
        input.focus();
    }

    // Update hidden JSON field
    function updateJsonField(array, field) {
        field.value = JSON.stringify(array);
    }

    // Reset all lists
    function resetLists() {
        subTitles = [];
        requirements = [];
        includes = [];
        forWhos = [];
        
        document.getElementById('sub-titles-list').innerHTML = '';
        document.getElementById('requirements-list').innerHTML = '';
        document.getElementById('includes-list').innerHTML = '';
        document.getElementById('for-whos-list').innerHTML = '';
        
        document.getElementById('sub-titles-json').value = '[]';
        document.getElementById('requirements-json').value = '[]';
        document.getElementById('includes-json').value = '[]';
        document.getElementById('for-whos-json').value = '[]';
        
        // Reset image preview
        const preview = document.getElementById('preview-image');
        preview.style.display = 'none';
        preview.src = '';
    }
    
    // Initialize JSON fields with empty arrays
    document.getElementById('sub-titles-json').value = JSON.stringify([]);
    document.getElementById('requirements-json').value = JSON.stringify([]);
    document.getElementById('includes-json').value = JSON.stringify([]);
    document.getElementById('for-whos-json').value = JSON.stringify([]);
});

</script>