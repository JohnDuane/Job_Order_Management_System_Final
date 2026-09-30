# JOMS – Full Backend Setup

This build completes the main Job Order Management workflow on top of the existing Laravel + Livewire/Blade project.

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+
- MySQL/MariaDB (recommended for the supplied `.env`)
- A database named `joms1` unless you change `.env`

## First run

1. Open the project folder in Terminal.
2. Make sure `.env` exists. If not:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Create the MySQL database:

   ```sql
   CREATE DATABASE joms1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. Check the DB settings in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=joms1
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Install PHP/JS dependencies if the included `vendor/` or `node_modules/` are missing:

   ```bash
   composer install
   npm install
   ```

6. Build the frontend:

   ```bash
   npm run build
   ```

7. Create the database tables and demo accounts/data:

   ```bash
   php artisan migrate:fresh --seed
   ```

8. Start Laravel:

   ```bash
   php artisan serve
   ```

## Demo accounts

All seeded accounts use password `03132006`:

- Admin: `admin@gmail.com`
- Supervisor: `supervisor@gmail.com`
- Mechanic: `mechanic@gmail.com`

## Workflow implemented

1. **Mechanic** creates a job order.
2. The system validates that the selected vehicle belongs to the selected customer.
3. One or more services can be selected and the total cost is calculated automatically from service prices.
4. The job order is submitted with status `pending_approval`.
5. **Supervisor** can approve it or return it as `needs_revision` with required remarks.
6. **Mechanic** can open a returned job order, correct it, and resubmit it.
7. **Supervisor** can assign one or more mechanics to an approved job order.
8. **Mechanic** can start an assigned job (`in_progress`).
9. **Mechanic** can mark an in-progress job as `completed`.
10. **Admin** can monitor all job orders, customers, vehicles, services, and staff.
11. Approval actions are recorded in `Job_Order_Approval` for history/auditing.
12. Assignment actions are recorded in `Job_Order_Assignment`.

## UI feedback added

- Success modal for successful actions.
- Failure/error modal for server-side errors and validation errors.
- Confirmation prompts for destructive/workflow actions.
- Supervisor revision form modal requiring a reason.
- Mechanic assignment form modal.

## Important

The original project already contains the authentication/profile/team infrastructure. The implementation keeps that infrastructure and adds the job-order workflow around it.

For a clean reset during development, use:

```bash
php artisan migrate:fresh --seed
npm run build
php artisan serve
```
