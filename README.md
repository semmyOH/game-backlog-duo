# Game Backlog — Laravel + React Challenge

Beginsituatie voor een mbo4-opdracht: **Laravel 12, React, Inertia 2 en SQLite**.
Gebaseerd op de officiële Laravel React Starter Kit. Registreren, inloggen,
games toevoegen, invoercontrole en eigen games tonen werken al.

**Start met [de volledige lesmodule](LESMODULE.md).** Deze bevat ook alle
GitHub-stappen, illustraties, opdrachten en tests. Dezelfde les staat als
zelfstandige webpagina in `docs/lesmodule.html`: download/open dat bestand
in je browser als je liever de online opmaak gebruikt.

## Eén repository per duo

1. Eén student kiest op de docenten-template **Use this template → Create a new repository**.
2. Kies jullie eigen account, een naam en Public. Alleen de standaardbranch is nodig.
3. Nodig de partner uit via **Settings → Collaborators → Add people**.
4. De partner accepteert; jullie klonen **allebei jullie eigen duo-repository**.
5. Controleer met `git remote -v` dat `origin` naar jullie repository verwijst.

Alleen klonen maakt nog geen eigen repository. Geef de docent de URL van jullie duo-project.

## Benodigdheden

- PHP 8.2, 8.3 of 8.4 met de gebruikelijke Laravel-extensies en `pdo_sqlite`.
- Composer 2, Node.js 22 LTS of 24 LTS, npm en Git.
- VS Code en een GitHub-account.

Gebruik `php -v` om de versie in je terminal te controleren. Apache, MySQL en
een Laravel-installer zijn voor dit project niet nodig.

## Installeren op iedere laptop

Open de gekloonde projectmap in VS Code. Je ziet hier `artisan` en `composer.json`.
Voer na elkaar uit:

```shell
composer install
npm ci
```

Een meegeleverd Composer-script maakt automatisch:

- `.env` vanuit het eenvoudige `.env.example`;
- een eigen willekeurige `APP_KEY`;
- `database/database.sqlite` vanuit de voorbereide `database/template.sqlite`.

De tabellen bestaan al. Je hoeft voor de eerste start geen migraties uit te voeren.
De database bevat geen accounts of games: registreer straks je eigen testaccount.
Het script bewaart bestaande instellingen en gegevens bij opnieuw uitvoeren.
Gebruik geen `--no-scripts`. Zo nodig kun je het script zelf opnieuw starten:

```shell
composer run setup-local
```

## Starten

Terminal 1:

```shell
php artisan serve
```

Terminal 2:

```shell
npm run dev
```

Open **http://localhost:8000**, kies **Register** en maak een lokaal testaccount.
Klik in het dashboard op **Open mijn games**, of ga naar `/games`.
E-mailverificatie is voor deze lokale oefening niet nodig.

## Opdrachten

De eerste drie opdrachten staan met TODO in de broncode:

| Opdracht | Bestand |
| --- | --- |
| A: status omdraaien en bewaren | `app/Http/Controllers/GameController.php` — TODO 1 |
| B: zoeken op titel | `resources/js/pages/games/index.tsx` — TODO 2 |
| C: uitgespeelde games tellen | hetzelfde bestand — TODO 3 |
| D: knop Wis zoeken | voeg zelf toe bij het zoekveld |
| E: aantal zichtbare resultaten | voeg zelf toe bij Mijn games |
| F: Alleen nog spelen | optioneel; zie de lesmodule |

Volg de uitleg en hints in [LESMODULE.md](LESMODULE.md). Houd je werk bij in
[VOORTGANG.md](VOORTGANG.md). Het is de bedoeling dat de startversie nog niet
zoekt, nog geen status verandert en nog nul uitgespeelde games telt.

## Samenwerken: om de beurt

**Pull → aanpassen en testen → stage → commit → push → partner pull.**
Gebruik ieder je eigen GitHub-account. Spreek af wie aan de beurt is en
wissel na iedere challenge. Laat de partner na Pull de wijziging op diens
eigen laptop testen. Zie de lesmodule voor stappen in VS Code en hulp bij conflicten.

Git deelt de code. De `.env`, accounts en games blijven lokaal. Verander
`database/template.sqlite` niet tijdens de opdracht. Voeg testgames op beide
laptops zelf toe. Gebruik geen Force Push.

## Controles en problemen

```shell
php artisan test --filter=Game
npm run types:check
npm run build
```

De Game-tests controleren de voorbereide basis en de eigendomscontrole.
Test status, zoeken, tellers en extra knoppen daarnaast handmatig met de tabel
in `VOORTGANG.md`. PHPUnit gebruikt een tijdelijke geheugendatabase.

- SQLite-driver ontbreekt: controleer `php --ini`, `php -m` en activeer `pdo_sqlite`.
- Vite manifest ontbreekt: laat `npm run dev` draaien.
- `.env`/database ontbreekt: voer `composer run setup-local` uit.
- Windows meldt `Failed to listen` op een vrije poort: probeer `php artisan serve --no-reload`.
  Herstart in dat geval Laravel handmatig als je `.env` aanpast.
- Na gewone codewijzigingen volstaat Pull. Bij een gewijzigd `composer.lock`:
  `composer install`; gewijzigd `package-lock.json`: `npm ci`; nieuwe migraties:
  `php artisan migrate`.

Werk in deze les met de lockbestanden. Voer geen pakketupdates uit zonder
afspraak met de docent. Verwijder je database niet bij een foutmelding.

## Als je de docent-repository al hebt gekloond

De eenvoudigste route: maak een eigen repository via **Use this template** en
kloon die in een nieuwe map. Bewaar eerst eventueel eigen werk.

Een alternatief voor iemand die Git al kent: maak op GitHub een **lege** eigen
repository, zonder README, licentie of .gitignore. Verander in je bestaande clone
alleen de remote-URL naar die nieuwe repository en push de bestaande geschiedenis.
Vervang de voorbeeld-URL door de echte URL van jullie lege repository:

```shell
git remote set-url origin https://github.com/JOUW-ACCOUNT/JOUW-REPOSITORY.git
git push -u origin main
```

Gebruik dit alternatief niet met een repository die al eigen commits bevat.
Nodig daarna je partner uit; die kloont de nieuwe repository. Deel uitsluitend
die nieuwe URL met elkaar.

## Herkomst en licentie

Zie [HERKOMST.md](HERKOMST.md) en [LICENSE](LICENSE). De template is bedoeld
voor lokaal lesgebruik. De docent beheert toekomstige pakketupdates.
