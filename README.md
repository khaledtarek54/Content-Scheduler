# Content Scheduler

> A Laravel API for scheduling and publishing content across multiple platforms — built with **clean-architecture** layering, **Sanctum** auth, **Redis-backed queues**, and a **Vue + Tailwind** frontend.

## What it does

Lets users author posts, schedule them for future publication, and target them to one or more platforms. A queued worker dispatches posts at the scheduled time and records publish status.

## Features

- 🔐 **Authentication** — Laravel Sanctum (token-based API)
- 📝 **Post management** — full CRUD with validation via custom Form Requests
- 🎯 **Platform targeting** — assign each post to one or more platforms
- ⏰ **Scheduling** — Laravel scheduler + queued jobs handle publication at the scheduled time
- 🚦 **Rate limiting** — per-route throttles protect the API
- ⚡ **Caching** — Redis caching on hot read endpoints
- 🖥️ **Frontend** — Vue 3 + Tailwind CSS

## Tech stack

- PHP 8.2 / Laravel 11
- Laravel Sanctum
- Redis (queues + cache)
- MySQL
- Vue 3
- Tailwind CSS
- Vite

## Architecture

The codebase follows clean-architecture layering — routes thin, controllers thinner, business logic isolated in services, persistence through Eloquent repositories.

```
app/
├── Http/Controllers/Api/  # HTTP layer only
├── Http/Requests/         # Validation
├── Services/              # Business logic
├── Repositories/          # Persistence
├── Jobs/                  # Queued work (publish, retry, notify)
└── Models/                # Eloquent
```

## Quick start

```bash
git clone https://github.com/khaledtarek54/Content-Scheduler.git
cd Content-Scheduler

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# In separate terminals:
php artisan serve
php artisan queue:work        # processes scheduled posts
php artisan schedule:work     # dispatches due posts
```

## API overview

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/api/auth/login` | Issue Sanctum token |
| GET    | `/api/posts` | List posts (paginated, filterable) |
| POST   | `/api/posts` | Create a scheduled post |
| PATCH  | `/api/posts/{id}` | Update post |
| DELETE | `/api/posts/{id}` | Delete post |
| GET    | `/api/platforms` | List target platforms |

## Run the tests

```bash
php artisan test
```

## License

MIT

---

Built by [Khaled Tarek](https://github.com/khaledtarek54) · [LinkedIn](https://www.linkedin.com/in/khaled-tarek-eng)
