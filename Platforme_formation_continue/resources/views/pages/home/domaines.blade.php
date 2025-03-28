<section class="bg-white py-12">
    <div class="container mx-auto px-4 py-12 max-w-6xl">
        <h2 class="text-center text-2xl md:text-3xl font-bold text-blue-800 mb-2">
            NOS DOMAINES DE FORMATION
        </h2>

        <p class="text-center text-gray-600 mb-8 max-w-3xl mx-auto">
            Depuis [année], notre plateforme de formation continue accompagne les entreprises dans le développement des compétences de leurs équipes.
        </p>

        <!-- Conteneur principal avec position relative et padding pour les boutons -->
        <div class="relative px-4 md:px-10 lg:px-16">
            <!-- Swiper Slider -->
            <div class="swiper mySwiper-domaines mt-8">
                <div class="swiper-wrapper">
                    @foreach($domaines as $domaine)
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center">
                            <div class="relative w-full h-48 md:h-56 overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/domaines/'.$domaine->image) }}" alt="{{ $domaine->nom }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                                    <div class="bg-white rounded-full w-10 h-10 flex items-center justify-center">
                                        <i class=" {{ $domaine->icon }} text-black"></i>
                                    </div>
                                </div>
                            </div>
                            <h3 class="mt-4 font-bold text-blue-800 uppercase text-center">{{ $domaine->nom }}</h3>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Boutons de navigation personnalisés -->
            <button class="hidden md:flex absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-md text-blue-500 hover:text-blue-700 focus:outline-none items-center justify-center w-10 h-10 mySwiper-domaines-prev">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="hidden md:flex absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-md text-blue-500 hover:text-blue-700 focus:outline-none items-center justify-center w-10 h-10 mySwiper-domaines-next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <!-- Pagination positionnée en dessous du carrousel avec une marge fixe -->
            <div class="swiper-pagination mySwiper-domaines-pagination !relative !bottom-0 mt-8"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Initialize Swiper for the domaines section with unique selectors
    const swiperDomaines = new Swiper(".mySwiper-domaines", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: {
        el: ".mySwiper-domaines-pagination",
        clickable: true,
        },
        navigation: {
        nextEl: ".mySwiper-domaines-next",
        prevEl: ".mySwiper-domaines-prev",
        },
        breakpoints: {
        640: { slidesPerView: 2, spaceBetween: 20 },
        768: { slidesPerView: 3, spaceBetween: 30 },
        1024: { slidesPerView: 4, spaceBetween: 40 },
        1280: { slidesPerView: 5, spaceBetween: 50 }
        },
        autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        },
    });
    
    document.addEventListener("turbo:load", () => {
        swiperDomaines.update();
    });
</script>
@endpush
