# api-proxy-php

A PHP API proxy (headless) project built using the Lumen framework.

## Description

This is a lightweight API proxy built with Lumen (Laravel micro-framework). It provides a simple REST API structure without database or view management.

## Requirements

- PHP 8.1 or higher
- Composer

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Luk-z/api-proxy-php.git
cd api-proxy-php
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

## Running the Application

Start the development server:
```bash
php -S localhost:8000 -t public
```

The application will be available at `http://localhost:8000`.

## API Endpoints

### Root Endpoint
```
GET /
```
Returns the Lumen version information.

### Hello World Endpoint
```
GET /hello
```
Returns a simple JSON response:
```json
{
  "message": "Hello World!"
}
```

## Project Structure

```
.
├── app/
│   ├── Console/           # Console commands
│   ├── Exceptions/        # Exception handlers
│   └── Http/
│       └── Controllers/   # API controllers
├── bootstrap/             # Framework bootstrap
├── public/                # Public web root
├── routes/                # Route definitions
└── storage/               # Logs and cache
```

## License

This project is open-sourced software licensed under the MIT license.

