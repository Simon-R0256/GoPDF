# Important

    Nach jedem Migration-Update:
    php artisan migrate:fresh
    php artisan db:seed
# Aufsetzen des Projekts

    1. Run composer install
    2. in .env "DB_DATABASE=restapi_project" setzen
    3. xampp apache und mysql öffnen
    4. Datenbank "restapi_project" erstellen
    5. php artisan migrate
    6. php artisan db:seed 
       Generischer Admin -> Email: admin@admin.com, Passwort "adminpass" 
    7. Run php artisan key:generate
    8. Run composer require dompdf/dompdf
    9. Run php artisan optimize
    10. Run php artisan serve

---
## Vorübergehende API Documentation

---

    Zum Testen Postman benutzen!

    --Benötigte Header Information--

    Authorization -> API-Key

    Bei POST Requests:
    Content-Type -> application/json

    --Requests--
    GET 127.0.0.1:8000/api/doc/
    - > Auflistung aller Freigegeben Dokumente
    GET 127.0.0.1:8000/api/doc/ID
    -> ID als Parameter übergeben um die Daten des Dokuments aufzurufen
    GET 127.0.0.1:8000/api/doc/search/NAME
    -> NAME als Parameter übergeben um nach Dokumenten zu suchen
    POST 127.0.0.1:8000/api/doc/id
    -> Ersetzt die Platzhalter im Dokument durch die übergebenen Werte
    Platzhalter-Name -> Wert

---
## MailHog Setup

    1. Passende Mailhog Version für das System downloaden: https://github.com/mailhog/MailHog
    2. Executable ausführen 
    3. http://127.0.0.1:8025/ aufrufen


