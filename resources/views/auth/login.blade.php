<x-layout>
    <x-slot:title>
        {{ "Ierkastīties" }}
    </x-slot:title>
    <h1>Ierakstīties</h1>
        <form action="/login" method="POST">
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
                        <button class="btn" type="submit">Saglabāt</button>
                    </li>
                </ul>
        </form>

        <div class="card welcome-card">
            <h2>Atgādinājums!!</h2>
            <p>Projektā (ja tikusi izpildīta <i>--seed</i> komanda) ir jau definēti lietotāji</p><hr>
            <p>Admin lietotājs - admin@emeks.lv</p>
            <p>Trašu saimnieki / īpašnieki - trases nosaukums (redzams kartē kā, piemēram, Ķegums) <strong>kegums@emeks.lv</strong><br>
            bez garumzīmēm e-pastā</p>
            <p>Arī lietotājiem no Facotry, kuri ir ievietoti vienkārši lai redzētu, kad projektā būtu lietotāji itkā var ielogoties viņu profilos, bet tur reali nekas nemainās no parasta sevis veidota lietotāja<br>
            , tomēr lai ieietu kādā no šiem profiliem pie kādas trases var apskatīties pieteikušos braucējus un iegaumēt viņa <strong>vārdu</strong> un <strong>uzvārdu</strong>, un ierakstīt pie epasta <strong>vards.uzvards@emeks.lv</strong></p>

            <h3>Un parole visiem jau iepriekš definētiem lietotājiem ir <strong>qwe</strong></h3>
            

        </div>
</x-layout>