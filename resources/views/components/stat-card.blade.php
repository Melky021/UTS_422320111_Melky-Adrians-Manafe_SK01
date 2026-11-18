@props(['title', 'value' => 0, 'hint' => null, 'tone' => 'default'])

<article {{ $attributes->class(['stat', 'stat-'.$tone]) }}>
    <p class="stat-title">{{ $title }}</p>
    <strong class="stat-value">{{ $value }}</strong>
    @if ($hint)
        <small class="muted">{{ $hint }}</small>
    @endif
</article>
