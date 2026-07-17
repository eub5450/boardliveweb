@php
    $activeFilters = collect((array) ($filters ?? []))
        ->filter(function ($filter) {
            return trim((string) ($filter['value'] ?? '')) !== '';
        })
        ->values();
@endphp

@if ($activeFilters->isNotEmpty())
    <div class="filter-summary" role="status" aria-live="polite">
        <div class="filter-summary-pills">
            @foreach ($activeFilters as $filter)
                <span class="toolbar-pill">
                    <strong>{{ $filter['label'] }}</strong>
                    <span>{{ $filter['value'] }}</span>
                    @if (!empty($filter['clear_url']))
                        <a href="{{ $filter['clear_url'] }}" aria-label="Clear {{ $filter['label'] }} filter">×</a>
                    @endif
                </span>
            @endforeach
        </div>
        @if (!empty($clearUrl))
            <a class="button-secondary button-small" href="{{ $clearUrl }}">Clear all filters</a>
        @endif
    </div>
@endif
