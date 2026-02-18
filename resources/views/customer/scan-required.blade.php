<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code - DND Cafe</title>
    @vite(['resources/css/app.css', 'resources/css/landing.css'])
</head>
<body style="padding-top: 0;"> {{-- Override body padding for this page --}}
    
    <div style="min-height: 100vh; background: linear-gradient(160deg, #3d0a0a 0%, #5c1010 40%, #1a0505 100%); display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div style="max-width: 580px; width: 100%;">
            
            {{-- DND Cafe Logo --}}
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 style="font-family: 'Bebas Neue', sans-serif; font-size: 4rem; letter-spacing: 0.06em; color: #e8b84b; line-height: 1; margin-bottom: 8px;">
                    DND CAFE
                </h1>
                <p style="font-family: 'Playfair Display', serif; font-style: italic; color: rgba(255,255,255,0.5); font-size: 1rem;">
                    Desi · n · Delicious
                </p>
            </div>

            {{-- Main Card --}}
            <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(201,146,42,0.3); border-radius: 16px; overflow: hidden; backdrop-filter: blur(10px);">
                
                {{-- Icon Section --}}
                <div style="background: linear-gradient(135deg, #c7922a 0%, #d4a853 100%); padding: 40px 30px; text-align: center;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: white; border-radius: 50%; margin-bottom: 20px;">
                        <svg style="width: 40px; height: 40px; color: #c7922a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h2 style="font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: #3d0a0a; margin-bottom: 8px; letter-spacing: 0.05em;">
                        Scan QR Code to Order
                    </h2>
                    <p style="color: rgba(61,10,10,0.7); font-size: 0.9rem; font-weight: 500;">
                        In-cafe dining only
                    </p>
                </div>

                {{-- Content Section --}}
                <div style="padding: 40px 30px;">
                    
                    {{-- Message --}}
                    <div style="background: rgba(201,146,42,0.15); border-left: 4px solid #c7922a; padding: 20px; border-radius: 8px; margin-bottom: 32px;">
                        <p style="color: #e8b84b; font-size: 0.95rem; line-height: 1.7; margin-bottom: 12px;">
                            <strong style="display: block; margin-bottom: 8px; font-size: 1.05rem;">Currently, we do not provide home delivery.</strong>
                            To place an order, please visit our cafe and scan the QR code on your table.
                        </p>
                    </div>

                    {{-- Steps --}}
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; color: rgba(255,255,255,0.9); letter-spacing: 0.05em; margin-bottom: 20px;">
                            How to Order:
                        </h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="display: flex; align-items: start; gap: 16px;">
                                <div style="flex-shrink: 0; width: 36px; height: 36px; background: #c7922a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                    1
                                </div>
                                <div style="padding-top: 6px;">
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; margin-bottom: 4px; font-weight: 500;">Visit DND Cafe</p>
                                    <p style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">Chawand ka Mand, Jamva Ramgar Road</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: 16px;">
                                <div style="flex-shrink: 0; width: 36px; height: 36px; background: #c7922a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                    2
                                </div>
                                <div style="padding-top: 6px;">
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; margin-bottom: 4px; font-weight: 500;">Choose a table</p>
                                    <p style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">Find a comfortable spot</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: 16px;">
                                <div style="flex-shrink: 0; width: 36px; height: 36px; background: #c7922a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                    3
                                </div>
                                <div style="padding-top: 6px;">
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; margin-bottom: 4px; font-weight: 500;">Scan QR code on table</p>
                                    <p style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">Open camera and scan the code</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: 16px;">
                                <div style="flex-shrink: 0; width: 36px; height: 36px; background: #c7922a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                    4
                                </div>
                                <div style="padding-top: 6px;">
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; margin-bottom: 4px; font-weight: 500;">Browse menu & order!</p>
                                    <p style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">Your order goes straight to kitchen</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Location/Contact --}}
                    <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px; margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <svg style="width: 18px; height: 18px; color: #c7922a; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span style="color: rgba(255,255,255,0.7); font-size: 0.85rem; line-height: 1.5;">
                                Chawand ka Mand, Near Police Chowki, Jamva Ramgar Road, Jaipur
                            </span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <svg style="width: 18px; height: 18px; color: #c7922a; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <a href="tel:8094296539" style="color: #e8b84b; font-size: 0.85rem; text-decoration: none; font-weight: 500;">
                                8094296539
                            </a>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <a href="/" 
                       style="display: block; width: 100%; padding: 14px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); text-align: center; color: rgba(255,255,255,0.8); font-size: 0.9rem; font-weight: 500; border-radius: 8px; text-decoration: none; transition: all 0.2s;">
                        ← Back to Home
                    </a>

                </div>
            </div>

            {{-- Footer Note --}}
            <p style="text-align: center; color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-top: 24px; line-height: 1.6;">
                We appreciate your understanding.<br>See you at the cafe! ☕
            </p>

        </div>
    </div>

</body>
</html>
