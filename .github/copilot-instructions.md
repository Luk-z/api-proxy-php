# GitHub Copilot Instructions for api-proxy-php

## Project Overview

This is a PHP API proxy (headless) project built using the Lumen framework (Laravel micro-framework). It provides a lightweight REST API structure without database or view management.

## Technology Stack

- **Framework**: Lumen 8.x (Laravel micro-framework)
- **Language**: PHP 7.3+ or PHP 8.0+
- **Dependency Manager**: Composer

## Coding Standards

This project strictly follows **PSR-12** coding standards. All code must adhere to these standards.

### Code Quality Tools

- **PHP_CodeSniffer (PHPCS)**: For detecting coding standard violations
- **PHP CS Fixer**: For automatic code formatting
- **PHPUnit**: For unit and integration testing

### Linting and Formatting Commands

Always run these commands before committing code:

```bash
# Check for coding standard violations
composer lint

# Automatically fix coding standard violations
composer lint:fix

# Format code using PHP CS Fixer
composer format

# Check what PHP CS Fixer would change (dry run)
composer format:check
```

## Testing

This project uses PHPUnit for testing.

```bash
# Run all tests
composer test

# Run tests with coverage
./vendor/bin/phpunit --coverage-html coverage
```

All tests are located in the `tests/` directory and must follow PSR-12 coding standards.

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

## Development Workflow

### Setup

1. Install dependencies:
   ```bash
   composer install
   ```

2. Copy environment file:
   ```bash
   cp .env.example .env
   ```

3. Start development server:
   ```bash
   php -S localhost:8000 -t public
   ```

### Code Quality Checks

Before committing:
1. Run linter: `composer lint`
2. Fix violations: `composer lint:fix` or `composer format`
3. Run tests: `composer test`

## Best Practices

### When Writing Code

1. **Follow PSR-12**: All code must conform to PSR-12 standards
2. **Type Hints**: Use type hints for function parameters and return types
3. **Dependency Injection**: Use Lumen's dependency injection container
4. **Controller Structure**: Keep controllers thin, delegate business logic to services
5. **Route Definitions**: All routes should be defined in `routes/web.php`

### When Writing Tests

1. **Test Location**: Place tests in `tests/` directory
2. **Naming Convention**: Test classes should end with `Test` (e.g., `ExampleTest.php`)
3. **Test Methods**: Prefix test methods with `test` (e.g., `testBasicExample()`)
4. **Follow PSR-12**: Test code must also follow PSR-12 standards

### When Adding Dependencies

1. Use Composer to add dependencies: `composer require package/name`
2. For dev dependencies: `composer require --dev package/name`
3. Ensure compatibility with PHP 7.3+ and PHP 8.0+

## Configuration Files

- `phpcs.xml` - PHP_CodeSniffer configuration
- `.php-cs-fixer.php` - PHP CS Fixer configuration
- `phpunit.xml` - PHPUnit configuration
- `composer.json` - Project dependencies and scripts

## API Conventions

### Response Format

- Use JSON for all API responses
- Return appropriate HTTP status codes
- Structure responses consistently

### Error Handling

- Use appropriate exception handlers in `app/Exceptions/Handler.php`
- Return meaningful error messages in JSON format

## Notes

- This is a headless API proxy - no views or frontend components
- No database management in this project
- Focus on REST API functionality
- Keep the project lightweight and minimal
