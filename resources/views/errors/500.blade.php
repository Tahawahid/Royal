@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-24 text-center">
    <div class="space-y-6">
        <div class="space-y-3">
            <h1 class="text-6xl font-bold text-red-600">500</h1>
            <h2 class="text-2xl font-semibold text-slate-700">Server Error</h2>
            <p class="text-lg text-slate-600">
                Something went wrong on our end. We're working to fix this issue.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ route('quote') }}" class="inline-flex items-center rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                Get A Quote
            </a>
            <div class="text-sm text-slate-500">
                <a href="{{ route('reservations') }}" class="text-amber-600 hover:text-amber-700">Make a Reservation</a>
            </div>
        </div>
        
        <div class="mt-8 text-xs text-slate-400">
            <p>Error ID: {{ Str::uuid() }}</p>
        </div>
    </div>
</section>
@endsection