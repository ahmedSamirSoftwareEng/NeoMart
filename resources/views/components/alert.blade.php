@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show custom-alert d-flex align-items-center justify-content-between"
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

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center justify-content-between"
        role="alert">
        <div>
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
        </div>
        <button type="button" class="btn text-white fs-5 custom-alert-close" aria-label="Close">
            &times;
        </button>
    </div>
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.custom-alert-close').forEach(button => {
                button.addEventListener('click', function() {
                    const alert = button.closest('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 300); // Wait for fade effect
                    }
                });
            });
        });
    </script>
@endpush
