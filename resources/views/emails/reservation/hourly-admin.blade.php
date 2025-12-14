<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Hourly Reservation - Royal Carriages</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9; }
        .email-container { width: 100%; padding: 20px 15px; box-sizing: border-box; }
        .container { width: 100%; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.12); }
        
        .header { background: linear-gradient(135deg, #dc2626 0%, #ea580c 50%, #f59e0b 100%); color: white; padding: 25px 30px; position: relative; }
        .header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="adminGrain" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="0.8" fill="%23ffffff" opacity="0.15"/><circle cx="40" cy="40" r="0.8" fill="%23ffffff" opacity="0.15"/><circle cx="25" cy="35" r="0.8" fill="%23ffffff" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23adminGrain)"/></svg>'); }
        .header-content { position: relative; z-index: 1; }
        .urgent-badge { background: rgba(255,255,255,0.2); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 12px; }
        .company-logo { font-size: 26px; font-weight: 800; margin: 0 0 4px 0; letter-spacing: -0.3px; }
        .header-title { font-size: 20px; font-weight: 600; margin: 8px 0 0 0; opacity: 0.95; }
        
        .content { padding: 35px 30px; }
        .alert-banner { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 15px 20px; margin-bottom: 25px; }
        .alert-text { color: #991b1b; font-size: 14px; font-weight: 600; margin: 0; }
        
        .section { margin-bottom: 30px; }
        .section-title { font-size: 16px; font-weight: 700; color: #dc2626; margin-bottom: 18px; display: flex; align-items: center; text-transform: uppercase; letter-spacing: 0.5px; }
        .section-icon { font-size: 18px; margin-right: 10px; }
        
        .info-card { background: #fafafa; border-radius: 10px; padding: 20px; border-left: 4px solid #dc2626; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item { margin-bottom: 12px; }
        .info-item:last-child { margin-bottom: 0; }
        .info-label { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; display: inline; }
        .info-value { font-size: 14px; color: #1f2937; font-weight: 500; word-break: break-word; display: inline; margin-left: 4px; }
        
        .schedule-card { background: #fff7ed; border-radius: 10px; padding: 20px; border-left: 4px solid #ea580c; }
        .trip-card { background: #f0fdf4; border-radius: 10px; padding: 20px; border-left: 4px solid #16a34a; }
        .requirements-card { background: #eff6ff; border-radius: 10px; padding: 20px; border-left: 4px solid #3b82f6; }
        .requirements-text { font-size: 14px; color: #1e293b; line-height: 1.6; white-space: pre-wrap; margin: 0; }
        
        .footer { background: #f8fafc; padding: 20px 30px; border-top: 1px solid #e2e8f0; }
        .footer-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center; }
        .footer-info { font-size: 12px; color: #64748b; }
        .footer-timestamp { font-size: 11px; color: #94a3b8; text-align: right; }
        
        @media (max-width: 600px) {
            .email-container { padding: 15px 10px; }
            .container { border-radius: 8px; }
            .content { padding: 25px 20px; }
            .info-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .footer-timestamp { text-align: center; margin-top: 10px; }
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
                    <div class="urgent-badge">🚨 New Hourly Reservation</div>
                    <h1 class="company-logo">Royal Carriages Limousines</h1>
                    <p class="header-title">Hourly Reservation Notification</p>
                </div>
            </div>
            
            <div class="content">
                <div class="alert-banner">
                    <p class="alert-text">⚡ New hourly reservation received - Extended service requested</p>
                </div>
                
                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 15px 20px; margin-bottom: 25px;">
                    <p style="color: #92400e; font-size: 14px; font-weight: 600; margin: 0 0 5px 0;">⏰ Response Required Within 24 Hours</p>
                    <p style="color: #92400e; font-size: 13px; margin: 0;">Please review this reservation request and respond to the customer promptly to maintain service excellence.</p>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">👤</span> Customer Information
                    </div>
                    <div class="info-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">First Name:</div>
                                <div class="info-value">{{ $data['first_name'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Last Name:</div>
                                <div class="info-value">{{ $data['last_name'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Company:</div>
                                <div class="info-value">{{ $data['company'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email Address:</div>
                                <div class="info-value">{{ $data['email'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone Number:</div>
                                <div class="info-value">{{ $data['phone'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">📅</span> Schedule and Location
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
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">🚗</span> Service Requirements
                    </div>
                    <div class="trip-card">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Type of Service:</div>
                                <div class="info-value">{{ $data['service_type'] ?? 'Hourly' }}</div>
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
                                <div class="info-label">Number of Suitcases:</div>
                                <div class="info-value">{{ $data['suitcases'] ?? 'Not specified' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="section">
                    <div class="section-title">
                        <span class="section-icon">💳</span> Payment Details
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
                        <span class="section-icon">📝</span> Special Requirements
                    </div>
                    <div class="requirements-card">
                        <div class="requirements-text">{{ $data['special_requirements'] }}</div>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="footer">
                <div class="footer-grid">
                    <div class="footer-info">
                        <strong>Royal Carriages Limousines</strong><br>
                        Admin Notification System
                    </div>
                    <div class="footer-timestamp">
                        <strong>Reservation Date:</strong> {{ date('M j, Y g:i A') }}<br>
                        <strong>Client IP:</strong> {{ request()->ip() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
