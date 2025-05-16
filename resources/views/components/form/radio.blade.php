@props(['name', 'options' => [], 'checked' => null])
@foreach ($options as $value => $text)
    <div class="form-check form-check-inline">
        <input type="radio" name="{{ $name }}" value="{{ $value }}"
            class="form-check-input {{ $errors->has($name) ? 'is-invalid' : '' }}" @checked(old($name, $checked) == $value)>
        <label class="form-check-label" for="status_active">{{ $text }}</label>
    </div>
@endforeach
