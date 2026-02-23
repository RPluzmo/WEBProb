<h1>EmEks Laravel Problēma</h1>

<p>Šis ir parasts laravel projekts, kurš paļaujās ur lokālu datubāzi kā mysql vai sqlite...</p>

<h2>Kā (es) plānoju šo projektu palaist</h2>
<p>Pats es izmantoju laragon, cmder termināli lai izpildītu komandas un mysql datubāzi</p><br>

<p>Es sāku ar projekta klonēšanu caur termināli cmder laragon www mapē ar <i>git clone ...</i> komandu</p>
<p>Terminālī izpildot <i>cd WEBProb</i> dodos uz projekta mapi</p>
<p>Tākā tas ir laravel un nēsmu mainijis <b>git ignore</b> jāaizpilda <i>composer install</i> komanda</p><br>

<p>Kamēr tas ielādē nepieciešamo, izpildu <i>code .</i> lai Visual Studio Code atvertu kodu.</p>
<p>VSC pārveido <b>.env example</b> uz <b>.env</b> un itkā var palikt nekas nemainīgs (runa iet par DB savienošanos) un palikt sqlite bet es parasti nomainu šīs koda rindiņas - </p>
<p>DB_CONNECTION=mysql</p>
<p>DB_HOST=127.0.0.1></p>
<p>DB_PORT=3306</p>
<p>DB_DATABASE=webprob</p>
<p>DB_USERNAME=root</p>
<p>DB_PASSWORD=</p><br>

<p>Tagad terminālī izpildu komandu <i>php artisan key:generate</i> lai piešķirtu <b>.env</b> failam APP_KEY</p><br>

<h3>Migrācijas</h3>
<p>Tagad svarīgi izpildīt terminālī ir <i>php artisan migreate</i> un piekrist izveidot DB</p>
<p>Pēc tam pietiek ar šīs komandas izpildīšanu <i>php artisan migrate:fresh --seed</i>, lai ievieotu jau definētus datus DatuBādē no seeder failiem</p><br>

<p>Un visbeidzot jāizpilda <i>php artisan serve</i> lai palaistu pašu projektu un tad pēc noklusējuma vienēr dodos uz "http://127.0.0.1:8000/"</p><br>

<h3>Veids kā jūs palaižat projektu var būt savādāks (no doubt), bet šīs ir darbības kuras veicu es pēc klonēšanas no git</h3>
