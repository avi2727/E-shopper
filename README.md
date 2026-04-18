# E-Shopper Project

This repository contains the full stack E-Shopper application, consisting of an Angular frontend and a Laravel backend.

## Project Structure

- **/frontend**: Angular application.
- **/backend**: Laravel application.

## Getting Started

### 1. Prerequisite
- PHP >= 7.3
- Composer
- Node.js & NPM
- MySQL (XAMPP recommended)

### 2. Backend Setup (Laravel)
1. Navigate to the `backend` directory:
   ```bash
   cd backend
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Create a `.env` file and configure your database settings:
   ```bash
   cp .env.example .env
   ```
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations (ensure your database is created):
   ```bash
   php artisan migrate
   ```
6. Start the Laravel server:
   ```bash
   php artisan serve
   ```

### 3. Frontend Setup (Angular)
1. Navigate to the `frontend` directory:
   ```bash
   cd frontend
   ```
2. Install NPM dependencies:
   ```bash
   npm install
   ```
3. Start the Angular development server:
   ```bash
   npm start
   ```

## Branches
- `master`: Stable production-ready code.
- `development`: Active development branch.
