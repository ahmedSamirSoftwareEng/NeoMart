@props(['name', 'value' => null, 'rows' => 4])

<textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
    {{ old($name, $value) }}
</textarea>

@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror
