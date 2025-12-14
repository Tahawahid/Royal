@extends('layouts.app')

@section('title', 'Too Many Requests')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-24 text-center">
    <div class="space-y-6">
        <div class="space-y-3">
            <h1 class="text-6xl font-bold text-orange-600">429</h1>
            <h2 class="text-2xl font-semibold text-slate-700">Too Many Requests</h2>
            <p class="text-lg text-slate-600">
                You've made too many requests. Please wait a moment and try again.
            </p>
        </div>
        
        <div class="space-y-4">
            <div class="rounded-lg bg-orange-50 px-4 py-3 text-sm text-orange-800">
                Please wait before submitting another request.
            </div>
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