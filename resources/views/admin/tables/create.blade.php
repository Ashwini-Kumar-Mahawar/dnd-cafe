@extends('layouts.admin')

@section('title', 'New Table')
@section('page-title', 'New Table')
@section('page-subtitle', 'A QR code will be generated automatically.')

@section('header-actions')
    <a href="{{ route('admin.tables.index') }}" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">← Back</a>
@endsection

@section('content')
    <div class="max-w-lg">
        <form method="POST" action="{{ route('admin.tables.store') }}"
              class="bg-stone-900 border border-stone-800 rounded-xl divide-y divide-stone-800">
            @csrf

            <div class="p-6 space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Table Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Table 1, Window Seat, Bar 3"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                  placeholder-stone-600 focus:outline-none focus:border-amber-500 focus:ring-1
                                  focus:ring-amber-500/20 transition-colors @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-stone-600 mt-1.5">
                        The QR code URL will use the slug: <span class="mono text-amber-500/60" id="slug-preview">table-1</span>
                    </p>
                </div>

                {{-- Capacity --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Capacity <span class="text-red-400">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', 4) }}" required min="1" max="20"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                  focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors
                                  @error('capacity') border-red-500 @enderror">
                    @error('capacity')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-stone-600 bg-stone-800 text-amber-500 focus:ring-amber-500/20">
                        <label for="is_active" class="text-sm text-stone-400">Active (QR code works for customers)</label>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 flex justify-end gap-3">
                <a href="{{ route('admin.tables.index') }}"
                   class="px-4 py-2 text-sm text-stone-400 hover:text-stone-200 transition-colors">Cancel</a>
                <button type="submit"
                        class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold text-sm rounded-lg transition-colors">
                    Create Table
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Live slug preview as user types the name
    document.querySelector('input[name="name"]').addEventListener('input', function () {
        const slug = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug-preview').textContent = slug || '...';
    });
</script>
@endpush