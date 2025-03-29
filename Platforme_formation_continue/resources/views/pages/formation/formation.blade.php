@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Formations') }}
    </h2>
@endsection
@section('content')
    <!-- Main Content -->
    <div class="container mx-auto px-10 pt-20 pb-8">
        <div class="flex flex-col md:flex-row">
            <!-- Left Column - Formation Info -->
            <div class="md:w-2/3 pr-0 md:pr-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $formation->nom }}</h1>
                {{-- <p class="text-gray-600 mb-4">3 in 1 Formation: Learn to design websites with Figma, build with Webflow, and
                    make a living freelancing.</p> --}}

                <!-- Rating -->
                <div class="flex items-center mb-6">
                    <span class=" text-gray-800 mr-2">{{ $averageRating }}</span>
                    <div class="flex text-yellow-400">
                        @for ($i = 0; $i < 5; $i++)
                            <i
                                class="{{ $i < floor($averageRating) ? 'fas fa-star' : ($i < ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5 ? 'fas fa-star-half-alt' : 'far fa-star') }}"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-600"> ({{ count($formation->reviews) }} Rating)</span>
                </div>

                <!-- Formation Preview Image -->
                <div class="relative rounded-lg overflow-hidden mb-8 bg-pink-100">
                    <img src="{{ asset('storage/' . $formation->image) }}" alt="Formation Preview"
                        class="w-full object-cover h-64 md:h-96">
                    {{-- <button class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg">
                        <i class="fas fa-play text-blue-500 text-xl"></i>
                    </button> --}}
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-2">
                            <a href="#"
                                class="inline-block py-4 px-4 text-sm font-medium text-center border-b-2 border-blue-500 text-blue-600">Aperçu</a>
                        </li>
                        <li class="mr-2">
                            <a href="#Curriculum"
                                class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 hover:text-gray-700">Programme</a>
                        </li>
                        <li class="mr-2">
                            <a href="#Aqui"
                                class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 hover:text-gray-700">À
                                qui</a>
                        </li>
                        <li class="mr-2">
                            <a href="#Requirements"
                                class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 hover:text-gray-700">Prérequis</a>
                        </li>
                        <li class="mr-2">
                            <a href="#Reviews"
                                class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 hover:text-gray-700">Avis</a>
                        </li>
                    </ul>
                </div>

                <!-- Description -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Description</h2>
                    <div class="text-gray-700 space-y-4">
                        <p>{{ $formation->description }}</p>
                        @if ($formation->description == null)
                            <p>Il n'y a pas de description pour cette formation</p>
                        @endif
                    </div>


                    <!-- Ce que vous apprendrez dans ce cours Section -->
                    <div id="Curriculum" class="mt-8 border border-gray-200 rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Ce que vous apprendrez dans ce cours</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- @dd(json_decode($formation->sub_titles)) --}}
                            @foreach (json_decode($formation->sub_titles) ?? [] as $sub_title)
                                <div class="flex">
                                    <div
                                        class="flex-shrink-0 h-6 w-6 rounded-full bg-green-500 flex items-center justify-center mt-1">
                                        <span class="text-white text-xs">✓</span>
                                    </div>
                                    <p class="ml-3 text-gray-700 text-sm">{{ $sub_title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- À qui s'adresse ce Formation Section -->
                    <div id="Aqui" class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">À qui s'adresse ce Formation :</h2>

                        <ul class="space-y-3 text-gray-700">
                            @foreach (json_decode($formation->for_whos) ?? [] as $forElement)
                                <li class="flex items-start">
                                    <span class="text-blue-500 mr-2">❯</span>
                                    <span>{{ $forElement }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Formation requirements Section -->
                    <div id="Requirements" class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Prérequis de la formation</h2>

                        <ul class="list-disc pl-5 space-y-3 text-gray-700">
                            @foreach (json_decode($formation->requirements) ?? [] as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column - Formation Purchase Card -->
            <div class="md:w-1/3 mt-8 md:mt-0">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden sticky top-4">
                    <!-- Discount Banner -->
                    <div class="bg-blue-500 text-white py-2 px-4 flex justify-between">
                        <span class="font-semibold">56% de réduction</span>
                        <span class="text-sm">2 jours restants pour cette offre !</span>
                    </div>

                    <!-- Formation Details -->
                    <div class="p-6">


                        <!-- Students Enrolled -->
                        <div class="flex justify-between mb-4">
                            <div class="flex items-center">
                                <span class="text-gray-500 mr-2">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="text-sm text-gray-600">Étudiants inscrits</span>
                            </div>
                            <span class="text-sm text-gray-800">
                                @php
                                    $number_personne = 0;
                                @endphp

                                @foreach ($formation->inscriptions as $inscription)
                                    @php
                                        $number_personne += $inscription->number_personne;
                                    @endphp
                                @endforeach

                                {{ $number_personne }}
                            </span>
                        </div>


                        <!-- Language -->
                        <div class="flex justify-between mb-6">
                            <div class="flex items-center">
                                <span class="text-gray-500 mr-2">
                                    <i class="fas fa-globe"></i>
                                </span>
                                <span class="text-sm text-gray-600">Langues</span>
                            </div>
                            <span class="text-sm text-gray-800">
                                @foreach (json_decode($formation->languages) ?? [] as $language)
                                    {{ $language . ', ' }}
                                @endforeach
                            </span>
                        </div>

                        <!-- Action Buttons -->

                        <form action="{{ route('cart.add', $formation->id) }}" method="POST">
                            @csrf
                            <button type="submit"  class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded mb-3">
                                Ajouter au panier
                            </button>
                           
                        </form>
                        <form action="{{ route('cart.devis', $formation->id) }}" method="POST">
                            @csrf
                            <button
                                class="w-full bg-white hover:bg-gray-50 text-blue-500 font-medium py-3 px-4 rounded border border-blue-500 mb-3">
                                Demande De Devis
                            </button>
                            {{-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button> --}}
                        </form>


                        <!-- Secondary Actions -->
                        {{-- <div class="flex justify-between mb-6">
                            <button class="text-gray-600 text-sm hover:text-blue-500">
                                <i class="far fa-heart mr-1"></i> Add To Wishlist
                            </button>
                            <button class="text-gray-600 text-sm hover:text-blue-500">
                                <i class="fas fa-gift mr-1"></i> Gift Formation
                            </button>
                        </div> --}}

                        <!-- Guarantee Notice -->
                        <div class="text-center text-xs text-gray-500 mb-6">
                            <p>Remarque : Toutes les formations bénéficient d'une garantie de remboursement de 30 jours</p>
                        </div>

                        <!-- What's Included -->
                        <div>
                            <h3 class="font-medium text-gray-800 mb-4">Cette formation inclut :</h3>
                            <ul class="space-y-3">
                                @foreach (json_decode($formation->includes) ?? [] as $include)
                                    <li class="flex items-center text-sm text-gray-600">
                                        <i class="fa-solid fa-arrow-right text-blue-500 mr-3"></i>
                                        {{ $include }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Share Formation -->
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-800 mb-3">Partager cette formation :</h3>
                            <div class="flex space-x-3">
                                <a href="#" onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link copied to clipboard!');" class="text-gray-600 hover:text-blue-500">
                                    <i class="fas fa-link"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="text-gray-600 hover:text-blue-700" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" class="text-gray-600 hover:text-blue-400" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="mailto:?subject=Check out this formation&body={{ urlencode(url()->current()) }}" class="text-gray-600 hover:text-blue-500">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" class="text-gray-600 hover:text-green-600" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- reriews --}}
<div id="Reviews" class="container mx-auto px-10 sm:px-6 lg:px-10 mb-20">
    @if (count($formation->reviews) !== 0)
        <div class="mt-8">
            <h2 class="text-lg sm:text-xl font-semibold mb-4">Evaluation du Formation</h2>
            <div class="flex flex-col sm:flex-row items-start sm:items-center mb-4">
                <div class="mr-0 sm:mr-4 mb-4 sm:mb-0 text-center sm:text-left">
                    <span class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $averageRating }}</span>
                    <div class="flex justify-center sm:justify-start text-yellow-400">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="{{ $i < floor($averageRating) ? 'fas fa-star' : ($i < ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5 ? 'fas fa-star-half-alt' : 'far fa-star') }}"></i>
                        @endfor
                    </div>
                    <div class="text-sm text-gray-500">Evaluation du Formation</div>
                </div>
                <div class="w-full sm:flex-1">
                    @foreach (range(5, 1) as $star)
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400 mr-2">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="{{ $i < $star ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                            </div>
                            <span class="text-xs sm:text-sm text-gray-600 mr-2">{{ $star }} étoiles</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $ratingPercentages[$star] }}%"></div>
                            </div>
                            <span class="text-xs sm:text-sm text-gray-600 ml-2">{{ $ratingPercentages[$star] }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

     <!--Comments Section -->
    <div class="mt-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Les commentaires</h2>
            <div class="flex items-center space-x-2 sm:space-x-3 mt-3 sm:mt-0">
                <select id="rating-filter" class="bg-white border rounded-lg px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="6">Tous les commentaires</option>
                    <option value="5">5 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="2">2 étoiles</option>
                    <option value="1">1 étoile</option>
                </select>
                <button id="openRatingModal" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 text-xs sm:text-sm rounded-lg shadow-sm flex items-center">
                    <span>Évaluer</span>
                    <svg class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="reviews-container">
            @foreach ($formation->reviews as $review)
                <div class="review-item border-t border-gray-200 py-4 flex flex-col sm:flex-row items-start" data-rating="{{ $review->note }}">
                    <img src="{{ asset('storage/'.$review->user->image) }}" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <div class="flex items-center">
                            <h3 class="font-medium text-gray-800 mr-2">{{ $review->user->name }}</h3>
                            <span class="text-xs sm:text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex text-yellow-400 my-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->note ? 'fas fa-star' : 'far fa-star' }}"></i>
                            @endfor
                        </div>
                        <p class="text-gray-700 text-xs sm:text-sm">{{ $review->commentaire }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="no-reviews-message" class="hidden text-center py-8 text-gray-500">No reviews match your selected filter.</div>
        @if (count($formation->reviews) == 0)
            <div id="no-reviews-message" class="text-center py-8 text-gray-500">No reviews to show.</div>
        @endif
    </div>
</div>


    <!-- Modal Backdrop -->
    <div id="ratingModalBackdrop"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden flex items-center justify-center transition-opacity duration-300 opacity-0">
        <!-- Modal Container -->
        <div id="ratingModal"
            class="fixed z-50 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md scale-95 opacity-0 transition-all duration-300">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gray-50 px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Évaluer cette formation</h3>
                    <button id="closeRatingModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form action="{{ route('avis.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="formation_id" value="{{ $formation->id }}">

                        <!-- Rating System -->
                        <div class="mb-6">
                            <label class="block text-gray-800 font-medium mb-3">Notez cette formation</label>
                            <div class="rating-container flex justify-center space-x-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer rating-star group">
                                        <input type="radio" name="rating" value="{{ $i }}"
                                            class="hidden peer" required>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-10 w-10 text-gray-400 peer-checked:text-yellow-400 group-hover:text-yellow-300 transition-colors duration-200"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <!-- Comment Input -->
                        <div class="mb-6">
                            <label for="comment" class="block text-gray-800 font-medium mb-2">Votre commentaire</label>
                            <textarea id="comment" name="comment" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                placeholder="Partagez votre expérience avec cette formation..."></textarea>
                        </div>

                        <!-- Form Footer -->
                        <div class="flex justify-end space-x-3 mt-8">
                            <button type="button" id="cancelButton"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Annuler
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium py-2 px-6 rounded-lg transition-all duration-200 flex items-center justify-center">
                                <span>Envoyer</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>








    {{-- notifiation --}}
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4" class="fixed top-4 right-4 z-50 max-w-sm w-full">

            <div class="flex items-center p-5 bg-white rounded-lg shadow-xl border-l-4 border-l-green-500">
                <!-- Checkmark icon with animated circle -->
                <div class="flex-shrink-0 relative">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <svg class="w-8 h-8 absolute top-0 left-0 text-green-500 animate-[spin_4s_ease-in-out_infinite]"
                        viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1"
                            stroke-dasharray="1 3" />
                    </svg>
                </div>

                <!-- Message with title and content -->
                <div class="ml-4 flex-1">
                    @if (session('status') === 'added-to-cart')
                        <h4 class="text-sm font-bold text-gray-800 mb-0.5">Success!</h4>
                        <p class="text-sm text-gray-600">
                            La formation a été ajoutée à votre panier avec succès.
                        </p>
                    @elseif(session('status') === 'already-in-cart')
                        <h4 class="text-sm font-bold text-gray-800 mb-0.5">Cette formation déjà dans le panier.</h4>
                    @elseif(session('status') === 'added_commit')
                        <h4 class="text-sm font-bold text-gray-800 mb-0.5">Success!</h4>
                        <p class="text-sm text-gray-600">
                            Votre avis a été ajouté avec succès !.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif


    <script>
        
        document.addEventListener("turbo:load", () => {
        // const reviewsContainer = document.getElementById('reviews-container');
        const noReviewsMessage = document.getElementById('no-reviews-message');
        // const reviewItems = document.querySelectorAll('.review-item');



        document.getElementById('rating-filter').addEventListener('change', function() {

            const selectedRating = this.value; // Value is a string
            let visibleReviews = 0;

            document.querySelectorAll('.review-item').forEach(function(review) {
                const reviewRating = review.getAttribute('data-rating');
                console.log(
                    `Review Rating: ${reviewRating}, Selected Rating: ${selectedRating}`);

                if (selectedRating === "6" || reviewRating === selectedRating) {
                    review.style.display = "block"; // Show matching reviews
                    visibleReviews++;
                } else {
                    review.style.display = "none"; // Hide non-matching reviews
                }
            });

            // Show/hide "no reviews" message based on visible reviews count
            noReviewsMessage.style.display = (visibleReviews === 0) ? "block" : "none";
        });

        const modal = document.getElementById('ratingModal');
        const backdrop = document.getElementById('ratingModalBackdrop');
        const openBtn = document.getElementById('openRatingModal');
        const closeBtn = document.getElementById('closeRatingModal');
        const cancelBtn = document.getElementById('cancelButton');

        // Stars functionality
        const stars = document.querySelectorAll('.rating-star');

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', function() {
                // Highlight current star and all previous stars
                for (let i = 0; i <= index; i++) {
                    stars[i].querySelector('svg').classList.add('text-yellow-300');
                }
            });

            star.addEventListener('mouseout', function() {
                // Remove highlight from stars that aren't selected
                stars.forEach(s => {
                    if (!s.querySelector('input').checked) {
                        s.querySelector('svg').classList.remove('text-yellow-300');
                    }
                });
            });

            star.addEventListener('click', function() {
                // Reset all stars
                stars.forEach(s => {
                    s.querySelector('svg').classList.remove('text-yellow-400');
                });

                // Highlight selected stars
                for (let i = 0; i <= index; i++) {
                    stars[i].querySelector('svg').classList.add('text-yellow-400');
                }
            });
        });

        // Open modal function
        function openModal() {
            backdrop.classList.remove('hidden');
            // Trigger reflow to enable transitions
            void backdrop.offsetWidth;
            backdrop.classList.add('opacity-100');
            modal.classList.add('opacity-100', 'scale-100');
            modal.classList.remove('scale-95');

            // Disable body scroll
            document.body.classList.add('overflow-hidden');
        }

        // Close modal function
        function closeModal() {
            backdrop.classList.remove('opacity-100');
            modal.classList.remove('opacity-100', 'scale-100');
            modal.classList.add('scale-95');

            // Wait for animation to finish before hiding
            setTimeout(() => {
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        // Event listeners
        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Close when clicking outside the modal
        backdrop.addEventListener('click', function(event) {
            if (event.target === backdrop) {
                closeModal();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !backdrop.classList.contains('hidden')) {
                closeModal();
            }
        });
        });
    </script>

@endsection
