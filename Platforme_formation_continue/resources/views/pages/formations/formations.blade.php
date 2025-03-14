@extends('layouts.app')

@section('content')
<!-- Hero section with search bar -->
<div class="relative h-64 md:h-80 w-full overflow-hidden ">
    <!-- Hero background image -->
    <div class="absolute inset-0">
        <img src="{{ asset('storage/images/searchFormations.png') }}" alt="Building at night" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-20"></div>
    </div>
    
    <!-- Search bar -->
    <div class="absolute inset-0 flex items-center justify-center">
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
<div class="container mx-auto px-4 py-8 mb-20">
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
                                    <input type="checkbox" name="etablissement_id[]" value="{{$etablissement->id}}" class="mr-2 filter-checkbox" data-category="{{$etablissement->nom}}" data-label="Universities">
                                    <span>{{$etablissement->nom}}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Tag filters -->
            <div class="mt-8">
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
                @foreach($formations ?? [] as $formation)
        
                <div  class="bg-white rounded-lg shadow-md overflow-hidden" onclick="window.location='{{ route('formation.show', ['id' => $formation->id]) }}'">
                    <div class="md:flex">
                        <div class="md:w-1/3">
                            <img src="{{ asset('storage/images/' . 'formation1.png') }}" alt="{{ $formation->nom ?? 'Formation' }}" class="h-48 w-full object-cover md:h-full">
                        </div>
                        <div class="p-6 md:w-2/3">
                            <h3 class="text-xl font-bold mb-2">
                                <a href="{{route('formation.show',['id'=>$formation->id])}}" class="text-gray-900 hover:text-blue-600">{{ $formation->nom ?? 'Best LearnPress WordPress Theme Collection For 2023' }}</a>
                            </h3>
                            <div class="text-blue-400 mb-3">
                                <i class="far fa-calendar-alt mr-1"></i>
                                <span>{{ $formation->created_at ?? 'Jan 24, 2023' }}</span>
                            </div>
                            <p class="text-gray-600">
                                {{ $formation->description ?? 'Looking for an amazing & well-functional LearnPress WordPress Theme? Online education...' }}
                            </p>
                        </div>
                    </div>
                </div>
        
                @endforeach

                
            </div>
        </div>
    </div>
</div>

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
    
    document.addEventListener('DOMContentLoaded', function() {
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

        Object.keys(activeFilters).forEach(category => {
            activeFilters[category].forEach((label, value) => {
                const newTag = tagTemplate.cloneNode(true);
                newTag.id = tag-${category}-${value};
                newTag.querySelector('.tag-label').textContent = label; // Show the filter name
                newTag.classList.remove('hidden');

                newTag.addEventListener('click', function() {
                    document.querySelector(input[type="checkbox"][value="${value}"]).checked = false;
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
        searchTerm.value = searchInput.value;
        fetch(filterForm.action + '?' + new URLSearchParams(new FormData(filterForm)))
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newFormations = doc.getElementById('formations-container');
                
                if (newFormations) {
                    document.getElementById('formations-container').innerHTML = newFormations.innerHTML;
                }
                
                const url = new URL(window.location);
                url.search = new URLSearchParams(new FormData(filterForm)).toString();
                window.history.pushState({}, '', url);
                console.log('URL:', url.toString());
            })
            .catch(error => console.error('Error fetching formations:', error));
    }
    
    // function initializeFromURL() {
    //     const params = new URLSearchParams(window.location.search);
        
    //     if (params.get('search')) {
    //         searchInput.value = params.get('search');
    //         searchTerm.value = params.get('search');
    //     }
        
    //     filterCheckboxes.forEach(checkbox => {
    //         if (params.has(checkbox.name)) {
    //             const values = params.getAll(checkbox.name);
    //             if (values.includes(checkbox.value)) {
    //                 checkbox.checked = true;
    //                 const category = checkbox.dataset.category;
    //                 if (!activeFilters[category]) {
    //                     activeFilters[category] = new Set();
    //                 }
    //                 activeFilters[category].add(checkbox.value);
    //             }
    //         }
    //     });
        
    //     updateSelectedFilters();
    // }
    
    // initializeFromURL();
});

</script>
@endsection