# URL shortener system

A few notes
------------

- Installed scribe to provide quick and easy documentation
- Duplicate URL shortening requests will not create duplicate data
- Data has been stored in a local database to allow for long term use. Using memory would see the shortened URL expire if it were to be used.
- Unit tests have been implemented for individual methods and API endpoints. I have used Github workflows/actions to automatically run unit tests on every deployment

Installation
------------
1. Clone respository


2. Copy the example environment file

```env
cp .env.example .env
```

3. Install dependencies

```bash
npm install && npm run build
```

3. (OPTIONAL) Run the unit tests

```bash
php artisan test
```

4. Run database migrations (can be run as many times as you want)

```bash
php artisan migrate:fresh --seed
```

5. Generate the API documentation

```bash
php artisan scribe:generate
```

6. Start the local server

```bash
composer run dev
```

7. Use the software

The route URL will be displayed in the previous step, but if it sticks with the default, the following routes will work.

| URL                           | Function |
|-------------------------------| --- | 
| http://127.0.0.1:8000/docs    | Navigate in your browser to view the API documentation |
| http://127.0.0.1:8000/encode  | Submit the long/original url to return a json object with the shortened URL |
|  http://127.0.0.1:8000/decode | Submit the shortened url to return a json object with the original and shorted URL |


