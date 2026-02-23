<x-layout>
    @php
        $groups = [
            'admin' => 'Administratori',
            'owner' => 'Trases saimnieki',
            'guest' => 'Lietotāji',
        ];
    @endphp

    <h1>Lietotāju pārvaldība</h1>

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    @foreach($groups as $roleKey => $roleLabel)
        @php $roleUsers = $users->where('role', $roleKey); @endphp

        <div class="card" style="margin-bottom:14px;">
            <h2>{{ $roleLabel }} ({{ $roleUsers->count() }})</h2>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profils</th>
                            <th>Vārds</th>
                            <th>E-pasts</th>
                            <th>Trase</th>
                            <th>Izveidots</th>
                            <th>Atjaunināts</th>
                            <th>Darbības</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roleUsers as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @if($user->profile_image)
                                        <img class="avatar-sm" src="{{ asset($user->profile_image) }}" alt="Bildīte">
                                    @else
                                        <span class="avatar-sm avatar-fallback">:D</span>
                                    @endif
                                </td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tracks->pluck('name')->join(', ') ?: '-' }}</td>
                                <td>{{ optional($user->created_at)->format('d.m.Y H:i') }}</td>
                                <td>{{ optional($user->updated_at)->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a class="btn btn-secondary" href="{{ route('users.edit', $user->id) }}">Rediģēt</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Dzēst lietotāju?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn" type="submit">Dzēst</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8">Nav ierakstu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</x-layout>
