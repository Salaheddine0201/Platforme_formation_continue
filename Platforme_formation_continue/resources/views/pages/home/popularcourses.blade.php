<!-- popular-courses.blade.php -->
<section class="bg-[#F8F8F8] py-12">
    <div class="container mx-auto px-4 py-12 max-w-6xl">
        <!-- Section Title -->
        <div class="text-center mb-10">
            <h2 class="text-center text-2xl md:text-3xl font-bold text-blue-800 mb-6">
                Formations populaires
                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-primary"></span>
            </h2>
        </div>

        <!-- Courses Slider -->
        <div class="swiper-container mySwiper-popular-courses">
            <div class="swiper-wrapper pb-10">
                @foreach($popularFormations as $formation)
                <div class="swiper-slide p-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col transition-transform hover:shadow-lg hover:-translate-y-1">
                        <div class="relative bg-cyan-500 h-48">
                            <img src="{{ asset('storage/'.$formation->image) }}" alt="{{ $formation->nom }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.jp/150x150.png'">
                        </div>
                        <div class="flex items-center gap-1 px-4 py-2 bg-gray-100">
                            <div class="flex -space-x-2">
                                @foreach($formation->recentParticipants as $inscription)
                                    @if($inscription->user)
                                        @if($inscription->user->image)
                                            <img class="w-8 h-8 rounded-full border-2 border-white" 
                                                 src="{{ asset('storage/'.$inscription->user->image) }}" 
                                                 alt="{{ $inscription->user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center">
                                                <span class="text-gray-500 text-xs font-bold">
                                                    {{ substr($inscription->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            @if($formation->total_participants > 0)
                            <span class="text-sm text-gray-600">• {{ $formation->total_participants }} Participants</span>
                            @endif
                            
                        </div>
                        <div class="p-4 flex-grow">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $formation->nom }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($formation->description, 100) }}</p>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-between items-center">
                            <a href="{{ route('formation.show', $formation->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-primaryDark transition">Explore</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>

        // Function to initialize Swiper for Popular Courses
        function initializeSwiperPopular() {
            const swiperPopular = new Swiper('.mySwiper-popular-courses', {
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                // when window width is >= 640px
                640: {
                slidesPerView: 2,
                },
                // when window width is >= 1024px
                1024: {
                slidesPerView: 3,
                },
                // when window width is >= 1280px
                1280: {
                slidesPerView: 4,
                }
            },
            autoplay: {
                delay: 5000,
            },
            });
        }

        // Initialize Swiper on page load
        document.addEventListener('DOMContentLoaded', initializeSwiperPopular);

        // Reinitialize Swiper after Turbo renders
        document.addEventListener('turbo:render', initializeSwiperPopular);
    
</script>
@endpush
