/**
 * Royal Carriages Forms - Centralized Form Management
 * Handles validation, Google Places, Cloudflare Turnstile, and vehicle selection
 */

class RoyalCarriageForms {
    constructor() {
        this.turnstileToken = null;
        this.assetBaseUrl = null;
        this.placesKey = null;
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.init());
        } else {
            this.init();
        }
    }

    init() {
        this.setupConfig();
        this.setupTurnstile();
        this.attachValidation();
        this.attachVehicleSelection();
        this.attachTabSwitching();
        this.ensurePlacesReady();
    }

    setupConfig() {
        // Get configuration from data attributes
        const configElement = document.querySelector('[data-places-key], [data-config]');
        if (configElement) {
            this.placesKey = configElement.dataset.placesKey;
        }
        
        // Set asset base URL for vehicle images
        this.assetBaseUrl = this.getAssetBaseUrl();
    }

    getAssetBaseUrl() {
        // Try to get from meta tag or construct from current domain
        const meta = document.querySelector('meta[name="asset-url"]');
        if (meta) {
            return meta.content + '/assets/images/cars';
        }
        // Fallback to relative path
        return '/assets/images/cars';
    }

    setupTurnstile() {
        // Turnstile callbacks
        window.onTurnstileSuccess = (token) => {
            this.turnstileToken = token;
            this.validateAllForms();
        };

        window.onTurnstileError = () => {
            this.turnstileToken = null;
            this.validateAllForms();
        };

        window.onTurnstileExpired = () => {
            this.turnstileToken = null;
            this.validateAllForms();
        };
    }

    validateForm(form) {
        if (!form) return;

        const submit = form.querySelector('button[type="submit"], input[type="submit"]');
        if (!submit) return;

        // Check all required fields
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        const allValid = Array.from(requiredFields).every(el => {
            if (el.type === 'checkbox' || el.type === 'radio') {
                return el.checked;
            }
            return el.value && el.value.toString().trim().length > 0;
        });

        // Check Turnstile if enabled
        const hasTurnstile = form.querySelector('.cf-turnstile');
        const turnstileValid = !hasTurnstile || this.turnstileToken;

        const formValid = allValid && turnstileValid;
        
        submit.disabled = !formValid;
        submit.classList.toggle('bg-amber-600', formValid);
        submit.classList.toggle('hover:bg-amber-700', formValid);
        submit.classList.toggle('bg-slate-300', !formValid);
        submit.classList.toggle('cursor-not-allowed', !formValid);
    }

    validateAllForms() {
        document.querySelectorAll('form').forEach(form => this.validateForm(form));
    }

    attachValidation() {
        document.querySelectorAll('form').forEach(form => {
            // Skip if already attached
            if (form.dataset.validationAttached) return;
            form.dataset.validationAttached = 'true';

            form.querySelectorAll('input, select, textarea').forEach((field) => {
                field.addEventListener('input', () => this.validateForm(form));
                field.addEventListener('change', () => this.validateForm(form));
            });
            
            // Form submission validation
            form.addEventListener('submit', (e) => {
                if (!this.turnstileToken && form.querySelector('.cf-turnstile')) {
                    e.preventDefault();
                    alert('Please complete the security verification.');
                    return false;
                }
                
                // Add turnstile token to form
                if (this.turnstileToken) {
                    // Remove existing token input if any
                    const existingToken = form.querySelector('input[name="turnstile_token"]');
                    if (existingToken) {
                        existingToken.remove();
                    }
                    
                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = 'turnstile_token';
                    tokenInput.value = this.turnstileToken;
                    form.appendChild(tokenInput);
                }
            });
            
            this.validateForm(form);
        });
    }

    attachVehicleSelection() {
        document.querySelectorAll('select[name="vehicle_type"]').forEach(vehicleSelect => {
            // Skip if already attached
            if (vehicleSelect.dataset.vehicleAttached) return;
            vehicleSelect.dataset.vehicleAttached = 'true';

            const form = vehicleSelect.closest('form') || vehicleSelect.closest('.vehicle-container') || document;
            const vehicleDisplay = form.querySelector('#vehicle-display');
            const vehicleImage = form.querySelector('#vehicle-image');
            const vehicleName = form.querySelector('#vehicle-name');
            const vehicleCapacity = form.querySelector('#vehicle-capacity');
            const passengersSelect = form.querySelector('select[name="passengers"]');
            const suitcasesSelect = form.querySelector('select[name="suitcases"]');

            vehicleSelect.addEventListener('change', () => {
                const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
                
                if (selectedOption.value && vehicleSelect.selectedIndex > 0) {
                    const maxPassengers = parseInt(selectedOption.dataset.passengers);
                    const maxSuitcases = parseInt(selectedOption.dataset.suitcases);
                    const imageName = selectedOption.dataset.image;

                    // Show vehicle display if elements exist
                    if (vehicleDisplay) {
                        vehicleDisplay.classList.remove('hidden');
                    }
                    
                    if (vehicleImage && imageName) {
                        vehicleImage.src = `${this.assetBaseUrl}/${imageName}`;
                        vehicleImage.alt = selectedOption.value;
                    }
                    
                    if (vehicleName) {
                        vehicleName.textContent = selectedOption.value;
                    }
                    
                    if (vehicleCapacity && maxPassengers) {
                        vehicleCapacity.textContent = `Max ${maxPassengers} passengers`;
                    }

                    // Handle passenger select if it exists
                    if (passengersSelect && maxPassengers) {
                        passengersSelect.disabled = false;
                        passengersSelect.classList.remove('bg-slate-100', 'text-slate-400');
                        passengersSelect.classList.add('bg-white', 'text-slate-900');
                        passengersSelect.innerHTML = '<option value="" disabled selected>Choose passengers</option>';
                        for (let i = 1; i <= maxPassengers; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            passengersSelect.appendChild(option);
                        }
                    }

                    // Handle suitcase select if it exists
                    if (suitcasesSelect && maxSuitcases !== undefined) {
                        suitcasesSelect.disabled = false;
                        suitcasesSelect.classList.remove('bg-slate-100', 'text-slate-400');
                        suitcasesSelect.classList.add('bg-white', 'text-slate-900');
                        suitcasesSelect.innerHTML = '<option value="" disabled selected>Choose suitcases</option>';
                        for (let i = 0; i <= maxSuitcases; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            suitcasesSelect.appendChild(option);
                        }
                    }
                } else {
                    // Hide vehicle display
                    if (vehicleDisplay) {
                        vehicleDisplay.classList.add('hidden');
                    }
                    
                    // Reset passenger select
                    if (passengersSelect) {
                        passengersSelect.disabled = true;
                        passengersSelect.classList.add('bg-slate-100', 'text-slate-400');
                        passengersSelect.classList.remove('bg-white', 'text-slate-900');
                        passengersSelect.innerHTML = '<option value="">Select vehicle first</option>';
                    }
                    
                    // Reset suitcase select
                    if (suitcasesSelect) {
                        suitcasesSelect.disabled = true;
                        suitcasesSelect.classList.add('bg-slate-100', 'text-slate-400');
                        suitcasesSelect.classList.remove('bg-white', 'text-slate-900');
                        suitcasesSelect.innerHTML = '<option value="">Select vehicle first</option>';
                    }
                }

                // Trigger validation
                this.validateForm(vehicleSelect.closest('form'));
            });

            // Initially disable passenger and suitcase selects
            if (passengersSelect) passengersSelect.disabled = true;
            if (suitcasesSelect) suitcasesSelect.disabled = true;
        });
    }

    attachTabSwitching() {
        const tabs = document.querySelectorAll('.form-tab');
        const forms = document.querySelectorAll('.reservation-form, .quote-form, [data-form]');

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-form');

                tabs.forEach((t) => t.classList.remove('active', 'border-amber-400', 'text-amber-700'));
                tab.classList.add('active', 'border-amber-400', 'text-amber-700');

                forms.forEach((form) => {
                    const isTarget = form.getAttribute('data-form') === target;
                    form.classList.toggle('hidden', !isTarget);
                });

                // Re-validate visible forms
                setTimeout(() => this.validateAllForms(), 100);
            });
        });
    }

    initPlaces() {
        if (!(window.google && window.google.maps && window.google.maps.places) || !this.placesKey) {
            return false;
        }

        document.querySelectorAll('.location-input').forEach((input) => {
            // Skip if already initialized
            if (input.dataset.placesInitialized) return;
            input.dataset.placesInitialized = 'true';

            const hidden = input.parentElement?.querySelector('.place-id');
            const autocomplete = new window.google.maps.places.Autocomplete(input, {
                types: ['address'],
                componentRestrictions: { country: 'us' },
                fields: ['place_id', 'formatted_address', 'address_components', 'geometry'],
            });

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.place_id) {
                    if (hidden) hidden.value = '';
                    return;
                }

                if (hidden) hidden.value = place.place_id;

                // Enhanced address formatting
                let detailedAddress = '';
                if (place.address_components) {
                    const components = {};
                    place.address_components.forEach((component) => {
                        component.types.forEach((type) => {
                            components[type] = component.long_name;
                        });
                    });

                    const addressParts = [];
                    if (components.street_number && components.route) {
                        addressParts.push(`${components.street_number} ${components.route}`);
                    } else if (components.route) {
                        addressParts.push(components.route);
                    }

                    if (components.locality || components.sublocality_level_1) {
                        addressParts.push(components.locality || components.sublocality_level_1);
                    }

                    if (components.administrative_area_level_1) {
                        addressParts.push(components.administrative_area_level_1);
                    }

                    if (components.postal_code) {
                        addressParts.push(components.postal_code);
                    }

                    detailedAddress = addressParts.join(', ');
                }

                input.value = detailedAddress || place.formatted_address || input.value;
                this.validateForm(input.closest('form'));
            });

            input.addEventListener('input', () => {
                if (hidden) hidden.value = '';
                this.validateForm(input.closest('form'));
            });
        });

        return true;
    }

    ensurePlacesReady(attempts = 0) {
        if (this.initPlaces()) {
            return;
        }
        if (attempts < 20) {
            setTimeout(() => this.ensurePlacesReady(attempts + 1), 200);
        }
    }
}

// Initialize the forms system
window.royalCarriageForms = new RoyalCarriageForms();

// Global callback for Google Places API
window.initFormPlaces = () => {
    if (window.royalCarriageForms) {
        window.royalCarriageForms.ensurePlacesReady();
    }
};

// Legacy callbacks for backward compatibility
window.initQuoteFormPlaces = window.initFormPlaces;
window.initReservationPlaces = window.initFormPlaces;