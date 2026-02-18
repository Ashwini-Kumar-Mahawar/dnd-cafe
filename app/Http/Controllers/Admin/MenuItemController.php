<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')
                            ->orderBy('category_id')
                            ->orderBy('sort_order')
                            ->get()
                            ->groupBy('category.name');

        // ← NEW: Get trashed items
        $trashedItems = MenuItem::onlyTrashed()
                                ->with('category')
                                ->orderBy('deleted_at', 'desc')
                                ->get();

        return view('admin.menu-items.index', compact('menuItems', 'trashedItems'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
                               ->orderBy('sort_order')
                               ->get();

        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'required|numeric|min:0|max:99999.99',
            'sort_order'   => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                                          ->store('menu-items', 'public');
        }

        $validated['is_available'] = $request->boolean('is_available', true);
        $validated['sort_order']   = $request->sort_order ?? 0;

        MenuItem::create($validated);

        return redirect()->route('admin.menu-items.index')
                         ->with('success', 'Menu item created successfully.');
    }

    public function show(MenuItem $menuItem)
    {
        // Not needed — handled by index/edit
        return redirect()->route('admin.menu-items.index');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::where('is_active', true)
                               ->orderBy('sort_order')
                               ->get();

        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'required|numeric|min:0|max:99999.99',
            'sort_order'   => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $validated['image'] = $request->file('image')
                                          ->store('menu-items', 'public');
        }

        $validated['is_available'] = $request->boolean('is_available');

        $menuItem->update($validated);

        return redirect()->route('admin.menu-items.index')
                         ->with('success', 'Menu item updated successfully.');
    }

    // ← UPDATED: Now soft deletes
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete(); // Soft delete

        return redirect()->route('admin.menu-items.index')
                        ->with('success', 'Menu item "' . $menuItem->name . '" moved to trash.');
    }

    // ← NEW: Restore from trash
    public function restore(int $id)
    {
        $menuItem = MenuItem::onlyTrashed()->findOrFail($id);
        $menuItem->restore();

        return redirect()->route('admin.menu-items.index')
                        ->with('success', 'Menu item "' . $menuItem->name . '" restored successfully.');
    }

    // ← NEW: Permanently delete
    public function forceDelete(int $id)
    {
        $menuItem = MenuItem::onlyTrashed()->findOrFail($id);

        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->forceDelete();

        return redirect()->route('admin.menu-items.index')
                        ->with('success', 'Menu item permanently deleted.');
    }
}