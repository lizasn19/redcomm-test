# Book & Author Management System

A full-stack web application for managing books and authors built with Laravel 11, Supabase PostgreSQL, Nuxt 3, and Tailwind CSS.

## Features
- **Authors**: Create, read, update, and delete authors.
- **Books**: Create, read, update, and delete books (linked to authors).
- **RESTful API**: Built with Laravel 11 with resource controllers.
- **Modern UI**: Built with Nuxt 3 and Tailwind CSS.
- **Pagination & Caching**: Efficient data loading for large datasets.

## Requirements
- PHP >= 8.2 (with SQLite extension enabled)
- Composer
- Node.js >= 18
- npm or yarn

## Backend Setup (Laravel)
1. Navigate to the backend directory:
   `cd backend`
2. Install dependencies:
   `composer install`
3. Copy `.env` file:
   `cp .env.example .env`
4. Set database connection to Supabase PostgreSQL in `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres.qouhgmvhxyrgsdrrxawe
   DB_PASSWORD=jJJm9jMDBJUtJbLz

   SUPABASE_URL=https://qouhgmvhxyrgsdrrxawe.supabase.co
   SUPABASE_PUBLISHABLE_KEY=sb_publishable_niDhyNa8dw1dfborOUMD0w_8lMj8_3u
   SUPABASE_SECRET_KEY=sb_secret_OpYlsj9VXNC5Kedw2-pXOQ_CTVfU***
   SUPABASE_JWKS_URL=https://qouhgmvhxyrgsdrrxawe.supabase.co/auth/v1/.well-known/jwks.json
   ```
5. Run migrations:
   `php artisan migrate`
6. Start the backend server:
   `php artisan serve` (Runs on `http://localhost:8000`)

## Frontend Setup (Nuxt 3)
1. Navigate to the frontend directory:
   `cd frontend`
2. Install dependencies:
   `npm install`
3. Configure API base URL in `nuxt.config.ts` if needed (default is `http://localhost:8000/api`).
4. Start the development server:
   `npm run dev` (Runs on `http://localhost:3000`)

## API Endpoints
- `GET /api/authors` - List all authors (paginated)
- `POST /api/authors` - Create an author
- `GET /api/authors/{id}` - Get an author
- `PUT /api/authors/{id}` - Update an author
- `DELETE /api/authors/{id}` - Delete an author

- `GET /api/books` - List all books (paginated)
- `POST /api/books` - Create a book
- `GET /api/books/{id}` - Get a book
- `PUT /api/books/{id}` - Update a book
- `DELETE /api/books/{id}` - Delete a book
