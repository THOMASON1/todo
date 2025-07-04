# Instalacja i uruchomienie aplikacji

## Wymagania
- **Docker** oraz **Docker Compose** muszą być zainstalowane na Twoim systemie.
- Pliki konfiguracyjne Dockera są w folderze: `/docker`.

## Struktura folderów

Poniżej znajduje się ogólny opis struktury folderów projektu, co ułatwia nawigację i zrozumienie organizacji aplikacji:

```dotenv
├── src/
│ ├── 
├── .dockerignore
├── .docker-compose.yml
├── Dockerfile
├── nginx.conf
```

### Wyjaśnienia:

- **src/** – Folder zawierający główną aplikację źródłową - pobraną z repozytorium.
- **.dockerignore** – Plik, który określa pliki i foldery, które powinny być ignorowane przez Docker przy tworzeniu obrazu. Używane do wykluczenia zbędnych plików, takich jak pliki tymczasowe, lokalne pliki konfiguracji, itp.
- **.docker-compose.yml** – Plik konfiguracyjny używany przez Docker Compose do uruchomienia wielu kontenerów w jednym środowisku. Określa usługi kontenerów, ich zależności, sieci, woluminy, itp.
- **Dockerfile** – Plik używany przez Docker do tworzenia obrazu kontenera aplikacji. Zawiera wszystkie instrukcje do zbudowania środowiska uruchomieniowego aplikacji.
- **nginx.conf** – Plik konfiguracyjny serwera Nginx, który zarządza ruchem HTTP, ustawia przekierowania, konfigurację proxy i inne opcje dla aplikacji.

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