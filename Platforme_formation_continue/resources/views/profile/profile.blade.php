@extends('layouts.app')

@section('content')
<div class=" p-0">
    <!-- Top section with blue background and profile info is included here -->
    @include('profile.partials.topSection')


    <!-- Content Area -->
    <div class="container m-auto items-center mb-10">
        <!-- Dynamic Section -->
        <div class="card p-4">
        @if ($section == 'wishlist')
                @include('profile.partials.wishlist', ['wishlist' => $wishlist])
            @elseif ($section == 'historique')
               @include('profile.partials.formation-history',['inscriptions' =>$inscriptions])
            @elseif ($section == 'edite')
                @include('profile.partials.edit')
            @endif
        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection