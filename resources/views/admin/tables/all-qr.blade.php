<!DOCTYPE html>
{{-- <html>
<head>
    <title>All QR Codes - DND Cafe</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 20px;
            background: #f5f5f5;
        }
        .qr-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        .qr-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            break-inside: avoid;
        }
        .qr-card h2 {
            font-size: 24px;
            color: #3d0a0a;
            margin-bottom: 10px;
        }
        .qr-card .url {
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
            word-break: break-all;
        }
        .qr-code {
            margin: 20px auto;
        }
        .instructions {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c9922a;
        }
        @media print {
            .no-print { display: none; }
            .qr-card { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <h1>DND Cafe - All Table QR Codes</h1>
        <div class="instructions">
            <strong>📌 Instructions:</strong>
            <ol>
                <li>Press Ctrl+P (or Cmd+P on Mac) to print</li>
                <li>Select "Save as PDF" or print directly</li>
                <li>Cut out each QR code</li>
                <li>Place on respective tables</li>
            </ol>
        </div>
    </div>

    <div class="qr-container">
        @foreach($tables as $table)
            <div class="qr-card">
                <h2>{{ $table->name }}</h2>
                <p class="url">{{ route('customer.scan', $table->slug) }}</p>
                
                <div class="qr-code">
                    {!! QrCode::size(250)->margin(2)->generate(route('customer.scan', $table->slug)) !!}
                </div>
                
                <p style="font-size: 14px; color: #666; margin-top: 10px;">
                    Scan to order
                </p>
            </div>
        @endforeach
    </div>

    <div class="no-print" style="margin-top: 40px; text-align: center;">
        <button onclick="window.print()" style="padding: 12px 24px; background: #c9922a; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer;">
            🖨️ Print All QR Codes
        </button>
        <a href="{{ route('admin.tables.index') }}" style="display: inline-block; margin-left: 10px; padding: 12px 24px; background: #666; color: white; text-decoration: none; border-radius: 6px;">
            ← Back to Tables
        </a>
    </div>
</body>
</html>
--}}