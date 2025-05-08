# Fagnoon Trip & Birthday Reservation System

This package contains the source code for the Fagnoon Trip & Birthday Reservation System, including the Laravel backend and the React frontend.

## Project Structure

-   `fagnoon_backend/`: Contains the Laravel backend application.
-   `fagnoon_frontend/`: Contains the React frontend application (source in `src/`, production build in `dist/`).
-   `database/`: The SQLite database file (`database.sqlite`) is located within `fagnoon_backend/database/`.

## Backend Setup (Laravel)

1.  **Environment Configuration:**
    *   Navigate to the `fagnoon_backend` directory.
    *   Copy `.env.example` to `.env` if it doesn't exist.
    *   Ensure the `.env` file is configured for your environment. Key settings:
        *   `APP_URL`: The public URL where your backend will be hosted.
        *   `DB_CONNECTION=sqlite` (this is pre-configured)
        *   `DB_DATABASE`: Should point to the absolute path of `database/database.sqlite` within the backend directory if you move it, or ensure it's correctly pathed if Replit handles SQLite differently.
        *   `SANCTUM_STATEFUL_DOMAINS`: Add the domain of your frontend application (e.g., `your-frontend-replit-url.repl.co`).
        *   `SESSION_DOMAIN`: Set to your base domain if using subdomains (e.g., `.repl.co`).
2.  **Dependencies:**
    *   Ensure PHP (compatible with Laravel 10/11), Composer, and relevant PHP extensions (sqlite3, mbstring, xml, curl) are installed.
    *   Run `composer install` in the `fagnoon_backend` directory.
3.  **Application Key:**
    *   Run `php artisan key:generate`.
4.  **Database Migrations & Seeding:**
    *   The provided `database.sqlite` should contain all tables and seeded data.
    *   If you need to reset or re-migrate: `php artisan migrate:fresh --seed`.
    *   Admin credentials (seeded): `admin@fagnoon.app` / `password`.
5.  **Storage Link:**
    *   Run `php artisan storage:link` (may not be applicable or work differently on Replit).
6.  **Running the Server:**
    *   Typically `php artisan serve --host=0.0.0.0 --port=8000` (Replit might handle port assignment automatically).

## Frontend Setup (React + Vite)

1.  **Environment Configuration:**
    *   Navigate to the `fagnoon_frontend` directory.
    *   Create a `.env` file.
    *   Add `REACT_APP_API_URL=your_backend_api_public_url` (e.g., `https://your-backend-replit-url.repl.co/api`).
2.  **Dependencies:**
    *   Ensure Node.js and npm are installed.
    *   Run `npm install` in the `fagnoon_frontend` directory.
3.  **Running the Development Server (for further development on Replit):**
    *   `npm run dev` (Replit might handle this via its run command).
    *   Ensure `vite.config.js` has `server.host = '0.0.0.0'` and `server.allowedHosts` includes your Replit frontend URL if issues arise.
4.  **Serving the Production Build:**
    *   The `fagnoon_frontend/dist` directory contains the production build.
    *   You can serve these static files using any static file server. Replit often has built-in ways to serve static sites or the output of a build process.

## CORS Configuration (Backend)

*   The backend CORS configuration is in `fagnoon_backend/config/cors.php`.
*   Ensure `paths` includes `api/*`.
*   `allowed_origins` should include the URL of your frontend application on Replit (e.g., `https://your-frontend-replit-url.repl.co`).
*   `supports_credentials` should be `true` if you rely on cookie-based sessions with Sanctum for SPA authentication.

## Important Notes for Replit Deployment

*   **Persistent Storage:** Ensure SQLite database changes are persisted. Replit's file system behavior might require specific configurations.
*   **Public URLs:** Replit provides public URLs for running applications. Use these in your `.env` files and CORS settings.
*   **Background Workers/Queues:** If any features rely on Laravel queues (not explicitly implemented in this phase but good to note for future), Replit's background worker support would be needed.
*   **HTTPS:** Replit typically provides HTTPS. Ensure all your URLs use `https://`.

This guide should help you get started with deploying the application on Replit. Good luck!

Triggering workflows.
