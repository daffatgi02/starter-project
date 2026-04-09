# Laravel 11 Freelance Starter — Complete Technical Documentation

> **Purpose**: This document is the definitive reference for the entire codebase. When starting a new client project, read this to quickly find reusable components, services, traits, and patterns you need.

---

## Table of Contents

1. [Technology Stack](#1-technology-stack)
2. [Architecture Overview](#2-architecture-overview)
3. [Design System (CSS)](#3-design-system-css)
4. [Icon System](#4-icon-system)
5. [Database & Models](#5-database--models)
6. [Enums](#6-enums)
7. [Repository Pattern](#7-repository-pattern)
8. [Service Layer](#8-service-layer)
9. [Reusable Traits — Livewire](#9-reusable-traits--livewire)
10. [Reusable Traits — Models](#10-reusable-traits--models)
11. [Base Livewire Classes](#11-base-livewire-classes)
12. [Blade UI Components (x-ui.*)](#12-blade-ui-components-x-ui)
13. [Blade Form Components (x-form.*)](#13-blade-form-components-x-form)
14. [Blade Table Components (x-table.*)](#14-blade-table-components-x-table)
15. [Global Livewire Components](#15-global-livewire-components)
16. [Layouts](#16-layouts)
17. [Module: Dashboard](#17-module-dashboard)
18. [Module: User Management](#18-module-user-management)
19. [Module: Roles & Permissions](#19-module-roles--permissions)
20. [Module: Settings](#20-module-settings)
21. [Module: Activity Logs](#21-module-activity-logs)
22. [Module: Profile](#22-module-profile)
23. [API Layer](#23-api-layer)
24. [Middleware](#24-middleware)
25. [Authorization (Policy)](#25-authorization-policy)
26. [Roles & Permissions Seed Data](#26-roles--permissions-seed-data)
27. [Global Helpers](#27-global-helpers)
28. [Configuration](#28-configuration)
29. [Testing](#29-testing)
30. [How to Create a New Module](#30-how-to-create-a-new-module)
31. [White-Label Checklist](#31-white-label-checklist)
32. [Full File Map](#32-full-file-map)

---

## 1. Technology Stack

| Component | Package | Version |
|---|---|---|
| Framework | `laravel/laravel` | ^11.0 |
| Livewire | `livewire/livewire` | ^3.0 (class-based only, NO Volt) |
| Auth scaffold | `laravel/breeze` | Livewire stack |
| CSS | Tailwind CSS | via Vite |
| JS | Alpine.js | bundled with Livewire |
| Icons | `blade-ui-kit/blade-heroicons` | ^2.7 |
| Roles | `spatie/laravel-permission` | ^6.25 |
| API tokens | `laravel/sanctum` | ^4.3 |
| Realtime | `laravel/reverb` | ^1.10 (installed, not active) |
| Database | MySQL | ULID primary keys |
| PHP | | ^8.3 |
| Font | Inter | via Bunny Fonts CDN |

**NOT used**: Redis, Inertia, Vue, React, Volt, Spatie Media Library, Horizon, Telescope, S3, dark mode.

---

## 2. Architecture Overview

```
Request → Middleware → Route → Livewire Component → Service → Repository → Model → DB
                                        ↓
                                   Blade View (uses x-ui.*, x-form.*, x-table.*)
```

**Key principles**:
- **Livewire components never touch DB directly** — they call Services
- **Services handle business logic** — password hashing, role syncing, avatar uploads
- **Repositories handle data access** — CRUD operations on models
- **Traits provide reusable behavior** — filters, sorting, bulk actions, toasts
- **Base classes enforce patterns** — BaseDataTable, BaseForm, BaseModal
- **Blade components provide reusable UI** — buttons, badges, cards, modals, forms

---

## 3. Design System (CSS)

**File**: `resources/css/app.css`

All reusable CSS classes are defined in Tailwind `@layer components`:

### Buttons

| Class | Usage |
|---|---|
| `.btn-primary` | Sky-600 background, white text, rounded-lg, shadow, hover/focus states |
| `.btn-secondary` | White background, slate border ring, slate text |
| `.btn-danger` | Red-600 background, white text |
| `.btn-ghost` | Transparent, slate text, hover:bg-slate-100 |

### Form Elements

| Class | Usage |
|---|---|
| `.form-label` | `text-sm font-medium text-slate-700 mb-1` |
| `.form-input` | Full-width rounded input with slate border, primary focus ring |
| `.form-input-error` | Same as form-input but with red border and red focus ring |

### Badge Colors

| Class | Color |
|---|---|
| `.badge-green` | Green pill badge (success, active) |
| `.badge-red` | Red pill badge (error, suspended) |
| `.badge-yellow` | Yellow pill badge (warning, pending) |
| `.badge-blue` | Blue pill badge (info) |
| `.badge-gray` | Gray pill badge (default, inactive) |
| `.badge-purple` | Purple pill badge (special) |

### Sidebar

| Class | Usage |
|---|---|
| `.sidebar-link` | Nav item: flex, gap-3, rounded-lg, slate-600, hover states |
| `.sidebar-link.active` | Active nav: primary-50 bg, primary-700 text |

### Primary Color Palette (Sky)

```
primary-50:  #f0f9ff    primary-500: #0ea5e9
primary-100: #e0f2fe    primary-600: #0284c7
primary-200: #bae6fd    primary-700: #0369a1
primary-300: #7dd3fc    primary-800: #075985
primary-400: #38bdf8    primary-900: #0c4a6e
```

**How to rebrand**: Change color values in `tailwind.config.js` → `theme.extend.colors.primary`, then `npm run build`.

---

## 4. Icon System

**Package**: `blade-ui-kit/blade-heroicons`

**Wrapper component**: `<x-ui.icon>`

**CRITICAL RULE**: No emojis anywhere. All icons use Heroicons.

### Usage

```blade
{{-- Via wrapper (recommended) --}}
<x-ui.icon name="users" />
<x-ui.icon name="users" style="solid" />
<x-ui.icon name="users" size="xs" />
<x-ui.icon name="users" size="sm" />
<x-ui.icon name="users" size="lg" />
<x-ui.icon name="users" class="text-primary-600" />

{{-- Direct Heroicon (also works) --}}
<x-heroicon-o-users class="w-5 h-5" />    {{-- outline --}}
<x-heroicon-s-users class="w-5 h-5" />    {{-- solid --}}
```

### Size Map

| Size | Class | Pixels |
|---|---|---|
| `xs` | `w-3.5 h-3.5` | 14px |
| `sm` | `w-4 h-4` | 16px |
| `md` (default) | `w-5 h-5` | 20px |
| `lg` | `w-6 h-6` | 24px |

### Where Icons Are Used

- Sidebar menu items
- Action buttons (create, edit, delete)
- Status badges
- Empty state illustrations
- Toast notifications (success, error, warning, info)
- Breadcrumb separators
- Table sort indicators
- Modal close buttons
- Stat card icons
- File upload button
- Dropdown triggers

**Icon reference**: https://heroicons.com — search by name, use kebab-case.

---

## 5. Database & Models

### All Tables Use ULID Primary Keys

Every table uses `$table->ulid('id')->primary()` instead of auto-increment. Related foreign keys use `string(26)`.

### Tables

| Table | Model | Traits | Soft Delete |
|---|---|---|---|
| `users` | `User` | HasUlids, SoftDeletes, HasRoles, HasApiTokens, HasActivityLog | Yes |
| `settings` | `Setting` | HasUlids | No |
| `activity_logs` | `ActivityLog` | HasUlids | No |
| `media` | `Media` | HasUlids, SoftDeletes | Yes |
| `roles` | (Spatie) | — | No |
| `permissions` | (Spatie) | — | No |
| `sessions` | — | — | No |
| `cache` | — | — | No |
| `jobs` | — | — | No |
| `personal_access_tokens` | — | ulidMorphs | No |

### User Model

**File**: `app/Models/User.php`

```php
// Fillable
'name', 'email', 'password', 'avatar', 'status', 'last_login_at'

// Casts
'email_verified_at' => 'datetime'
'last_login_at'     => 'datetime'
'password'          => 'hashed'
'status'            => UserStatus::class   // Enum cast

// Logged attributes (for HasActivityLog)
$logAttributes = ['name', 'email', 'status']

// Relations
activityLogs(): HasMany → ActivityLog
media(): MorphMany → Media
roles(): BelongsToMany → Role  (via Spatie)
```

### Setting Model

**File**: `app/Models/Setting.php`

```php
// Fillable
'key', 'value', 'type', 'group', 'label'

// Static helpers
Setting::get('app.name', 'Default')   // returns casted value
Setting::set('app.name', 'MyApp')     // upserts

// Type casting (via 'type' column)
'string'  → returns as-is
'boolean' → filter_var with FILTER_VALIDATE_BOOLEAN
'integer' → (int) cast
'json'    → json_decode
```

### ActivityLog Model

**File**: `app/Models/ActivityLog.php`

```php
// Fillable
'user_id', 'event', 'subject_type', 'subject_id',
'description', 'properties', 'ip_address', 'user_agent'

// Casts
'properties' => 'array'

// Relations
user(): BelongsTo → User
subject(): MorphTo (any model)
```

### Media Model

**File**: `app/Models/Media.php`

```php
// Fillable
'mediable_type', 'mediable_id', 'collection', 'disk',
'path', 'filename', 'mime_type', 'size', 'user_id'

// Appended: 'url' → Storage::disk($this->disk)->url($this->path)

// Relations
mediable(): MorphTo (any model)
user(): BelongsTo → User
```

**How to use in a new module**:
```php
// In your model
public function media(): MorphMany
{
    return $this->morphMany(Media::class, 'mediable');
}
```

---

## 6. Enums

### UserStatus

**File**: `app/Enums/UserStatus.php`

```php
UserStatus::Active    // 'active'  → label: 'Active',    color: 'green'
UserStatus::Inactive  // 'inactive' → label: 'Inactive',  color: 'gray'
UserStatus::Suspended // 'suspended' → label: 'Suspended', color: 'red'
```

**Usage in Blade**:
```blade
<x-ui.badge :color="$user->status->color()">
    {{ $user->status->label() }}
</x-ui.badge>
```

### PermissionGroup

**File**: `app/Enums/PermissionGroup.php`

```php
PermissionGroup::Users        // 'users'
PermissionGroup::Roles        // 'roles'
PermissionGroup::Settings     // 'settings'
PermissionGroup::ActivityLogs // 'activity-logs'
PermissionGroup::Media        // 'media'
```

**When to add new enums**: Create in `app/Enums/` for any new status field or grouped constants. Always include `label()` and `color()` methods for UI display.

---

## 7. Repository Pattern

### Interface

**File**: `app/Repositories/Contracts/UserRepositoryInterface.php`

```php
findById(string $id): ?User
findByEmail(string $email): ?User
paginate(int $perPage = 15): LengthAwarePaginator
create(array $data): User
update(User $user, array $data): User
delete(User $user): bool
```

### Implementation

**File**: `app/Repositories/UserRepository.php`

Implements the interface with Eloquent operations.

### Binding

**File**: `app/Providers/AppServiceProvider.php`

```php
$this->app->bind(UserRepositoryInterface::class, UserRepository::class);
```

### How to Create a New Repository

```php
// 1. Create interface
// app/Repositories/Contracts/ProductRepositoryInterface.php
interface ProductRepositoryInterface {
    public function findById(string $id): ?Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function delete(Product $product): bool;
}

// 2. Create implementation
// app/Repositories/ProductRepository.php
class ProductRepository implements ProductRepositoryInterface { ... }

// 3. Bind in AppServiceProvider
$this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
```

---

## 8. Service Layer

### UserService

**File**: `app/Services/UserService.php`

```php
create(array $data): User
    // Extracts 'role' from $data before create
    // Hashes password
    // Assigns role via Spatie

update(User $user, array $data): User
    // Extracts 'role' from $data before update
    // Hashes password if provided, skips if empty
    // Syncs roles via Spatie

delete(User $user): bool

suspend(User $user): User
    // Sets status → UserStatus::Suspended

activate(User $user): User
    // Sets status → UserStatus::Active

syncRoles(User $user, array $roles): User

uploadAvatar(User $user, UploadedFile $file): User
    // Saves to: storage/app/public/avatars/{userId}.{ext}
    // Deletes old avatar if exists
```

### SettingService

**File**: `app/Services/SettingService.php`

```php
get(string $key, mixed $default = null): mixed
    // Cached per-request via Cache::store('array')

set(string $key, mixed $value): void
    // Clears cache after update

getGroup(string $group): Collection
    // Returns all settings in a group

setMany(array $settings): void
    // Bulk update: ['key1' => 'val1', 'key2' => 'val2']
```

### ActivityLogService

**File**: `app/Services/ActivityLogService.php`

```php
static log(string $event, ?Model $subject, ?string $description, array $properties): ActivityLog
    // Auto-captures: auth user, IP address, user agent

static logAuth(string $event, User $user): void
    // For login/logout events specifically
```

**Usage in any module**:
```php
ActivityLogService::log('approved', $order, 'Order approved by manager', [
    'old_status' => 'pending',
    'new_status' => 'approved',
]);
```

---

## 9. Reusable Traits — Livewire

### HasFilters

**File**: `app/Traits/Livewire/HasFilters.php`

```php
// Properties (wire:model bindable)
public array $filters = [];
public string $search = '';
public int $perPage = 15;

// Methods
resetFilters(): void          // Resets search, filters, pagination
updatingSearch(): void        // Auto-resets pagination
updatingFilters(): void       // Auto-resets pagination
applyFilters(Builder): Builder // Override in your component
```

**Includes `WithPagination` trait automatically.**

### HasSorting

**File**: `app/Traits/Livewire/HasSorting.php`

```php
public string $sortField = 'created_at';
public string $sortDirection = 'desc';

sortBy(string $field): void         // Toggles direction or sets new field
applySorting(Builder): Builder      // Applies orderBy to query
```

### HasBulkActions

**File**: `app/Traits/Livewire/HasBulkActions.php`

```php
public array $selected = [];
public bool $selectAll = false;

toggleSelectAll(): void       // Selects/deselects all visible rows
updatedSelected(): void       // Resets selectAll when individual changes
clearSelection(): void        // Resets both
getSelectedCountProperty(): int  // Computed: $this->selectedCount
```

### HasToast

**File**: `app/Traits/Livewire/HasToast.php`

```php
dispatchSuccess(string $message): void   // green toast
dispatchError(string $message): void     // red toast
dispatchWarning(string $message): void   // yellow toast
dispatchInfo(string $message): void      // blue toast
```

**How it works**: Dispatches `toast` Livewire event → caught by `FlashToast` global component → renders toast notification in top-right corner.

### HasConfirmDelete

**File**: `app/Traits/Livewire/HasConfirmDelete.php`

```php
public ?string $confirmingDeleteId = null;

confirmDelete(string $id): void     // Opens confirm modal
cancelDelete(): void                // Closes modal
executeDelete(): void               // Calls performDelete(), then cancelDelete()

abstract performDelete(string $id): void  // YOU MUST IMPLEMENT THIS
```

**Flow**: User clicks Delete → `confirmDelete($id)` → dispatches `open-confirm-modal` → ConfirmModal opens → User clicks Confirm → dispatches `delete-confirmed` → your component catches with `#[On('delete-confirmed')]` → calls `performDelete($id)`.

---

## 10. Reusable Traits — Models

### HasActivityLog

**File**: `app/Traits/Models/HasActivityLog.php`

Auto-logs `created`, `updated`, `deleted` events on the model.

```php
// In your model:
use HasActivityLog;

protected array $logAttributes = ['name', 'status', 'price'];

// To disable logging temporarily:
$model->disableActivityLog = true;
$model->save();
```

**What it logs automatically**:
- `created` → records all tracked attributes
- `updated` → records old vs new values (diff) for tracked attributes only
- `deleted` → records all tracked attributes at time of deletion

---

## 11. Base Livewire Classes

### BaseDataTable

**File**: `app/Livewire/Base/BaseDataTable.php`

**Uses**: HasFilters, HasSorting, HasBulkActions, HasToast, HasConfirmDelete

```php
// YOU MUST IMPLEMENT:
abstract protected function getQuery(): Builder;
abstract protected function getView(): string;

// PROVIDED:
getRowsProperty(): LengthAwarePaginator
    // Calls getQuery() → applyFilters() → applySorting() → paginate()

performDelete(string $id): void
    // Default: finds model and deletes. Override for custom logic.

render(): mixed
    // Returns view with 'rows' variable
```

**Usage** (see Section 30 for full example):
```php
class ProductTable extends BaseDataTable
{
    protected function getQuery(): Builder
    {
        return Product::query()->with('category');
    }

    protected function getView(): string
    {
        return 'livewire.products.product-table';
    }
}
```

### BaseForm

**File**: `app/Livewire/Base/BaseForm.php`

**Uses**: HasToast

```php
public ?string $modelId = null;

// Computed:
getIsEditingProperty(): bool   // $this->isEditing → true if modelId is set

// YOU MUST IMPLEMENT:
abstract protected function getFormRules(): array;
abstract public function save(): void;

// PROVIDED:
resetForm(): void          // Resets all properties + validation
validateForm(): void       // Validates using getFormRules()
```

### BaseModal

**File**: `app/Livewire/Base/BaseModal.php`

**Uses**: HasToast

```php
public bool $isOpen = false;

open(mixed ...$params): void   // Sets isOpen=true, calls onOpen()
close(): void                  // Sets isOpen=false, calls onClose()

// Override hooks:
onOpen(mixed ...$params): void
onClose(): void
```

### BaseStatsWidget

**File**: `app/Livewire/Base/BaseStatsWidget.php`

```php
// YOU MUST IMPLEMENT:
abstract protected function getStats(): array;
    // Return array of: ['title', 'value', 'icon', 'change', 'changeType', 'color']

// Renders: livewire.base.stats-widget
// Uses x-ui.stat-card for each stat
```

---

## 12. Blade UI Components (x-ui.*)

All located in `resources/views/components/ui/`.

### x-ui.button

```blade
<x-ui.button>Save</x-ui.button>
<x-ui.button variant="secondary">Cancel</x-ui.button>
<x-ui.button variant="danger">Delete</x-ui.button>
<x-ui.button variant="ghost">More</x-ui.button>
<x-ui.button size="sm">Small</x-ui.button>
<x-ui.button size="lg">Large</x-ui.button>
<x-ui.button type="submit">Submit</x-ui.button>
<x-ui.button href="/users">Link Button</x-ui.button>
<x-ui.button icon="plus">Add User</x-ui.button>
<x-ui.button disabled>Disabled</x-ui.button>
<x-ui.button wire:click="save">Livewire</x-ui.button>
```

| Prop | Type | Default | Options |
|---|---|---|---|
| `variant` | string | `primary` | primary, secondary, danger, ghost |
| `size` | string | `md` | sm, md, lg |
| `type` | string | `button` | button, submit |
| `href` | string | null | renders `<a>` instead of `<button>` |
| `disabled` | bool | false | |
| `icon` | string | null | Heroicon name, rendered before slot text |

### x-ui.icon

```blade
<x-ui.icon name="users" />
<x-ui.icon name="users" style="solid" size="lg" class="text-red-500" />
```

| Prop | Default | Options |
|---|---|---|
| `name` | (required) | any heroicon name |
| `style` | `outline` | outline, solid |
| `size` | `md` | xs, sm, md, lg |

### x-ui.badge

```blade
<x-ui.badge color="green">Active</x-ui.badge>
<x-ui.badge color="red" icon="x-circle">Suspended</x-ui.badge>
<x-ui.badge color="gray" size="md">Large Badge</x-ui.badge>
```

| Prop | Default | Options |
|---|---|---|
| `color` | `gray` | green, red, yellow, blue, gray, purple |
| `size` | `sm` | sm, md |
| `icon` | null | Heroicon name |

### x-ui.card

```blade
<x-ui.card>
    Content here
</x-ui.card>

<x-ui.card :padding="false">
    <x-slot:header>Card Title</x-slot:header>
    Full-bleed content
    <x-slot:footer>Footer actions</x-slot:footer>
</x-ui.card>
```

| Prop/Slot | Description |
|---|---|
| `padding` | true (default) — adds px-6 py-4 |
| `header` slot | Optional top section with border |
| `footer` slot | Optional bottom section with bg-slate-50 |

### x-ui.stat-card

```blade
<x-ui.stat-card
    title="Total Users"
    value="1,234"
    icon="users"
    change="+12%"
    changeType="increase"
    color="primary"
/>
```

| Prop | Default | Options |
|---|---|---|
| `title` | (required) | stat label |
| `value` | (required) | stat number |
| `icon` | `chart-bar` | Heroicon name |
| `change` | null | e.g. "+12%", "-3%" |
| `changeType` | `neutral` | increase (green), decrease (red), neutral (gray) |
| `color` | `primary` | primary, green, red, yellow, blue, purple |

### x-ui.empty-state

```blade
<x-ui.empty-state
    title="No products found"
    description="Get started by creating your first product."
    icon="cube"
>
    <x-slot:action>
        <x-ui.button icon="plus" href="/products/create">Add Product</x-ui.button>
    </x-slot:action>
</x-ui.empty-state>
```

### x-ui.skeleton

```blade
<x-ui.skeleton />                          {{-- 3 text lines --}}
<x-ui.skeleton :lines="5" />               {{-- 5 text lines --}}
<x-ui.skeleton type="table" :lines="8" />  {{-- table skeleton --}}
<x-ui.skeleton type="card" />              {{-- card skeleton --}}
```

### x-ui.dropdown

```blade
<x-ui.dropdown>
    <x-slot:trigger>
        <x-ui.button variant="ghost" size="sm" icon="ellipsis-vertical" />
    </x-slot:trigger>

    <a href="/edit" class="block px-4 py-2 text-sm hover:bg-slate-50">Edit</a>
    <button wire:click="delete" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Delete</button>
</x-ui.dropdown>
```

Uses Alpine.js for open/close toggle, click-outside to close, Escape key to close.

### x-ui.modal

```blade
<x-ui.modal title="Edit Item" wire:model="showModal" maxWidth="lg">
    <x-slot:headerIcon>
        <x-ui.icon name="pencil-square" class="text-primary-600" />
    </x-slot:headerIcon>

    <p>Modal body content</p>

    <x-slot:footer>
        <x-ui.button variant="secondary" @click="show = false">Cancel</x-ui.button>
        <x-ui.button wire:click="save">Save</x-ui.button>
    </x-slot:footer>
</x-ui.modal>
```

| Prop/Slot | Default | Options |
|---|---|---|
| `title` | `Confirm` | |
| `maxWidth` | `md` | sm, md, lg, xl |
| `wire:model` | (required) | Livewire boolean property |
| `headerIcon` slot | optional | icon before title |
| `footer` slot | optional | action buttons |

### x-ui.toast

```blade
<x-ui.toast type="success" message="User created successfully." />
<x-ui.toast type="error" message="Something went wrong." />
<x-ui.toast type="warning" message="Please review your input." />
<x-ui.toast type="info" message="New update available." />
```

| Type | Icon | Color |
|---|---|---|
| success | check-circle | green |
| error | x-circle | red |
| warning | exclamation-triangle | yellow |
| info | information-circle | blue |

### x-ui.page-header

```blade
<x-ui.page-header title="Users" description="Manage all system users">
    <x-slot:actions>
        <x-ui.button icon="plus" href="{{ route('users.create') }}">Add User</x-ui.button>
    </x-slot:actions>
</x-ui.page-header>
```

### x-ui.breadcrumb

```blade
<x-ui.breadcrumb :items="[
    ['label' => 'Users', 'route' => route('users.index')],
    ['label' => 'Create'],
]" />
```

Always starts with a Home icon link to dashboard. Last item is plain text (no link).

### x-ui.tabs

```blade
<x-ui.tabs :tabs="['General', 'Security', 'Notifications']">
    <div x-show="activeTab === 'General'">General content</div>
    <div x-show="activeTab === 'Security'">Security content</div>
    <div x-show="activeTab === 'Notifications'">Notifications content</div>
</x-ui.tabs>
```

Uses Alpine.js `activeTab` variable. No page reload.

### x-ui.table

```blade
<x-ui.table>
    <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-200">
        <tr class="hover:bg-slate-50">
            <td class="px-6 py-4 text-sm text-slate-900">John Doe</td>
        </tr>
    </tbody>
</x-ui.table>
```

Wraps `<table>` with overflow-x-auto, rounded border, white background.

### x-ui.confirm-delete

Wrapper for delete confirmation content. Used internally by ConfirmModal.

---

## 13. Blade Form Components (x-form.*)

All located in `resources/views/components/form/`.

### x-form.input

```blade
<x-form.input
    id="name"
    label="Full Name"
    placeholder="Enter name"
    wire:model="name"
    :required="true"
    :error="$errors->first('name')"
/>

<x-form.input id="email" label="Email" type="email" wire:model="email" />
<x-form.input id="password" label="Password" type="password" wire:model="password" />
```

| Prop | Default | Description |
|---|---|---|
| `id` | (required) | input id |
| `label` | null | label text |
| `type` | `text` | input type |
| `placeholder` | `''` | |
| `required` | false | shows red asterisk |
| `disabled` | false | |
| `error` | null | error message string → shows red border + error text |

### x-form.select

```blade
<x-form.select
    id="role"
    label="Role"
    wire:model="role"
    :options="['admin' => 'Admin', 'user' => 'User', 'manager' => 'Manager']"
    placeholder="Choose a role"
    :required="true"
    :error="$errors->first('role')"
/>
```

| Prop | Default |
|---|---|
| `options` | `[]` — associative array `value => label` |
| `placeholder` | `Select an option` |

### x-form.textarea

```blade
<x-form.textarea
    id="description"
    label="Description"
    wire:model="description"
    :rows="5"
    :error="$errors->first('description')"
/>
```

### x-form.checkbox

```blade
<x-form.checkbox id="agree" label="I agree to terms" wire:model="agree" />
```

### x-form.toggle

```blade
<x-form.toggle id="is_active" label="Active" wire:model="isActive" />
```

Renders a premium toggle switch (not a checkbox). Uses Alpine.js for smooth animation.

### x-form.file-upload

```blade
<x-form.file-upload
    id="avatar"
    label="Profile Photo"
    wire:model="avatar"
    accept="image/*"
    :error="$errors->first('avatar')"
/>
```

Shows "Choose file" button + filename. Uses Alpine.js to display selected filename.

### x-form.error

```blade
<x-form.error :message="$errors->first('email')" />
```

Renders red error text. Used internally by other form components.

---

## 14. Blade Table Components (x-table.*)

### x-table.sort-button

```blade
<x-table.sort-button
    field="name"
    :sortField="$sortField"
    :sortDirection="$sortDirection"
>
    Name
</x-table.sort-button>
```

Renders a clickable column header. Shows:
- Active ascending: chevron-up (primary color)
- Active descending: chevron-down (primary color)
- Inactive: chevron-up-down (gray)

Fires `wire:click="sortBy('name')"` — handled by HasSorting trait.

### x-table.bulk-bar

```blade
<x-table.bulk-bar :selectedCount="$selectedCount">
    <x-ui.button variant="danger" size="sm" wire:click="bulkDelete">Delete Selected</x-ui.button>
</x-table.bulk-bar>
```

Shows "X item(s) selected" with action buttons. Only renders when `selectedCount > 0`.

---

## 15. Global Livewire Components

### FlashToast

**File**: `app/Livewire/Components/FlashToast.php`

Renders stacked toast notifications in the top-right corner. Auto-removes after 4 seconds (via Alpine.js `setTimeout`).

- Listens for `toast` event via `#[On('toast')]`
- Called by any component using `HasToast` trait
- Included in `layouts/app.blade.php` as `<livewire:components.flash-toast />`

### ConfirmModal

**File**: `app/Livewire/Components/ConfirmModal.php`

Global delete confirmation dialog.

- Listens for `open-confirm-modal` event
- On confirm: dispatches `delete-confirmed` event with the item ID
- Customizable title, message, confirm button text
- Included in `layouts/app.blade.php` as `<livewire:components.confirm-modal />`

**Flow from any table**:
```php
// In your component, use HasConfirmDelete trait
$this->confirmDelete($id);  // Opens the modal

// Listen for confirmation
#[On('delete-confirmed')]
public function handleDeleteConfirmed(string $id): void
{
    // Delete logic here
}
```

### GlobalSearch

**File**: `app/Livewire/Components/GlobalSearch.php`

Top-bar search that queries users by name/email. Shows up to 5 results.
Extend the `search()` method to add more model queries for new modules.

---

## 16. Layouts

### app.blade.php (Authenticated)

**File**: `resources/views/layouts/app.blade.php`

Structure:
```
┌──────────────────────────────────────────┐
│ Sidebar (256px)  │  Main Content Area     │
│                  │                        │
│ - Logo           │  ┌──────────────────┐  │
│ - Nav items      │  │ Topbar           │  │
│ - User info      │  ├──────────────────┤  │
│ - Logout         │  │ {{ $slot }}      │  │
│                  │  │                  │  │
│                  │  └──────────────────┘  │
│                  │  Footer                │
└──────────────────────────────────────────┘
```

Includes:
- `<livewire:components.flash-toast />`
- `<livewire:components.confirm-modal />`
- Alpine.js mobile sidebar drawer
- `@stack('modals')` and `@stack('scripts')` before `</body>`

### guest.blade.php (Auth pages)

**File**: `resources/views/layouts/guest.blade.php`

Centered card layout for login, register, forgot password, etc.

### Sidebar

**File**: `resources/views/layouts/partials/sidebar.blade.php`

Navigation items with permission gates:

| Menu Item | Route | Permission Guard |
|---|---|---|
| Dashboard | `dashboard` | none |
| Users | `users.index` | `@can('view users')` |
| Roles & Permissions | `roles.index` | `@can('view roles')` |
| Settings | `settings.index` | `@can('view settings')` |
| Activity Logs | `activity-logs.index` | `@can('view activity-logs')` |
| Profile | `profile.edit` | none |

**Active state**: `request()->routeIs('users.*')` → adds `.active` class.

---

## 17. Module: Dashboard

**Component**: `app/Livewire/Dashboard/DashboardIndex.php`
**View**: `resources/views/livewire/dashboard/dashboard-index.blade.php`
**Route**: `GET /dashboard` → `dashboard`

**Features**:
- 4 stat cards: Total Users, Active Users, Total Roles, Activity Logs
- Recent Activity card (latest 5 activity logs)
- Latest Users card (latest 5 users)

---

## 18. Module: User Management

**Components**:
| Component | Route | Permission |
|---|---|---|
| `UserIndex` | `GET /users` | `view users` |
| `UserCreate` | `GET /users/create` | `create users` |
| `UserEdit` | `GET /users/{user}/edit` | `edit users` |

**UserIndex features**:
- Extends `BaseDataTable`
- Search by name + email
- Filter by status (active/inactive/suspended) and role
- Sort by created_at (default desc)
- Bulk select + bulk delete
- Action dropdown per row: Edit, Delete
- Delete confirmation modal

---

## 19. Module: Roles & Permissions

**Component**: `app/Livewire/Roles/RoleIndex.php`
**Route**: `GET /roles` → `roles.index`
**Permission**: `view roles`

**Features**:
- Lists all roles with assigned permissions
- Inline permission toggle (checkbox) per role
- Permissions grouped by category (users, roles, settings, etc.)

---

## 20. Module: Settings

**Component**: `app/Livewire/Settings/SettingIndex.php`
**Route**: `GET /settings` → `settings.index`
**Permission**: `view settings`, `edit settings`

**Features**:
- Key-value settings management
- Grouped by category
- Supports types: string, boolean, integer, json
- Uses `SettingService` for CRUD

---

## 21. Module: Activity Logs

**Component**: `app/Livewire/ActivityLogs/ActivityLogIndex.php`
**Route**: `GET /activity-logs` → `activity-logs.index`
**Permission**: `view activity-logs`

**Features**:
- Read-only log viewer
- Search by event, description, user name
- Sort by event, created_at
- Color-coded event badges (created=green, updated=blue, deleted=red)

---

## 22. Module: Profile

**Component**: `app/Livewire/Profile/ProfileEdit.php`
**Route**: `GET /profile` → `profile.edit`
**Permission**: none (own profile only)

**Features**:
- Update name and email
- Upload/change avatar
- Change password (requires current password verification)

---

## 23. API Layer

**File**: `routes/api.php`

All endpoints are prefixed with `/api/v1/`.

### Auth Endpoints

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | `/api/v1/login` | No | Returns Sanctum token |
| POST | `/api/v1/logout` | Sanctum | Revokes current token |
| GET | `/api/v1/me` | Sanctum | Returns authenticated user + roles |

### User CRUD Endpoints

| Method | Endpoint | Auth | Controller |
|---|---|---|---|
| GET | `/api/v1/users` | Sanctum | `UserController@index` |
| POST | `/api/v1/users` | Sanctum | `UserController@store` |
| GET | `/api/v1/users/{id}` | Sanctum | `UserController@show` |
| PUT | `/api/v1/users/{id}` | Sanctum | `UserController@update` |
| DELETE | `/api/v1/users/{id}` | Sanctum | `UserController@destroy` |

All User API endpoints use `UserPolicy` authorization (`$this->authorize()` per method).

### UserResource

Returns: `id`, `name`, `email`, `status`, `roles` (array), `avatar_url`, `created_at`, `updated_at`.

### How to Add New API Resource

```php
// 1. Create controller: app/Http/Controllers/Api/V1/ProductController.php
// 2. Create resource: app/Http/Resources/ProductResource.php
// 3. Add route in routes/api.php:
Route::apiResource('products', ProductController::class);
```

---

## 24. Middleware

### EnsureUserIsActive

**File**: `app/Http/Middleware/EnsureUserIsActive.php`

**Registered in**: `bootstrap/app.php` → web middleware group

**Behavior**:
- Skips if user is not logged in (guest)
- If `status !== UserStatus::Active`:
  - **Web**: logs out, invalidates session, redirects to login with error message
  - **API** (JSON): returns `403 { "message": "Your account is not active." }`

---

## 25. Authorization (Policy)

### UserPolicy

**File**: `app/Policies/UserPolicy.php`

| Method | Permission Check | Extra Logic |
|---|---|---|
| `viewAny` | `can('view users')` | — |
| `view` | `can('view users')` | — |
| `create` | `can('create users')` | — |
| `update` | `can('edit users')` | — |
| `delete` | `can('delete users')` | Cannot delete self |
| `restore` | `can('delete users')` | — |
| `forceDelete` | `can('delete users')` | Cannot delete self |

### How to Create a New Policy

```php
// app/Policies/ProductPolicy.php
class ProductPolicy {
    public function viewAny(User $user): bool {
        return $user->can('view products');
    }
    // ... create, update, delete
}
```

Laravel auto-discovers policies by naming convention (`Product` model → `ProductPolicy`).

---

## 26. Roles & Permissions Seed Data

**File**: `database/seeders/RolesAndPermissionsSeeder.php`

### 14 Permissions

```
Users:        view users, create users, edit users, delete users
Roles:        view roles, create roles, edit roles, delete roles
Settings:     view settings, edit settings
ActivityLogs: view activity-logs
Media:        view media, upload media, delete media
```

### 4 Roles

| Role | Permissions |
|---|---|
| `super-admin` | All 14 permissions |
| `admin` | All except: `delete users`, `delete roles` |
| `manager` | View-only: `view users`, `view roles`, `view settings`, `view activity-logs`, `view media` |
| `user` | No permissions |

### Default Super-Admin Account

| Field | Value |
|---|---|
| Name | Super Admin |
| Email | `daffatgi02@gmail.com` |
| Password | `daffa123` |
| Role | super-admin |

### Adding Permissions for a New Module

```php
// In RolesAndPermissionsSeeder.php, add to $permissions array:
'view products', 'create products', 'edit products', 'delete products',

// Assign to roles as needed
// Re-run: php artisan migrate:fresh --seed
```

---

## 27. Global Helpers

**File**: `app/Helpers/helpers.php` (autoloaded via composer.json)

```php
format_date(Carbon|string $date, string $format = 'd M Y'): string
    // "08 Apr 2026"

format_datetime(Carbon|string $date, string $format = 'd M Y, H:i'): string
    // "08 Apr 2026, 10:30"

format_relative(Carbon|string $date): string
    // "2 hours ago", "3 days ago"
```

---

## 28. Configuration

### Key Config Values

| File | Key | Value |
|---|---|---|
| `.env` | `APP_TIMEZONE` | `Asia/Jakarta` (WIB) |
| `.env` | `APP_LOCALE` | `id` |
| `.env` | `APP_FAKER_LOCALE` | `id_ID` |
| `.env` | `CACHE_STORE` | `database` |
| `.env` | `QUEUE_CONNECTION` | `database` |
| `.env` | `SESSION_DRIVER` | `database` |
| `config/permission.php` | `cache.store` | `array` |
| `bootstrap/app.php` | web middleware | `EnsureUserIsActive` |
| `bootstrap/app.php` | api middleware | `EnsureFrontendRequestsAreStateful` |

### AppServiceProvider Boot

```php
config(['app.locale' => 'id']);
Carbon::setLocale('id');
Model::shouldBeStrict(! app()->isProduction());
Paginator::useTailwind();
```

---

## 29. Testing

**Tests: 47 passed, 99 assertions**

| Test File | Tests |
|---|---|
| `Feature/Auth/AuthenticationTest` | login screen, login success, login fail, dashboard render, logout |
| `Feature/Auth/LoginTest` | login page render, valid login, invalid login, auth redirect |
| `Feature/Auth/RegistrationTest` | register screen, register flow |
| `Feature/Auth/EmailVerificationTest` | verify screen, verify success, verify invalid |
| `Feature/Auth/PasswordResetTest` | forgot screen, send link, reset screen, reset with token |
| `Feature/Auth/PasswordConfirmationTest` | confirm screen, confirm success, confirm fail |
| `Feature/Auth/PasswordUpdateTest` | update success, wrong password |
| `Feature/ProfileTest` | profile display, profile update |
| `Feature/Users/UserCrudTest` | view list, create page, no permission, dashboard, roles, settings, activity logs, unauthenticated |
| `Feature/Api/UserApiTest` | API login, /me, list users, unauthenticated 401, invalid login 401, logout |
| `Unit/Services/UserServiceTest` | create with role, update, suspend, activate, delete, hash password |

Run `php artisan test` to verify.

---

## 30. How to Create a New Module

### Step-by-step Example: Products Module

**1. Migration**:
```bash
php artisan make:migration create_products_table
```
```php
Schema::create('products', function (Blueprint $table) {
    $table->ulid('id')->primary();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->string('status')->default('active');
    $table->timestamps();
    $table->softDeletes();
});
```

**2. Model**: `app/Models/Product.php`
```php
class Product extends Model {
    use HasUlids, SoftDeletes, HasActivityLog;
    protected $fillable = ['name', 'description', 'price', 'status'];
    protected array $logAttributes = ['name', 'price', 'status'];
}
```

**3. Permissions** (add to seeder):
```php
'view products', 'create products', 'edit products', 'delete products',
```

**4. Policy**: `app/Policies/ProductPolicy.php`

**5. Repository** (optional): `ProductRepository` + interface

**6. Service**: `app/Services/ProductService.php`

**7. Livewire listing**: `app/Livewire/Products/ProductIndex.php`
```php
class ProductIndex extends BaseDataTable {
    protected function getQuery(): Builder {
        return Product::query();
    }
    public function applyFilters(Builder $query): Builder {
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }
        return $query;
    }
    protected function getView(): string {
        return 'livewire.products.product-index';
    }
    protected function performDelete(string $id): void {
        Product::findOrFail($id)->delete();
        $this->dispatchSuccess('Product deleted.');
    }
}
```

**8. View**: `resources/views/livewire/products/product-index.blade.php`

Use `x-ui.page-header`, `x-ui.table`, `x-table.sort-button`, `x-table.bulk-bar`, `x-ui.badge`, `x-ui.dropdown`, `x-ui.empty-state`, pagination.

**9. Route** (in `routes/web.php`):
```php
Route::get('products', ProductIndex::class)->name('products.index');
```

**10. Sidebar** (in `layouts/partials/sidebar.blade.php`):
```blade
@can('view products')
<a href="{{ route('products.index') }}"
   @class(['sidebar-link', 'active' => request()->routeIs('products.*')])>
    <x-ui.icon name="cube" size="sm" />
    <span>Products</span>
</a>
@endcan
```

---

## 31. White-Label Checklist

When cloning for a new client:

1. `APP_NAME` in `.env` → client project name
2. Logo in `resources/views/layouts/partials/sidebar.blade.php`
3. Primary color tokens in `tailwind.config.js` → `theme.extend.colors.primary`
4. Seed credentials in `database/seeders/DatabaseSeeder.php`
5. Run `npm run build` after color changes

---

## 32. Full File Map

```
app/
├── Enums/
│   ├── UserStatus.php            # Active/Inactive/Suspended + label() + color()
│   └── PermissionGroup.php       # Users/Roles/Settings/ActivityLogs/Media
├── Helpers/
│   └── helpers.php               # format_date, format_datetime, format_relative
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php        # Base with AuthorizesRequests
│   │   └── Api/V1/
│   │       ├── AuthController.php    # login, logout, me
│   │       └── UserController.php    # CRUD with authorize()
│   ├── Middleware/
│   │   └── EnsureUserIsActive.php    # Blocks suspended/inactive users
│   └── Resources/
│       └── UserResource.php          # API JSON resource
├── Livewire/
│   ├── Base/
│   │   ├── BaseDataTable.php     # Abstract: table with filter/sort/bulk/toast/delete
│   │   ├── BaseForm.php          # Abstract: form with validation/toast
│   │   ├── BaseModal.php         # Abstract: modal with open/close hooks
│   │   └── BaseStatsWidget.php   # Abstract: dashboard stat cards
│   ├── Components/
│   │   ├── FlashToast.php        # Global toast notification handler
│   │   ├── ConfirmModal.php      # Global delete confirmation modal
│   │   └── GlobalSearch.php      # Top-bar search
│   ├── Dashboard/
│   │   └── DashboardIndex.php    # Stats + recent activity + latest users
│   ├── Users/
│   │   ├── UserIndex.php         # User list table
│   │   ├── UserCreate.php        # Create user form page
│   │   └── UserEdit.php          # Edit user form page
│   ├── Roles/
│   │   └── RoleIndex.php         # Role list + inline permission editing
│   ├── Settings/
│   │   └── SettingIndex.php      # Settings management
│   ├── ActivityLogs/
│   │   └── ActivityLogIndex.php  # Activity log viewer
│   └── Profile/
│       └── ProfileEdit.php       # Profile + password + avatar
├── Models/
│   ├── User.php                  # HasUlids, SoftDeletes, HasRoles, HasApiTokens, HasActivityLog
│   ├── Setting.php               # HasUlids, static get/set helpers
│   ├── ActivityLog.php           # HasUlids, morph relations
│   └── Media.php                 # HasUlids, SoftDeletes, url accessor
├── Policies/
│   └── UserPolicy.php            # CRUD gates for User model
├── Providers/
│   └── AppServiceProvider.php    # Repository binding, locale, strict mode
├── Repositories/
│   ├── Contracts/
│   │   └── UserRepositoryInterface.php
│   └── UserRepository.php
├── Services/
│   ├── ActivityLogService.php    # log(), logAuth() — static
│   ├── SettingService.php        # get, set, getGroup, setMany
│   └── UserService.php           # create, update, delete, suspend, activate, uploadAvatar
└── Traits/
    ├── Livewire/
    │   ├── HasFilters.php        # search, filters, perPage, pagination
    │   ├── HasSorting.php        # sortField, sortDirection, sortBy
    │   ├── HasBulkActions.php    # selected, selectAll, clearSelection
    │   ├── HasToast.php          # dispatchSuccess/Error/Warning/Info
    │   └── HasConfirmDelete.php  # confirmDelete, cancelDelete, executeDelete
    └── Models/
        └── HasActivityLog.php    # Auto-log created/updated/deleted

resources/views/
├── components/
│   ├── ui/                       # 15 UI components
│   │   ├── button.blade.php      # variant, size, type, href, icon
│   │   ├── icon.blade.php        # Heroicon wrapper: name, style, size
│   │   ├── badge.blade.php       # color, size, icon
│   │   ├── card.blade.php        # header/footer slots, padding toggle
│   │   ├── stat-card.blade.php   # title, value, icon, change, color
│   │   ├── empty-state.blade.php # title, description, icon, action slot
│   │   ├── skeleton.blade.php    # lines, type (lines/table/card)
│   │   ├── dropdown.blade.php    # Alpine.js dropdown with trigger slot
│   │   ├── modal.blade.php       # title, maxWidth, headerIcon/footer slots
│   │   ├── toast.blade.php       # type, message
│   │   ├── page-header.blade.php # title, description, actions slot
│   │   ├── breadcrumb.blade.php  # items array [{label, route}]
│   │   ├── tabs.blade.php        # Alpine.js tabs
│   │   ├── table.blade.php       # Table wrapper with overflow
│   │   └── confirm-delete.blade.php
│   ├── form/                     # 7 form components
│   │   ├── input.blade.php       # label, id, type, error, required
│   │   ├── select.blade.php      # label, id, options, error
│   │   ├── textarea.blade.php    # label, id, rows, error
│   │   ├── checkbox.blade.php    # label, id
│   │   ├── toggle.blade.php      # Alpine.js toggle switch
│   │   ├── file-upload.blade.php # label, id, accept, multiple
│   │   └── error.blade.php       # Error message text
│   └── table/                    # 2 table components
│       ├── sort-button.blade.php # Sortable column header
│       └── bulk-bar.blade.php    # Bulk action bar
├── layouts/
│   ├── app.blade.php             # Authenticated layout (sidebar + topbar)
│   ├── guest.blade.php           # Auth pages layout
│   └── partials/
│       ├── sidebar.blade.php     # Navigation + user info + logout
│       ├── topbar.blade.php      # Search + user dropdown
│       └── footer.blade.php      # Copyright footer
└── livewire/                     # Livewire component views
    ├── dashboard/
    ├── users/
    ├── roles/
    ├── settings/
    ├── activity-logs/
    ├── profile/
    ├── components/
    └── base/
```

---

> **Last verified**: All 47 tests passing, `npm run build` successful, `php artisan migrate:fresh --seed` clean.
