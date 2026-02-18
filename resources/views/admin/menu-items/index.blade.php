@extends('layouts.admin')

@section('title', 'Menu Items')
@section('page-title', 'Menu Items')
@section('page-subtitle', 'Manage the items customers can order.')

@section('header-actions')
    <a href="{{ route('admin.menu-items.create') }}"
       class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold px-4 py-2 rounded-lg text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Item
    </a>
@endsection

@section('content')

    @if($menuItems->isEmpty())
        <div class="bg-stone-900 border border-stone-800 rounded-xl p-12 text-center">
            <p class="text-stone-500 text-sm">No menu items yet.</p>
            <a href="{{ route('admin.menu-items.create') }}" class="text-amber-400 text-sm hover:underline mt-1 inline-block">Add your first item →</a>
        </div>
    @else
        {{-- Grouped by Category --}}
        @foreach($menuItems as $categoryName => $items)
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-stone-500 uppercase tracking-widest mb-3 px-1">{{ $categoryName }}</h3>

                <div class="bg-stone-900 border border-stone-800 rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="border-b border-stone-800">
                            <tr class="text-xs text-stone-600 uppercase tracking-widest">
                                <th class="px-6 py-3 text-left font-medium w-16">Image</th>
                                <th class="px-6 py-3 text-left font-medium">Item</th>
                                <th class="px-6 py-3 text-left font-medium">Price</th>
                                <th class="px-6 py-3 text-left font-medium">Status</th>
                                <th class="px-6 py-3 text-left font-medium">Sort</th>
                                <th class="px-6 py-3 text-right font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800">
                            @foreach($items as $item)
                                <tr class="hover:bg-stone-800/30 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-stone-800 shrink-0">
                                            @if($item->image)
                                                <img src="{{ $item->image_url }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-stone-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <p class="font-medium text-stone-200">{{ $item->name }}</p>
                                        @if($item->description)
                                            <p class="text-xs text-stone-600 mt-0.5 truncate max-w-xs">{{ Str::limit($item->description, 60) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="mono font-semibold text-amber-400">{{ $item->formatted_price }}</span>
                                    </td>
                                    <td class="px-6 py-3">
                                        @if($item->is_available)
                                            <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-medium">Available</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-red-500/10 text-red-400 rounded-full text-xs font-medium">Unavailable</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 mono text-xs text-stone-600">{{ $item->sort_order }}</td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.menu-items.edit', $item) }}"
                                               class="text-stone-500 hover:text-amber-400 transition-colors text-xs font-medium">Edit</a>
                                            <form method="POST" action="{{ route('admin.menu-items.destroy', $item) }}"
                                                  onsubmit="return confirm('Delete {{ $item->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-stone-600 hover:text-red-400 transition-colors text-xs font-medium">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

    {{-- ── Trash Section ──────────────────────────────────────── --}}
        @if($trashedItems->count() > 0)
            <div x-data="{ open: false }" class="mt-6">
                {{-- Trash Toggle Button --}}
                <button @click="open = !open"
                        class="flex items-center gap-2 text-sm text-stone-500 hover:text-red-400 transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                     Trash ({{ $trashedItems->count() }})
                    <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Trash Table --}}
                <div x-show="open" x-transition>
                    <div class="bg-stone-900 border border-red-500/20 rounded-xl overflow-hidden">
                        <div class="px-6 py-3 bg-red-500/5 border-b border-red-500/20">
                            <p class="text-xs text-red-400 font-medium"> Deleted Menu Items — Restore or permanently delete</p>
                        </div>
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-stone-800">
                                @foreach($trashedItems as $item)
                                    <tr class="hover:bg-stone-800/20 transition-colors opacity-60">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                {{-- Image --}}
                                                <div class="w-9 h-9 rounded-lg overflow-hidden bg-stone-800 shrink-0">
                                                    @if($item->image)
                                                        <img src="{{ $item->image_url }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-stone-700">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-stone-400 line-through">{{ $item->name }}</p>
                                                    <p class="text-xs text-stone-600">{{ $item->category?->name ?? 'Unknown' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="mono text-stone-600">{{ $item->formatted_price }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-stone-600 text-xs">
                                            Deleted {{ $item->deleted_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-end gap-3">
                                                {{-- Restore --}}
                                                <form method="POST" action="{{ route('admin.menu-items.restore', $item->id) }}">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-500 hover:text-emerald-400 transition-colors text-xs font-medium">
                                                        Restore
                                                    </button>
                                                </form>

                                                {{-- Force Delete --}}
                                                <form method="POST" action="{{ route('admin.menu-items.force-delete', $item->id) }}"
                                                    onsubmit="return confirm('Permanently delete {{ $item->name }}? This CANNOT be undone!')">
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