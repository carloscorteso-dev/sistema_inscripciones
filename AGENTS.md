# Sistema UBBJ - AI Agent Instructions

## Project Overview

**Sistema UBBJ** is a Laravel 13.7 educational management system built with modern PHP and frontend tooling. It manages university student enrollments, academic programs (careers), generation cohorts, and academic cycles.

**Tech Stack:**
- Laravel 13.7 | PHP 8.3 | Eloquent ORM
- Blade templates | Tailwind CSS | Alpine.js
- MySQL/SQLite for database
- Vite for asset bundling
- Pest for testing
- Laravel Breeze for authentication

## Domain Models

The application uses a hierarchical entity structure:

```
Carrera (Career/Program)
  ├─ Generacion (Generation/Cohort) 
  │   └─ Ciclo (Academic Cycle)
  └─ Alumno (Student)
       └─ Inscripcion (Enrollment)

User (Authentication)
AjusteSistema (System Settings)
```

**Key Entities:**
- **Carrera**: Academic program/degree (e.g., "Licenciatura en Medicina")
- **Generacion**: Student cohort within a career (e.g., "GENERATION 2026-2")
- **Ciclo**: Academic cycle/semester within a generation
- **Alumno**: Student with personal and contact information
- **Inscripcion**: Student enrollment in a specific cycle
- **AjusteSistema**: System-wide configuration (logo, contact info)

## Development Commands

### Setup
```bash
composer install
php artisan key:generate
php artisan migrate
npm install
```

### Development Server
```bash
composer run dev
# Runs: php artisan serve + queue:listen + pail + npm run dev (concurrently)
```

### Build & Testing
```bash
npm run build           # Build frontend assets
php artisan test        # Run Pest tests
php artisan pint        # Code style fixer
```

### Database
```bash
php artisan migrate                # Run migrations
php artisan migrate:rollback       # Rollback latest batch
php artisan seed                   # Seed database with sample data
php artisan tinker                 # Interactive shell
```

## Project Structure

```
app/
  Http/Controllers/     # Request handlers (AjusteSistema, Carrera, etc.)
  Http/Requests/        # Form validation classes
  Models/               # Eloquent models (Alumno, Carrera, Ciclo, etc.)
  Providers/            # Service providers

database/
  migrations/           # Schema definitions for entities
  seeders/             # Sample data (DatabaseSeeder.php)

resources/views/
  layouts/admin.blade.php    # Main admin template (Bootstrap)
  admin/                     # Admin pages for each entity

routes/
  web.php               # Admin routes (all protected by 'auth' middleware)
  auth.php              # Authentication routes (Laravel Breeze)

config/
  database.php          # Database connection settings
  auth.php              # Authentication configuration
```

## Core Routes

All admin routes require authentication (`middleware('auth')`):

| Route | Controller | Purpose |
|-------|-----------|---------|
| `/` | Admin index | Dashboard (auth required) |
| `/admin/carreras` | CarreraController | List careers |
| `/admin/generaciones` | GeneracionController | Create/edit generations |
| `/admin/ciclos` | CicloController | Manage cycles (full CRUD) |
| `/admin/inscripciones` | InscripcionController | View student enrollments |
| `/admin/ajuste_sistema` | AjusteSistemaController | System settings |
| `/profile` | ProfileController | User profile management |

## Common Development Patterns

### Creating New Features

1. **Model with relationships** → Create in `app/Models/`
2. **Migration** → Create in `database/migrations/`
3. **Controller** → Create in `app/Http/Controllers/`
4. **Routes** → Add to `routes/web.php` with `middleware('auth')`
5. **Blade views** → Add to `resources/views/admin/`

### Database Operations
- Use **Eloquent relationships** (belongsTo, hasMany, etc.) defined in models
- Queries use method chaining: `Model::with('relation')->get()`
- Validation via `$request->validate()` in controllers
- Mass assignment: models use `$fillable` for security

### View Rendering
- Layout extends `@extends('layouts.admin')`
- Admin template uses **Bootstrap 5** + Alpine.js for interactivity
- Flash messages with `with('mensaje', 'text')->with('icono', 'success/error')`

## Important Conventions

- **Naming**: Controllers use singular entity names (`CarreraController` for `Carrera` model)
- **Routes**: All admin routes under `/admin/` prefix, followed by entity plural
- **Relationships**: Foreign keys are `{model}_id` in snake_case
- **Validation**: Validate in controller before saving; use `|exists:table,column` for FK validation
- **Redirects**: After create/update, redirect to index with success message

## Known Issues & Quirks

1. **CicloController typo**: `Genaracion` is misspelled (should be `Generacion`) - not used but present
2. **Model relationships incomplete**: Some models missing inverse relationships
3. **Forms with searches**: InscripcionController searches students by name/folio
4. **Image handling**: AjusteSistemaController manages logo uploads to `storage/public/logos`
5. **Database constraint**: Ciclo→Generacion is 1:1 (one cycle per generation, enforced by view logic)

## Before Starting Any Task

1. **Run migrations** if database hasn't been set up: `php artisan migrate`
2. **Seed sample data** if needed: `php artisan seed`
3. **Start dev server** for testing: `composer run dev`
4. **Check authentication** - all `/admin/*` routes require login (test user: `test@example.com` / `12345678`)

## File I'm Likely to Edit

- `app/Http/Controllers/*` - Most business logic
- `database/migrations/*` - Schema changes
- `resources/views/admin/*` - UI updates
- `app/Models/*` - Data relationships
- `routes/web.php` - Routing changes

---

*Generated for AI agents working on Sistema UBBJ. Use this context to understand the domain, architecture, and development workflow.*
