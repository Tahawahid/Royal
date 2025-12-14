<?php
namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Mail\QuoteAdminMail;
use App\Mail\QuoteCustomerMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(QuoteRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['turnstile_token', 'website']);

        // Send admin emails to temporary addresses
        // Mail::to('sammohammad7788@gmail.com')->send(new QuoteAdminMail($data));
        Mail::to('info@royalcarriages.com')->send(new QuoteAdminMail($data));
        Mail::to('muhammadtahawahid1@gmail.com')->send(new QuoteAdminMail($data));

        Mail::to($data['email'])->send(new QuoteCustomerMail($data));

        return back()->with('status', 'Thank you! Your quote request was received. We will contact you shortly.');
    }
}
