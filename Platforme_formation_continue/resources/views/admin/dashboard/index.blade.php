@extends('admin.layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Formations Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Formations</p>
                    <p class="text-3xl font-bold"></p>
                </div>
            </div>
        </div>

        <!-- Domaines Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 flex items-center">
                <div class="p-3 rounded-full bg-pink-100 mr-4">
                    <svg class="h-8 w-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Domaines</p>
                    <p class="text-3xl font-bold"></p>
                </div>
            </div>
        </div>

        <!-- Inscriptions Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 mr-4">
                    <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Inscriptions</p>
                    <p class="text-3xl font-bold"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <!-- Placeholder for recent activity content -->
                <p class="text-gray-500">No recent activity to display.</p>
            </div>
        </div>
    </div>
@endsection