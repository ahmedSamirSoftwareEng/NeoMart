@extends('layouts.dashboard-layout')

@section('title', 'Category Details')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Category: {{ $category->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $category->description ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($category->status) }}</p>

            @if ($category->parent)
                <p><strong>Parent Category:</strong> {{ $category->parent->name }}</p>
            @else
                <p><strong>Parent Category:</strong> None (Primary Category)</p>
            @endif

            @if ($category->image)
                <p><strong>Image:</strong></p>
                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="200">
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
