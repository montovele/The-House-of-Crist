# The-House-of-Crist

The house of Christ is a page where each Brother can search for the Churches of the Lord depending on their location.

## Novedades

-   Laravel 8
-   Vue + VueRouter + Vuex
-   Login, register, update profile, map
-   password reset
-   Authentication with Sanctum
-   Tailwind + Heroicons

## Instalation

-   `git clone git@github.com:montovele/The-House-of-Crist.git`  set verion and app name 
-   `cd The-House-of-Crist`
-   Edit `.env` and set your database connection details and **your APP_URL** 
-   `php artisan key:generate`
-   `php artisan migrate`
-   `npm install`
-   `npm run dev`

### mailer 
-   set up mailer details
-   put **QUEUE_CONNECTION=database** 
## Notes
- make sure your domain is included in the statefull allowed domains (app/config/sanctum.php) to avoid [Unauthorised domains issue #3](/../../issues/3).

## Usage

#### Development

```bash
npm run watch

```

#### Production

```bash
npm run production
```
- turn off debug mode **.env**
##
