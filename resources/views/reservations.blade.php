@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-12 md:py-16">
        <div class="space-y-6">
            <div class="text-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Royal Carriages" class="mx-auto h-12 w-auto object-contain" loading="lazy">
                <h1 class="mt-3 text-4xl font-semibold text-slate-900 md:text-5xl">Book Your Reservation</h1>
                <p class="mt-2 text-base text-slate-600">
                    Choose your trip type and complete the form. We'll confirm promptly.
                </p>
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-emerald-100 p-2">
                            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 p-4 ring-1 ring-red-200">
                    <div class="flex items-start gap-3">
                        <div class="rounded-lg bg-red-100 p-2">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-amber-100 ring-1 ring-slate-100"
                 data-places-key="{{ config('services.google_places.key') }}">
                <div class="mb-4 grid grid-cols-1 gap-2 md:grid-cols-3">
                    <button type="button" data-form="one-way"
                            class="form-tab active inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-amber-400 hover:text-amber-700 active:border-amber-400 active:text-amber-700">
                        One Way
                    </button>
                    <button type="button" data-form="round-trip"
                            class="form-tab inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-amber-400 hover:text-amber-700 active:border-amber-400 active:text-amber-700">
                        Round Trip
                    </button>
                    <button type="button" data-form="hourly"
                            class="form-tab inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-amber-400 hover:text-amber-700 active:border-amber-400 active:text-amber-700">
                        Hourly
                    </button>
                </div>

                <div class="space-y-8">
                    <form class="reservation-form space-y-6" data-form="one-way" action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="website" value="">
                        <input type="hidden" name="reservation_type" value="one-way">
                        <div>
                            <p class="text-lg font-semibold text-slate-900">One Way Reservation</p>
                            <p class="text-sm text-slate-600">All fields are required.</p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">First Name</label>
                                <input type="text" name="first_name" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Last Name</label>
                                <input type="text" name="last_name" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Company (Optional)</label>
                            <input type="text" name="company" placeholder="Company name (optional)" class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Phone</label>
                                <input type="tel" name="phone" required pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" placeholder="555-123-4567"
                                       class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Date</label>
                                <input type="date" name="pickup_date" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Time</label>
                                <select name="pickup_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Drop-off Time</label>
                                <select name="dropoff_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Location</label>
                                <input type="text" name="pickup_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="pickup_place_id" class="place-id">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Drop-off Location</label>
                                <input type="text" name="dropoff_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="dropoff_place_id" class="place-id">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Type of Service</label>
                                <select name="service_type" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select service type</option>
                                    <option>From Airport</option>
                                    <option>To Airport</option>
                                    <option>Hourly</option>
                                    <option>Birthday Quinceanera</option>
                                    <option>Point to Point</option>
                                    <option>Wedding</option>
                                    <option>Casino Transfer</option>
                                    <option>Prom</option>
                                    <option>Tour</option>
                                    <option>Transfer</option>
                                    <option>Evening Out</option>
                                    <option>Homecoming</option>
                                    <option>Game</option>
                                    <option>Anniversary</option>
                                    <option>Custom Itinerary</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Vehicle</label>
                                <select name="vehicle_type" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Choose vehicle</option>
                                    <option value="Sedan (3 passengers)" data-passengers="3" data-suitcases="3" data-image="sedan-3-p.jpg">Sedan (3 passengers)</option>
                                    <option value="Mercedes S Class Sedan (3 passengers)" data-passengers="3" data-suitcases="3" data-image="Mercedec_S_Class_Sedan_3_p.png">Mercedes S Class Sedan (3 passengers)</option>
                                    <option value="Luxury Suburban (6 passengers)" data-passengers="6" data-suitcases="6" data-image="luxury_suburban_6_p.jpg">Luxury Suburban (6 passengers)</option>
                                    <option value="Luxury Escalade (6 passengers)" data-passengers="6" data-suitcases="6" data-image="Luxury_escalade_6_p.png">Luxury Escalade (6 passengers)</option>
                                    <option value="Stretch Limousine (10 passengers)" data-passengers="10" data-suitcases="4" data-image="stretch_limousine_10_p.jpg">Stretch Limousine (10 passengers)</option>
                                    <option value="Passenger Van (10 passengers)" data-passengers="10" data-suitcases="10" data-image="passenger_vans_9_p.jpg">Passenger Van (10 passengers)</option>
                                    <option value="Luxury Mercedes Sprinter Van (14 passengers)" data-passengers="14" data-suitcases="14" data-image="luxury_mercedes_sprinter_10_p.jpg">Luxury Mercedes Sprinter Van (14 passengers)</option>
                                    <option value="Stretch Hummer Limousine (18 passengers)" data-passengers="18" data-suitcases="6" data-image="stretch_hummer_limousine_18_p.jpg">Stretch Hummer Limousine (18 passengers)</option>
                                    <option value="Stretch Escalade Limousine (18 passengers)" data-passengers="18" data-suitcases="8" data-image="stretch_escalade_limousine_18_p.jpeg">Stretch Escalade Limousine (18 passengers)</option>
                                    <option value="Limo Bus (20 passengers)" data-passengers="20" data-suitcases="10" data-image="limo_bus_20_p.jpg">Limo Bus (20 passengers)</option>
                                    <option value="Limo Bus (30 passengers)" data-passengers="30" data-suitcases="20" data-image="Limo_Bus_30_Pass.png">Limo Bus (30 passengers)</option>
                                    <option value="Mini Bus (25 - 30 passengers)" data-passengers="30" data-suitcases="30" data-image="Mini_shuttle_buses_30_p.jpg">Mini Bus (25 - 30 passengers)</option>
                                    <option value="Luxury Executive Shuttle Bus (40 passengers)" data-passengers="40" data-suitcases="40" data-image="Luxury-Executive-Shuttle-Bus-Royal-Carriages_40_p.png">Luxury Executive Shuttle Bus (40 passengers)</option>
                                    <option value="Charter Bus / Motor Coach (55 passengers)" data-passengers="55" data-suitcases="55" data-image="charter-bus-motor-coach-55_p.jpeg">Charter Bus / Motor Coach (55 passengers)</option>
                                </select>
                            </div>
                        </div>

                        <div id="vehicle-display" class="vehicle-display hidden grid gap-6 md:grid-cols-2">
                            <div>
                                <h4 class="mb-2 text-sm font-medium text-slate-700">Selected Vehicle</h4>
                                <div id="vehicle-name" class="vehicle-name text-lg font-semibold text-slate-900"></div>
                                <div id="vehicle-capacity" class="vehicle-capacity mt-1 text-2xl font-bold text-red-600"></div>
                            </div>
                            <div>
                                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                                    <img id="vehicle-image" src="" alt="" class="vehicle-image h-48 w-full rounded-lg bg-slate-100 object-cover">
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Passengers</label>
                                <select name="passengers" disabled class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                    <option value="">Select vehicle first</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Suitcases</label>
                                <select name="suitcases" disabled class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                    <option value="">Select vehicle first</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Special Requirements</label>
                            <textarea name="special_requirements" rows="3" placeholder="Flight numbers, mobility needs, special requests, etc."
                                      class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"></textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-1.5">
                                <p class="text-sm font-semibold text-slate-900">Card Details</p>
                                <input type="text" name="card_holder" required placeholder="Card Holder Name"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="text" name="card_number" required placeholder="Card Number"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <div class="grid gap-3 sm:grid-cols-3">
                                    <input type="text" name="cvc" required placeholder="CVC"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <select name="expiry_month" required class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                        <option value="" disabled selected>Exp. Month</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}">{{ sprintf('%02d', $m) }}</option>
                                        @endfor
                                    </select>
                                    <select name="expiry_year" required class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                        <option value="" disabled selected>Exp. Year</option>
                                        @for ($y = now()->year; $y <= now()->year + 10; $y++)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <p class="text-sm font-semibold text-slate-900">Billing Info</p>
                                <input type="text" name="billing_address" required placeholder="Billing Address"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="text" name="billing_city" required placeholder="City"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <input type="text" name="billing_state" required placeholder="State/Province"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <input type="text" name="billing_zip" required placeholder="ZIP Code"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                </div>
                            </div>
                        </div>

                        @if (config('services.cloudflare_turnstile.site_key'))
                            <div class="flex justify-center">
                                <div class="cf-turnstile" data-sitekey="{{ config('services.cloudflare_turnstile.site_key') }}" data-callback="onTurnstileSuccess" data-error-callback="onTurnstileError" data-expired-callback="onTurnstileExpired"></div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="consent_contact" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>By submitting this form, I consent to be contacted by Royal Carriages via call, text, or email regarding services or inquiries.</span>
                            </label>
                            <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="consent_promotions" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>I agree to receive news, offers, and promotional messages from Royal Carriages.</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                            <button type="submit" disabled
                                    class="submit-btn inline-flex items-center justify-center rounded-xl bg-amber-300 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 disabled:cursor-not-allowed disabled:opacity-70">
                                Submit
                            </button>
                        </div>
                    </form>

                    <form class="reservation-form hidden space-y-6" data-form="round-trip" action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="website" value="">
                        <input type="hidden" name="reservation_type" value="round-trip">
                        <div>
                            <p class="text-lg font-semibold text-slate-900">Round Trip Reservation</p>
                            <p class="text-sm text-slate-600">All fields are required.</p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">First Name</label>
                                <input type="text" name="first_name" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Last Name</label>
                                <input type="text" name="last_name" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Company (Optional)</label>
                            <input type="text" name="company" placeholder="Company name (optional)" class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Phone</label>
                                <input type="tel" name="phone" required pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" placeholder="555-123-4567"
                                       class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Date</label>
                                <input type="date" name="pickup_date" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Time</label>
                                <select name="pickup_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Drop-off Time</label>
                                <select name="dropoff_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Location</label>
                                <input type="text" name="pickup_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="pickup_place_id" class="place-id">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Drop-off Location</label>
                                <input type="text" name="dropoff_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="dropoff_place_id" class="place-id">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Type of Service</label>
                                <select name="service_type" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select service type</option>
                                    <option>From Airport</option>
                                    <option>To Airport</option>
                                    <option>Hourly</option>
                                    <option>Birthday Quinceanera</option>
                                    <option>Point to Point</option>
                                    <option>Wedding</option>
                                    <option>Casino Transfer</option>
                                    <option>Prom</option>
                                    <option>Tour</option>
                                    <option>Transfer</option>
                                    <option>Evening Out</option>
                                    <option>Homecoming</option>
                                    <option>Game</option>
                                    <option>Anniversary</option>
                                    <option>Custom Itinerary</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Vehicle</label>
                                <select name="vehicle_type" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Choose vehicle</option>
                                    <option value="Sedan (3 passengers)" data-passengers="3" data-suitcases="3" data-image="sedan-3-p.jpg">Sedan (3 passengers)</option>
                                    <option value="Mercedes S Class Sedan (3 passengers)" data-passengers="3" data-suitcases="3" data-image="Mercedec_S_Class_Sedan_3_p.png">Mercedes S Class Sedan (3 passengers)</option>
                                    <option value="Luxury Suburban (6 passengers)" data-passengers="6" data-suitcases="6" data-image="luxury_suburban_6_p.jpg">Luxury Suburban (6 passengers)</option>
                                    <option value="Luxury Escalade (6 passengers)" data-passengers="6" data-suitcases="6" data-image="Luxury_escalade_6_p.png">Luxury Escalade (6 passengers)</option>
                                    <option value="Stretch Limousine (10 passengers)" data-passengers="10" data-suitcases="4" data-image="stretch_limousine_10_p.jpg">Stretch Limousine (10 passengers)</option>
                                    <option value="Passenger Van (10 passengers)" data-passengers="10" data-suitcases="10" data-image="passenger_vans_9_p.jpg">Passenger Van (10 passengers)</option>
                                    <option value="Luxury Mercedes Sprinter Van (14 passengers)" data-passengers="14" data-suitcases="14" data-image="luxury_mercedes_sprinter_10_p.jpg">Luxury Mercedes Sprinter Van (14 passengers)</option>
                                    <option value="Stretch Hummer Limousine (18 passengers)" data-passengers="18" data-suitcases="6" data-image="stretch_hummer_limousine_18_p.jpg">Stretch Hummer Limousine (18 passengers)</option>
                                    <option value="Stretch Escalade Limousine (18 passengers)" data-passengers="18" data-suitcases="8" data-image="stretch_escalade_limousine_18_p.jpeg">Stretch Escalade Limousine (18 passengers)</option>
                                    <option value="Limo Bus (20 passengers)" data-passengers="20" data-suitcases="10" data-image="limo_bus_20_p.jpg">Limo Bus (20 passengers)</option>
                                    <option value="Limo Bus (30 passengers)" data-passengers="30" data-suitcases="20" data-image="Limo_Bus_30_Pass.png">Limo Bus (30 passengers)</option>
                                    <option value="Mini Bus (25 - 30 passengers)" data-passengers="30" data-suitcases="30" data-image="Mini_shuttle_buses_30_p.jpg">Mini Bus (25 - 30 passengers)</option>
                                    <option value="Luxury Executive Shuttle Bus (40 passengers)" data-passengers="40" data-suitcases="40" data-image="Luxury-Executive-Shuttle-Bus-Royal-Carriages_40_p.png">Luxury Executive Shuttle Bus (40 passengers)</option>
                                    <option value="Charter Bus / Motor Coach (55 passengers)" data-passengers="55" data-suitcases="55" data-image="charter-bus-motor-coach-55_p.jpeg">Charter Bus / Motor Coach (55 passengers)</option>
                                </select>
                            </div>
                        </div>

                        <div id="vehicle-display" class="vehicle-display hidden grid gap-6 md:grid-cols-2">
                            <div>
                                <h4 class="mb-2 text-sm font-medium text-slate-700">Selected Vehicle</h4>
                                <div id="vehicle-name" class="vehicle-name text-lg font-semibold text-slate-900"></div>
                                <div id="vehicle-capacity" class="vehicle-capacity mt-1 text-2xl font-bold text-red-600"></div>
                            </div>
                            <div>
                                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                                    <img id="vehicle-image" src="" alt="" class="vehicle-image h-48 w-full rounded-lg bg-slate-100 object-cover">
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Passengers</label>
                                <select name="passengers" disabled class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                    <option value="">Select vehicle first</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Suitcases</label>
                                <select name="suitcases" disabled class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                    <option value="">Select vehicle first</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Special Requirements</label>
                            <textarea name="special_requirements" rows="3" placeholder="Flight numbers, mobility needs, special requests, etc."
                                      class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"></textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Return Pick-up Date</label>
                                <input type="date" name="return_pickup_date" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Return Pick-up Time</label>
                                <select name="return_pickup_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Return Drop-off Time</label>
                                <select name="return_dropoff_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Return Pick-up Address</label>
                                <input type="text" name="return_pickup_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="return_pickup_place_id" class="place-id">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Return Drop-off Destination</label>
                                <input type="text" name="return_dropoff_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="return_dropoff_place_id" class="place-id">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Return Other Requirements</label>
                            <textarea name="return_other_requirements" rows="3" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"></textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-1.5">
                                <p class="text-sm font-semibold text-slate-900">Card Details</p>
                                <input type="text" name="card_holder" required placeholder="Card Holder Name"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="text" name="card_number" required placeholder="Card Number"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <div class="grid gap-3 sm:grid-cols-3">
                                    <input type="text" name="cvc" required placeholder="CVC"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <select name="expiry_month" required class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                        <option value="" disabled selected>Exp. Month</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}">{{ sprintf('%02d', $m) }}</option>
                                        @endfor
                                    </select>
                                    <select name="expiry_year" required class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                        <option value="" disabled selected>Exp. Year</option>
                                        @for ($y = now()->year; $y <= now()->year + 10; $y++)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <p class="text-sm font-semibold text-slate-900">Billing Info</p>
                                <input type="text" name="billing_address" required placeholder="Billing Address"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="text" name="billing_city" required placeholder="City"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <input type="text" name="billing_state" required placeholder="State/Province"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <input type="text" name="billing_zip" required placeholder="ZIP Code"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                </div>
                            </div>
                        </div>

                        @if (config('services.cloudflare_turnstile.site_key'))
                            <div class="flex justify-center">
                                <div class="cf-turnstile" data-sitekey="{{ config('services.cloudflare_turnstile.site_key') }}" data-callback="onTurnstileSuccess" data-error-callback="onTurnstileError" data-expired-callback="onTurnstileExpired"></div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="consent_contact" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>By submitting this form, I consent to be contacted by Royal Carriages via call, text, or email regarding services or inquiries.</span>
                            </label>
                            <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="consent_promotions" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>I agree to receive news, offers, and promotional messages from Royal Carriages.</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                            <button type="submit" disabled
                                    class="submit-btn inline-flex items-center justify-center rounded-xl bg-amber-300 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 disabled:cursor-not-allowed disabled:opacity-70">
                                Submit
                            </button>
                        </div>
                    </form>

                    <form class="reservation-form hidden space-y-6" data-form="hourly" action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="website" value="">
                        <input type="hidden" name="reservation_type" value="hourly">
                        <div>
                            <p class="text-lg font-semibold text-slate-900">Hourly Reservation</p>
                            <p class="text-sm text-slate-600">All fields are required.</p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">First Name</label>
                                <input type="text" name="first_name" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Last Name</label>
                                <input type="text" name="last_name" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Company (Optional)</label>
                            <input type="text" name="company" placeholder="Company name (optional)" class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Phone</label>
                                <input type="tel" name="phone" required pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" placeholder="555-123-4567"
                                       class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Date</label>
                                <input type="date" name="pickup_date" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Time</label>
                                <select name="pickup_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Drop-off Time</label>
                                <select name="dropoff_time" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select time</option>
                                    @foreach ($timeOptions as $time)
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Pick-up Location</label>
                                <input type="text" name="pickup_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="pickup_place_id" class="place-id">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Drop-off Location</label>
                                <input type="text" name="dropoff_location" required placeholder="Start typing an address"
                                       class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="hidden" name="dropoff_place_id" class="place-id">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Type of Service</label>
                                <select name="service_type" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Select service type</option>
                                    <option>From Airport</option>
                                    <option>To Airport</option>
                                    <option>Hourly</option>
                                    <option>Birthday Quinceanera</option>
                                    <option>Point to Point</option>
                                    <option>Wedding</option>
                                    <option>Casino Transfer</option>
                                    <option>Prom</option>
                                    <option>Tour</option>
                                    <option>Transfer</option>
                                    <option>Evening Out</option>
                                    <option>Homecoming</option>
                                    <option>Game</option>
                                    <option>Anniversary</option>
                                    <option>Custom Itinerary</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Vehicle</label>
                                <select name="vehicle_type" required class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <option value="" disabled selected>Choose vehicle</option>
                                    <option value="Sedan (3 passengers)" data-passengers="3" data-suitcases="3" data-image="sedan-3-p.jpg">Sedan (3 passengers)</option>
                                    <option value="Mercedes S Class Sedan (3 passengers)" data-passengers="3" data-suitcases="3" data-image="Mercedec_S_Class_Sedan_3_p.png">Mercedes S Class Sedan (3 passengers)</option>
                                    <option value="Luxury Suburban (6 passengers)" data-passengers="6" data-suitcases="6" data-image="luxury_suburban_6_p.jpg">Luxury Suburban (6 passengers)</option>
                                    <option value="Luxury Escalade (6 passengers)" data-passengers="6" data-suitcases="6" data-image="Luxury_escalade_6_p.png">Luxury Escalade (6 passengers)</option>
                                    <option value="Stretch Limousine (10 passengers)" data-passengers="10" data-suitcases="4" data-image="stretch_limousine_10_p.jpg">Stretch Limousine (10 passengers)</option>
                                    <option value="Passenger Van (10 passengers)" data-passengers="10" data-suitcases="10" data-image="passenger_vans_9_p.jpg">Passenger Van (10 passengers)</option>
                                    <option value="Luxury Mercedes Sprinter Van (14 passengers)" data-passengers="14" data-suitcases="14" data-image="luxury_mercedes_sprinter_10_p.jpg">Luxury Mercedes Sprinter Van (14 passengers)</option>
                                    <option value="Stretch Hummer Limousine (18 passengers)" data-passengers="18" data-suitcases="6" data-image="stretch_hummer_limousine_18_p.jpg">Stretch Hummer Limousine (18 passengers)</option>
                                    <option value="Stretch Escalade Limousine (18 passengers)" data-passengers="18" data-suitcases="8" data-image="stretch_escalade_limousine_18_p.jpeg">Stretch Escalade Limousine (18 passengers)</option>
                                    <option value="Limo Bus (20 passengers)" data-passengers="20" data-suitcases="10" data-image="limo_bus_20_p.jpg">Limo Bus (20 passengers)</option>
                                    <option value="Limo Bus (30 passengers)" data-passengers="30" data-suitcases="20" data-image="Limo_Bus_30_Pass.png">Limo Bus (30 passengers)</option>
                                    <option value="Mini Bus (25 - 30 passengers)" data-passengers="30" data-suitcases="30" data-image="Mini_shuttle_buses_30_p.jpg">Mini Bus (25 - 30 passengers)</option>
                                    <option value="Luxury Executive Shuttle Bus (40 passengers)" data-passengers="40" data-suitcases="40" data-image="Luxury-Executive-Shuttle-Bus-Royal-Carriages_40_p.png">Luxury Executive Shuttle Bus (40 passengers)</option>
                                    <option value="Charter Bus / Motor Coach (55 passengers)" data-passengers="55" data-suitcases="55" data-image="charter-bus-motor-coach-55_p.jpeg">Charter Bus / Motor Coach (55 passengers)</option>
                                </select>
                            </div>
                        </div>

                        <div id="vehicle-display" class="vehicle-display hidden grid gap-6 md:grid-cols-2">
                            <div>
                                <h4 class="mb-2 text-sm font-medium text-slate-700">Selected Vehicle</h4>
                                <div id="vehicle-name" class="vehicle-name text-lg font-semibold text-slate-900"></div>
                                <div id="vehicle-capacity" class="vehicle-capacity mt-1 text-2xl font-bold text-red-600"></div>
                            </div>
                            <div>
                                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                                    <img id="vehicle-image" src="" alt="" class="vehicle-image h-48 w-full rounded-lg bg-slate-100 object-cover">
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Passengers</label>
                                <select name="passengers" disabled class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                    <option value="">Select vehicle first</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">Suitcases</label>
                                <select name="suitcases" disabled class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                    <option value="">Select vehicle first</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Special Requirements</label>
                            <textarea name="special_requirements" rows="3" placeholder="Flight numbers, mobility needs, special requests, etc."
                                      class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"></textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-1.5">
                                <p class="text-sm font-semibold text-slate-900">Card Details</p>
                                <input type="text" name="card_holder" required placeholder="Card Holder Name"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="text" name="card_number" required placeholder="Card Number"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <div class="grid gap-3 sm:grid-cols-3">
                                    <input type="text" name="cvc" required placeholder="CVC"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <select name="expiry_month" required class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                        <option value="" disabled selected>Exp. Month</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}">{{ sprintf('%02d', $m) }}</option>
                                        @endfor
                                    </select>
                                    <select name="expiry_year" required class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                        <option value="" disabled selected>Exp. Year</option>
                                        @for ($y = now()->year; $y <= now()->year + 10; $y++)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <p class="text-sm font-semibold text-slate-900">Billing Info</p>
                                <input type="text" name="billing_address" required placeholder="Billing Address"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <input type="text" name="billing_city" required placeholder="City"
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <input type="text" name="billing_state" required placeholder="State/Province"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                    <input type="text" name="billing_zip" required placeholder="ZIP Code"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                </div>
                            </div>
                        </div>

                        @if (config('services.cloudflare_turnstile.site_key'))
                            <div class="flex justify-center">
                                <div class="cf-turnstile" data-sitekey="{{ config('services.cloudflare_turnstile.site_key') }}" data-callback="onTurnstileSuccess" data-error-callback="onTurnstileError" data-expired-callback="onTurnstileExpired"></div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="consent_contact" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>By submitting this form, I consent to be contacted by Royal Carriages via call, text, or email regarding services or inquiries.</span>
                            </label>
                            <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="consent_promotions" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span>I agree to receive news, offers, and promotional messages from Royal Carriages.</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                            <button type="submit" disabled
                                    class="submit-btn inline-flex items-center justify-center rounded-xl bg-amber-300 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 disabled:cursor-not-allowed disabled:opacity-70">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    @vite('resources/js/forms.js')

    @if (config('services.google_places.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places.key') }}&libraries=places&callback=initFormPlaces" async defer></script>
    @endif
    @if (config('services.cloudflare_turnstile.site_key'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
@endpush
