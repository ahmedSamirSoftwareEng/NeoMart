@extends('layouts.dashboard-layout')

@section('title', 'Role Details')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">{{ $admin->name }}</li>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-folder-open me-2"></i>Role: {{ $admin->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Description:</strong><br> {{ $admin->description ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge {{ $admin->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($admin->status) }}
                        </span>
                    </p>
                    <p><strong>Parent Role:</strong><br>
                        {{ $admin->parent ? $admin->parent->name : 'None (Primary Role)' }}
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    @if ($admin->image)
                        <img src="{{ asset('storage/' . $admin->image) }}" alt="Role Image" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                    @else
                        <div class="border bg-light rounded p-4">
                            <i class="fas fa-image fa-2x text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No image available</p>
                        </div>
                    @endif
                </div>
            </div>

            <hr>

            <h5 class="mb-3"><i class="fas fa-boxes me-2"></i>Products in this Role</h5>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="80">Image</th>
                            <th class="text-center" width="60">ID</th>
                            <th>Name</th>
                            <th>Store</th>
                            <th class="text-center" width="120">Status</th>
                            <th class="text-center" width="180">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $products = $admin->products()->with('store')->paginate(5);
                        @endphp
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="50" height="50" class="rounded-circle border object-fit-cover">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $product->id }}</td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>
                                    @if ($product->store)
                                        <span class="badge bg-info text-dark">{{ $product->store->name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <small>{{ $product->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $product->created_at->format('h:i A') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                        <h5 class="text-muted">No products found</h5>
                                        <p class="text-muted mb-0">Start by adding a new product to this admin.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('dashboard.admins.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Admins
            </a>
        </div>
    </div>
@endsection
