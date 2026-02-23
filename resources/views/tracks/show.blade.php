<x-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    @endpush

    @php
        $coverImage = $track->images->firstWhere('slot', 'cover');
        $galleryImages = $track->images->whereIn('slot', ['gallery_1', 'gallery_2', 'gallery_3'])->sortBy('slot');
        $canManageTrack = auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $track->owner_id);
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        $authUser = auth()->user();
        $authReady = $authUser && !empty($authUser->category) && !empty($authUser->experience_level);

        $timeToPeriod = [
            '08:00' => 'No rīta',
            '12:00' => 'Pusdienlaikā',
            '16:00' => 'Pēcpusdienā',
            '20:00' => 'Vakarā',
        ];
    @endphp

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <h1>{{ $track->name }}</h1>

    <div class="track-top">
        <div class="card">
            @if($coverImage)
                <img
                    class="track-cover lightbox-trigger"
                    src="{{ asset($coverImage->path) }}"
                    data-lightbox-src="{{ asset($coverImage->path) }}"
                    alt="Titula attēls"
                >
            @endif
        </div>

        <div class="card">
            <h3>Informācija</h3>
            <ul class="meta-list">
                <li><strong>Apraksts:</strong> {{ $track->description ?: 'Nav norādīts' }}</li></br>
                <li><strong>Segums:</strong> {{ $track->surface_type ?: 'Nav norādīts' }}</li></br>
                <li><strong>Īpašnieks:</strong> {{ $track->owner?->first_name }} {{ $track->owner?->last_name }}</li>
                    </ul>
                        <h3>Sacensības</h3>
                        @if($track->events->count())
                            <ul class="event-list" style="list-style: none; padding: 0;">
                @foreach($track->events as $event)
                    @php 
                        $days = now()->startOfDay()->diffInDays($event->event_date->startOfDay(), false); 
                        
                        $bgColor = '#f3f4f6';

                        if (str_contains($event->title, 'Latvijas čempionāts')) {
                            $bgColor = '#ff7b7b';
                        } elseif (str_contains($event->title, 'Nacionālais kauss')) {
                            $bgColor = '#96bfff';
                        } elseif (str_contains($event->title, 'Latvijas kauss')) {
                            $bgColor = '#ffdd79';
                        }
                    @endphp
                    <li style="background-color: {{ $bgColor }}; padding: 10px; border-radius: 6px; margin-bottom: 8px; border: 1px solid rgba(0,0,0,0.1);">
                        <strong>{{ $event->title }}</strong> <br>
                        <small>
                            {{ $event->event_date->format('d.m.Y') }} | 
                            @if($days > 0) pēc {{ $days }} dienām
                            @elseif($days === 0) <strong>šodien</strong>
                            @else notikušas
                            @endif
                        </small>
                    </li>
                @endforeach
        </ul>
            @else
                <p>Nav plānotas sacensības.</p>
            @endif
        </div>
    </div>

    @if($canManageTrack)
        <div class="manage-toggle">
            <button id="manageToggle" class="btn" type="button">Rediģēt trasi</button>
        </div>
    @endif

    <div id="managePanel" class="card manage-panel" hidden>
        <a class="btn" href="{{ route('tracks.edit', $track->id) }}">Pilna rediģēšana</a>

        <form class="form-grid" action="{{ route('tracks.images.store', $track->id) }}" method="POST" enctype="multipart/form-data" style="margin-top:12px;">
            @csrf
            <div>
                <label for="slot">Kuru attēlu aizstāt</label>
                <select id="slot" name="slot" required>
                    <option value="cover">Titula attēls</option>
                    <option value="gallery_1">Galerija 1</option>
                    <option value="gallery_2">Galerija 2</option>
                    <option value="gallery_3">Galerija 3</option>
                </select>
            </div>
            <div>
                <label for="image">Jaunais attēls</label>
                <input id="image" type="file" name="image" accept="image/*" required>
            </div>
            <div>
                <button class="btn" type="submit">Saglabāt attēlu</button>
            </div>
        </form>
    </div>

    <div class="track-gallery">
        @foreach($galleryImages as $image)
            <div class="track-gallery-item">
                <img
                    class="track-gallery-img lightbox-trigger"
                    src="{{ asset($image->path) }}"
                    data-lightbox-src="{{ asset($image->path) }}"
                    alt="Trases attēls"
                >
                @if($canManageTrack)
                    <form class="manage-delete" action="{{ route('images.destroy', $image->id) }}" method="POST" hidden style="position:absolute; top:6px; right:6px;">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit" onclick="return confirm('Dzēst šo attēlu?')">Dzēst</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    <div class="track-grid">
        <div class="card">
            <h3>Pieteikties treniņam</h3>

            @auth
                <p><strong>Tava informācija:</strong></p>
                <ul class="meta-list">
                    <li><strong>Vārds:</strong> {{ $authUser->first_name }} {{ $authUser->last_name }}</li>
                    <li><strong>Klubs:</strong> {{ $authUser->club->name ?? 'Privāti' }}</li>
                    <li><strong>Klase:</strong> {{ $authUser->category ?: '-' }}</li>
                    <li><strong>Pieredze:</strong> {{ $authUser->experience_level ?: '-' }}</li>
                </ul>

                @if(!$authReady)
                    <p style="color:red;">
                        Lai pieteiktos, vispirms aizpildi klasi un pieredzi profilā.
                    </p>
                    <a class="btn" href="{{ route('profile.edit') }}">Atvērt profilu</a>
                @else
                    <form class="form-grid" action="{{ route('riders.store', $track->id) }}" method="POST">
                        @csrf

                        <div>
                            <label>Datums</label>
                            <select name="ride_date" required>
                                <option value="{{ $today }}">{{ \Carbon\Carbon::parse($today)->format('d.m.Y') }} (Šodien)</option>
                                <option value="{{ $tomorrow }}">{{ \Carbon\Carbon::parse($tomorrow)->format('d.m.Y') }} (Rīt)</option>
                            </select>
                        </div>

                        <div>
                            <label>Laika periods</label>
                            <select name="ride_period" required>
                                <option value="morning">No rīta</option>
                                <option value="noon">Pusdienlaikā</option>
                                <option value="afternoon">Pēcpusdienā</option>
                                <option value="evening">Vakarā</option>
                            </select>
                        </div>

                        <input type="hidden" name="club_id" value="{{ $authUser->club_id }}">
                        <input type="hidden" name="category" value="{{ $authUser->category }}">
                        <input type="hidden" name="experience_level" value="{{ $authUser->experience_level }}">

                        <div>
                            <button class="btn" type="submit">Pieteikties</button>
                        </div>
                    </form>
                @endif
            @endauth

            @guest
                <form class="form-grid" action="{{ route('riders.store', $track->id) }}" method="POST">
                    @csrf

                    <div>
                        <label>Datums</label>
                        <select name="ride_date" required>
                            <option value="{{ $today }}">{{ \Carbon\Carbon::parse($today)->format('d.m.Y') }} (Šodien)</option>
                            <option value="{{ $tomorrow }}">{{ \Carbon\Carbon::parse($tomorrow)->format('d.m.Y') }} (Rīt)</option>
                        </select>
                    </div>

                    <div>
                        <label>Laika periods</label>
                        <select name="ride_period" required>
                            <option value="morning">No rīta</option>
                            <option value="noon">Pusdienlaikā</option>
                            <option value="afternoon">Pēcpusdienā</option>
                            <option value="evening">Vakarā</option>
                        </select>
                    </div>

                    <div>
                        <label>Vārds (obligāti)</label>
                        <input type="text" name="name" required>
                    </div>

                    <div>
                        <label>Klubs (obligāti)</label>
                        <select name="club_id">
                            <option value="">Privāti</option>
                            @foreach($clubs as $club)
                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Klase (obligāti)</label>
                        <select name="category" required>
                            <option>Nav norādīts</option>
                            <option value="MX1">MX1</option>
                            <option value="MX2">MX2</option>
                            <option value="MX125">MX125</option>
                            <option value="MX85">MX85</option>
                            <option value="MX65">MX65</option>
                            <option value="MX50">MX50</option>
                            <option value="Kvadracikls">Kvadracikls</option>
                            <option value="Blakusvāģis">Blakusvāģis</option>
                        </select>
                    </div>

                    <div>
                        <label>Pieredze (obligāti)</label>
                        <select name="experience_level" required>
                            <option>Nav norādīts</option>
                            <option value="Iesācējs">Iesācējs</option>
                            <option value="Amatieris">Amatieris</option>
                            <option value="Veterāns">Veterāns</option>
                            <option value="Profesionālis">Profesionālis</option>
                        </select>
                    </div>

                    <div>
                        <button class="btn" type="submit">Pieteikties</button>
                    </div>
                </form>
            @endguest
        </div>

        <div class="card">
            <h3>Pieteiktie braucēji</h3>
            @forelse($groupedRiders as $clubName => $riders)
                @php $logo = optional($riders->first()->clubRelation)->logo_path; @endphp

                <div class="club-block">
                    <div class="club-header">
                        @if($logo)
                            <img
                                class="club-logo lightbox-trigger"
                                src="{{ asset($logo) }}"
                                data-lightbox-src="{{ asset($logo) }}"
                                alt="{{ $clubName }} logo"
                            >
                        @endif
                        <strong>{{ $clubName }}</strong>
                    </div>

                    <ul class="rider-list">
                        @foreach($riders as $rider)
                            @php
                                $timeKey = \Carbon\Carbon::parse($rider->ride_time)->format('H:i');
                                $periodLabel = $timeToPeriod[$timeKey] ?? $timeKey;
                            @endphp
                            <li>
                                {{ $rider->name }} |
                                {{ $rider->category }} |
                                {{ $rider->experience_level }} |
                                {{ \Carbon\Carbon::parse($rider->ride_date)->format('d.m') }} |
                                {{ $periodLabel }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p>Nav neviena pieteikuma.</p>
            @endforelse
        </div>
    </div>

    @if($canManageTrack)
        <script>
            const toggle = document.getElementById('manageToggle');
            const panel = document.getElementById('managePanel');
            const deletes = document.querySelectorAll('.manage-delete');
            let isOpen = false;

            toggle?.addEventListener('click', () => {
                isOpen = !isOpen;
                panel.hidden = !isOpen;
                deletes.forEach(el => el.hidden = !isOpen);
            });
        </script>
    @endif
</x-layout>
