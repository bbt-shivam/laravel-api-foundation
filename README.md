# A secure, auditable, scalable Laravel 11 API foundation

This is a Laravel backend application.

---

## 🧪 Code Quality & Testing

This project uses modern Laravel tooling for testing, code style, static analysis, and security checks.

---

## 📋 Prerequisites

- PHP 8.1+
- Composer
- Node.js & npm

---

## ▶ Running Tests (Pest)

Run the full test suite:

```bash
php artisan test
```

Run a specific test file or directory:

```bash
vendor/bin/pest tests/Feature
```

---

## 🧹 Code Style (Laravel Pint)

Automatically fix code style issues:

```bash
vendor/bin/pint
```

Check code style without modifying files (CI-safe):

```bash
vendor/bin/pint --test
```

---

## 🔍 Static Analysis (PHPStan + Larastan)

Run static analysis on the application code:

```bash
vendor/bin/phpstan analyse app
```

PHPStan is configured using `phpstan.neon` and includes Laravel-specific rules via Larastan.

---

## ✅ Recommended Local Workflow

Before committing code, run:

```bash
vendor/bin/pint
php artisan test
vendor/bin/phpstan analyse app
```

Run a full quality check:

```bash
vendor/bin/pint --test
vendor/bin/phpstan analyse app
vendor/bin/paratest
```

---

## 🔐 Security

Check for known dependency vulnerabilities:

```bash
composer audit
```

It is recommended to run this regularly and in CI pipelines.

---

## 📦 Frontend Assets

Install frontend dependencies:

```bash
npm install
```

Build frontend assets:

```bash
npm run build
```

Run the Vite development server:

```bash
npm run dev
```

---

## 🚀 Development Server

Start the Laravel development server:

```bash
php artisan serve
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).