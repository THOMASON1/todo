# Instalacja i uruchomienie aplikacji

## Wymagania
- **Docker** oraz **Docker Compose** muszą być zainstalowane na Twoim systemie.

## Uruchomienie aplikacji

1. **Uruchom Docker Compose**:
    ```bash
    docker-compose up --build -d
    ```

2. **Zainstaluj zależności PHP**:
    ```bash
    docker-compose run --rm composer install
    ```

3. **Zainstaluj zależności Node.js**:
    ```bash
    docker-compose exec app npm install
    ```

4. **Zbuduj zasoby front-endowe**:
    ```bash
    docker-compose exec app npm run build
    ```

## Konfiguracja aplikacji

1. **Tworzenie pliku `.env`**:
    Jeśli nie masz jeszcze pliku `.env`, wygeneruj go na podstawie przykładu:
    ```bash
    cp .env.example .env
    ```

2. **Generowanie klucza aplikacji**:
    Uruchom poniższe polecenie, aby wygenerować klucz aplikacji:
    ```bash
    docker-compose exec app php artisan key:generate
    ```

3. **Czyszczenie pamięci podręcznej i konfigurowanie aplikacji**:
    Aby oczyścić pamięć podręczną oraz skonfigurować aplikację, uruchom:
    ```bash
    docker-compose exec app php artisan cache:clear
    docker-compose exec app php artisan config:cache
    ```

4. **Migracja bazy danych**:
    Uruchom migracje:
    ```bash
    docker-compose exec app php artisan migrate
    ```

## Dodatkowe konfiguracje

### Google Calendar API

Aby umożliwić tworzenia adnotacji w **Google Calendar**, musisz skonfigurować klucz API:

1. Zaloguj się do swojego konta **Google Cloud Console** i wygeneruj **credentials.json**.
2. Wstaw plik `credentials.json` do folderu: `/storage/app/google-calendar`.
3. Skonfiguruj identyfikator kalendarza w pliku `.env`:
```dotenv
GOOGLE_CALENDAR_ID=<Twój_ID_Kalendarza>
```

### Wysyłka mailowa

Aplikacja zawiera cron do automatycznego wysyłania maili w określonych odstępach czasu. Używa on systemu cron na podstawie crontab, aby wykonywać zadania związane z wysyłką maili (np. powiadomienia, przypomnienia).

Potrzebna jest poprawna konfiguracja danych w pliku `.env`:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=twoj_email@gmail.com
MAIL_PASSWORD=twoje_haslo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=twoj_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```