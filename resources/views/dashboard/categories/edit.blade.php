@extends('layouts.dashboard-layout')

@section('title', 'Edit Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            @if ($category->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $category->image) }}" width="150" alt="Current Image">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Primary Category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label><br>
            <label><input type="radio" name="status" value="active" @checked($category->status == 'active')> Active</label>
            <label class="ms-3"><input type="radio" name="status" value="archived" @checked($category->status == 'archived')> Archived</label> 
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
