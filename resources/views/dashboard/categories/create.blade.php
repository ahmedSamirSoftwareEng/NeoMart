@extends('layouts.dashboard-layout')

@section('title', 'Create Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Primary Category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label><br>
            <label><input type="radio" name="status" value="active"
                    {{ old('status', 'active') == 'active' ? 'checked' : '' }}> Active</label>
            <label class="ms-3"><input type="radio" name="status" value="inactive"
                    {{ old('status') == 'inactive' ? 'checked' : '' }}> Inactive</label>
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
