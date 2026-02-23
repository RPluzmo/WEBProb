<x-layout>
    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <div class="card profile-form">
        <h1>Mans profils</h1>

        <div style="display:flex; align-items:center; gap:14px; margin-bottom:14px;">
            @if($user->profile_image)
                <img
                    class="avatar-lg lightbox-trigger"
                    src="{{ asset($user->profile_image) }}"
                    data-lightbox-src="{{ asset($user->profile_image) }}"
                    alt="Profila attēls"
                >
            @else
                <span class="avatar-lg avatar-fallback">PR</span>
            @endif
            <div>
                <div style="font-size:22px; font-weight:700;">
                    {{ $user->first_name }} {{ $user->last_name }}
                </div>
                <div style="color:#6b7280;">
                    {{ $user->email }}
                </div>
            </div>
        </div>

        <form class="form-grid" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="profile_image">Profila bilde</label>
                <input id="profile_image" type="file" name="profile_image" accept="image/*">
                @error('profile_image')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="first_name">Vārds</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
            </div>

            <div>
                <label for="last_name">Uzvārds</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
            </div>

            <div>
                <label for="email">E-pasts</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div>
                <label for="club_id">Klubs</label>
                <select id="club_id" name="club_id">
                    <option value="">Privāti</option>
                    @foreach($clubs as $club)
                        <option value="{{ $club->id }}" {{ (string) old('club_id', $user->club_id) === (string) $club->id ? 'selected' : '' }}>
                            {{ $club->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="category">Klase</label>
                <select id="category" name="category">
                    <option value="">Nav norādīta</option>
                    <option value="MX1" {{ old('category', $user->category) === 'MX1' ? 'selected' : '' }}>MX1</option>
                    <option value="MX2" {{ old('category', $user->category) === 'MX2' ? 'selected' : '' }}>MX2</option>
                    <option value="MX125" {{ old('category', $user->category) === 'MX125' ? 'selected' : '' }}>MX125</option>
                    <option value="MX85" {{ old('category', $user->category) === 'MX85' ? 'selected' : '' }}>MX85</option>
                    <option value="MX65" {{ old('category', $user->category) === 'MX65' ? 'selected' : '' }}>MX65</option>
                    <option value="MX50" {{ old('category', $user->category) === 'MX50' ? 'selected' : '' }}>MX50</option>
                    <option value="Kvadracikls" {{ old('category', $user->category) === 'Kvadracikls' ? 'selected' : '' }}>Kvadracikls</option>
                    <option value="Blakusvāģis" {{ old('category', $user->category) === 'Blakusvāģis' ? 'selected' : '' }}>Blakusvāģis</option>
                </select>
            </div>

            <div>
                <label for="experience_level">Pieredze</label>
                <select id="experience_level" name="experience_level">
                    <option value="">Nav norādīta</option>
                    <option value="Iesācējs" {{ old('experience_level', $user->experience_level) === 'Iesācējs' ? 'selected' : '' }}>Iesācējs</option>
                    <option value="Amatieris" {{ old('experience_level', $user->experience_level) === 'Amatieris' ? 'selected' : '' }}>Amatieris</option>
                    <option value="Veterāns" {{ old('experience_level', $user->experience_level) === 'Veterāns' ? 'selected' : '' }}>Veterāns</option>
                    <option value="Profesionālis" {{ old('experience_level', $user->experience_level) === 'Profesionālis' ? 'selected' : '' }}>Profesionālis</option>
                </select>
            </div>

            <div>
                <button class="btn" type="submit">Saglabāt</button>
            </div>
        </form>
    </div>
</x-layout>
