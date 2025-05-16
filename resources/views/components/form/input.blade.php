 @props(['name', 'value' => null, 'type' => 'text'])

 <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"
     {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
 @error($name)
     <div class="text-danger">{{ $message }}</div>
 @enderror
