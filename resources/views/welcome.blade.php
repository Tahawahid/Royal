@extends('layouts.app')

@php
    $timeOptions = [];

    for ($hour = 0; $hour < 24; $hour++) {
        foreach ([0, 30] as $minute) {
            $timeOptions[] = sprintf('%02d:%02d', $hour, $minute);
        }
    }
@endphp

@section('content')
    <section class="mx-auto max-w-5xl px-6 py-12 md:py-16">
        <div class="space-y-8">
            <div class="space-y-6 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.08em] text-amber-600">Royal Carriages</p>
                <h1 class="text-4xl font-semibold leading-tight text-slate-900 md:text-5xl">Get A Quote</h1>
                <div class="space-y-4">
                <p class="text-lg text-slate-700 md:text-xl">
                    If you are looking for more information about luxury vehicles and packages offered by our company
                    'Royal Carriages', please fill out the online quote form available below. Just go through the form
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

            <div id="quote" class="rounded-2xl bg-white/95 p-6 shadow-lg shadow-amber-100 ring-1 ring-slate-100">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-amber-600">Quote Form</p>
                        <p class="text-2xl font-semibold text-slate-900">Royal Carriages Quote Request</p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 ring-1 ring-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form id="quote-form" class="space-y-6" action="{{ route('quote.store') }}" method="POST"
                      data-places-key="{{ config('services.google_places.key') }}"
                      data-turnstile-sitekey="{{ config('services.cloudflare_turnstile.site_key') }}">
                    @csrf
                    <input type="hidden" name="turnstile_token" id="turnstile_token" value="">

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="text-sm font-medium text-slate-700">First Name</label>
                            <input id="first_name" name="first_name" type="text" required autocomplete="given-name"
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                        <div>
                            <label for="last_name" class="text-sm font-medium text-slate-700">Last Name</label>
                            <input id="last_name" name="last_name" type="text" required autocomplete="family-name"
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                            <input id="email" name="email" type="email" required autocomplete="email"
                                   inputmode="email"
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                        </div>
                        <div>
                            <label for="phone" class="text-sm font-medium text-slate-700">Phone Number (US)</label>
                            <input id="phone" name="phone" type="tel" required inputmode="tel" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$"
                                   placeholder="555-123-4567"
                                   class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                            <p class="mt-1 text-xs text-slate-500">Format: 555-123-4567</p>
                        </div>
                    </div>

                    <div>
                        <label for="company" class="text-sm font-medium text-slate-700">Company</label>
                        <input id="company" name="company" type="text" autocomplete="organization"
                               class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                    </div>

                    <div class="hidden" aria-hidden="true">
                        <label for="website" class="text-sm font-medium text-slate-700">Leave this blank</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off"
                               class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900" />
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
                                @foreach ($timeOptions as $time)
                                    <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="dropoff_time" class="text-sm font-medium text-slate-700">Drop-off Time</label>
                            <select id="dropoff_time" name="dropoff_time" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <option value="" disabled selected>Select time</option>
                                @foreach ($timeOptions as $time)
                                    <option value="{{ $time }}">{{ date('g:i A', strtotime($time)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="pickup_location" class="text-sm font-medium text-slate-700">Pick-up Location</label>
                                <span class="text-xs font-medium text-amber-700">Google verified only</span>
                            </div>
                            <input id="pickup_location" name="pickup_location" type="text" required autocomplete="off"
                                   placeholder="Start typing an address"
                                   class="location-input w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                            <p id="pickup_error" class="hidden text-sm text-red-600"></p>
                            <input id="pickup_place_id" name="pickup_place_id" type="hidden" class="place-id" />
                            <input id="pickup_street" name="pickup_street" type="hidden" />
                            <input id="pickup_city" name="pickup_city" type="hidden" />
                            <input id="pickup_state" name="pickup_state" type="hidden" />
                            <input id="pickup_postal_code" name="pickup_postal_code" type="hidden" />
                        </div>

                        <div class="space-y-1.5">
                            <label for="dropoff_location" class="text-sm font-medium text-slate-700">Drop-off Location</label>
                            <input id="dropoff_location" name="dropoff_location" type="text" required autocomplete="off"
                                   placeholder="Start typing an address"
                                   class="location-input w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" />
                            <p id="dropoff_error" class="hidden text-sm text-red-600"></p>
                            <input id="dropoff_place_id" name="dropoff_place_id" type="hidden" class="place-id" />
                            <input id="dropoff_street" name="dropoff_street" type="hidden" />
                            <input id="dropoff_city" name="dropoff_city" type="hidden" />
                            <input id="dropoff_state" name="dropoff_state" type="hidden" />
                            <input id="dropoff_postal_code" name="dropoff_postal_code" type="hidden" />
                        </div>
                    </div>

                    @if (! config('services.google_places.key'))
                        <p class="rounded-lg bg-amber-50 px-3 py-2 text-sm text-amber-700">
                            Add your Google Places API key to enable address autocomplete and validation
                            (<code>GOOGLE_PLACES_API_KEY</code> in your environment).
                        </p>
                    @endif

                    <div class="grid gap-4 md:grid-cols-2 md:items-start">
                        <div>
                            <label for="service_type" class="text-sm font-medium text-slate-700">Type of Service</label>
                            <select id="service_type" name="service_type" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <option value="" disabled selected>Select service type</option>
                                <option value="from-airport">From Airport</option>
                                <option value="to-airport">To Airport</option>
                                <option value="hourly">Hourly</option>
                                <option value="birthday-quinceanera">Birthday Quinceanera</option>
                                <option value="point-to-point">Point to Point</option>
                                <option value="wedding">Wedding</option>
                                <option value="casino-transfer">Casino Transfer</option>
                                <option value="prom">Prom</option>
                                <option value="tour">Tour</option>
                                <option value="transfer">Transfer</option>
                                <option value="evening-out">Evening Out</option>
                                <option value="homecoming">Homecoming</option>
                                <option value="game">Game</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="custom-itinerary">Custom Itinerary</option>
                            </select>
                        </div>
                        <div>
                            <label for="vehicle_type" class="text-sm font-medium text-slate-700">Type of Vehicle</label>
                            <select id="vehicle_type" name="vehicle_type" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                                <option value="" disabled selected>Choose vehicle</option>
                                <option value="Sedan (3 passengers)">Sedan (3 passengers)</option>
                                <option value="Mercedes S Class Sedan (3 passengers)">Mercedes S Class Sedan (3 passengers)</option>
                                <option value="Luxury Suburban (6 passengers)">Luxury Suburban (6 passengers)</option>
                                <option value="Luxury Escalade (6 passengers)">Luxury Escalade (6 passengers)</option>
                                <option value="Stretch Limousine (10 passengers)">Stretch Limousine (10 passengers)</option>
                                <option value="Passenger Van (10 passengers)">Passenger Van (10 passengers)</option>
                                <option value="Luxury Mercedes Sprinter Van (14 passengers)">Luxury Mercedes Sprinter Van (14 passengers)</option>
                                <option value="Stretch Hummer Limousine (18 passengers)">Stretch Hummer Limousine (18 passengers)</option>
                                <option value="Stretch Escalade Limousine (18 passengers)">Stretch Escalade Limousine (18 passengers)</option>
                                <option value="Limo Bus (20 passengers)">Limo Bus (20 passengers)</option>
                                <option value="Limo Bus (30 passengers)">Limo Bus (30 passengers)</option>
                                <option value="Mini Bus (25 - 30 passengers)">Mini Bus (25 - 30 passengers)</option>
                                <option value="Luxury Executive Shuttle Bus (40 passengers)">Luxury Executive Shuttle Bus (40 passengers)</option>
                                <option value="Charter Bus / Motor Coach (55 passengers)">Charter Bus / Motor Coach (55 passengers)</option>
                            </select>
                            <div id="vehicle-card" class="mt-3 hidden items-center gap-4 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <div class="h-32 w-48 overflow-hidden rounded-lg bg-white ring-1 ring-slate-100">
                                    <img id="vehicle-image" src="" alt="Selected vehicle" class="h-full w-full object-cover" loading="lazy" />
                                </div>
                                <div>
                                    <p id="vehicle-name" class="text-sm font-semibold text-slate-900">Select a vehicle to preview</p>
                                    <p id="vehicle-capacity" class="text-sm text-slate-600">Passengers: –</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="passengers" class="text-sm font-medium text-slate-700">Number of Passengers</label>
                            <select id="passengers" name="passengers" required disabled
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:cursor-not-allowed disabled:bg-slate-100">
                                <option value="" disabled selected>Select passengers</option>
                                @for ($i = 1; $i <= 60; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="suitcases" class="text-sm font-medium text-slate-700">Number of Suitcases</label>
                            <select id="suitcases" name="suitcases" required disabled
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 disabled:cursor-not-allowed disabled:bg-slate-100">
                                <option value="" disabled selected>Select suitcases</option>
                                @for ($i = 0; $i <= 60; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="other_requirements" class="text-sm font-medium text-slate-700">Other Requirements</label>
                        <textarea id="other_requirements" name="other_requirements" rows="3" required
                                  class="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"
                                  placeholder="Share flight numbers, mobility needs, or special requests"></textarea>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-slate-700">Consent</p>
                        <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                            <input type="checkbox" id="consent_contact" name="consent_contact" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500" />
                            <span>By submitting this form, I consent to be contacted by Royal Carriages via call, text, or email regarding services or inquiries.</span>
                        </label>
                        <label class="flex items-start gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                            <input type="checkbox" id="consent_promotions" name="consent_promotions" required class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500" />
                            <span>I agree to receive news, offers, and promotional messages from Royal Carriages.</span>
                        </label>
                    </div>

                    @if (config('services.cloudflare_turnstile.site_key'))
                        <div id="turnstile-container" class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2"></div>
                    @else
                        <p class="rounded-lg bg-amber-50 px-3 py-2 text-sm text-amber-700">
                            Add your Cloudflare Turnstile site key to enable anti-spam protection
                            (<code>CLOUDFLARE_TURNSTILE_SITE_KEY</code>).
                        </p>
                    @endif

                    <div class="flex flex-col gap-3 rounded-xl bg-slate-50 px-4 py-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">We respond fast</p>
                            <p class="text-sm text-slate-600">Expect a tailored quote in minutes during business hours.</p>
                        </div>
                        <button id="submit-button" type="submit" disabled
                                class="inline-flex items-center justify-center rounded-xl bg-amber-300 px-4 py-3 text-sm font-semibold text-white shadow-md transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 disabled:cursor-not-allowed disabled:opacity-70">
                            Request Quote
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex flex-wrap gap-3">
                <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2 shadow-sm ring-1 ring-slate-100">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="text-sm font-medium text-slate-700">Licensed chauffeurs</span>
                </div>
                <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2 shadow-sm ring-1 ring-slate-100">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    <span class="text-sm font-medium text-slate-700">Quick responses</span>
                </div>
                <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2 shadow-sm ring-1 ring-slate-100">
                    <span class="h-2 w-2 rounded-full bg-slate-700"></span>
                    <span class="text-sm font-medium text-slate-700">Nationwide coverage</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')\n    <script>\n        (() => {\n            const placesKey = document.querySelector('[data-places-key]')?.dataset.placesKey;\n\n            function validateForm() {\n                const form = document.getElementById('quote-form');\n                const submitButton = document.getElementById('submit-button');\n                if (!submitButton) return;\n                \n                const requiredInputs = Array.from(form.querySelectorAll('input[required], select[required], textarea[required]'));\n                const allValid = requiredInputs.every((el) => {\n                    if (el.type === 'checkbox') {\n                        return el.checked;\n                    }\n                    if (el.classList.contains('place-id')) {\n                        return el.value.trim().length > 0;\n                    }\n                    return el.value && el.value.toString().trim().length > 0;\n                });\n\n                submitButton.disabled = !allValid;\n                submitButton.classList.toggle('bg-amber-600', allValid);\n                submitButton.classList.toggle('bg-amber-300', !allValid);\n            }\n\n            function attachValidation() {\n                const form = document.getElementById('quote-form');\n                if (form) {\n                    form.querySelectorAll('input, select, textarea').forEach((field) => {\n                        field.addEventListener('input', () => validateForm());\n                        field.addEventListener('change', () => validateForm());\n                    });\n                    validateForm();\n                }\n            }\n\n            function initPlaces() {\n                if (!(window.google && window.google.maps && window.google.maps.places) || !placesKey) {\n                    return false;\n                }\n\n                document.querySelectorAll('.location-input').forEach((input) => {\n                    const hidden = input.parentElement?.querySelector('.place-id');\n                    const autocomplete = new google.maps.places.Autocomplete(input, {\n                        types: ['address'],\n                        componentRestrictions: { country: 'us' },\n                        fields: ['place_id', 'formatted_address'],\n                    });\n\n                    autocomplete.addListener('place_changed', () => {\n                        const place = autocomplete.getPlace();\n                        if (hidden) {\n                            hidden.value = place.place_id || '';\n                        }\n                        input.value = place.formatted_address || input.value;\n                        validateForm();\n                    });\n\n                    input.addEventListener('input', () => {\n                        if (hidden) hidden.value = '';\n                        validateForm();\n                    });\n                });\n\n                return true;\n            }\n\n            function ensurePlacesReady(attempts = 0) {\n                if (initPlaces()) {\n                    return;\n                }\n                if (attempts < 20) {\n                    setTimeout(() => ensurePlacesReady(attempts + 1), 200);\n                }\n            }\n\n            document.addEventListener('DOMContentLoaded', () => {\n                attachValidation();\n                ensurePlacesReady();\n            });\n\n            window.initQuotePlaces = () => {\n                ensurePlacesReady();\n            };\n        })();\n    </script>\n\n    @if (config('services.google_places.key'))\n        <script src=\"https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places.key') }}&libraries=places&callback=initQuotePlaces\" async defer></script>\n    @endif\n    @if (config('services.cloudflare_turnstile.site_key'))\n        <script src=\"https://challenges.cloudflare.com/turnstile/v0/api.js\" async defer></script>\n    @endif\n@endpush
    <script>
        const requiredComponents = ['street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code'];
        const disposableDomains = new Set([
            'mailinator.com',
            'tempmail.com',
            '10minutemail.com',
            'guerrillamail.com',
            'yopmail.com',
            'sharklasers.com',
            'trashmail.com',
            'dispostable.com',
            'getnada.com',
            'maildrop.cc',
            'fakeinbox.com',
            'emailondeck.com',
            'burnermail.io',
            'mail.tm',
        ]);
        let turnstileToken = '';
        let quotePlacesKey = '';
        const vehicleMap = {
            'Sedan (3 passengers)': {
                passengers: 3,
                suitcases: 3,
                image: '/assets/images/cars/sedan-3-p.jpg',
            },
            'Mercedes S Class Sedan (3 passengers)': {
                passengers: 3,
                suitcases: 3,
                image: '/assets/images/cars/Mercedec_S_Class_Sedan_3_p.png',
            },
            'Luxury Suburban (6 passengers)': {
                passengers: 6,
                suitcases: 6,
                image: '/assets/images/cars/luxury_suburban_6_p.jpg',
            },
            'Luxury Escalade (6 passengers)': {
                passengers: 6,
                suitcases: 6,
                image: '/assets/images/cars/Luxury_escalade_6_p.png',
            },
            'Stretch Limousine (10 passengers)': {
                passengers: 10,
                suitcases: 4,
                image: '/assets/images/cars/stretch_limousine_10_p.jpg',
            },
            'Passenger Van (10 passengers)': {
                passengers: 10,
                suitcases: 10,
                image: '/assets/images/cars/passenger_vans_9_p.jpg',
            },
            'Luxury Mercedes Sprinter Van (14 passengers)': {
                passengers: 14,
                suitcases: 14,
                image: '/assets/images/cars/luxury_mercedes_sprinter_10_p.jpg',
            },
            'Stretch Hummer Limousine (18 passengers)': {
                passengers: 18,
                suitcases: 6,
                image: '/assets/images/cars/stretch_hummer_limousine_18_p.jpg',
            },
            'Stretch Escalade Limousine (18 passengers)': {
                passengers: 18,
                suitcases: 8,
                image: '/assets/images/cars/stretch_escalade_limousine_18_p.jpeg',
            },
            'Limo Bus (20 passengers)': {
                passengers: 20,
                suitcases: 10,
                image: '/assets/images/cars/limo_bus_20_p.jpg',
            },
            'Limo Bus (30 passengers)': {
                passengers: 30,
                suitcases: 20,
                image: '/assets/images/cars/Limo_Bus_30_Pass.png',
            },
            'Mini Bus (25 - 30 passengers)': {
                passengers: 30,
                suitcases: 30,
                image: '/assets/images/cars/Mini_shuttle_buses_30_p.jpg',
            },
            'Luxury Executive Shuttle Bus (40 passengers)': {
                passengers: 40,
                suitcases: 40,
                image: '/assets/images/cars/Luxury-Executive-Shuttle-Bus-Royal-Carriages_40_p.png',
            },
            'Charter Bus / Motor Coach (55 passengers)': {
                passengers: 55,
                suitcases: 55,
                image: '/assets/images/cars/charter-bus-motor-coach-55_p.jpeg',
            },
        };

        function mapAddressComponents(components) {
            return (components || []).reduce((acc, component) => {
                component.types.forEach((type) => {
                    acc[type] = component.long_name;
                });

                return acc;
            }, {});
        }

        function clearAddressError(prefix) {
            const errorElement = document.getElementById(`${prefix}_error`);

            errorElement.textContent = '';
            errorElement.classList.add('hidden');
        }

        function setAddress(prefix, place) {
            const input = document.getElementById(`${prefix}_location`);
            const placeIdField = document.getElementById(`${prefix}_place_id`);
            const streetField = document.getElementById(`${prefix}_street`);
            const cityField = document.getElementById(`${prefix}_city`);
            const stateField = document.getElementById(`${prefix}_state`);
            const postalField = document.getElementById(`${prefix}_postal_code`);
            const errorElement = document.getElementById(`${prefix}_error`);

            const components = mapAddressComponents(place.address_components);
            const hasRequiredParts = requiredComponents.every((item) => components[item]);

            if (!place.place_id || !hasRequiredParts) {
                placeIdField.value = '';
                input.value = '';
                streetField.value = '';
                cityField.value = '';
                stateField.value = '';
                postalField.value = '';
                errorElement.textContent = 'Select a complete U.S. street address from the list.';
                errorElement.classList.remove('hidden');

                return;
            }

            input.value = place.formatted_address;
            placeIdField.value = place.place_id;
            streetField.value = `${components.street_number || ''} ${components.route || ''}`.trim();
            cityField.value = components.locality || '';
            stateField.value = components.administrative_area_level_1 || '';
            postalField.value = components.postal_code || '';
            clearAddressError(prefix);
            validateForm();
        }

        function formatPhone(value) {
            const digits = value.replace(/\D/g, '').slice(0, 10);

            if (digits.length <= 3) {
                return digits;
            }

            if (digits.length <= 6) {
                return `${digits.slice(0, 3)}-${digits.slice(3)}`;
            }

            return `${digits.slice(0, 3)}-${digits.slice(3, 6)}-${digits.slice(6)}`;
        }

        function isPhoneValid(value) {
            return /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/.test(value);
        }

        function isEmailValid(email) {
            const normalized = (email || '').trim().toLowerCase();
            const basicPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

            if (!basicPattern.test(normalized)) {
                return false;
            }

            const domain = normalized.split('@')[1] || '';

            return domain && !disposableDomains.has(domain);
        }

        function validateForm() {
            const form = document.getElementById('quote-form');
            const submitButton = document.getElementById('submit-button');

            if (!form || !submitButton) {
                return;
            }

            const requiredFields = [
                'first_name',
                'last_name',
                'email',
                'phone',
                'pickup_date',
                'pickup_time',
                'dropoff_time',
                'pickup_location',
                'dropoff_location',
                'service_type',
                'vehicle_type',
                'passengers',
                'suitcases',
                'other_requirements',
            ];

            const requiredChecks = ['consent_contact', 'consent_promotions'];

            const allFilled = requiredFields.every((id) => {
                const el = document.getElementById(id);

                if (!el) {
                    return false;
                }

                if (el.disabled) {
                    return true;
                }

                return el.value && el.value.toString().trim().length > 0;
            });

            const allChecked = requiredChecks.every((id) => document.getElementById(id)?.checked);

            const placeIdsPresent = ['pickup', 'dropoff'].every(
                (prefix) => document.getElementById(`${prefix}_place_id`)?.value,
            );

            const phoneValid = isPhoneValid(document.getElementById('phone')?.value || '');
            const emailValid = isEmailValid(document.getElementById('email')?.value || '');
            const turnstileValid = !form.dataset.turnstileSitekey || Boolean(turnstileToken);

            const formIsValid = allFilled && allChecked && placeIdsPresent && phoneValid && emailValid && turnstileValid;

            submitButton.disabled = !formIsValid;
            submitButton.classList.toggle('bg-amber-600', formIsValid);
            submitButton.classList.toggle('bg-amber-300', !formIsValid);
        }

        function attachValidationHandlers() {
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            const form = document.getElementById('quote-form');
            const vehicleInput = document.getElementById('vehicle_type');

            phoneInput?.addEventListener('input', (event) => {
                event.target.value = formatPhone(event.target.value);
                validateForm();
            });

            emailInput?.addEventListener('input', validateForm);

            vehicleInput?.addEventListener('change', () => {
                updateVehicleDetails();
                validateForm();
            });

            form?.querySelectorAll('input, select, textarea').forEach((field) => {
                field.addEventListener('change', validateForm);
                field.addEventListener('input', validateForm);
            });
        }

        let turnstileRenderAttempts = 0;
        const maxTurnstileAttempts = 20;
        const turnstileInput = document.getElementById('turnstile_token');

        function renderTurnstileWidget() {
            const form = document.getElementById('quote-form');
            const siteKey = form?.dataset.turnstileSitekey;
            const container = document.getElementById('turnstile-container');

            if (!siteKey || !container || !window.turnstile) {
                if (turnstileRenderAttempts < maxTurnstileAttempts) {
                    turnstileRenderAttempts += 1;
                    setTimeout(renderTurnstileWidget, 150);
                }

                validateForm();

                return;
            }

            window.turnstile.render(container, {
                sitekey: siteKey,
                callback: (token) => {
                    turnstileToken = token;
                    if (turnstileInput) {
                        turnstileInput.value = token;
                    }
                    validateForm();
                },
                'error-callback': () => {
                    turnstileToken = '';
                    if (turnstileInput) {
                        turnstileInput.value = '';
                    }
                    validateForm();
                },
                'expired-callback': () => {
                    turnstileToken = '';
                    if (turnstileInput) {
                        turnstileInput.value = '';
                    }
                    validateForm();
                },
            });
        }

        function initQuotePlaceAutocomplete() {
            if (!quotePlacesKey || !(window.google && window.google.maps && window.google.maps.places)) {
                return false;
            }

            ['pickup', 'dropoff'].forEach((prefix) => {
                const input = document.getElementById(`${prefix}_location`);
                const placeIdField = document.getElementById(`${prefix}_place_id`);

                if (!input || !placeIdField) {
                    return;
                }

                input.setAttribute('autocomplete', 'off');

                const autocomplete = new google.maps.places.Autocomplete(input, {
                    types: ['address'],
                    componentRestrictions: { country: 'us' },
                    fields: ['address_components', 'formatted_address', 'place_id'],
                });

                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    setAddress(prefix, place);
                });

                input.addEventListener('input', () => {
                    placeIdField.value = '';
                    clearAddressError(prefix);
                    validateForm();
                });
            });

            const form = document.getElementById('quote-form');

            form.addEventListener('submit', (event) => {
                const invalidPrefixes = ['pickup', 'dropoff'].filter(
                    (prefix) => !document.getElementById(`${prefix}_place_id`).value,
                );

                if (invalidPrefixes.length) {
                    event.preventDefault();

                    invalidPrefixes.forEach((prefix) => {
                        const errorElement = document.getElementById(`${prefix}_error`);

                        errorElement.textContent = 'Please choose an address suggestion to continue.';
                        errorElement.classList.remove('hidden');
                    });
                }

                if (!isEmailValid(document.getElementById('email')?.value || '')) {
                    event.preventDefault();
                    const email = document.getElementById('email');
                    email.focus();
                }

                if (!isPhoneValid(document.getElementById('phone')?.value || '')) {
                    event.preventDefault();
                    const phone = document.getElementById('phone');
                    phone.focus();
                }
            });

            return true;
        }

        function updateVehicleDetails() {
            const vehicleSelect = document.getElementById('vehicle_type');
            const passengersSelect = document.getElementById('passengers');
            const suitcasesSelect = document.getElementById('suitcases');
            const vehicleCard = document.getElementById('vehicle-card');
            const vehicleImage = document.getElementById('vehicle-image');
            const vehicleName = document.getElementById('vehicle-name');
            const vehicleCapacity = document.getElementById('vehicle-capacity');

            if (!vehicleSelect || !passengersSelect || !suitcasesSelect) {
                return;
            }

            const selectedVehicle = vehicleSelect.value;
            const vehicleInfo = vehicleMap[selectedVehicle];

            if (!vehicleInfo || !selectedVehicle) {
                // Disable dependent fields
                passengersSelect.disabled = true;
                suitcasesSelect.disabled = true;
                passengersSelect.value = '';
                suitcasesSelect.value = '';
                
                if (vehicleCard) {
                    vehicleCard.classList.add('hidden');
                }
                return;
            }

            // Enable and populate dependent fields
            passengersSelect.disabled = false;
            suitcasesSelect.disabled = false;

            // Clear and populate passengers options
            while (passengersSelect.children.length > 1) {
                passengersSelect.removeChild(passengersSelect.lastChild);
            }
            for (let i = 1; i <= vehicleInfo.passengers; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                passengersSelect.appendChild(option);
            }

            // Clear and populate suitcases options
            while (suitcasesSelect.children.length > 1) {
                suitcasesSelect.removeChild(suitcasesSelect.lastChild);
            }
            for (let i = 0; i <= vehicleInfo.suitcases; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                suitcasesSelect.appendChild(option);
            }

            // Update vehicle card display
            if (vehicleCard && vehicleImage && vehicleName && vehicleCapacity) {
                vehicleImage.src = vehicleInfo.image;
                vehicleImage.alt = selectedVehicle;
                vehicleName.textContent = selectedVehicle;
                vehicleCapacity.textContent = `Passengers: ${vehicleInfo.passengers} | Suitcases: ${vehicleInfo.suitcases}`;
                vehicleCard.classList.remove('hidden');
            }
        }

        function ensureQuotePlacesReady(attempts = 0) {
            if (initQuotePlaceAutocomplete()) {
                return;
            }
            if (attempts < 20) {
                setTimeout(() => ensureQuotePlacesReady(attempts + 1), 200);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            quotePlacesKey = document.getElementById('quote-form')?.dataset.placesKey || '';
            attachValidationHandlers();
            validateForm();
            renderTurnstileWidget();
            updateVehicleDetails();
            ensureQuotePlacesReady();
        });

        window.initQuotePlaceAutocomplete = () => {
            if (quotePlacesKey && window.google && window.google.maps && window.google.maps.places) {
                initQuotePlaceAutocomplete();
            } else {
                ensureQuotePlacesReady();
            }
        };
    </script>

    @if (config('services.google_places.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places.key') }}&libraries=places&callback=initQuotePlaceAutocomplete" async defer></script>
    @endif
    @if (config('services.cloudflare_turnstile.site_key'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
@endpush

