<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class QuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'email:rfc', 'max:150'],
            'phone' => ['required', 'regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/'],
            'company' => ['nullable', 'string', 'max:120'],
            'pickup_date' => ['required', 'date'],
            'pickup_time' => ['required', 'string', 'max:10'],
            'dropoff_time' => ['required', 'string', 'max:10'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'pickup_place_id' => ['required', 'string', 'max:255'],
            'dropoff_location' => ['required', 'string', 'max:255'],
            'dropoff_place_id' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:80'],
            'vehicle_type' => ['required', 'string', 'max:120'],
            'passengers' => ['required', 'integer', 'min:1', 'max:60'],
            'other_requirements' => ['required', 'string', 'max:2000'],
            'consent_contact' => ['accepted'],
            'consent_promotions' => ['accepted'],
            'turnstile_token' => ['required', 'string'],
            'website' => ['present', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Use a US phone number in the format 555-123-4567.',
            'website.max' => 'Nice try.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if ($this->hasDisposableEmail()) {
                $validator->errors()->add('email', 'Please use a valid business email address.');
            }

            $this->checkForSpamPatterns($validator);
            $this->checkNameForSpam($validator);
            $this->checkPhoneForSpam($validator);

            if (! $this->verifyTurnstile()) {
                $validator->errors()->add('turnstile', 'Spam check failed. Please try again.');
            }
        });
    }

    protected function hasDisposableEmail(): bool
    {
        $email = strtolower((string) $this->input('email'));
        $domain = substr($email, strrpos($email, '@') + 1);

        $blocklist = [
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
            'mail.ru',
            'mailbox.in.ua',
            '1rmmail.top',
            'loancalculator.world',
            'fringmail.com', // From spam samples
        ];

        return $domain === '' || in_array($domain, $blocklist, true);
    }

    protected function checkForSpamPatterns($validator): void
    {
        $fields = [
            'other_requirements' => $this->input('other_requirements', ''),
            'first_name' => $this->input('first_name', ''),
            'last_name' => $this->input('last_name', ''),
        ];

        foreach ($fields as $field => $text) {
            $text = strtolower((string) $text);

            // Check for URLs
            $linkCount = preg_match_all('/https?:\/\//', $text);

            // Check for Cyrillic characters (Russian spam)
            $hasCyrillic = (bool) preg_match('/[\p{Cyrillic}]{4,}/u', $text);

            // Check for HTML tags
            $hasHtml = (bool) preg_match('/<[a-z][^>]*>/i', $text);

            // Check for suspicious keywords from spam samples
            $spamKeywords = [
                'proffseo.ru',
                'сайт',
                'продвижение',
                'bestlimousines',
                'адвокат',
                'юрист',
                'dog house',
                'calculator',
                'casino',
                'payment available',
                'transfer here',
            ];

            $hasSpamKeywords = false;
            foreach ($spamKeywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    $hasSpamKeywords = true;
                    break;
                }
            }

            if ($linkCount > 0 || $hasCyrillic || $hasHtml || $hasSpamKeywords) {
                $validator->errors()->add($field, 'Please remove links, HTML, or promotional content.');
            }
        }
    }

    protected function checkNameForSpam($validator): void
    {
        $firstName = strtolower((string) $this->input('first_name', ''));
        $lastName = strtolower((string) $this->input('last_name', ''));

        // Check for suspicious patterns in names from spam samples
        $spamNamePatterns = [
            'buddyelact',
            'advokat_',
            'fnqraropy',
            'santohob',
            '* * *',
            'ххх',
        ];

        foreach ($spamNamePatterns as $pattern) {
            if (str_contains($firstName, $pattern) || str_contains($lastName, $pattern)) {
                $validator->errors()->add('first_name', 'Please provide a valid name.');
                break;
            }
        }

        // Check if first and last name are identical (common spam pattern)
        if (! empty($firstName) && $firstName === $lastName) {
            $validator->errors()->add('last_name', 'Please provide different first and last names.');
        }
    }

    protected function checkPhoneForSpam($validator): void
    {
        $phone = (string) $this->input('phone', '');

        // Remove formatting for analysis
        $digitsOnly = preg_replace('/[^0-9]/', '', $phone);

        // Check for suspicious phone patterns from spam samples
        $spamPhonePatterns = [
            '629405794605', // From spam sample
            '854913',       // Common prefix in spam
            '837756',       // Common prefix in spam
        ];

        foreach ($spamPhonePatterns as $pattern) {
            if (str_contains($digitsOnly, $pattern)) {
                $validator->errors()->add('phone', 'Please provide a valid phone number.');
                break;
            }
        }
    }

    protected function verifyTurnstile(): bool
    {
        $secret = config('services.cloudflare_turnstile.secret_key');
        $token = (string) $this->input('turnstile_token');

        if (! $secret || ! $token) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $this->ip(),
            ]);

            return (bool) data_get($response->json(), 'success', false);
        } catch (\Throwable) {
            return false;
        }
    }
}
