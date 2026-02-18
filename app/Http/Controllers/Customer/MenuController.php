<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Scan QR Code - Sets session and redirects to menu
     */
    public function scan(string $tableSlug)
    {
        $table = CafeTable::where('slug', $tableSlug)->firstOrFail();
        
        // Set session flag that user scanned QR at cafe
        session([
            'scanned_at_cafe' => true,
            'scanned_table' => $table->slug,
            'scanned_at' => now(),
        ]);
        
        // Redirect to menu
        return redirect()->route('customer.menu', $tableSlug);
    }
    
    /**
     * Show menu - Verify user scanned QR
     */
    public function index(string $tableSlug)
    {
        $table = CafeTable::where('slug', $tableSlug)->firstOrFail();
        
        // ⭐ CHECK IF USER SCANNED QR CODE
        if (!session('scanned_at_cafe')) {
            return view('customer.scan-required', compact('table'));
        }
        
        // Check if session is for this table
        if (session('scanned_table') !== $tableSlug) {
            return view('customer.scan-required', compact('table'));
        }
        
        // Optional: Check if scan is recent (within 8 hours)
        $scannedAt = session('scanned_at');
        if ($scannedAt && now()->diffInHours($scannedAt) > 8) {
            session()->forget(['scanned_at_cafe', 'scanned_table', 'scanned_at']);
            return view('customer.scan-required', compact('table'));
        }
        
        // ✅ User scanned QR - show menu
        $categories = Category::with(['menuItems' => function($query) {
            $query->where('is_available', true)->orderBy('name');
        }])
        ->whereHas('menuItems', function($query) {
            $query->where('is_available', true);
        })
        ->orderBy('sort_order')
        ->get();

        // ✅ Calculate cart count
        $cartCount = collect(session('cart_' . $table->slug, []))->sum('quantity');

        return view('customer.menu', compact('categories', 'table', 'cartCount'));
    }
}