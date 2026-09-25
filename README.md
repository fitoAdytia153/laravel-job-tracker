# Job Tracker

A simple web application to track job applications. Built with **Laravel 11**, **Tailwind CSS**, **Flatpickr**, and **vanilla JavaScript** — featuring full AJAX CRUD without page reloads.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green?style=flat-square)

---

## ✨ Features

### Full CRUD (AJAX)
- ➕ **Add** new applications via modal
- 👁️ **View** application details via modal (click row)
- ✏️ **Edit** applications via modal
- 🗑️ **Delete** with confirmation modal

### Filter & Search
- 🔍 **Search** by `company` or `position` (debounced, 450ms)
- 🎯 **Filter by status**: Applied, Interview, Accepted, Rejected
- 📅 **Filter by applied date** (Flatpickr)
- ↕️ **Server-side sorting** on any column
- 🔄 **Reset all filters** with a single click

### User Experience
- ⚡ **Full AJAX** — table & statistics refresh without page reload
- 📊 **Live statistics cards** updated automatically after CRUD
- 📄 **Pagination** — 5 records per page
- 🔔 **Toast notifications** for CRUD feedback
- ⌨️ **ESC** or click outside to close modals
- ⏪ **Browser back/forward** stays in sync with the table

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 11 |
| Database | MySQL / MariaDB |
| Frontend | Blade + Tailwind CSS (CDN) |
| Date Picker | Flatpickr |
| JavaScript | Vanilla JS (Fetch API) |
| Dev Server | `php artisan serve` / XAMPP |

---

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM *(optional)*

---

## 🚀 Installation

### 1. Clone & Install Dependencies

```bash
git clone https://github.com/<your-username>/job-tracker.git
cd job-tracker
composer install
```

### 2. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Job Tracker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=day_code_job_tracker
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Create Database

```bash
mysql -u root -p -e "CREATE DATABASE job_tracker;"
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Start the Server

```bash
php artisan serve
```

Open `http://127.0.0.1:8000` 🎉

---

## 📁 Project Structure (Key Files)

```
app/
├── Http/Controllers/
│   └── JobApplicationController.php   # All CRUD + AJAX logic
└── Models/
    └── JobApplication.php

database/migrations/
└── xxxx_create_job_applications_table.php

resources/views/job-applications/
├── index.blade.php       # Dashboard (table + modals)
├── edit.blade.php        # Standalone edit page (fallback)
├── show.blade.php        # Standalone detail page (fallback)
├── _stats.blade.php      # Partial: statistics cards
├── _table.blade.php      # Partial: table + pagination
└── _ajax.blade.php       # Partial: wrapper for stats + table

routes/
└── web.php
```

---

## 🗄️ Database Schema

**Table: `job_applications`**

| Column | Type | Nullable | Notes |
|--------|------|:--------:|-------|
| `id` | BIGINT UNSIGNED | ❌ | Primary key |
| `company` | VARCHAR(255) | ❌ | Company name |
| `position` | VARCHAR(255) | ❌ | Position applied for |
| `status` | VARCHAR(255) | ❌ | `Applied` / `Interview` / `Accepted` / `Rejected` |
| `applied_at` | DATE | ✅ | Application date |
| `notes` | TEXT | ✅ | Additional notes |
| `created_at` | TIMESTAMP | ✅ | - |
| `updated_at` | TIMESTAMP | ✅ | - |

---

## 🛣️ Routes

| Method | URI | Name | Action | Notes |
|--------|-----|------|--------|-------|
| GET | `/` | `index` | `index` | Dashboard |
| POST | `/jobs` | — | `store` | Create new record |
| GET | `/jobs/{id}` | — | `show` | **Returns JSON** (for modals) |
| GET | `/jobs/{id}/edit` | — | `edit` | Standalone edit page |
| PUT | `/jobs/{id}` | — | `update` | Update record |
| DELETE | `/jobs/{id}` | — | `destroy` | Delete record |

> **Note:** The `show` endpoint returns **JSON**, not a view — it's used by the detail & edit modals.

---

## 🔄 How AJAX Works

This app uses a **partial rendering** pattern for all operations.

### 1. Filter & Sort (No Reload)

```
User types in search
    ↓ (debounce 450ms)
fetch GET /?search=xxx&sort=xxx&ajax=1
    ↓
Controller: if ($request->ajax()) → returns _ajax.blade.php
    ↓
JS replaces #table-wrapper and #stats-wrapper
    ↓
Rebinds event listeners
    ↓
Browser URL updated via history.pushState()
```

### 2. CRUD Operations (Add / Edit / Delete)

```
User submits form
    ↓
fetch POST with X-Requested-With header
    ↓
Controller: if ($request->ajax()) → returns JSON {success: true}
    ↓
JS closes modal + calls loadTable()
    ↓
Table & stats update without reload
```

### 3. AJAX Detection in Controller

```php
if ($request->ajax() || $request->input('ajax') === '1') {
    return view('job-applications._ajax', compact(...));
}
return view('job-applications.index', compact(...));
```

---

## 🎨 Customization

### Change Records Per Page

In `JobApplicationController@index`:

```php
$applications = $query->paginate(5);  // change the number
```

### Change Date Display Format

In `index.blade.php` (Flatpickr init):

```js
flatpickr('.date-picker', {
    dateFormat: 'Y-m-d',      // sent to server — do not change
    altFormat: 'd F Y',        // display format
    // ...
});
```

Common formats:

| `altFormat` | Output |
|-------------|--------|
| `d F Y` | 25 September 2026 |
| `d, F Y` | 25, September 2026 |
| `d M Y` | 25 Sep 2026 |
| `l, d F Y` | Thursday, 25 September 2026 |

### Change Search Debounce Delay

In `index.blade.php`:

```js
const delay = value === '' ? 300 : 450;  // adjust here
```

### Change Primary Color (Indigo)

Search & replace across Blade files:
- `bg-indigo-600` → `bg-blue-600` / `bg-emerald-600`
- `text-indigo-600` → matching
- `focus:border-indigo-500` → matching
- `focus:ring-indigo-200` → matching

---

## 🧪 Manual Testing Checklist

| Test Case | Expected Result |
|-----------|-----------------|
| Open `/` | Dashboard with stats + table |
| Type in search | Table refreshes after 450ms (no reload) |
| Change status filter | Instant refresh |
| Pick a date | Table refreshes, calendar closes |
| Click column header | Table sorts, no reload |
| Click pagination | Page changes, smooth scroll to top |
| Click a row | Detail modal opens |
| Click Edit | Edit modal opens with date pre-filled |
| Submit Edit | Modal closes, table + stats update, toast shows |
| Click Delete | Confirmation modal appears |
| Submit Delete | Modal closes, table + stats update, toast shows |
| Add new record | Modal closes, table + stats update |
| Click Reset | All filters cleared, table resets |
| Press ESC | All modals close |

---

## 🐛 Troubleshooting

### Blank / white page on `/`
- Check `storage/logs/laravel.log`
- Set `APP_DEBUG=true` in `.env`, then run `php artisan config:clear`
- Ensure all partials exist (`_stats`, `_table`, `_ajax`)

### Date picker doesn't open
- Make sure the input has the `date-picker` class
- Verify in Console: `document.getElementById('date-filter')._flatpickr`

### AJAX filter not working
- Open Network tab → confirm request with `?ajax=1` is sent
- Confirm controller returns partial when `$request->ajax()`
- Confirm `_ajax.blade.php` exists

### Edit modal date field is empty
- Must use `editDatePicker.setDate(value, true)` — **not** `.value = ...`
- This is required because Flatpickr uses `altInput: true`

### 404 on Delete
- The record may have been deleted in another session
- Refresh the page first

### Data not updating after CRUD
- Check the AJAX response in the Network tab
- Ensure `loadTable()` is called after successful submit
- Ensure `#stats-wrapper` is also being replaced

---

## 📝 Changelog

### v1.1.0
- Full AJAX (table + stats refresh without reload)
- Detail modal
- Flatpickr date inputs
- Pagination (5 per page)
- Toast notifications
- Browser back/forward in sync

### v1.0.0
- Initial CRUD (no AJAX)
- Statistics cards
- Status filter & search

---

## 🤝 Contributing

1. Fork the repo
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

For major changes, please open an issue first to discuss what you'd like to change.

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 👤 Author

**Your Name**
- GitHub: [@your-username](https://github.com/your-username)
- Email: your.email@example.com

---

## 🙏 Credits

- [Laravel](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Flatpickr](https://flatpickr.js.org)
- [Shields.io](https://shields.io) for badges
