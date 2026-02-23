<header class="site-header">
    @php
        $weekdayLv = [
            'Monday' => 'Pirmdiena',
            'Tuesday' => 'Otrdiena',
            'Wednesday' => 'Trešdiena',
            'Thursday' => 'Ceturtdiena',
            'Friday' => 'Piektdiena',
            'Saturday' => 'Sestdiena',
            'Sunday' => 'Svētdiena',
        ];
        $dayName = $weekdayLv[now()->englishDayOfWeek] ?? now()->englishDayOfWeek;
    @endphp

    <nav class="site-nav">
        <div class="nav-left">
            <a class="nav-link" href="{{ url('/') }}">Sākums</a>
            <a class="nav-link" href="{{ route('home') }}">Karte</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a class="nav-link" href="{{ route('users.index') }}">Lietotāji</a>
                @endif
            @endauth
        </div>

        <div class="nav-right">
            <span class="nav-date">{{ $dayName }}, {{ now()->format('d.m') }}</span>

            @auth
                @if(Auth::user()->profile_image)
                    <img
                        class="avatar-sm lightbox-trigger"
                        src="{{ asset(Auth::user()->profile_image) }}"
                        data-lightbox-src="{{ asset(Auth::user()->profile_image) }}"
                        alt="Profils"
                    >
                @else
                    <span class="avatar-sm avatar-fallback">:D</span>
                @endif

                <a href="{{ route('profile.edit') }}" class="profile-link">
                    <strong>Sveiks, {{ Auth::user()->first_name }}</strong>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn" type="submit">Izrakstīties</button>
                </form>
            @else
                <a class="btn" href="{{ route('login') }}">Ienākt</a>
                <a class="btn" href="{{ route('register') }}">Reģistrēties</a>
            @endauth
        </div>
    </nav>
</header>
