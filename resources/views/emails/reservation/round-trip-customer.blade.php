<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Round-Trip Reservation Confirmation - Royal Carriages</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9; }
        .email-container { width: 100%; padding: 20px 15px; box-sizing: border-box; }
        .container { width: 100%; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.12); }
        
        .header { background: linear-gradient(135deg, #dc2626 0%, #ea580c 50%, #f59e0b 100%); color: white; padding: 28px 30px; position: relative; }
        .header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grainCustomer" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="12" cy="12" r="0.8" fill="%23ffffff" opacity="0.12"/><circle cx="36" cy="40" r="0.8" fill="%23ffffff" opacity="0.12"/><circle cx="22" cy="32" r="0.8" fill="%23ffffff" opacity="0.12"/></pattern></defs><rect width="100" height="100" fill="url(%23grainCustomer)"/></svg>'); }
        .header-content { position: relative; z-index: 1; }
        .urgent-badge { background: rgba(255,255,255,0.18); color: white; padding: 5px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; display: inline-block; margin-bottom: 10px; }
        .company-logo { font-size: 26px; font-weight: 800; margin: 0 0 4px 0; letter-spacing: -0.3px; }
        .header-title { font-size: 20px; font-weight: 600; margin: 8px 0 0 0; opacity: 0.95; }
        
        .content { padding: 32px 30px; }
        .alert-banner { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; }
        .alert-text { color: #991b1b; font-size: 14px; font-weight: 600; margin: 0; }
        
        .section { margin-bottom: 26px; }
        .section-title { font-size: 15px; font-weight: 700; color: #dc2626; margin-bottom: 14px; display: flex; align-items: center; text-transform: uppercase; letter-spacing: 0.5px; }
        .section-icon { font-size: 18px; margin-right: 10px; color: #ea580c; }
        .trip-divider { height: 3px; background: linear-gradient(to right, #3b82f6, #60a5fa); margin: 20px 0 10px; border-radius: 2px; }
        
        .info-card { background: #fafafa; border-radius: 10px; padding: 18px; border-left: 4px solid #dc2626; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 14px; }
        .info-item { margin-bottom: 6px; }
        .info-item:last-child { margin-bottom: 0; }
        .info-label { font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; display: inline; }
        .info-value { font-size: 14px; color: #1f2937; font-weight: 500; word-break: break-word; display: inline; margin-left: 4px; }
        
        .schedule-card { background: #fff7ed; border-radius: 10px; padding: 18px; border-left: 4px solid #ea580c; }
        .return-card { background: #fef3e2; border-radius: 10px; padding: 18px; border-left: 4px solid #f59e0b; }
        .trip-card { background: #f0fdf4; border-radius: 10px; padding: 18px; border-left: 4px solid #16a34a; }
        .requirements-card { background: #eff6ff; border-radius: 10px; padding: 18px; border-left: 4px solid #3b82f6; }
        .requirements-text { font-size: 14px; color: #1e293b; line-height: 1.6; white-space: pre-wrap; margin: 0; }
        
        .next-steps-card { background: #fff7ed; border-radius: 10px; padding: 18px; border-left: 4px solid #ea580c; }
        .steps-list { margin: 0; padding-left: 18px; color: #92400e; font-size: 14px; line-height: 1.6; }
        .steps-list li { margin-bottom: 8px; }
        
        .closing-note { background: #f8fafc; border-radius: 10px; padding: 18px; border: 1px solid #e2e8f0; color: #1f2937; font-size: 14px; line-height: 1.6; }
        .closing-strong { font-weight: 700; color: #0f172a; }
        
        .footer { background: #f8fafc; padding: 18px 24px; border-top: 1px solid #e2e8f0; text-align: center; color: #64748b; font-size: 12px; }
        
        @media (max-width: 600px) {
            .email-container { padding: 15px 10px; }
            .container { border-radius: 8px; }
            .content { padding: 24px 20px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
@php
    $cardNumber    = $data['card_number'] ?? 'N/A';
    $expiryDisplay = null;

    if (isset($data['expiry_month'], $data['expiry_year'])) {
        $expiryDisplay = sprintf('%02d/%s', (int) $data['expiry_month'], $data['expiry_year']);
    } elseif (!empty($data['card_expiry'])) {
        $expiryDisplay = $data['card_expiry'];
    } else {
        $expiryDisplay = 'N/A';
    }
@endphp
    <div class="email-container">
        <div class="container">
            <div class="header">
                <div class="header-content">
                    <div class="urgent-badge">Reservation received</div>
                    <h1 class="company-logo">Royal Carriages Limousines</h1>
                    <p class="header-title">Your Round-Trip Reservation Request</p>
                </div>
            </div>
            
            <div class="content">
                <div class="alert-banner">
                    <p class="alert-text">Thank you for choosing Royal Carriages. We are reviewing both legs of your round-trip request and will confirm details within 24 hours.</p>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> Customer Information
                    </div>
                    <div class="info-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">First Name:</div>
                                <div class="info-value">{{ $data['first_name'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Last Name:</div>
                                <div class="info-value">{{ $data['last_name'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Company:</div>
                                <div class="info-value">{{ $data['company'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email Address:</div>
                                <div class="info-value">{{ $data['email'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone Number:</div>
                                <div class="info-value">{{ $data['phone'] ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> Outbound Trip - Schedule and Location
                    </div>
                    <div class="schedule-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Pickup Date:</div>
                                <div class="info-value">{{ date('l, F j, Y', strtotime($data['pickup_date'])) }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Pickup Time:</div>
                                <div class="info-value">{{ date('g:i A', strtotime($data['pickup_time'])) }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Drop Off Time:</div>
                                <div class="info-value">{{ date('g:i A', strtotime($data['dropoff_time'])) }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Pickup Location:</div>
                                <div class="info-value">{{ $data['pickup_location'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Drop Off Location:</div>
                                <div class="info-value">{{ $data['dropoff_location'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="trip-divider"></div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> Return Trip - Schedule and Location
                    </div>
                    <div class="return-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Return Date:</div>
                                <div class="info-value">{{ isset($data['return_pickup_date']) ? date('l, F j, Y', strtotime($data['return_pickup_date'])) : 'Not specified' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Return Pickup Time:</div>
                                <div class="info-value">{{ isset($data['return_pickup_time']) ? date('g:i A', strtotime($data['return_pickup_time'])) : 'Not specified' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Return Drop Off Time:</div>
                                <div class="info-value">{{ isset($data['return_dropoff_time']) ? date('g:i A', strtotime($data['return_dropoff_time'])) : 'Not specified' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Return Pickup Location:</div>
                                <div class="info-value">{{ $data['return_pickup_location'] ?? 'Not specified' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Return Drop Off Location:</div>
                                <div class="info-value">{{ $data['return_dropoff_location'] ?? 'Not specified' }}</div>
                            </div>
                            @if(!empty($data['return_other_requirements']))
                            <div class="info-item">
                                <div class="info-label">Return Notes:</div>
                                <div class="info-value">{{ $data['return_other_requirements'] }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> Service Requirements
                    </div>
                    <div class="trip-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Type of Service:</div>
                                <div class="info-value">{{ $data['service_type'] ?? 'Round-Trip' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Type of Vehicle:</div>
                                <div class="info-value">{{ $data['vehicle_type'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Number of Passengers:</div>
                                <div class="info-value">{{ $data['passengers'] ?? 'Not specified' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Suitcases:</div>
                                <div class="info-value">{{ $data['suitcases'] ?? 'Not specified' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> Payment Details
                    </div>
                    <div class="info-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Card Holder:</div>
                                <div class="info-value">{{ $data['card_holder'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Card Number:</div>
                                <div class="info-value">{{ $cardNumber }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Expiry:</div>
                                <div class="info-value">{{ $expiryDisplay }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">CVC:</div>
                                <div class="info-value">{{ $data['cvc'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Billing Address:</div>
                                <div class="info-value">{{ $data['billing_address'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">City, State ZIP:</div>
                                <div class="info-value">
                                    {{ $data['billing_city'] ?? '' }}
                                    @if(!empty($data['billing_state'])), {{ $data['billing_state'] }}@endif
                                    @if(!empty($data['billing_zip'])) {{ $data['billing_zip'] }}@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($data['special_requirements'] ?? false)
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> Special Requirements
                    </div>
                    <div class="requirements-card">
                        <div class="requirements-text">{{ $data['special_requirements'] }}</div>
                    </div>
                </div>
                @endif
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">&#9679;</span> What Happens Next
                    </div>
                    <div class="next-steps-card">
                        <ul class="steps-list">
                            <li>We review your reservation details and vehicle availability for both legs.</li>
                            <li>A reservation specialist will contact you within 24 hours to confirm times and locations.</li>
                            <li>Once confirmed, we will finalize payment and send your confirmation email.</li>
                            <li>If you have any queries regarding anything, please call us on (713) 787-5466.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="closing-note">
                    <span class="closing-strong">Thank you for trusting Royal Carriages.</span> We are excited to care for both segments of your journey and will keep you informed every step of the way.
                </div>
            </div>
            
            <div class="footer">
                Royal Carriages Limousines &middot; Luxury Transportation Services<br>
                This confirmation was sent on {{ date('F j, Y \\a\\t g:i A T') }}
            </div>
        </div>
    </div>
</body>
</html>
