# E-commerce Management System

## Overview

This project is a basic e-commerce management system built with Laravel (backend) and Vue.js (frontend admin panel). It includes user management, product management, cart & checkout, order management, and content management (CMS).

## Setup Instructions

1. Clone the repository.

2. Install dependencies:

```bash
composer install
npm install
```

3. Configure your `.env` file with database and other settings.

4. Run migrations:

```bash
php artisan migrate
```

5. Serve the application:

```bash
php artisan serve
```

6. Build frontend assets:

```bash
npm run dev
```

## Running Tests

To run all tests (unit and feature):

```bash
php artisan test
```

or

```bash
vendor/bin/phpunit
```

## API Documentation

A Postman collection is provided in the `postman_collection.json` file (or link to public collection).

Import it into Postman to test the API endpoints.

## Features

- User registration, login, profile management with Laravel Sanctum authentication.
- Product management (admin only) with CRUD operations.
- Cart management: add/remove products, view cart.
- Order management: place orders, view order history, admin order status updates.
- CMS management: create/edit/archive content pages with banner images and links.
- Unit tests for Eloquent models.
- Feature tests for product creation and order checkout.

## Notes

- Admin authorization is simplified; consider adding roles and permissions for production.
- Frontend Vue.js admin panel to be implemented separately.
