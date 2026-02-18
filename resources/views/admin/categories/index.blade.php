@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Organise your menu into categories.')

@section('header-actions')
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold px-4 py-2 rounded-lg text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Category
    </a>
@endsection

@section('content')

    {{-- ── Active Categories ───────────────────────────────────── --}}
    <div class="bg-stone-900 border border-stone-800 rounded-xl overflow-hidden mb-6">
        <table class="w-full text-sm">
            <thead class="border-b border-stone-800">
                <tr class="text-xs text-stone-500 uppercase tracking-widest">
                    <th class="px-6 py-3 text-left font-medium">#</th>
                    <th class="px-6 py-3 text-left font-medium">Category</th>
                    <th class="px-6 py-3 text-left font-medium">Items</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-left font-medium">Sort Order</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                @forelse($categories as $category)
                    <tr class="hover:bg-stone-800/30 transition-colors">
                        <td class="px-6 py-4 mono text-stone-600 text-xs">{{ $category->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($category->image)
                                    <img src="{{ $category->image_url }}"
                                         class="w-9 h-9 rounded-lg object-cover bg-stone-800"
                                         alt="{{ $category->name }}">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-stone-800 flex items-center justify-center text-stone-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <span class="font-medium text-stone-200">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-stone-400">{{ $category->menu_items_count }} items</td>
                        <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-medium">Active</span>
                            @else
                                <span class="px-2.5 py-1 bg-stone-700/50 text-stone-500 rounded-full text-xs font-medium">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 mono text-stone-500 text-xs">{{ $category->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-stone-500 hover:text-amber-400 transition-colors text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Move {{ $category->name }} to trash?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-stone-600 hover:text-red-400 transition-colors text-xs font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-stone-500">
                            No categories yet.
                            <a href="{{ route('admin.categories.create') }}" class="text-amber-400 ml-1 hover:underline">Create your first one →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Trash Section ────────────────────────────────────────── --}}
    @if($trashedCategories->count() > 0)
        <div x-data="{ open: false }">
            {{-- Trash Toggle Button --}}
            <button @click="open = !open"
                    class="flex items-center gap-2 text-sm text-stone-500 hover:text-red-400 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                 Trash ({{ $trashedCategories->count() }})
                <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Trash Table --}}
            <div x-show="open" x-transition>
                <div class="bg-stone-900 border border-red-500/20 rounded-xl overflow-hidden">
                    <div class="px-6 py-3 bg-red-500/5 border-b border-red-500/20">
                        <p class="text-xs text-red-400 font-medium"> Deleted Categories — Restore or permanently delete</p>
                    </div>
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-stone-800">
                            @foreach($trashedCategories as $category)
                                <tr class="hover:bg-stone-800/20 transition-colors opacity-60">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium text-stone-400 line-through">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-stone-600 text-xs">
                                        Deleted {{ $category->deleted_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            {{-- Restore --}}
                                            <form method="POST" action="{{ route('admin.categories.restore', $category->id) }}">
                                                @csrf
                                                <button type="submit" class="text-emerald-500 hover:text-emerald-400 transition-colors text-xs font-medium">
                                                    Restore
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form method="POST" action="{{ route('admin.categories.force-delete', $category->id) }}"
                                                  onsubmit="return confirm('Permanently delete {{ $category->name }}? This CANNOT be undone!')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-400 transition-colors text-xs font-medium">
                                                    Delete Forever
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection