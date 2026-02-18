<?php

use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Kitchen\KitchenController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// -------------------------------------------------------
// ROUTE MODEL BINDING — Always load relationships
// -------------------------------------------------------
Route::bind('order', function ($value) {
    return Order::with(['table', 'items.menuItem'])->findOrFail($value);
});

// -------------------------------------------------------
// ROOT — Smart redirect based on who is visiting
// -------------------------------------------------------
Route::get('/', function () {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    
    if ($user) {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('kitchen')) {
            return redirect()->route('kitchen.dashboard');
        }
    }
    return view('welcome');
});

// -------------------------------------------------------
// SCAN REQUIRED PAGE (for home visitors)
// -------------------------------------------------------
Route::get('/dine-in-only', function () {
    // Create a dummy table for display purposes
    $table = (object)['name' => 'DND Cafe', 'slug' => 'table-1'];
    return view('customer.scan-required', compact('table'));
})->name('customer.dine-in-only');

// -------------------------------------------------------
// AUTHENTICATION ROUTES (Login/Logout)
// -------------------------------------------------------
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        // Redirect based on role
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }
        if ($user->hasRole('kitchen')) {
            return redirect()->intended(route('kitchen.dashboard'));
        }
        
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->middleware('guest');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login');
})->name('logout');

// -------------------------------------------------------
// SCAN QR CODE ROUTE (Sets session then redirects to menu)
// -------------------------------------------------------
Route::get('/scan/{tableSlug}', [MenuController::class, 'scan'])->name('customer.scan');

// -------------------------------------------------------
// CUSTOMER ROUTES (Public — No Login Required)
// -------------------------------------------------------

Route::prefix('menu')->name('customer.')->group(function () {

    // ── Specific routes FIRST ─────────────────────────────────────
    Route::post('/cart/add',    [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/{tableSlug}', [CartController::class, 'show'])->name('cart.show');

    Route::post('/order/place', [OrderController::class, 'place'])->name('order.place');
    Route::get('/order/{orderNumber}/status',  [OrderController::class, 'status'])->name('order.status');

    // ── Wildcard LAST — must always be at the bottom of this group ─
    Route::get('/{tableSlug}', [MenuController::class, 'index'])->name('menu');
});

// -------------------------------------------------------
// ADMIN ROUTES (Protected — Admin Login Required)
// -------------------------------------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu Management
    Route::resource('categories', CategoryController::class);
    Route::resource('menu-items', MenuItemController::class);

    // Tables & QR Codes
    Route::resource('tables', TableController::class);
    Route::get('tables/{table}/qr', [TableController::class, 'generateQR'])->name('tables.qr');

    // Orders
    Route::resource('orders', OrderManagementController::class)->only(['index', 'show', 'destroy']);
    Route::patch('orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/mark-paid', [OrderManagementController::class, 'markAsPaid'])->name('orders.mark-paid');

    // ← NEW: Soft Delete Routes
    // Categories trash
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');

    // Menu Items trash
    Route::post('menu-items/{id}/restore', [MenuItemController::class, 'restore'])->name('menu-items.restore');
    Route::delete('menu-items/{id}/force-delete', [MenuItemController::class, 'forceDelete'])->name('menu-items.force-delete');

    // Tables trash
    Route::post('tables/{id}/restore', [TableController::class, 'restore'])->name('tables.restore');
    Route::delete('tables/{id}/force-delete', [TableController::class, 'forceDelete'])->name('tables.force-delete');

});

// -------------------------------------------------------
// KITCHEN ROUTES (Protected — Kitchen Staff Login)
// -------------------------------------------------------
Route::prefix('kitchen')->name('kitchen.')->middleware(['auth', 'role:kitchen'])->group(function () {
    Route::get('/',  [KitchenController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/status', [KitchenController::class, 'updateStatus'])->name('orders.status');
});

// // ── TEMPORARY: Generate all QR codes ──────────────────────────
// Route::get('/admin/generate-all-qr-codes', function() {
//     $tables = \App\Models\CafeTable::all();
    
//     return view('admin.tables.all-qr', compact('tables'));
// })->middleware(['auth', 'role:admin']);