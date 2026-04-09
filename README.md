# Laravel 11 Freelance Starter

A **production-ready, reusable starter template** for Laravel freelance projects. Clone this for every new client project — admin panels, CRM, CMS, approval workflows, inventory systems, and sales management tools.

## Stack

| Component | Version |
|---|---|
| Laravel | ^11.0 |
| Livewire | ^3.0 (class-based, NO Volt) |
| Auth | Laravel Breeze (Livewire stack) |
| CSS | Tailwind CSS via Vite |
| JS | Alpine.js (bundled with Livewire) |
| Icons | Heroicons via blade-heroicons |
| Database | MySQL (ULID primary keys) |
| Roles/Permissions | spatie/laravel-permission |
| API | Laravel Sanctum |
| Realtime | Laravel Reverb (installed, disabled by default) |
| Testing | PHPUnit |

## Requirements

- PHP 8.2+
- Composer 2.x
- Node.js 20+
- MySQL 8.x

## Installation

```bash
# Clone the repository
git clone <repo-url> my-project
cd my-project

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure .env
# - Set DB_DATABASE, DB_USERNAME, DB_PASSWORD
# - Set APP_NAME to your project name

# Create database
mysql -u root -e "CREATE DATABASE your_db_name"

# Run migrations and seed
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

## Default Credentials

| Field | Value |
|---|---|
| Email | `daffatgi02@gmail.com` |
| Password | `daffa123` |
| Role | super-admin |

## Environment Variables

| Variable | Default | Description |
|---|---|---|
| `APP_NAME` | Starter | Application name |
| `APP_TIMEZONE` | Asia/Jakarta | Server timezone (WIB) |
| `APP_LOCALE` | id | Application locale |
| `APP_FAKER_LOCALE` | id_ID | Faker locale for seeders |
| `DB_CONNECTION` | mysql | Database driver |
| `CACHE_STORE` | database | Cache driver |
| `QUEUE_CONNECTION` | database | Queue driver |
| `SESSION_DRIVER` | database | Session driver |
| `MAIL_MAILER` | log | Mail driver (change for production) |

## Folder Structure

```
app/
├── Enums/               # UserStatus, PermissionGroup
├── Helpers/             # Global helper functions
├── Http/
│   ├── Controllers/Api/ # API controllers (v1)
│   ├── Middleware/       # EnsureUserIsActive
│   └── Resources/       # API resources
├── Livewire/
│   ├── Base/            # Abstract base components
│   ├── Components/      # Global (FlashToast, ConfirmModal, GlobalSearch)
│   ├── Dashboard/       # Dashboard page
│   ├── Users/           # User CRUD pages
│   ├── Roles/           # Role management
│   ├── Settings/        # Settings management
│   ├── ActivityLogs/    # Activity log viewer
│   └── Profile/         # Profile editor
├── Models/              # User, Setting, ActivityLog, Media
├── Policies/            # UserPolicy
├── Providers/           # AppServiceProvider
├── Repositories/        # UserRepository + interface
├── Services/            # UserService, SettingService, ActivityLogService
└── Traits/
    ├── Livewire/        # HasFilters, HasSorting, HasBulkActions, HasToast, HasConfirmDelete
    └── Models/          # HasActivityLog

resources/views/
├── components/
│   ├── ui/              # x-ui.* (button, icon, badge, card, stat-card, etc.)
│   ├── form/            # x-form.* (input, select, textarea, checkbox, etc.)
│   └── table/           # x-table.* (sort-button, bulk-bar)
├── layouts/
│   ├── app.blade.php    # Authenticated layout
│   ├── guest.blade.php  # Auth pages layout
│   └── partials/        # sidebar, topbar, footer
└── livewire/            # Component views
```

## Creating a New Module

Follow these steps to create a new module:

### 1. Create the Livewire Component

```php
// app/Livewire/Products/ProductIndex.php
namespace App\Livewire\Products;

use App\Livewire\Base\BaseDataTable;

class ProductIndex extends BaseDataTable
{
    protected function getQuery(): Builder
    {
        return Product::query();
    }

    public function applyFilters(Builder $query): Builder
    {
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }
        return $query;
    }

    protected function getView(): string
    {
        return 'livewire.products.product-index';
    }

    protected function performDelete(string $id): void
    {
        Product::findOrFail($id)->delete();
        $this->dispatchSuccess('Product deleted.');
    }
}
```

### 2. Add Permissions to Seeder

```php
// In RolesAndPermissionsSeeder.php, add:
'view products', 'create products', 'edit products', 'delete products',
```

### 3. Add Route

```php
// In routes/web.php
Route::get('products', ProductIndex::class)->name('products.index');
```

### 4. Add Sidebar Link

```blade
<!-- In layouts/partials/sidebar.blade.php -->
@can('view products')
<a href="{{ route('products.index') }}" @class(['sidebar-link', 'active' => request()->routeIs('products.*')])>
    <x-ui.icon name="cube" size="sm" />
    <span>Products</span>
</a>
@endcan
```

## White-Label Checklist

When cloning for a new client:

1. Update `APP_NAME` in `.env`
2. Replace logo in `resources/views/layouts/partials/sidebar.blade.php`
3. Update primary color in `tailwind.config.js`
4. Update seed credentials in `database/seeders/DatabaseSeeder.php`
5. Run `npm run build` after color changes

## Available Artisan Commands

```bash
php artisan migrate:fresh --seed    # Reset DB + seed
php artisan test                    # Run test suite
php artisan reverb:start            # Start WebSocket server
php artisan queue:work              # Process queue
```

## Deploy to Ubuntu VPS (Nginx + PHP-FPM)

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/your-project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Code Quality Rules

1. All PHP files start with `<?php` + `declare(strict_types=1);`
2. All class properties have typed declarations
3. All methods have return type declarations
4. No `var_dump`, `dd`, `dump`, `print_r` in code
5. No commented-out code blocks
6. Service classes have no direct `request()` calls
7. Livewire components have no direct DB queries — use services/repositories
8. All user-facing strings in English
9. PSR-12 formatting throughout
10. Max 30 lines per method

## License

Private — Not for redistribution.
