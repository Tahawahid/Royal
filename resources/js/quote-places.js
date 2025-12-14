const requiredComponents = ['street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code'];
let quotePlacesKey = '';

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
    
    // Call validation if it exists
    if (window.validateForm) {
        window.validateForm();
    }
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
            if (window.validateForm) {
                window.validateForm();
            }
        });
    });

    return true;
}

// Global callback for Google Maps API
window.initQuotePlaceAutocomplete = () => {
    if (window.google && window.google.maps && window.google.maps.places) {
        quotePlacesKey = document.getElementById('quote-form')?.dataset.placesKey || '';
        if (quotePlacesKey) {
            initQuotePlaceAutocomplete();
        }
    }
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    quotePlacesKey = document.getElementById('quote-form')?.dataset.placesKey || '';
});