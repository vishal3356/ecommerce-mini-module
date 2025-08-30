<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border rounded p-2">
        @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Slug</label>
        <input name="slug" value="{{ old('slug', $product->slug ?? '') }}" class="w-full border rounded p-2">
        @error('slug') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Price (INR)</label>
        <input name="price" type="number" step="0.01" value="{{ old('price', isset($product) ? $product->price_cents/100 : '') }}" class="w-full border rounded p-2">
        @error('price') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Stock</label>
        <input name="stock" type="number" value="{{ old('stock', $product->stock ?? 0) }}" class="w-full border rounded p-2">
        @error('stock') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Image URL</label>
        <input name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}" class="w-full border rounded p-2">
        @error('image_url') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="mr-2">
            Active
        </label>
        @error('is_active') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
</div>
