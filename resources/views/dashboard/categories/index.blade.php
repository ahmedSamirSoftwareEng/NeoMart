@extends('layouts.dashboard-layout')
@section('title', 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')

    <div class="mb-3">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">+ Create Category</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th>Id</th>
                <th>Name</th>
                <th>Parent</th>
                <th>created_at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_id }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <button class="btn btn-primary"><a href="{{ route('dashboard.categories.show', $category->id) }}"
                                class="text-white">View</a></button>
                        <button class="btn btn-info"><a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                class="text-white">Edit</a></button>
                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No categories found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
