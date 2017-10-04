# my_mvc


## Utvecklades i
- PHP 7
- Mysql 5.6.25


## Användning
1. Ladda ner,
2. Sätt document root till my_mvc/public
3. Skapa och koppla till db via App/config.php
4. Tabellen posts skapas automatiskt
5. Skapa/uppdatera inlägg


## Uppgift
Uppgiften kommer se enkel ut "utifrån" dvs frontend, men kommer vara
relativt komplex i backend. Vi vill att du ska ta fram 2st sidor.

SIDA #1. "Listan" är en lista över poster som hämtas från en DB.
Listan innehåller rubrik och lång beskrivning, en för varje post.
- Varje post går att redigera.
- Listan har även en "Lägg till" knapp.

SIDA #2. "Lägg till" sidan innehåller 2st rutor, en för rubrik och en
textarea för lång beskrivning.
När man klickar "Spara" så ska fälten verifieras mha jquery, om OK så
sparas de i DB.
- Rubrik får ej innehålla några siffror.
- Lång beskrivning får inte innehålla HTML.
- Båda fälten måste vara ifyllda.

- Se bifogad .png bild hur enkelt det kan se ut när det är klart.
Bilden ska föreställa 2st olika sidor.

- MVC där Model innehåller all logik, View är helt strippad från
class/function etc och endast innehåller nödvändig logik.
Controllern binder de två samman.

- DB ska ha egen Model. Mysql PDO samt skydd mot SQL-injections i
rimlig utsträckning.

- Bygg in felhantering i rimlig utsträckning, dvs "try/catch" och "throw
new exception" etc när lämpligt.

- Gör en egen config-fil eller config-class där man anger sina
mysql-uppgifter. Det ska gå att sätta upp denna PHP-applikationen samt
DB på sin lokala dator och testa, så skicka även över hur DB-tabellen
ser ut, tex CREATE TABLE 'MyTable' etc...

- Lägg EJ onödig tid på att göra ett snyggt GUI, dvs utseende, viktigt
är att PHP-koden är ren, väldokumenterad och logisk för annan
programmerare. HTML5-koden ska vara w3c validerad.

- Tänk på säkerheten.



