<section class="bg-[#F8F8F8] py-12 relative">
    <div class="container mx-auto px-4 py-12 max-w-6xl">
        <h2 class="text-center text-2xl md:text-3xl font-bold text-blue-800 mb-6">
            NOS ÉTABLISSEMENTS DE FORMATIONS
        </h2>
        
        <p class="text-center text-gray-600 mb-8 max-w-3xl mx-auto">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et blandit id mi a vulputate. Nunc, eros, a mattis sapien.
        </p>
        
        <!-- Conteneur principal avec position relative et padding pour les boutons -->
        <div class="relative px-4 md:px-10 lg:px-16">
            <!-- Swiper Slider -->
            <div class="swiper mySwiper-etablissements mt-8 rounded-2xl">
                <div class="swiper-wrapper">
                    @foreach($etablissements as $etablissement)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                            <div class="relative">
                                <img src="{{ asset('storage/etablissements/'.$etablissement->image) }}" alt="{{ $etablissement->nom }}" class="w-full h-64 object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <div class="flex items-center">
                                        <img src="{{ asset('storage/logo/'.$etablissement->logo) }}" alt="{{ $etablissement->logo }}" class="w-12 h-12 rounded-full bg-white p-1">
                                        <h3 class="text-white font-bold ml-3">{{ $etablissement->nom }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $etablissement->adresse }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ $etablissement->description }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-xs text-gray-500 ml-1"><a href="{{ $etablissement->localisation }}" target="_blank">Localisation</a></span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Boutons de navigation personnalisés -->
            <button class="hidden md:flex absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-md text-blue-500 hover:text-blue-700 focus:outline-none items-center justify-center w-10 h-10 mySwiper-etablissements-prev">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="hidden md:flex absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-md text-blue-500 hover:text-blue-700 focus:outline-none items-center justify-center w-10 h-10 mySwiper-etablissements-next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <!-- Pagination positionnée en dessous du carrousel avec une marge fixe -->
            <div class="swiper-pagination mySwiper-etablissements-pagination !relative !bottom-0 mt-8"></div>
        </div>
    </div>
</section>


@push('scripts')
<script>
    // Initialize Swiper for the etablissements section with unique selectors
 
        var swiperEtablissements = new Swiper(".mySwiper-etablissements", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
            el: ".mySwiper-etablissements-pagination",
            clickable: true,
            },
            navigation: {
            nextEl: ".mySwiper-etablissements-next",
            prevEl: ".mySwiper-etablissements-prev",
            },
            breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
            },
            autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            },
        });

        document.addEventListener("turbo:load", function() {
            swiperEtablissements.init();
        });
    
</script>
@endpush