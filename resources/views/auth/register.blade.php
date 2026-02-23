<x-layout>
    <x-slot:title>
        {{ "Reģistrēties" }}
    </x-slot:title>
    <h1>Reģistrēties</h1>
        <form action="/register" method="POST">
            @csrf
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
                <ul>
                    <li>           
                        <label>vārds
                            <input name="first_name" value="{{ old('first_name') }}" required/>
                        </label>
                    </li>
                    <li>           
                        <label>uzvārds
                            <input name="last_name" value="{{ old('last_name') }}" required/>
                        </label>
                    </li>
                    <li>           
                        <label>e-pasts
                            <input type="email" name="email" value="{{ old('email') }}" required/>
                        </label>
                    </li>
                    <li>           
                        <label>parole
                            <input type="password" name="password" required/>
                        </label>
                    </li>
                    <li> 
                        <label>paroles apstiprinājums
                            <input type="password" name="password_confirmation" required/>
                        </label>
                    </li>
                        <button type="submit">Saglabāt</button>
                </ul>
        </form>
    </x-layout>