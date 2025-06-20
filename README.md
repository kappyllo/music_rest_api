# Dokumentacja API

## Spis treści

-   [Rejestracja użytkownika](#rejestracja-użytkownika)
-   [Logowanie](#logowanie)
-   [Wylogowanie](#wylogowanie)
-   [Użytkownicy](#użytkownicy)
-   [Piosenki](#piosenki)
-   [Artyści](#artyści)
-   [Albumy](#albumy)
-   [Playlisty](#playlisty)

---

## Rejestracja użytkownika

**POST** `/api/register`

Rejestruje nowego użytkownika.

### Request Body

```json
{
    "name": "string",
    "email": "string",
    "password": "string"
}
```

Response

    201 Created – użytkownik utworzony

    422 Unprocessable Entity – błąd walidacji

## Logowanie

POST /api/login

Loguje użytkownika i zwraca token.

### Request Body

```json
{
    "email": "string",
    "password": "string"
}
```

Response

    200 OK – token i dane użytkownika

    401 Unauthorized – nieprawidłowe dane logowania

## Wylogowanie

POST /api/logout

Wylogowuje zalogowanego użytkownika.
Headers

Authorization: Bearer {token}

Response

    200 OK – wylogowano

    401 Unauthorized – brak autoryzacji

Pobierz dane zalogowanego użytkownika

GET /api/user

Zwraca dane aktualnie zalogowanego użytkownika.
Headers

Authorization: Bearer {token}

Response

    200 OK – dane użytkownika

    401 Unauthorized – brak autoryzacji

## Użytkownicy

GET /api/users

Zwraca listę użytkowników.
Response

    200 OK – lista użytkowników

## Piosenki

| Metoda | Endpoint          | Opis                   | Autoryzacja |
| ------ | ----------------- | ---------------------- | ----------- |
| GET    | `/api/songs`      | Pobierz listę piosenek | Nie         |
| POST   | `/api/add-song`   | Dodaj nową piosenkę    | Nie         |
| GET    | `/api/songs/{id}` | Pobierz piosenkę po ID | Nie         |
| DELETE | `/api/songs/{id}` | Usuń piosenkę po ID    | Nie         |

Przykład Request Body dla POST /api/add-song

```json
{
    "title": "string",
    "artist_id": 1,
    "album_id": 1,
    "duration": 180
}
```

## Artyści

| Metoda | Endpoint            | Opis                   | Autoryzacja |
| ------ | ------------------- | ---------------------- | ----------- |
| GET    | `/api/artists`      | Pobierz listę artystów | Nie         |
| POST   | `/api/add-artist`   | Dodaj nowego artystę   | Nie         |
| GET    | `/api/artists/{id}` | Pobierz artystę po ID  | Nie         |
| DELETE | `/api/artists/{id}` | Usuń artystę po ID     | Nie         |

Przykład Request Body dla POST /api/add-artist

```json
{
    "name": "string"
}
```

## Albumy

| Metoda | Endpoint           | Opis                  | Autoryzacja |
| ------ | ------------------ | --------------------- | ----------- |
| GET    | `/api/albums`      | Pobierz listę albumów | Nie         |
| GET    | `/api/albums/{id}` | Pobierz album po ID   | Nie         |
| POST   | `/api/add-album`   | Dodaj nowy album      | Nie         |

Przykład Request Body dla POST /api/add-album

```json
{
    "title": "string",
    "artist_id": 1,
    "release_date": "2025"
}
```

## Playlisty

| Metoda | Endpoint                          | Opis                        | Autoryzacja      |
| ------ | --------------------------------- | --------------------------- | ---------------- |
| GET    | `/api/playlists`                  | Pobierz listę playlist      | Nie              |
| POST   | `/api/add-new-playlist`           | Utwórz nową playlistę       | Tak              |
| POST   | `/api/playlists/{id}/add-song`    | Dodaj piosenkę do playlisty | Tak (właściciel) |
| POST   | `/api/playlists/{id}/delete-song` | Usuń piosenkę z playlisty   | Tak (właściciel) |

Przykład Request Body dla POST /api/add-new-playlist

```json
{
    "name": "string"
}
```

Przykład Request Body dla POST /api/playlists/{id}/add-song i /api/playlists/{id}/delete-song

```json
{
    "song_id": 1
}
```

Headers dla endpointów wymagających autoryzacji

Authorization: Bearer {token}

Możliwe odpowiedzi

    200 OK – operacja wykonana pomyślnie

    201 Created – zasób utworzony (np. nowa playlista)

    401 Unauthorized – brak autoryzacji (np. brak tokena lub nieprawidłowy)

    403 Forbidden – brak uprawnień (np. użytkownik nie jest właścicielem playlisty)

    422 Unprocessable Entity – błąd walidacji

Uwagi końcowe

    Wszystkie dane są przesyłane i zwracane w formacie JSON.

    Endpointy wymagające autoryzacji muszą zawierać nagłówek Authorization: Bearer {token}.

    W przypadku błędów walidacji, API zwraca status 422 i szczegóły błędów w odpowiedzi.
