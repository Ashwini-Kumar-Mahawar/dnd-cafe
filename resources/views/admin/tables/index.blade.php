@extends('layouts.admin')

@section('title', 'Tables & QR Codes')
@section('page-title', 'Tables & QR Codes')
@section('page-subtitle', 'Each table gets a unique QR code for customer ordering.')

@section('header-actions')
    <a href="{{ route('admin.tables.create') }}"
       class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold px-4 py-2 rounded-lg text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Table
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($tables as $table)
            <div class="bg-stone-900 border border-stone-800 rounded-xl p-5 flex flex-col gap-4
                        {{ $table->isOccupied() ? 'border-amber-500/30' : '' }}">

                {{-- Header --}}
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-stone-100">{{ $table->name }}</h3>
                        <p class="text-xs text-stone-500 mt-0.5">Up to {{ $table->capacity }} guests</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Occupied indicator --}}
                        @if($table->isOccupied())
                            <span class="flex items-center gap-1.5 text-xs text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                Active
                            </span>
                        @else
                            <span class="text-xs text-stone-600 bg-stone-800 px-2.5 py-1 rounded-full">Free</span>
                        @endif
                        {{-- Active toggle --}}
                        @if($table->is_active)
                            <span class="text-xs text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full">Enabled</span>
                        @else
                            <span class="text-xs text-stone-600 bg-stone-800 px-2.5 py-1 rounded-full">Disabled</span>
                        @endif
                    </div>
                </div>

                {{-- QR URL Preview --}}
                <div class="bg-stone-950 border border-stone-800 rounded-lg p-3">
                    <p class="text-xs text-stone-600 mb-1 uppercase tracking-widest font-medium">QR URL</p>
                    <p class="mono text-xs text-amber-400/70 truncate">{{ $table->qr_url }}</p>
                </div>

                {{-- Stats --}}
                <div class="flex items-center gap-4 text-xs text-stone-500">
                    <span>{{ $table->orders_count }} total orders</span>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 pt-1 border-t border-stone-800">
                    {{-- Download QR --}}
                    <a href="{{ route('admin.tables.qr', $table) }}"
                       class="flex items-center gap-1.5 px-3 py-2 bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-medium rounded-lg transition-colors flex-1 justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        Download QR
                    </a>
                    <a href="{{ route('admin.tables.edit', $table) }}"
                       class="px-3 py-2 text-stone-500 hover:text-amber-400 text-xs font-medium transition-colors">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.tables.destroy', $table) }}"
                          onsubmit="return confirm('Delete {{ $table->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-2 text-stone-600 hover:text-red-400 text-xs font-medium transition-colors">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="col-span-3 bg-stone-900 border border-stone-800 rounded-xl p-12 text-center">
                <p class="text-stone-500 text-sm">No tables set up yet.</p>
                <a href="{{ route('admin.tables.create') }}" class="text-amber-400 text-sm hover:underline mt-1 inline-block">Add your first table →</a>
            </div>
        @endforelse
    </div>

    {{-- ── Trash Section ──────────────────────────────────────── --}}
    @if(isset($trashedTables) && $trashedTables->count() > 0)
        <div x-data="{ open: false }" class="mt-6">
            <button @click="open = !open"
                    class="flex items-center gap-2 text-sm text-stone-500 hover:text-red-400 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                 Trash ({{ $trashedTables->count() }})
                <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-transition>
                <div class="bg-stone-900 border border-red-500/20 rounded-xl overflow-hidden">
                    <div class="px-6 py-3 bg-red-500/5 border-b border-red-500/20">
                        <p class="text-xs text-red-400 font-medium"> Deleted Tables — Restore or permanently delete</p>
                    </div>
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-stone-800">
                            @foreach($trashedTables as $table)
                                <tr class="hover:bg-stone-800/20 transition-colors opacity-60">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-stone-400 line-through">{{ $table->name }}</p>
                                        <p class="text-xs text-stone-600">Capacity: {{ $table->capacity }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-stone-600 text-xs">
                                        Deleted {{ $table->deleted_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <form method="POST" action="{{ route('admin.tables.restore', $table->id) }}">
                                                @csrf
                                                <button type="submit" class="text-emerald-500 hover:text-emerald-400 transition-colors text-xs font-medium">
                                                    Restore
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.tables.force-delete', $table->id) }}"
                                                  onsubmit="return confirm('Permanently delete {{ $table->name }}? This CANNOT be undone!')">
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