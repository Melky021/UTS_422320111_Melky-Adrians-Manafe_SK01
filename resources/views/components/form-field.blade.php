{{--
    Field form reusable.
    name memakai notasi titik agar cocok dengan old() & @error, contoh: "asal.desa"
    -> atribut HTML name otomatis menjadi "asal[desa]".
--}}
@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null])

@php
    $parts = explode('.', $name);
    $inputName = array_shift($parts) . implode('', array_map(fn ($p) => "[{$p}]", $parts));
    $current = old($name, $value);
@endphp

<div class="field">
    <label for="{{ $name }}">
        {{ $label }} @if ($required)<span class="req">*</span>@endif
    </label>

    @if ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $inputName }}" rows="3" @class(['is-invalid' => $errors->has($name)])>{{ $current }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $name }}" name="{{ $inputName }}" @class(['is-invalid' => $errors->has($name)])>
            {{ $slot }}
        </select>
    @else
        <input id="{{ $name }}" type="{{ $type }}" name="{{ $inputName }}" value="{{ $current }}"
            {{ $attributes->merge(['class' => $errors->has($name) ? 'is-invalid' : '']) }}>
    @endif

    @if ($hint)
        <small class="muted">{{ $hint }}</small>
    @endif

    @error($name)
        <small class="error">{{ $message }}</small>
    @enderror
</div>
