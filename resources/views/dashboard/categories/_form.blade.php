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
            action="{{ isset($category->id) ? route('dashboard.categories.update', $category->id) : route('dashboard.categories.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($category->id))
                @method('PUT')
            @endif

            <div class="mb-3">
                <x-form.label id="name"> Name </x-form.label>
                <x-form.input label="Name" name="name" :value="old('name', $category->name)" />
            </div>

            <div class="mb-3">
                <x-form.textarea name="description" :value="$category->description" label="Description" rows="4" />
            </div>

            <div class="mb-3">
                @if ($category->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $category->image) }}" width="150" class="border rounded"
                            alt="Current Image">
                    </div>
                @endif
                <x-form.input type="file" name="image" id="image" label="Upload Image" />
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">Primary Category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <x-form.label id="status"> Status </x-form.label>
                <x-form.radio name="status" :options="['active' => 'Active', 'archived' => 'Archived']" :checked="$category->status" />
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> {{ $button_label }}
                </button>
                <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">
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
@endpush
