@extends('layouts.admin')

@section('title', 'New Menu Item')
@section('page-title', 'New Menu Item')
@section('page-subtitle', 'Add an item customers can order.')

@section('header-actions')
    <a href="{{ route('admin.menu-items.index') }}" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">← Back</a>
@endsection

@section('content')
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.menu-items.store') }}" enctype="multipart/form-data"
              class="bg-stone-900 border border-stone-800 rounded-xl divide-y divide-stone-800">
            @csrf

            <div class="p-6 space-y-5">

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Category <span class="text-red-400">*</span></label>
                    <select name="category_id" required
                            class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                   focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors
                                   @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Item Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Classic Cheeseburger"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                  placeholder-stone-600 focus:outline-none focus:border-amber-500 focus:ring-1
                                  focus:ring-amber-500/20 transition-colors @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Description <span class="text-stone-600 font-normal">(optional)</span></label>
                    <textarea name="description" rows="3"
                              placeholder="Describe the item, ingredients, or what makes it special..."
                              class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                     placeholder-stone-600 focus:outline-none focus:border-amber-500 focus:ring-1
                                     focus:ring-amber-500/20 transition-colors resize-none">{{ old('description') }}</textarea>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Price <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-500 text-sm">₹</span>
                        <input type="number" name="price" value="{{ old('price') }}" required
                               step="0.01" min="0" max="99999.99"
                               placeholder="0.00"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg pl-8 pr-4 py-2.5 text-sm text-stone-100
                                      placeholder-stone-600 focus:outline-none focus:border-amber-500 focus:ring-1
                                      focus:ring-amber-500/20 transition-colors @error('price') border-red-500 @enderror">
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Photo <span class="text-stone-600 font-normal">(optional)</span></label>
                    <div class="flex items-start gap-4">
                        <div id="image-preview"
                             class="w-20 h-20 rounded-xl bg-stone-800 border border-stone-700 flex items-center justify-center overflow-hidden shrink-0">
                            <svg class="w-7 h-7 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                                   class="block text-sm text-stone-400 file:mr-3 file:py-1.5 file:px-4 file:rounded-full file:border-0
                                          file:text-xs file:font-semibold file:bg-stone-700 file:text-stone-200
                                          hover:file:bg-stone-600 file:transition-colors file:cursor-pointer">
                            <p class="text-xs text-stone-600 mt-1.5">JPG, PNG or WebP · Max 2MB · Square images look best</p>
                        </div>
                    </div>
                </div>

                {{-- Sort Order + Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                      focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-1.5">Availability</label>
                        <div class="flex items-center gap-3 mt-3">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" id="is_available" value="1"
                                   {{ old('is_available', true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-stone-600 bg-stone-800 text-amber-500 focus:ring-amber-500/20">
                            <label for="is_available" class="text-sm text-stone-400">Available to order</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.menu-items.index') }}"
                   class="px-4 py-2 text-sm text-stone-400 hover:text-stone-200 transition-colors">Cancel</a>
                <button type="submit"
                        class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold text-sm rounded-lg transition-colors">
                    Add to Menu
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('image-preview').innerHTML =
                `<img src="${ev.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush