@extends('layouts.dashboard-layout')
@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex align-items-center">
            <h4 class="mb-0">Categories</h4>
            <div class="flex-grow-1"></div>
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Create Category
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between"
                    role="alert">
                    <div>
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn text-white fs-5 custom-alert-close" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80px" class="text-center">Image</th>
                            <th width="60px" class="text-center">ID</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th width="180px" class="text-center">Created At</th>
                            <th width="200px" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="text-center">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image"
                                            width="50" height="50" class="rounded-circle object-fit-cover border">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-folder text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $category->id }}</td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>
                                <td>
                                    @if ($category->parent)
                                        <span class="badge bg-info">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <small>{{ $category->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $category->created_at->format('h:i A') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="{{ route('dashboard.categories.show', $category->id) }}"
                                            class="btn btn-sm btn-primary px-3 py-1">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>
                                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-info text-white px-3 py-1">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3 py-1">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                                        <h5 class="text-muted">No categories found</h5>
                                        <p class="text-muted mb-0">Create your first category by clicking the button above
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.custom-alert-close');
            closeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const alert = btn.closest('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                });
            });
        });
    </script>
@endpush
