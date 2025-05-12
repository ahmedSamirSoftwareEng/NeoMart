@extends('layouts.dashboard-layout')
@section('title', isset($category->id) ? 'Edit Category' : 'Create Category')

@section('breadcrumb')
    @parent
@endsection

@section('content')
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
                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" required
                        value="{{ old('name', $category->name) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    @if ($category->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $category->image) }}" width="150" class="border rounded"
                                alt="Current Image">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
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
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="status" id="status_active" value="active" class="form-check-input"
                            {{ $category->status == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_active">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="status" id="status_archived" value="archived" class="form-check-input"
                            {{ $category->status == 'archived' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_archived">Archived</label>
                    </div>
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
@endsection

@push('styles')
    <style>
        .form-check-label {
            font-weight: 500;
        }
    </style>
@endpush
