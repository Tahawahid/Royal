@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-5xl px-6 py-12 md:py-16">
        <div class="space-y-8">
            <div class="space-y-6 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.08em] text-amber-600">Royal Carriages Limousines</p>
                <h1 class="text-4xl font-semibold leading-tight text-slate-900 md:text-5xl">Get A Quote</h1>
                <div class="space-y-4">
                    <p class="text-lg text-slate-700 md:text-xl">
                        If you are looking for more information about luxury vehicles and packages offered by our company
                        'Royal Carriages Limousines', please fill out the online quote form available below. Just go through the form
                        and fill out each section so that we can accurately quote your prices based on your requirements.
                    </p>
                    <div class="space-y-3 rounded-2xl bg-amber-50 px-6 py-6 ring-1 ring-amber-200">
                        <p class="text-lg font-semibold text-amber-800">IMPORTANT NOTE</p>
                        <p class="text-base text-slate-700 md:text-lg">
                            To get an immediate assistance with a perfect quote, please get in touch with us via phone right
                            now – Customer service available 24 hours a day, 7 days a week. You can call us anytime @
                            <span class="font-semibold text-slate-900">+1 (713) 787-5466</span>. The International callers can
                            contact at the same number <span class="font-semibold text-slate-900">+1 (713) 787-5466</span>. For
                            more enquiries, email us at <span class="font-semibold text-slate-900">quotes@royalcarriages.com</span>.
                        </p>
                        <p class="text-lg font-semibold text-slate-900">Thank you for your trust!</p>
                    </div>
                </div>
            </div>

            <div id="quote" class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-amber-100 ring-1 ring-slate-100" 
                 data-places-key="{{ config('services.google_places.key') }}">
                <div class="mb-4">
                    <p class="text-sm font-semibold text-amber-600">Quote Form</p>
                    <p class="text-2xl font-semibold text-slate-900">Royal Carriages Limousines Quote Request</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 ring-1 ring-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form id="quote-form" class="space-y-6" action="{{ route('quote.store') }}" method="POST">
                    @csrf

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="text-sm font-medium text-slate-700">First Name</label>
                            <input id="first_name" name="first_name" type="text" required
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                        <div>
                            <label for="last_name" class="text-sm font-medium text-slate-700">Last Name</label>
                            <input id="last_name" name="last_name" type="text" required
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                            <input id="email" name="email" type="email" required
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                        <div>
                            <label for="phone" class="text-sm font-medium text-slate-700">Phone Number</label>
                            <input id="phone" name="phone" type="tel" required pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$"
                                   placeholder="555-123-4567"
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                    </div>

                    <div>
                        <label for="company" class="text-sm font-medium text-slate-700">Company</label>
                        <input id="company" name="company" type="text"
                               class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="pickup_date" class="text-sm font-medium text-slate-700">Pick-up Date</label>
                            <input id="pickup_date" name="pickup_date" type="date" required
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                        <div>
                            <label for="pickup_time" class="text-sm font-medium text-slate-700">Pick-up Time</label>
                            <select id="pickup_time" name="pickup_time" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <option value="" disabled selected>Select time</option>
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @foreach ([0, 30] as $minute)
                                        @php $time = sprintf('%02d:%02d', $hour, $minute); @endphp
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="dropoff_time" class="text-sm font-medium text-slate-700">Drop-off Time</label>
                            <select id="dropoff_time" name="dropoff_time" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <option value="" disabled selected>Select time</option>
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @foreach ([0, 30] as $minute)
                                        @php $time = sprintf('%02d:%02d', $hour, $minute); @endphp
                                        <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                    @endforeach
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="pickup_location" class="text-sm font-medium text-slate-700">Pick-up Location</label>
                            <input id="pickup_location" name="pickup_location" type="text" required 
                                   placeholder="Start typing an address"
                                   class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                            <input type="hidden" name="pickup_place_id" class="place-id">
                        </div>
                        <div>
                            <label for="dropoff_location" class="text-sm font-medium text-slate-700">Drop-off Location</label>
                            <input id="dropoff_location" name="dropoff_location" type="text" required 
                                   placeholder="Start typing an address"
                                   class="location-input mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                            <input type="hidden" name="dropoff_place_id" class="place-id">
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="service_type" class="text-sm font-medium text-slate-700">Type of Service</label>
                            <select id="service_type" name="service_type" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <option value="" disabled selected>Select service type</option>
                                <option value="from-airport">From Airport</option>
                                <option value="to-airport">To Airport</option>
                                <option value="hourly">Hourly</option>
                                <option value="point-to-point">Point to Point</option>
                                <option value="wedding">Wedding</option>
                                <option value="prom">Prom</option>
                                <option value="tour">Tour</option>
                                <option value="transfer">Transfer</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="vehicle_type" class="text-sm font-medium text-slate-700">Type of Vehicle</label>
                            <select id="vehicle_type" name="vehicle_type" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
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

                    <!-- Vehicle Display Row -->
                    <div id="vehicle-display" class="hidden grid gap-6 md:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-medium text-slate-700 mb-2">Selected Vehicle</h4>
                            <div class="text-lg font-semibold text-slate-900" id="vehicle-name"></div>
                            <div class="text-2xl font-bold text-red-600 mt-1" id="vehicle-capacity"></div>
                        </div>
                        <div>
                            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                                <img id="vehicle-image" src="" alt="" class="w-full h-48 rounded-lg object-cover bg-slate-100">
                            </div>
                        </div>
                    </div>

                    <!-- Passenger and Suitcase Row -->
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="passengers" class="text-sm font-medium text-slate-700">Number of Passengers</label>
                            <select id="passengers" name="passengers" required disabled
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                <option value="">Select vehicle first</option>
                            </select>
                        </div>
                        <div>
                            <label for="suitcases" class="text-sm font-medium text-slate-700">Number of Suitcases</label>
                            <select id="suitcases" name="suitcases" required disabled
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:bg-slate-100 disabled:text-slate-400">
                                <option value="">Select vehicle first</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="other_requirements" class="text-sm font-medium text-slate-700">Other Requirements</label>
                        <textarea id="other_requirements" name="other_requirements" rows="3" required
                                  placeholder="Share flight numbers, mobility needs, or special requests"
                                  class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"></textarea>
                    </div>

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

                    <!-- Hidden honeypot field -->
                    <div class="hidden">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <!-- Cloudflare Turnstile -->
                    @if (config('services.cloudflare_turnstile.site_key'))
                        <div class="flex justify-center">
                            <div class="cf-turnstile" 
                                 data-sitekey="{{ config('services.cloudflare_turnstile.site_key') }}"
                                 data-callback="onTurnstileSuccess"
                                 data-error-callback="onTurnstileError"
                                 data-expired-callback="onTurnstileExpired">
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                        <button type="submit"
                                class="submit-btn inline-flex items-center justify-center rounded-xl bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                            Submit Quote Request
                        </button>
                    </div>
                </form>
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
