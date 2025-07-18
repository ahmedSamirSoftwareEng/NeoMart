<div class="card shadow-sm">
    <div class="card-body">
        <form
            action="{{ isset($role->id) ? route('dashboard.roles.update', $role->id) : route('dashboard.roles.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($role->id))
            @method('PUT')
            @endif

            <div class="mb-3">
                <x-form.label id="name"> Role Name </x-form.label>
                <x-form.input label="Name" name="name" :value="old('name', $role->name)" />
            </div>
            <fieldset>
                <legend>{{ __('Abilities') }}</legend>
                @foreach (app('abilities') as $abilityCode => $abilityName)
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-check-label">{{ is_callable($abilityName) ?  $abilityName() : $abilityName }}</label>
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="abilities[{{ $abilityCode }}]" value="allow" class="form-check-input"
                            @checked(($role_abilities[$abilityCode] ?? '' )==='allow' )>Allow
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="abilities[{{ $abilityCode }}]" value="deny" class="form-check-input"
                            @checked(($role_abilities[$abilityCode] ?? '' )==='deny' )>Deny
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="abilities[{{ $abilityCode }}]" value="inherit" class="form-check-input"
                            @checked(($role_abilities[$abilityCode] ?? '' )==='inherit' )>Inherit
                    </div>
                </div>
                @endforeach

            </fieldset>

    </div>

    </fieldset>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> {{ $button_label }}
        </button>
        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-secondary">
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