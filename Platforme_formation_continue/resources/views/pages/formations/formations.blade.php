
@extends('layouts.app')

@section('content')
<!-- Hero section with search bar -->
<div class="relative h-64 md:h-80 w-full overflow-hidden ">
    <!-- Hero background image -->
    <div class="absolute inset-0">
        <img id="hero-image" src="{{ asset('images/searchFormations5.png') }}" alt="Building at night" class="w-full h-full object-cover">
        <div class="absolute object-cover inset-0 bg-black opacity-20"></div>
    </div>
    
    <!-- Search bar -->
    <div class="absolute inset-x-0 bottom-[20%] flex items-center justify-center">
        <div class="w-full max-w-3xl px-4">
            <div class="relative">
                <input type="text" id="search-input" placeholder="Search..." class="w-full py-3 px-5 pr-10 rounded-full shadow-lg text-gray-700">
                <button id="search-button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Main content area -->
<div class="container mx-auto px-10  py-8 mb-20">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Left sidebar filters -->
        
        <div class="w-full md:w-64 shrink-0">
            <h2 class="text-xl font-semibold mb-4">Filter</h2>
            
            <form id="filter-form" 
            action="{{ route('formations') }}" 
            method="GET">
                <!-- Search input hidden field to include in form submission -->
                <input type="hidden" id="search-term" name="search">
                
                <!-- Filter accordions -->
                
                <div class="space-y-4">
                    <!-- Domain filter -->
                    <div class="bg-white rounded-md shadow-sm">
                        
                        <button type="button" class="w-full px-4 py-3 text-left flex justify-between items-center" onclick="toggleAccordion('domaine')">
                            <span>Domaine</span>
                            <i class="fas fa-chevron-down text-blue-500"></i>
                        </button>
                        <div id="domaine" class="hidden px-4 py-2">
                            <!-- Filter content here -->
                            <div class="space-y-2">
                                @foreach($domaines ?? [] as $domaine)
                                <label class="flex items-center">
                                    <input type="checkbox" name="domaine_id[]"  value="{{$domaine->id}}" class="mr-2 filter-checkbox" data-category="domaine" data-label="Web Development">
                                    <span>{{$domaine->nom}}</span>
                                </label>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                    
                   
                    
                    <!-- Establishment filter -->
                    <div class="bg-white rounded-md shadow-sm">
                        <button type="button" class="w-full px-4 py-3 text-left flex justify-between items-center" onclick="toggleAccordion('etablissement')">
                            <span>Établissement</span>
                            <i class="fas fa-chevron-down text-blue-500"></i>
                        </button>
                        <div id="etablissement" class="hidden px-4 py-2">
                            <!-- Filter content here -->
                            @foreach($etablissements ?? [] as $etablissement)
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="etablissement_id[]" value="{{$etablissement->id}}" class="mr-2 filter-checkbox" data-category="etablissement" data-label="Universities">
                                    <span>{{$etablissement->nom}}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Tag filters -->
            <div class="votre_filter mt-8 ">
                <h3 class="text-lg font-semibold mb-4">Votre Filter</h3>
                <div id="selected-filters" class="flex flex-wrap gap-2">
                    <!-- Dynamically populated tags will appear here -->
                    <button class="px-4 py-2 bg-white rounded-md shadow-sm hover:bg-gray-50 hidden" id="tag-template">
                        <span class="tag-label">Filter</span>
                        <i class="fas fa-times ml-2 text-gray-500"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Right content area -->
        <div class="flex-1">
            <!-- Articles list -->
            <div id="formations-container" class="space-y-6">
                <!-- Formation items will be loaded here -->
               @include('pages.formations.partials.formations_list')

                
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // Toggle accordion functionality
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
        } else {
            content.classList.add('hidden');
        }
    }
    
    
    const filterForm = document.getElementById('filter-form');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const searchTerm = document.getElementById('search-term');
    const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
    const selectedFiltersContainer = document.getElementById('selected-filters');
    const tagTemplate = document.getElementById('tag-template');
    
    const activeFilters = {};
    
    searchButton.addEventListener('click', function() {
        searchTerm.value = searchInput.value;
        submitFilters();
    });
    
    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            searchTerm.value = searchInput.value;
            submitFilters();
            searchInput.value='';
            
        }
    });
    
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const category = this.dataset.category;
            const value = this.value;
            const label = this.nextElementSibling.textContent;

            if (!activeFilters[category]) {
                activeFilters[category] = new Map();
            }

            if (this.checked) {
                activeFilters[category].set(value, label);
            } else {
                activeFilters[category].delete(value);
                if (activeFilters[category].size === 0) {
                    delete activeFilters[category];
                }
            }

            updateSelectedFilters();
            submitFilters();
        });
    });

    function updateSelectedFilters() {
        selectedFiltersContainer.innerHTML = '';

        const filterContainer = document.querySelector('.votre_filter'); // "Votre Filter" div

        if (Object.keys(activeFilters).length === 0) {
            filterContainer.classList.add('hidden'); // Hide if no filters are selected
        } else {
            filterContainer.classList.remove('hidden'); // Show if filters exist
        }

        Object.keys(activeFilters).forEach(category => {
            activeFilters[category].forEach((label, value) => {
                const newTag = tagTemplate.cloneNode(true);
                newTag.id = `tag-${category}-${value}`;
                newTag.querySelector('.tag-label').textContent = label; // Show the filter name
                newTag.classList.remove('hidden');

                newTag.addEventListener('click', function() {
                    document.querySelector(`input[name="${category}_id[]"][value="${value}"]`).checked= false;
                    activeFilters[category].delete(value);
                    if (activeFilters[category].size === 0) {
                        delete activeFilters[category];
                    }
                    updateSelectedFilters();
                    submitFilters();
                });

                selectedFiltersContainer.appendChild(newTag);
            });
        });
    }

    
    function submitFilters() {
    // Cache the search value to avoid repeated DOM access
    const searchValue = searchInput.value;
    searchTerm.value = searchValue;
    
    // Use FormData object once instead of creating it multiple times
    const formData = new FormData(filterForm);
    const queryParams = new URLSearchParams(formData);
    
    // Update URL first (non-blocking)
    const url = new URL(window.location);
    url.search = queryParams.toString();
    window.history.pushState({}, '', url);
    
   
   
    // Fetch with proper error handling and optimization
    fetch(filterForm.action + '?' + queryParams)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            // Use a more efficient approach to update the DOM
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            const newFormations = tempDiv.querySelector('#formations-container');
            
            if (newFormations) {
                // Direct HTML replacement is faster than innerHTML
                const currentFormations = document.getElementById('formations-container');
                currentFormations.replaceWith(newFormations);
            }
        })
        .catch(error => {
            console.error('Error fetching formations:', error);
            // Consider adding user-friendly error handling here
        });
}
    
    function initializeFromURL() {
        const params = new URLSearchParams(window.location.search);
        
        if (params.get('search')) {
            searchInput.value = params.get('search');
            searchTerm.value = params.get('search');
        }
        
        filterCheckboxes.forEach(checkbox => {
            if (params.has(checkbox.name)) {
                const values = params.getAll(checkbox.name);
                if (values.includes(checkbox.value)) {
                    checkbox.checked = true;
                    const value=checkbox.value;
                    const label=checkbox.nextElementSibling.textContent;
                    const category = checkbox.dataset.category;
                    if (!activeFilters[category]) {
                        activeFilters[category] = new Map();
                    }
                    activeFilters[category].set(value, label);
                }
            }
        });
        
        updateSelectedFilters();
    }
    
    initializeFromURL();

    const image = document.querySelector("#hero-image"); // Select the image
    const imagePaths = [
        "{{ asset('images/searchFormations1.png') }}",
        "{{ asset('images/searchFormations2.png') }}",
        "{{ asset('images/searchFormations3.jpg') }}",
        "{{ asset('images/searchFormations4.jpg') }}",
        "{{ asset('images/searchFormations5.png') }}",
    ];
    
    let index = 0;

    function changeImage() {
        index = (index + 1) % imagePaths.length;
        image.src = imagePaths[index];
    }

    setInterval(changeImage, 10000); // Change every 10 seconds

</script>
@endpush
@endsection

