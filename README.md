# E-Shopper 🛍️
**A Modern Full-Stack E-Commerce Solution built with Laravel 8 and Angular 16.**

E-Shopper is a professionally architected e-commerce platform designed for scalability, performance, and type safety. It features a robust Laravel backend with a decoupled service-layer architecture and a strictly typed Angular frontend.

---

## 🚀 Key Features

### Backend (Laravel)
- **Professional Architecture**: Implemented a dedicated **Service Layer** to encapsulate business logic and **API Resources** for standardized JSON responses.
- **Eloquent Optimization**: Advanced use of **Eloquent Scopes** for clean, reusable database queries (e.g., Trendy Products, Just Arrived).
- **Robust Validation**: Standardized data integrity using Laravel **Form Requests** and manual Facade validation for complex checkout flows.
- **Relational Integrity**: Managing complex relationships between Products, Categories, Cart Items, and Orders.

### Frontend (Angular)
- **Strictly Typed**: Fully implemented **TypeScript Interfaces** for all core entities (Products, User, CartItems) to prevent runtime errors.
- **Dynamic Homepage**: High-performance landing page with smart loading for featured categories and trendy products.
- **Seamless Checkout**: A secure, multi-step-ready checkout flow with real-time field validation and cart synchronization.
- **Responsive Design**: Premium aesthetics optimized for both desktop and mobile shoppers.

---

## 🛠️ Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Frontend** | Angular, RxJS, Bootstrap, FontAwesome |
| **Backend** | Laravel (PHP), Eloquent ORM |
| **Database** | MySQL |
| **Security** | Laravel Session/Token Auth |

---

## 📂 Project Structure

```bash
├── frontend      # Angular application root
│   └── src/app   # Core logic, components, and services
└── backend       # Laravel application root
    ├── app       # Models, Services, and Controllers
    ├── database  # Migrations and Seeders
    └── routes    # API and Web routings
```

---

## ⚙️ Getting Started

### 1. Prerequisites
- PHP >= 8.1 (Laravel compatible)
- Node.js >= 16.x & NPM
- Composer
- MySQL (XAMPP/WAMP recommended)

### 2. Backend Installation (Laravel)
```bash
cd backend
composer install
cp .env.example .env      # Configure your DB_DATABASE in .env
php artisan key:generate
php artisan migrate       # Set up the database schema
php artisan serve         # Start at http://127.0.0.1:8000
```

### 3. Frontend Installation (Angular)
```bash
cd frontend
npm install
npm start                 # Start at http://localhost:4200
```

---

## 👨‍💻 Designed By
Designed and Developed by **Avinash Shukla**. 
*Modernized and Architected during the Professional Refactoring Phase (2026).*

---
*This project is part of a professional transformation to demonstrate high-level full-stack engineering principles.*
