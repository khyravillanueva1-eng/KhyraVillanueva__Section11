# Personal Task Manager

A simple Laravel app for keeping school tasks, due dates, and completion status in one place.

## Project Information

- **Project Code:** WST21-PM-2026-SF
- **Student Name:** [Enter your name]
- **Course & Year:** [Enter your course and year]
- **Database Used:** SQLite by default; MySQL can be configured in `.env`

## Features

- Add Task: Save a task name, optional description, and optional due date
- View Tasks: See all tasks and pending/completed counts
- Edit Task: Update task details
- Delete Task: Remove a task
- Update Status: Change a task between Pending and Completed

## Requirements

- PHP 8.3 or later
- Composer
- Node.js and npm

## Run Locally

From the project folder:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build
```

Start the Laravel server:

```bash
php artisan serve
```

Open the URL printed by the command. For MySQL, set `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` before migrating.

## Tests

```bash
php artisan test
```

## Submission

Push the complete project to a public GitHub repository and submit that repository URL.
