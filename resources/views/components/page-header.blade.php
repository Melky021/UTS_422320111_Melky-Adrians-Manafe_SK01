@props(['title', 'subtitle' => null])

<header class="page-header">
    <div>
        <h1>{{ $title }}</h1>
        @if ($subtitle)
            <p class="muted">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="page-actions">{{ $slot }}</div>
    @endif
</header>
