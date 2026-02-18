<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $tables = CafeTable::withCount('orders')
                            ->orderBy('name')
                            ->get();

        // ← NEW
        $trashedTables = CafeTable::onlyTrashed()
                                ->orderBy('deleted_at', 'desc')
                                ->get();

        return view('admin.tables.index', compact('tables', 'trashedTables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:tables,name',
            'capacity'  => 'required|integer|min:1|max:20',
            'is_active' => 'boolean',
        ]);

        // ── Auto-generate URL-safe slug from name ─────────────────
        // "Table 1" becomes "table-1"
        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        CafeTable::create($validated);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table created successfully.');
    }

    public function show(CafeTable $table)
    {
        return redirect()->route('admin.tables.index');
    }

    public function edit(CafeTable $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, CafeTable $table)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:tables,name,' . $table->id,
            'capacity'  => 'required|integer|min:1|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $table->update($validated);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table updated successfully.');
    }

    // ← UPDATED: Now soft deletes
    public function destroy(CafeTable $table)
    {
        $hasActiveOrders = $table->orders()
                                ->whereNotIn('status', ['delivered', 'cancelled'])
                                ->exists();

        if ($hasActiveOrders) {
            return back()->with('error', 'Cannot delete table with active orders.');
        }

        $table->delete(); // Soft delete

        return redirect()->route('admin.tables.index')
                        ->with('success', 'Table "' . $table->name . '" moved to trash.');
    }

    // ← NEW: Restore from trash
    public function restore(int $id)
    {
        $table = CafeTable::onlyTrashed()->findOrFail($id);
        $table->restore();

        return redirect()->route('admin.tables.index')
                        ->with('success', 'Table "' . $table->name . '" restored successfully.');
    }


    // ── QR Code Generation ────────────────────────────────────────
    public function generateQR(CafeTable $table)
    {
        // ⭐ CHANGED: Use /scan/ route instead of /menu/ route
        // This sets the session flag before showing the menu
        $url = route('customer.scan', $table->slug);

        $qrCode = QrCode::format('svg')
                        ->size(300)
                        ->margin(2)
                        ->errorCorrection('H')
                        ->generate($url);

        // Return as downloadable SVG file
        return response($qrCode, 200, [
            'Content-Type'        => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="qr-' . $table->slug . '.svg"',
        ]);
    }

    // ← NEW: Permanently delete
    public function forceDelete(int $id)
    {
        $table = CafeTable::onlyTrashed()->findOrFail($id);
        $table->forceDelete();

        return redirect()->route('admin.tables.index')
                        ->with('success', 'Table permanently deleted.');
    }
}