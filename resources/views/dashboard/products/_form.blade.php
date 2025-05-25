@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form
            action="{{ isset($product->id) ? route('dashboard.products.update', $product->id) : route('dashboard.products.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($product->id))
                @method('PUT')
            @endif

            {{-- Product Name --}}
            <div class="mb-3">
                <x-form.label id="name"> Product Name </x-form.label>
                <x-form.input name="name" :value="old('name', $product->name)" />
            </div>
            {{-- Description --}}
            <div class="mb-3">
                <x-form.label id="name"> Product Description </x-form.label>
                <x-form.textarea name="description" :value="old('description', $product->description)" label="Description" rows="4" />
            </div>

            {{-- Image --}}
            <div class="mb-3">
                @if ($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" width="150" class="border rounded"
                            alt="Current Image">
                    </div>
                @endif
                <x-form.input type="file" name="image" id="image" label="Upload Image" />
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    @foreach (App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <x-form.label id="price"> Price </x-form.label>
                <x-form.input type="number" step="0.01" name="price" :value="old('price', $product->price)" />
            </div>

            {{-- Compare Price --}}
            <div class="mb-3">
                <x-form.label id="compare_price"> Compare Price </x-form.label>
                <x-form.input type="number" step="0.01" name="compare_price" :value="old('compare_price', $product->compare_price)" />
            </div>
            {{-- Tags --}}
            <div class="mb-3">
                <x-form.label id="tags"> Tags </x-form.label>
                <x-form.input name="tags" :value="old('tags', $tags)" />
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> {{ $button_label }}
                </button>
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
    <style>
        .form-check-label {
            font-weight: 500;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputElm = document.querySelector('[name="tags"]');
            if (inputElm) {
                new Tagify(inputElm);
            }
        });
    </script>
@endpush
