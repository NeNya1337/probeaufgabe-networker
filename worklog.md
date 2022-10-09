Aufgabe/n
1. Erstellung eines GitHub.com Repository für das Projekt
Das Repo kann öffentlich oder privat sein. Wenn es privat ist, dann bitte mich als Contributor zuweisen. Mein GitHub Account BlackhawkG7 (Björn Stengel) (github.com).
Die Aufgabe ist im finalen Status als Main oder Master-Branch des Repos abzuspeichern.
2. Erstellung einer MySQL Datenbank-Struktur zum Einlesen der CSV Daten. Es sollen die Antworten mit einem Zeitstempel geflaggt und die Zustellung an den User nachweislich protokolliert werden.
3. Import der CSV Daten in die Datenbank
4. Erstellung eines PHP (7.4) Scripts zum Versand der E-Mails (siehe Word Doc) und Auswertung der Antworten Ja / Nein zur Weitergabe. Die Wahl von Frameworks oder Core PHP bleibt frei.
5. Versand an die in der CSV enthaltenen Adressen. Idealerweise wird der erfolgte Versand für jede Adresse mit einem Zeitstempel, welcher in der Datenbank protokolliert wird.
6. Erstellung von MySQL Queries zum Auslesen der bestätigten bzw. abgelehnten Adressen zur Weiterverarbeitung im CRM, vorzugsweise als CSV. Die Export CSV Daten sollten abgelegt sein, das Script mehrfach verwendbar (z.B. mit einem Truncate auf die Tabellen zu Beginn).

2:
* nötige Datenbankspalten:
* * Name (varchar30)
* * Email (varchar100)
* * zustellungsdatum
* * Antwort-status (tinyint) 0/1
* * AntwortDatum

3: 
* CSV-Import als Formular ohne css etc
* versenden der mails per buttom
* * hier werden nur mails versendet, in denen zustellungsdatum NULL ist
* aufruf der api mit folgenden variablen (z.b. get)
* * mail des users (oder id)
* * antwortstatus
* php führt db befehl aus und gibt rückmeldung
* * "sie wurden erfolgreich ausgetragen"
* * "vielen dank für ihre weitere unterstützung"
* * "es ist ein fehler aufgetreten"
* * * z.b. wenn falsche variablen übermittelt
