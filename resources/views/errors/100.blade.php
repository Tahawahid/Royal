@extends('layouts.app')

@section('title', 'Continue')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-24 text-center">
    <div class="space-y-6">
        <div class="space-y-3">
            <h1 class="text-6xl font-bold text-slate-900">100</h1>
            <h2 class="text-2xl font-semibold text-slate-700">Continue</h2>
            <p class="text-lg text-slate-600">
                The request is being processed. Please continue.
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
    </div>
</section>
@endsection