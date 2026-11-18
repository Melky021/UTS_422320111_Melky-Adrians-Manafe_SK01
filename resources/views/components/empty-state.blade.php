@props(['message' => 'Belum ada data.'])

<div {{ $attributes->class(['empty']) }}>
    <p>{{ $message }}</p>
    {{ $slot }}
</div>
