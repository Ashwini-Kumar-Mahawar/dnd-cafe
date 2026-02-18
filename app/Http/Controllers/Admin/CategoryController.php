<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menuItems')
                               ->orderBy('sort_order')
                               ->get();

        // ← NEW: Get trashed categories
        $trashedCategories = Category::onlyTrashed()
                                     ->withCount('menuItems')
                                     ->orderBy('deleted_at', 'desc')
                                     ->get();

        return view('admin.categories.index', compact('categories', 'trashedCategories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:categories,name',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'boolean',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                                          ->store('categories', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['sort_order'] = $request->sort_order ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:categories,name,' . $category->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'boolean',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')
                                          ->store('categories', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $category->update($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    // ← UPDATED: Now soft deletes
    public function destroy(Category $category)
    {
        $category->delete(); // Soft delete

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category "' . $category->name . '" moved to trash.');
    }

    // ← NEW: Restore from trash
    public function restore(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category "' . $category->name . '" restored successfully.');
    }

    // ← NEW: Permanently delete
    public function forceDelete(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->forceDelete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category permanently deleted.');
    }

    public function show(Category $category) {}
}