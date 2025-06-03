@php
    $selected = $selected ?? null;
@endphp
<select name="{{ $name }}" id="{{ $id ?? $name }}" class="form-select form-select-sm">
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @selected($value == $selected)>
            {{ is_scalar($text) ? $text : json_encode($text) }}
        </option>
    @endforeach
</select>
</div>
