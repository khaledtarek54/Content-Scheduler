# Content Scheduler
A Laravel-based API for scheduling and managing content across multiple platforms.
I used `Clean architecture` For structuring my project to enhance maintainability and scalability.

## Features
- **Authentication**: Secure API using Laravel Sanctum.
- **Post Management**: Create, update, and schedule posts.
- **Platform Integration**: Assign posts to different platforms.
- **Queue & Scheduling**: Processes scheduled posts using Laravel's job queue.
- **Rate Limiting & Caching**: Protects API endpoints and optimizes performance.
- **Frontend:** Built using Vue.js with TailwindCSS for styling.
  
## Installation

### Clone the repository:
```bash
git clone https://github.com/khaledtarek54/Content-Scheduler.git  
cd Content-Scheduler
```

### Install dependencies:
```bash
composer install  
npm install && npm run build  
```

### Set up environment:
```bash
cp .env.example .env  
php artisan key:generate  
```

### Configure database:
Update `.env` with your database credentials, then run:
```bash
php artisan migrate --seed  
```

### Start the server:
```bash
php artisan serve  
```

## API Endpoints

### Authentication:
#### Login:
```http
POST /api/login
```
**Request Body:**
```json
{
  "email": "test@example.com",
  "password": "password123"
}
```
## Frontend
- **Framework:** Vue.js
- **Styling:** TailwindCSS
- **Component-based architecture:** Ensures reusability and maintainability.
- **State Management:** Uses pinia for state management.
- **Toast Notifications:** Provides validation error feedback and status messages.




