@extends('layouts.admin')

@section('title', 'Edit Table')
@section('page-title', 'Edit Table')
@section('page-subtitle', 'Update "{{ $table->name }}".')

@section('header-actions')
    <a href="{{ route('admin.tables.index') }}" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">← Back</a>
@endsection

@section('content')
    <div class="max-w-lg">
        <form method="POST" action="{{ route('admin.tables.update', $table) }}"
              class="bg-stone-900 border border-stone-800 rounded-xl divide-y divide-stone-800">
            @csrf @method('PUT')

            <div class="p-6 space-y-5">

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Table Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $table->name) }}" required
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                  focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors
                                  @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Capacity</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $table->capacity) }}" min="1" max="20"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                  focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors">
                </div>

                <div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $table->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-stone-600 bg-stone-800 text-amber-500 focus:ring-amber-500/20">
                        <label for="is_active" class="text-sm text-stone-400">Active (QR code works for customers)</label>
                    </div>
                </div>

                {{-- Current QR preview --}}
                <div class="bg-stone-950 border border-stone-800 rounded-lg p-3">
                    <p class="text-xs text-stone-600 mb-1 uppercase tracking-widest font-medium">Current QR URL</p>
                    <p class="mono text-xs text-amber-400/70 break-all">{{ $table->qr_url }}</p>
                    <a href="{{ route('admin.tables.qr', $table) }}"
                       class="inline-flex items-center gap-1.5 mt-2 text-xs text-stone-400 hover:text-amber-400 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download current QR code
                    </a>
                </div>

            </div>

            <div class="px-6 py-4 flex items-center justify-between">
                <button type="button"
                        onclick="document.getElementById('delete-table-form').submit()"
                        class="text-xs text-stone-600 hover:text-red-400 transition-colors">
                    Delete table
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('admin.tables.index') }}"
                       class="px-4 py-2 text-sm text-stone-400 hover:text-stone-200 transition-colors">Cancel</a>
                    <button type="submit"
                            class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold text-sm rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
        {{-- ✅ DELETE FORM - Outside update form --}}
        <form id="delete-table-form"
              method="POST"
              action="{{ route('admin.tables.destroy', $table) }}"
              class="hidden"
              onsubmit="return confirm('Delete {{ $table->name }}? This cannot be undone.')">
            @csrf @method('DELETE')
        </form>
    </div>
@endsection