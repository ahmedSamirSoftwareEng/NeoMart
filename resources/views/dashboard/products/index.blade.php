@extends('layouts.dashboard-layout')
@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <h4 class="mb-3 mb-md-0">Products</h4>

                <a href="{{ route('dashboard.products.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i> Create Product
                </a>
                {{-- <a href="{{ route('dashboard.products.trash') }}" class="btn btn-danger btn-sm mt-2 mt-md-0">
                    <i class="fas fa-trash-alt me-1"></i> Trash
                </a> --}}
            </div>

            {{-- Search Form --}}
            <form action="{{ url()->current() }}" method="GET" class="mt-3"> {{-- Added mt-3 for space --}}
                {{-- Use flexbox for horizontal alignment --}}
                <div class="d-flex align-items-center gap-2 flex-wrap"> {{-- Added flex-wrap for responsiveness --}}
                    <!-- Search Input -->
                    <div class="flex-grow-1" style="min-width: 200px;"> {{-- Allows input to grow, sets minimum width --}}
                        <x-form.input name="name" placeholder="Search products..." class="form-control form-control-sm"
                            :value="request('name')" />
                    </div>

                    <!-- Status Dropdown and Label -->
                    <div class="d-flex align-items-center gap-2"> {{-- Group label and select --}}
                        <span class="text-muted text-sm">Filter by Status:</span> {{-- Added text label --}}
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div> {{-- Button container --}}
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </div>
                </div>
            </form>
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
                            <th>Category</th>
                            <th>Store</th>
                            <th width="180px" class="text-center">Status</th>
                            <th width="180px" class="text-center">Created At</th>
                            <th width="200px" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                            width="50" height="50" class="rounded-circle object-fit-cover border">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-folder text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $product->id }}</td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                </td>
                                <td>
                                    @if ($product->category_id)
                                        <span class="badge bg-info">{{ $product->category_id }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->store_id)
                                        <span class="badge bg-info">{{ $product->store_id }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($product->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Archived</span>
                                    @endif
                                </td> {{-- Closing the td tag --}}
                                <td class="text-center">
                                    <small>{{ $product->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $product->created_at->format('h:i A') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center"> {{-- Used gap-2 for spacing --}}
                                        <a href="{{ route('dashboard.products.show', $product->id) }}"
                                            class="btn btn-sm btn-primary px-3 py-1">
                                            <i class="fas fa-eye"></i> {{-- Removed me-1 to save space in buttons --}}
                                        </a>
                                        <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-info text-white px-3 py-1">
                                            <i class="fas fa-edit"></i> {{-- Removed me-1 --}}
                                        </a>
                                        <form action="{{ route('dashboard.products.destroy', $product->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3 py-1">
                                                <i class="fas fa-trash-alt"></i> {{-- Removed me-1 --}}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4"> {{-- Corrected colspan to 7 --}}
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                                        <h5 class="text-muted">No products found</h5>
                                        <p class="text-muted mb-0">Create your first product by clicking the button
                                            above
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $products->withQueryString()->links() }}
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

        /* Added styles for text label next to select */
        .text-sm {
            font-size: 0.875em;
            /* Bootstrap's small font size */
        }

        .gap-2 {
            gap: 0.5rem !important;
            /* Ensures consistent gap */
        }

        .gap-3 {
            gap: 1rem !important;
            /* Ensures consistent gap for actions */
        }

        /* Adjusted padding for small buttons with icons only */
        .btn-sm i {
            margin-right: 0 !important;
            /* Remove right margin on icon */
        }

        .btn-sm.px-3.py-1 {
            padding: 0.25rem 0.75rem !important;
            /* Keep original padding if needed */
        }

        .btn-sm:not(.px-3) i,
        .btn-sm:not(.py-1) i {
            margin-right: 0.25rem !important;
            /* Add margin if button has text */
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing alert closing script
            const closeButtons = document.querySelectorAll('.custom-alert-close'); // Assuming custom alert class
            closeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const alert = btn.closest('.alert');
                    if (alert) {
                        // Use Bootstrap's built-in close behavior if available
                        const bsAlert = bootstrap.Alert.getInstance(alert);
                        if (bsAlert) {
                            bsAlert.hide(); // Or dispose() depending on desired effect
                        } else {
                            // Fallback for custom alerts without BS JS
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }
                    }
                });
            });

            // Example: Adding Bootstrap JS for Alerts if not already included
            // Ensure Bootstrap's JS file is loaded before this script
        });
    </script>
@endpush
