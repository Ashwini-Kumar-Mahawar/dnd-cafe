@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('page-subtitle', 'Update "{{ $category->name }}".')

@section('header-actions')
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">← Back</a>
@endsection

@section('content')
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data"
              class="bg-stone-900 border border-stone-800 rounded-xl divide-y divide-stone-800">
            @csrf @method('PUT')

            <div class="p-6 space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Category Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                  focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors
                                  @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-1.5">Image</label>
                    <div class="flex items-center gap-4">
                        <div id="image-preview" class="w-16 h-16 rounded-xl bg-stone-800 border border-stone-700 flex items-center justify-center overflow-hidden shrink-0">
                            @if($category->image)
                                <img src="{{ $category->image_url }}" class="w-full h-full object-cover" alt="{{ $category->name }}">
                            @else
                                <svg class="w-6 h-6 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                                   class="block text-sm text-stone-400 file:mr-3 file:py-1.5 file:px-4 file:rounded-full file:border-0
                                          file:text-xs file:font-semibold file:bg-stone-700 file:text-stone-200
                                          hover:file:bg-stone-600 file:transition-colors file:cursor-pointer">
                            <p class="text-xs text-stone-600 mt-1">Upload a new image to replace the current one.</p>
                        </div>
                    </div>
                </div>

                {{-- Sort Order + Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100
                                      focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-1.5">Status</label>
                        <div class="flex items-center gap-3 mt-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-stone-600 bg-stone-800 text-amber-500 focus:ring-amber-500/20">
                            <label for="is_active" class="text-sm text-stone-400">Active (visible on menu)</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 flex items-center justify-between">
                

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-4 py-2 text-sm text-stone-400 hover:text-stone-200 transition-colors">Cancel</a>
                    <button type="submit"
                            class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-stone-950 font-semibold text-sm rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>

        </form>

        {{-- Danger Zone --}}
        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                onsubmit="return confirm('Delete {{ $category->name }}? This cannot be undone.')">
            @csrf @method('DELETE')
            <button type="submit" class="text-xs text-stone-600 hover:text-red-400 transition-colors">
                Delete category
            </button>
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
            const preview = document.getElementById('image-preview');
            preview.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush