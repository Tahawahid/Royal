<?php
namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Mail\ReservationAdminMail;
use App\Mail\ReservationCustomerMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Remove spam protection fields from data
        unset($validatedData['turnstile_token'], $validatedData['website']);

        // Prepare admin email data with full credit card details
        $adminEmailData = $validatedData;

                                               // Add payment info for email display
        $adminEmailData['total_amount']   = 0; // Will be calculated later
        $adminEmailData['payment_method'] = 'Credit Card';
        $adminEmailData['card_type']      = $this->getCardType($validatedData['card_number'] ?? '');

        // Add service-specific fields for hourly reservations
        if (($validatedData['reservation_type'] ?? '') === 'hourly') {
            // Calculate hours of service from times
            $pickupTime                         = strtotime($validatedData['pickup_time'] ?? '00:00');
            $dropoffTime                        = strtotime($validatedData['dropoff_time'] ?? '00:00');
            $hoursOfService                     = max(1, abs($dropoffTime - $pickupTime) / 3600);
            $adminEmailData['hours_of_service'] = round($hoursOfService, 1) . ' hours';
        }

        // Prepare customer email data with masked credit card information for security
        $customerEmailData = $validatedData;
        unset($customerEmailData['card_number'], $customerEmailData['cvc'], $customerEmailData['expiry_month'], $customerEmailData['expiry_year']);

                                                  // Add payment info for customer email
        $customerEmailData['total_amount']   = 0; // Will be calculated later
        $customerEmailData['payment_method'] = 'Credit Card';
        $customerEmailData['card_type']      = $this->getCardType($validatedData['card_number'] ?? '');

        // Add service-specific fields for hourly reservations
        if (($validatedData['reservation_type'] ?? '') === 'hourly') {
            // Calculate hours of service from times
            $pickupTime                            = strtotime($validatedData['pickup_time'] ?? '00:00');
            $dropoffTime                           = strtotime($validatedData['dropoff_time'] ?? '00:00');
            $hoursOfService                        = max(1, abs($dropoffTime - $pickupTime) / 3600);
            $customerEmailData['hours_of_service'] = round($hoursOfService, 1) . ' hours';
        }

        // Add masked card number for customer confirmation
        if (isset($validatedData['card_number'])) {
            $cardNumber                          = $validatedData['card_number'];
            $customerEmailData['card_last_four'] = '**** **** **** ' . substr($cardNumber, -4);
            $customerEmailData['card_holder']    = $validatedData['card_holder'];
        }

        try {
            // Send admin emails to temporary addresses
            // Mail::to('sammohammad7788@gmail.com')->send(new ReservationAdminMail($adminEmailData));
            Mail::to('info@royalcarriages.com')->send(new ReservationAdminMail($adminEmailData));
            Mail::to('muhammadtahawahid1@gmail.com')->send(new ReservationAdminMail($adminEmailData));

            // Send customer email
            Mail::to($customerEmailData['email'])->send(new ReservationCustomerMail($customerEmailData));

            return redirect()
                ->route('reservations')
                ->with('success', 'Thank you! Your reservation request has been submitted successfully. We\'ll contact you soon to confirm the details.');

        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput($request->except('turnstile_token', 'card_number', 'cvc'))
                ->withErrors(['submission' => 'Error: ' . $e->getMessage() . ' (File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ')']);
        }
    }

    /**
     * Determine credit card type from card number
     */
    private function getCardType(string $cardNumber): string
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);

        if (preg_match('/^4/', $cardNumber)) {
            return 'Visa';
        } elseif (preg_match('/^5[1-5]/', $cardNumber) || preg_match('/^2[2-7]/', $cardNumber)) {
            return 'Mastercard';
        } elseif (preg_match('/^3[47]/', $cardNumber)) {
            return 'American Express';
        } elseif (preg_match('/^6011|^65/', $cardNumber)) {
            return 'Discover';
        }

        return 'Credit Card';
    }
}
