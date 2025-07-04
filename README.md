# Instalacja i uruchomienie aplikacji

## Wymagania
- **Docker** oraz **Docker Compose** muszą być zainstalowane na Twoim systemie. Jeśli nie masz ich zainstalowanych, odwiedź [stronę Docker](https://www.docker.com/get-started) i postępuj zgodnie z instrukcjami.

## Uruchomienie aplikacji

1. **Uruchom Docker Compose** w tle:
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
    Jeśli aplikacja używa bazy danych, uruchom migracje:
    ```bash
    docker-compose exec app php artisan migrate
    ```

## Dodatkowe konfiguracje

### Google Calendar API

Aby umożliwić system tworzenia adnotacji w **Google Calendar**, musisz skonfigurować klucz API:

1. Zaloguj się do swojego konta **Google Cloud Console** i wygeneruj **credentials.json**.
2. Wstaw plik `credentials.json` do folderu:
