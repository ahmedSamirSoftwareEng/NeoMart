@props(['id' => null])

<label for="{{ $id }}" {{ $attributes->class(['form-label']) }}>
    {{ $slot }}
</label>
