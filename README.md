# SLECC | Luxury Laravel Website

A complete **Laravel application source package** for a premium venue and event-services website. Uses Laravel 12, PHP 8.2+, Blade, SQLite by default, custom CSS and vanilla JavaScript. No Node/Vite build is needed.

## Luxury colour system

| Token | Hex | Purpose |
|---|---|---|
| Midnight Forest | `#102923` | Header buttons, footer, statement panels |
| Deep Jade | `#183D35` | Secondary brand surface |
| Moss Jade | `#224E43` | Accent gradients |
| Champagne Gold | `#C6A66B` | Primary CTA, highlights and lines |
| Light Champagne | `#E0C58F` | Text on dark panels |
| Porcelain | `#F7F4EE` | Warm light surfaces |
| Ivory White | `#FFFEFB` | Cards and page background |
| Deep Ink | `#1D2928` | Typography |
| Muted Sage | `#68736D` | Paragraphs and metadata |

The brand lettermark is **a placeholder**, not an official SLECC logo.

## Pages

Home `/` · Venues `/venues` · Venue detail `/venues/{slug}` · Services `/services` · Events `/events` · Clients `/clients` · About `/about` · Contact `/contact` · Admin `/admin/login`.

## Included application features

- Responsive public site; image-led service cards, detailed copy, event types, featured venues and client section.
- Search venues by type via query string, with direct enquiry CTAs.
- Validated, CSRF-protected, rate-limited enquiry form; stores submissions in database.
- Optional enquiry email to a configured address (uses Laravel Mail; `MAIL_MAILER=log` by default).
- Admin-only sign-in, content CRUD for venues/services/events/clients and enquiry status/notes.
- SQLite-supported migrations and demo content seeder.
- No invented public event dates or client logos are seeded.

## Installation (Windows PowerShell)

### Prerequisites
PHP 8.2 or later with required extensions, Composer, and SQLite PDO enabled. If starting from this project folder, do **not** overwrite an existing application; use a separate new folder or Git branch.

```powershell
cd C:\Projects\SLECC_Luxury_Laravel
composer install
Copy-Item .env.example .env
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan key:generate
```

Edit `.env` and enter a **strong, unique** admin password (12+ characters). Set the admin email before seeding:

```dotenv
SLECC_ADMIN_NAME="SLECC Administrator"
SLECC_ADMIN_EMAIL="admin@your-domain.example"
SLECC_ADMIN_PASSWORD="REPLACE_WITH_A_STRONG_UNIQUE_PASSWORD"
```

Then:

```powershell
php artisan migrate --seed
php artisan serve
```

Website: `http://127.0.0.1:8000`  
Admin login: `http://127.0.0.1:8000/admin/login`

**No default admin account is created unless** both `SLECC_ADMIN_EMAIL` and `SLECC_ADMIN_PASSWORD` are present when the seeder runs. For security, unset `SLECC_ADMIN_PASSWORD` after successful seeding, and do not put `.env` in Git.

## Deployment

1. Point web-server document root to `public/` **not** repository root. Set `APP_ENV=production`, `APP_DEBUG=false`, correct `APP_URL`, and a generated `APP_KEY`.
2. Set DB credentials and migrate with `php artisan migrate --force`; use a persistent DB for production. SQLite is simplest locally; consider managed MySQL/Postgres for production.
3. Set `MAIL_MAILER` and delivery credentials; set `SLECC_ENQUIRY_EMAIL` to receive notifications. Test mail and form submissions.
4. Set HTTPS, write access to `storage/` and `bootstrap/cache/`, configure logs/backups, and run `php artisan config:cache` and `php artisan route:cache`.
5. Replace demo images with SLECC-owned, approved photography, replace the lettermark with the approved logo, and verify all venue details/contact information. Publish actual events and clients only with permission.
6. Add privacy/terms/cookie notices as applicable and arrange production QA/security review before publishing.

### Important limitations

- This package includes **full authored application source**, not Composer `vendor/` dependencies or a compiled production deployment.
- `composer install` and Laravel browser tests could not run in this environment (Composer not available here); PHP syntax was linted. Test migrations, admin CRUD, mail and production hosting on your machine.
- Venue availability, schedules, capacities, prices and customer claims are **not** verified and should not be published as confirmed. Demo images are remote stock-photo placeholders.
- Enquiry submission is *not* a reservation, payment or inventory hold. No online payment module or rental stock management is included, in line with the revised SLECC venue/services brief.
- Sample content may be edited in Admin. This is a **separate Laravel application**; merging with an existing rental portal requires a planned migration and integration.
