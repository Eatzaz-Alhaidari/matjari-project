# Copilot Instructions for E-Store Laravel Project

## Architecture Overview
This is a Laravel 12-based e-commerce API application with the following key components:
- **Authentication**: Laravel Sanctum for API token-based auth
- **Authorization**: Spatie Laravel Permission for roles and permissions
- **Frontend**: Vite + Tailwind CSS + Alpine.js for reactive UI
- **Database**: MySQL with Eloquent ORM, migrations for schema management

## Core Data Model
- `User` has roles (via Spatie) and owns one `Store`
- `Store` belongs to `User`, has many `Product`s
- `Product` belongs to `Store` and `Category`
- Relationships enforced via foreign keys in migrations (e.g., `store_id`, `category_id`)

## API Structure
- Controllers in `App\Http\Controllers\API\` namespace
- JSON responses via API Resources (e.g., `ProductResource`)
- Routes defined in `routes/api.php` with Sanctum middleware

## Development Workflows
- **Setup**: Run `composer run setup` for initial install, env copy, key gen, migrate, npm install/build
- **Development**: Use `composer run dev` for concurrent processes (server on :8000, queue listener, logs tail, Vite dev server)
- **Testing**: Pest framework in `tests/` directory
- **Migrations**: Use `php artisan migrate` after schema changes

## Key Conventions
- Models use standard Laravel fillable/hidden/casts arrays
- Arabic comments in seeders (e.g., `ComplaintSeeder`)
- Status enums: 'open', 'in_progress', 'closed' for complaints
- Slugs for stores (unique in DB)
- Decimal prices with 8,2 precision

## Common Patterns
- API controllers return Resource collections: `return ProductResource::collection($products);`
- User factory for seeding test data
- Permission tables auto-created via Spatie migration

## File Locations
- Models: `app/Models/`
- Migrations: `database/migrations/` (check foreign key constraints)
- API routes: `routes/api.php`
- Resources: `app/Http/Resources/`
- Config: `config/permission.php` for Spatie settings