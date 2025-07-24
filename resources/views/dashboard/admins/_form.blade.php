<div class="card shadow-sm">
    <div class="card-body">
        <form
            action="{{ isset($admin->id) ? route('dashboard.admins.update', $admin->id) : route('dashboard.admins.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($admin->id))
            @method('PUT')
            @endif

            <div class="mb-3">
                <x-form.label id="name"> Admin Name </x-form.label>
                <x-form.input label="Name" name="name" :value="old('name', $admin->name)" />
            </div>

            <div class="mb-3">
                <x-form.label id="email">Email</x-form.label>
                <x-form.input type="email" label="Email" name="email" :value="old('email', $admin->email)" />
            </div>

            <!-- Roles -->
            <div class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Assign Roles</label>

                    @foreach (App\Models\Role::all() as $role)
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->id }}"
                            id="role_{{ $role->id }}"
                            class="form-check-input"
                            {{ in_array($role->id, old('roles', $admin->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                    @endforeach

                    @error('roles')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


            </div>


    </div>

    </fieldset>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> {{ $button_label }}
        </button>
        <a href="{{ route('dashboard.admins.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
    </form>
</div>
</div>

@push('styles')
<style>
    .form-check-label {
        font-weight: 500;
    }
</style>
@endpush