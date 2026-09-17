# Digipost

Digipost is een PHP-API voor het beheren en opvragen van digitale berichten. Gebruikers kunnen berichten naar elkaar sturen en berichten ophalen uit hun persoonlijke berichtenbox.

## Functionaliteit

De API ondersteunt:

- Alle berichten ophalen
- Een specifiek bericht ophalen
- Alle gebruikers ophalen
- Een specifieke gebruiker ophalen
- De berichtenbox van een gebruiker bekijken
- De koppeling tussen berichten, afzenders en ontvangers bekijken

De gegevens worden opgeslagen in een MySQL-database met de tabellen `User`, `Bericht` en `Ontvanger`.

## API-endpoints

Wanneer Docker draait, zijn de volgende endpoints beschikbaar:

```text
GET http://localhost/bericht
GET http://localhost/bericht/{id}

GET http://localhost/user
GET http://localhost/user/{id}

GET http://localhost/berichtenbox/{user_id}

GET http://localhost/userhasbericht
GET http://localhost/userhasbericht/{user_id}
