
@extends('layouts.admin')

@section('content')

<div class="heading">
    <h1>{{ $item ? 'Edit' : 'Create' }} {{ rtrim($section, 's') }}</h1>
    <a href="{{ route('admin.items', ['section' => $section]) }}">
        ← Back
    </a>
</div>

<form class="editform" method="POST"
      action="{{ $item ? route('admin.update', ['section' => $section, 'id' => $item->id]) : route('admin.store', ['section' => $section]) }}">

    @csrf

    @if ($item)
        @method('PUT')
    @endif

    @php
        $v = fn($field, $fallback = '') =>
            old($field, $item ? ($item->{$field} ?? $fallback) : $fallback);
    @endphp

    @if ($section === 'clients')

        <label>
            Client / partner name *
            <input name="name" required value="{{ $v('name') }}">
        </label>

        <label>
            Industry
            <input name="industry" value="{{ $v('industry') }}">
        </label>

        <label>
            Logo image URL
            <input name="logo_url" type="url" value="{{ $v('logo_url') }}">
        </label>

    @else

        <label>
            Title *
            <input name="title" required value="{{ $v('title') }}">
        </label>

        <label>
            Summary
            <textarea name="summary" rows="3">{{ $v('summary') }}</textarea>
        </label>

        <label>
            Description
            <textarea name="description" rows="5">{{ $v('description') }}</textarea>
        </label>

        <label>
            Image URL (https)
            <input name="image_url" type="url" value="{{ $v('image_url') }}">
        </label>

        @if ($section === 'venues')

            <label>
                Venue type *
                <input name="type" required
                       value="{{ $v('type', 'Event Space') }}">
            </label>

            <label>
                Capacity note (only if verified)
                <input name="capacity_note"
                       value="{{ $v('capacity_note') }}">
            </label>

            <label>
                Features (comma-separated)
                <textarea name="features" rows="2">{{ old('features', $item ? implode(', ', ($item->features ?? [])) : '') }}</textarea>
            </label>

        @endif

        @if ($section === 'services')

            <label>
                Icon / symbol
                <input name="icon"
                       value="{{ $v('icon', '✦') }}"
                       maxlength="10">
            </label>

        @endif

        @if ($section === 'events')

            <label>
                Event date
                <input name="event_date" type="date"
                       value="{{ old('event_date', $item?->event_date?->format('Y-m-d')) }}">
            </label>

            <label>
                End date
                <input name="end_date" type="date"
                       value="{{ old('end_date', $item?->end_date?->format('Y-m-d')) }}">
            </label>

            <label>
                Status
                <select name="status">
                    @foreach (['Upcoming', 'Past', 'Featured'] as $status)
                        <option
                            {{ $v('status', 'Upcoming') === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </label>

        @endif

    @endif

    <label>
        Display order
        <input name="sort_order" type="number" min="0"
               value="{{ $v('sort_order', 0) }}">
    </label>

    <label>
        Status
        <select name="is_published">
            <option value="1"
                {{ (string) $v('is_published', 1) === '1' ? 'selected' : '' }}>
                Published
            </option>

            <option value="0"
                {{ (string) $v('is_published', 1) === '0' ? 'selected' : '' }}>
                Hidden
            </option>
        </select>
    </label>

    <button type="submit" class="primary">
        {{ $item ? 'Save changes' : 'Create item' }}
    </button>

</form>

@endsection
