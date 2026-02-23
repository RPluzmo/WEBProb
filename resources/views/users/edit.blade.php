<x-layout>
    <h1>Rediģēt lietotāju: {{ $user->first_name }} {{ $user->last_name }}</h1>

    <div class="card">
        <form class="form-grid" method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div>
                <label>Profila attēls</label>
                @if($user->profile_image)
                    <img class="avatar-lg" src="{{ asset($user->profile_image) }}" alt="Profila attēls">
                @else
                    <span class="avatar-lg avatar-fallback">PR</span>
                @endif
                <label style="margin-top:8px;">
                    <input type="checkbox" name="remove_profile_image" value="1">
                    Noņemt profila attēlu
                </label>
            </div>

            <div>
                <label>Vārds</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
            </div>

            <div>
                <label>Uzvārds</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
            </div>

            <div>
                <label>E-pasts</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div>
                <label>Loma</label>
                <select id="role" name="role" required>
                    <option value="guest" {{ old('role', $user->role) === 'guest' ? 'selected' : '' }}>Lietotājs</option>
                    <option value="owner" {{ old('role', $user->role) === 'owner' ? 'selected' : '' }}>Trases saimnieks</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrators</option>
                </select>
            </div>

            <div id="ownerTrackBox" {{ old('role', $user->role) === 'owner' ? '' : 'hidden' }}>
                <label>Owner trase</label>
                <select name="owner_track_id">
                    <option value="">Nav piešķirta</option>
                    @foreach($tracks as $track)
                        <option value="{{ $track->id }}" {{ (string) old('owner_track_id', $ownerTrackId) === (string) $track->id ? 'selected' : '' }}>
                            {{ $track->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button class="btn" type="submit">Saglabāt</button>
                <a class="btn btn-secondary" href="{{ route('users.index') }}">Atcelt</a>
            </div>
        </form>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const ownerTrackBox = document.getElementById('ownerTrackBox');

        roleSelect?.addEventListener('change', () => {
            ownerTrackBox.hidden = roleSelect.value !== 'owner';
        });
    </script>
</x-layout>
