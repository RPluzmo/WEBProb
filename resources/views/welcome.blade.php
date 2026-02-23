<x-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    @endpush

    <section class="welcome-hero">
        <img src="{{ asset('welcome/cover.png') }}" alt="Moto trases cover attēls" class="welcome-hero-image">
        <div class="welcome-hero-overlay">
            <h1>Motokrosa treniņu plānošana..</h1>
            <p>Organizētāks veids kā ieplānot treniņus</p>
        </div>
    </section>

    <section class="welcome-content">
        <article class="card welcome-card">
            <h2>Problēma?</h2>
            <p>
                Manuprāt, šis projekts atbilst (3.slaidā) saistībām ar <strong><i>Draugiem un komunikāciju</i></strong>,
                jo parasti visvairāk cilvēku dodas uz treniņiem nedēļas nogalē un bieži vien speciāli organizē, lai brauktu kopīgi.<br><br>
                Tas var radīt tādu kā nelielu problēmu citiem, kas piemēram ir tajā pašā WhatsApp grupā un galīgi neplāno ierasties,
                bet saņem daudz paziņojumu, kas dažreiz sāk krist uz nerviem... Vismaz man... 
            </p>
        </article>

        <article class="card welcome-card">
            <h2>Lietotāju lomas</h2>
            <ul>
                <li><strong>Admin - </strong> pārvalda lietotājus, lomas, īpašniekus, trases un attēlus.</li><br>
                <li><strong>Trases īpašnieks - </strong> pārvalda sev piešķirtās trases informāciju un attēlus.</li><br>
                <li><strong>Reģistrēts lietotājs - </strong> piesakās treniņiem ar savu profilu un nav nepieciešams katru reizi aizpildīt formu par sevi.</li><br>
                <li><strong>Viesis - </strong> var pieteikties, aizpildot pilno formu.</li><br>
            </ul>
        </article>

        <article class="card welcome-card">
            <h2>Kā tas strādā?</h2>
            <ul>
                <li>Kartē tiek attēlotas trases ar aktīvo braucēju skaitu.</li><br>
                <li>Atverot trasi, var redzēt aprakstu, segumu, attēlus(daudzām trasēm šis nav aprakstīts un aizpildīts
                    , jo daudzkur nēsmu bijis / nav baigi daudz trases saimnieku dotais info[aprakstus ņēmu no 
                    <a href="https://www.licences.lv/licenses/category/6">Licences.lv</a>]) un pieteikušos braucējus.</li><br>
                <li>Reģistrēti lietotāji piesakās ātri ar savu profila informāciju.</li>
            </ul>
        </article>

        <article class="card welcome-card">
            <h2>Pierakstīšanās un reģistrācija</h2>
            <p>
                No "seeders" tiek saglabāti trašu saimnieki, viens adminstrātors un random braucēji kā reali lietotāji.<br><br>
                <strong>!!Pirmkārt, visiem manis definētiem lietotājiem parole ir vienkārši "qwe"!!</strong><br><br>
                Lai pieslēgtos kā admins - Login lapā epasts ir "admin@emeks.lv"<br>
                Trases saimniekiem epasti ir saistīti ar viņu konkrēto trases pilsētu vai apdzīvoto vietu, piemēram, 
                Cēsu(ezerkalnu)trases epasts ir - "cesis@emeks.lv" un parole "qwe"
            </p>
        </article>

        <article class="card welcome-card">
            <h2>Lietojamība</h2>
            <p>
                Lietotājs var pieteikties uz treniņu šodien vai rīt, kā arī izvēlēties laika periodu, kad plāno ierasties<br><br>
                (proti, nekas neaizliedz vakarā pēc īstā laika vēl pieteikt treniņu šīs dienas rītam...)<br><br>
                projekts ir domāts kā katru dienu tas atjaunojas un noņem vecos pieteikumus, bet šeit tas vēl nav īstenots.
            </p>
        </article>
        

        <article class="card welcome-card">
            <h2>Apjoms un iespējas</h2>
           <p>
                Iespējams klonēšanas laikā un seed laikā pamanījāt cik lēni vis lādējas (kādas 10s WOW), un tas ir dēļ attēliem, un visa seeder... :]<br><br>
                Tādā ziņā būtu iespēja katrai trasei kas balstās kādā no atbalstītām trasēm vēl papildus attēlot klubu, kā piemēram,
                Alojas - Jaunzemnieku trasē parādīt klubu MX Aloja, jo tā ir viņu "mājas trase", bet šobrīd tas nav īstenots.<br><br>
                Kā arī labāk filtrēt trases pēc, piemēram, sacensībām, kur tiktu attēlotas tikai tās trases kurās plānotas sacensības.<br><br>
                Vēl ļoti krīt acīs kā katrai trasei ir 3 mazās galerijas bildes kautgan vieta ir arī 4. bet pārbīdot attēlus un stilu atbrīvojās šī vieta, 
                kad bija paredzētas tikai 3 bildes, bet man personīgi vairs negribās meklēt katrai trasei attēlu, kad tie jau ir ļoti maz un nekvalatitāti.<br>
                Kautkā tā.. iespējas nākotnē :D
            </p>
        </article>

        
    </section>
</x-layout>
