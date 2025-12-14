@extends('layouts.app')

@section('title', 'Service Unavailable')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-24 text-center">
    <div class="space-y-6">
        <div class="space-y-3">
            <h1 class="text-6xl font-bold text-red-600">503</h1>
            <h2 class="text-2xl font-semibold text-slate-700">Service Unavailable</h2>
            <p class="text-lg text-slate-600">
                We're temporarily down for maintenance. Please try again later.
            </p>
        </div>
        
        <div class="space-y-4">
            <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-800">
                We'll be back online soon. Thank you for your patience.
            </div>
            <button onclick="window.location.reload()" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Try Again
            </button>
        </div>
        
        <div class="text-xs text-slate-400">
            <p>Contact: +1 (713) 787-5466 | quotes@royalcarriages.com</p>
        </div>
    </div>
</section>
@endsection