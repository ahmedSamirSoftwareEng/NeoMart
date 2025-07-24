@extends('layouts.dashboard-layout')
@section('title', 'Trashed Admins')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex align-items-center">
            <h4 class="mb-0">Trashed Admins</h4>
            <div class="flex-grow-1"></div>
            <a href="{{ route('dashboard.admins.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Admins
            </a>
        </div>

        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80px" class="text-center">Image</th>
                            <th width="60px" class="text-center">ID</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th width="180px" class="text-center">Deleted At</th>
                            <th width="220px" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td class="text-center">
                                    @if ($admin->image)
                                        <img src="{{ asset('storage/' . $admin->image) }}" alt="Admin Image"
                                            width="50" height="50" class="rounded-circle object-fit-cover border">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-folder text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $admin->id }}</td>
                                <td><strong>{{ $admin->name }}</strong></td>
                                <td>
                                    @if ($admin->parent_id)
                                        <span class="badge bg-info">{{ $admin->parent_name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <small>{{ $admin->deleted_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $admin->deleted_at->format('h:i A') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <form action="{{ route('dashboard.admins.restore', $admin->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success px-3 py-1">
                                                <i class="fas fa-undo me-1"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.admins.force-delete', $admin->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('This will permanently delete the admin. Continue?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3 py-1">
                                                <i class="fas fa-trash-alt me-1"></i> Delete Forever
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-trash-alt fa-2x text-muted mb-2"></i>
                                        <h5 class="text-muted">Trash is empty</h5>
                                        <p class="text-muted mb-0">No deleted admins found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $admins->withQueryString()->links() }}
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

        .card-body {
            padding: 1.5rem;
        }
    </style>
@endpush
