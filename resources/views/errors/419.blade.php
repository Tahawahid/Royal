@extends('layouts.app')

@section('title', 'Page Expired')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-24 text-center">
    <div class="space-y-6">
        <div class="space-y-3">
            <h1 class="text-6xl font-bold text-orange-600">419</h1>
            <h2 class="text-2xl font-semibold text-slate-700">Page Expired</h2>
            <p class="text-lg text-slate-600">
                Your session has expired. Please refresh the page and try again.
            </p>
        </div>
        
        <div class="space-y-4">
            <button onclick="window.location.reload()" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Refresh Page
            </button>
            <div class="space-x-4 text-sm text-slate-500">
                <a href="{{ route('quote') }}" class="text-amber-600 hover:text-amber-700">Get A Quote</a>
                <a href="{{ route('reservations') }}" class="text-amber-600 hover:text-amber-700">Make a Reservation</a>
            </div>
        </div>
    </div>
</section>
@endsection