<x-layout>
    <div class="main-content">
        <h1>Rediģēt trasi: {{ $track->name }}</h1>

        <form action="{{ route('tracks.update', $track->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Nosaukums</label>
            <input id="name" type="text" name="name" value="{{ old('name', $track->name) }}" required>

            <label for="description">Apraksts</label>
            <textarea id="description" name="description">{{ old('description', $track->description) }}</textarea>

            <label for="surface_type">Segums</label>
            <input id="surface_type" type="text" name="surface_type" value="{{ old('surface_type', $track->surface_type) }}">

            <h3 style="margin-top:16px;">Sacensības</h3>
            <p style="margin-top:0;">Aizpildi rindas, kuras vajag. Tukšās netiks saglabātas.</p>

            @php
                $events = old('event_titles') ? collect(old('event_titles'))->map(fn ($title, $i) => [
                    'title' => $title,
                    'event_date' => old('event_dates.' . $i),
                ]) : $track->events->map(fn ($e) => ['title' => $e->title, 'event_date' => $e->event_date->format('Y-m-d')]);

                $rows = max(3, $events->count());
            @endphp

            @for($i = 0; $i < $rows; $i++)
                <div style="display:grid; grid-template-columns:2fr 1fr; gap:8px; margin-bottom:8px;">
                    <input
                        type="text"
                        name="event_titles[]"
                        placeholder="Sacensību nosaukums"
                        value="{{ $events[$i]['title'] ?? '' }}"
                    >
                    <input
                        type="date"
                        name="event_dates[]"
                        value="{{ $events[$i]['event_date'] ?? '' }}"
                    >
                </div>
            @endfor

            <div style="display:flex; gap:10px; margin-top:12px;">
                <button type="submit">Saglabāt</button>
                <a href="{{ route('tracks.show', $track->id) }}">Atcelt</a>
            </div>
        </form>
    </div>
</x-layout>
