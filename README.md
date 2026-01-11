# api-proxy-php

A PHP API proxy (headless) project built using the Lumen framework.

This is a lightweight API proxy built with Lumen (Laravel micro-framework). It provides a simple REST API structure without database or view management.

## Usage in applications

1. Install as dependency
```bash
composer require luk-z/api-proxy-php
```


2. Copy the environment file:
```bash
cp .env.example .env
```

### Required `define`

In order to work the following php define should be defined:
- APP_TABLE_APPS

These php defined are optional
- APP_ADD_DEFAULT_ROUTES
- APP_CUSTOM_INCLUDES_PATH
- APP_CUSTOM_ROUTES_PATH

## Requirements

- PHP 7.3 or higher
- Composer

## Development

### Setup local machine

To install dependencies php 7.3+ and composer are needed. Instead installing them in the local machine use a dockerized composer (requires Docker Desktop).

Create `php` and `composer` aliases following [this guide](https://github.com/Luk-z/dockerized-composer).

1. Clone the repository:
```bash
git clone https://github.com/Luk-z/api-proxy-php.git project_name && rm -rf ./project_name/.git
cd project_name
```

2. Install suggested vscode extensions

3. Copy the `php-cs-fixer-wrapper.sh` file:
```bash
cp php-cs-fixer-wrapper.sh.example php-cs-fixer-wrapper.sh
```
change `WORKSPACE_ROOT="<absolute path to your workspace>"` inserting the application absolute path (use `pwd` command to obtain absolute path)

4. Install dependencies:
```bash
composer install
```

### Running the Application

Start the development server:
```bash
php -S localhost:8000 -t public
```

The application will be available at `http://localhost:8000`.

## Development Tools

### Code Quality and Formatting

This project includes PHP linting and formatting tools that work seamlessly with Visual Studio Code.

#### Tools Included

- **PHP_CodeSniffer (PHPCS)**: Linter for detecting coding standard violations (PSR-12)
- **PHP CS Fixer**: Automatic code formatter
- **PHPUnit**: Testing framework for unit and integration tests

#### Visual Studio Code Setup

1. Install the recommended extensions when prompted, or manually install:
   - PHP CS Fixer (`junstyle.php-cs-fixer`)
   - PHP_CodeSniffer (`ikappas.phpcs`)
   - PHP Intelephense (`bmewburn.vscode-intelephense-client`)

2. The workspace settings (`.vscode/settings.json`) are pre-configured to:
   - Enable format on save
   - Run PHP CS Fixer automatically
   - Show PHPCS violations in real-time

#### Command Line Usage

Check for coding standard violations:
```bash
composer lint
```

Automatically fix coding standard violations:
```bash
composer lint:fix
```

Format code using PHP CS Fixer:
```bash
composer format
```

Check what PHP CS Fixer would change (dry run):
```bash
composer format:check
```

#### Configuration Files

- `phpcs.xml` - PHP_CodeSniffer configuration (PSR-12 standard)
- `.php-cs-fixer.php` - PHP CS Fixer configuration
- `phpunit.xml` - PHPUnit configuration
- `.vscode/settings.json` - VS Code workspace settings
- `.vscode/extensions.json` - Recommended VS Code extensions

### Testing

This project uses PHPUnit for testing.

Run all tests:
```bash
composer test
```

Run tests with coverage:
```bash
./vendor/bin/phpunit --coverage-html coverage
```

Tests are located in the `tests/` directory and follow the PSR-12 coding standard.

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

