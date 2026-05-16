# PsyCheck - Mental Health Self-Assessment Platform

**PsyCheck** is a comprehensive web-based mental health self-assessment and support guidance platform built with modern technologies. It provides users with tools to assess their physical and mental well-being, track their health metrics over time, and receive personalized guidance based on their responses.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation & Setup](#installation--setup)
- [Configuration](#configuration)
- [Database](#database)
- [Usage](#usage)
- [API Routes](#api-routes)
- [Components & Views](#components--views)
- [Models & Database Schema](#models--database-schema)
- [Authentication](#authentication)
- [Testing](#testing)
- [Development](#development)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

PsyCheck is a Laravel-based application designed to help users perform self-guided psychological and physical health assessments. Users can:

- Create an account and log in securely
- Complete mental and physical health assessments
- Track their health metrics with scores and insights
- Receive AI-powered analysis of their assessment results
- Access personalized guidance based on assessment outcomes
- View their health history and progress over time

---

## ✨ Features

### 1. **User Authentication**
   - Secure user registration and login via Laravel Breeze
   - Email verification support
   - Password reset functionality with custom mail templates
   - Profile management and deletion

### 2. **Assessment System**
   - **Three Assessment Tracks:**
     - **Body Track**: Physical health, vitality, and somatic regulation assessment
     - **Mind Track**: Mental health, emotional balance, and cognitive clarity assessment
     - **Analysis Track**: In-depth psychological analysis and insights
   
   - Multiple-choice questions organized by modules
   - Real-time score calculation
   - Immediate feedback and mood assessment

### 3. **Scoring & Feedback System**
   - Percentage-based health scoring (0-100%)
   - Mood determination (Excellent, Good, Fair, Tired, Exhausted/Overwhelmed)
   - Stress level assessment (Very Low, Low, Moderate, High, Severe)
   - Personalized remarks and recommendations
   - Historical tracking of all assessments

### 4. **AI-Powered Analysis** (Optional)
   - Integration with AI services for comprehensive analysis
   - Generates detailed insights from assessment responses
   - Cached analysis results for performance optimization

### 5. **Dashboard**
   - User-friendly dashboard for accessing assessments
   - View previous results and historical data
   - Track health trends and progress
   - Quick access to new assessments

---

## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 12 (PHP 8.2+)
- **Authentication**: Laravel Breeze
- **Database**: MySQL/SQLite (configurable)
- **ORM**: Eloquent
- **Job Queue**: Laravel Queue
- **Caching**: Laravel Cache
- **Logging**: Monolog
- **Templating**: Blade (Pure Server-Side Rendering)

### Frontend
- **Templating Engine**: Laravel Blade (Pure HTML/CSS/PHP)
- **CSS Framework**: Tailwind CSS 3.1 (via CDN and config files)
- **Interactive Components**: Alpine.js 3.4 (lightweight Alpine for interactivity)
- **HTTP Client**: Axios 1.11 (for AJAX requests)

### Testing
- **Testing Framework**: Pest PHP 3.8
- **Mocking**: Mockery
- **Fake Data**: Faker PHP

### Development Tools
- **Code Formatting**: Laravel Pint
- **Package Manager**: Composer
- **Development Server**: Laravel built-in or Artisan
- **Monitoring**: Laravel Pail

---

## 📁 Project Structure

```
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AssessmentController.php      # Handles assessment logic
│   │   │   ├── ProfileController.php         # Manages user profiles
│   │   │   ├── Auth/                         # Authentication controllers
│   │   │   └── Controller.php                # Base controller
│   │   └── Requests/                         # Form request validations
│   ├── Mail/
│   │   └── ResetPasswordMail.php             # Password reset email template
│   ├── Models/
│   │   ├── User.php                          # User model
│   │   ├── AssessmentQuestion.php            # Assessment questions model
│   │   └── AssessmentResult.php              # Assessment results model
│   ├── View/
│   │   └── Components/                       # Blade view components
│   └── Providers/
│       └── AppServiceProvider.php            # Service provider configuration
├── bootstrap/
│   ├── app.php                               # Application bootstrap
│   └── providers.php                         # Provider registration
├── config/
│   ├── app.php                               # Application configuration
│   ├── auth.php                              # Authentication settings
│   ├── database.php                          # Database configuration
│   ├── cache.php                             # Cache configuration
│   ├── mail.php                              # Mail configuration
│   ├── queue.php                             # Queue configuration
│   └── [other configs]
├── database/
│   ├── migrations/                           # Database migrations
│   │   ├── create_users_table.php
│   │   ├── create_assessment_questions_table.php
│   │   ├── create_assessment_results_table.php
│   │   └── [other migrations]
│   ├── factories/
│   │   └── UserFactory.php                   # User model factory for testing
│   └── seeders/
│       ├── DatabaseSeeder.php                # Main seeder
│       └── AssessmentQuestionSeeder.php      # Assessment questions seeder
├── public/
│   ├── index.php                             # Application entry point
│   └── images/                               # Public images (logos, etc.)
├── resources/
│   └── views/                                # Blade templates (Pure server-side)
│       ├── assessment/                       # Assessment views
│       │   ├── body/
│       │   ├── mind/
│       │   ├── analysis/
│       │   ├── exam.blade.php
│       ├── auth/                             # Authentication views
│       ├── dashboard/                        # Dashboard views
│       ├── profile/                          # User profile views
│       ├── layouts/                          # Layout templates
│       ├── components/                       # Reusable Blade components
│       └── welcome.blade.php                 # Landing page
├── routes/
│   ├── web.php                               # Web routes
│   ├── auth.php                              # Authentication routes
│   └── console.php                           # Console routes
├── storage/
│   ├── app/                                  # File storage
│   ├── logs/                                 # Application logs
│   └── framework/                            # Framework caches
├── tests/
│   ├── Feature/                              # Feature tests
│   ├── Unit/                                 # Unit tests
│   └── Pest.php                              # Pest configuration
├── vendor/                                   # Composer dependencies
├── .env.example                              # Environment variables template
├── artisan                                   # Laravel CLI tool
├── composer.json                             # PHP dependencies
├── composer.lock                             # Locked PHP dependencies
├── tailwind.config.js                        # Tailwind CSS configuration
├── postcss.config.js                         # PostCSS configuration
├── phpunit.xml                               # PHPUnit testing configuration
└── README.md                                 # This file
```

---

## 🚀 Installation & Setup

### Prerequisites
- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Database**: MySQL 8.0+ or SQLite
- **Web Server**: Apache or Nginx (optional for development)

### Quick Start

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd Project-PsyCheck
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   ```

3. **Setup Environment**
   ```bash
   # Copy environment configuration
   cp .env.example .env

   # Generate application key
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Create database tables
   php artisan migrate

   # Seed assessment questions (optional)
   php artisan db:seed
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```
   
   Access the application at `http://localhost:8000`

### Manual Setup Details

```bash
# Install PHP dependencies
composer install

# Copy environment configuration
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database tables
php artisan migrate

# Seed assessment questions
php artisan db:seed --class=AssessmentQuestionSeeder
```

---

## ⚙️ Configuration

### Environment Variables
Edit `.env` file to configure:

```env
APP_NAME=PsyCheck
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=psycheck
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Database Configuration
Edit `config/database.php` to select your database driver:
- **MySQL** (default)
- **SQLite**

### Mail Configuration
Configure mail service in `config/mail.php`:
- SMTP (recommended)
- Mailtrap (for testing)

---

## 🗄️ Database

### Migrations
Database tables are created through migrations:

1. **Users Table** (`create_users_table.php`)
   - Stores user account information
   - Email verification timestamp
   - Password (hashed)

2. **Assessment Questions Table** (`create_assessment_questions_table.php`)
   - Assessment questions for each track
   - Question text and options (JSON)
   - Module organization

3. **Assessment Results Table** (`create_assessment_results_table.php`)
   - User assessment responses and scores
   - Mood and stress metrics
   - Personalized remarks
   - Cached user answers (JSON)

### Running Migrations
```bash
# Run all migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database
php artisan migrate:reset

# Refresh database
php artisan migrate:refresh --seed
```

### Seeding Data
```bash
# Seed assessment questions
php artisan db:seed --class=AssessmentQuestionSeeder

# Seed all data
php artisan db:seed
```

---

## 📖 Usage

### Starting Development Server

```bash
# Start development server
php artisan serve

# Server will be available at http://localhost:8000
# For changes to take effect, the browser will auto-refresh (via Blade rendering)
```

### Landing Page
Navigate to `http://localhost:8000` to access the welcome page with:
- Application overview
- Feature highlights
- Call-to-action buttons
- Registration/Login links

### User Registration & Login
1. Click "Register" on the landing page
2. Fill in email and password
3. Verify email address (if email verification is enabled)
4. Login with credentials

### Taking an Assessment
1. Go to Dashboard after login
2. Click on an assessment track:
   - **Physical Vitality**: Assess body health
   - **Mental Health**: Assess mind health
   - **Analysis**: View detailed insights
3. Answer all questions (scale of 0-3)
4. Submit assessment
5. Receive personalized feedback
6. View progress tracking

### Viewing Results
- Results automatically saved to user profile
- Access via Dashboard
- View detailed scores and recommendations
- Track historical progress in results view
- Compare trends over time

---

## 🔗 API Routes

### Public Routes
```
GET  /                          → Welcome page
GET  /register                  → Registration form
POST /register                  → Register new user
GET  /login                     → Login form
POST /login                     → Authenticate user
POST /forgot-password           → Request password reset
```

### Authenticated Routes (require login)
```
GET  /dashboard                 → Dashboard
GET  /assessment/start          → Start assessment page
GET  /assessment/{track}/exam   → Assessment exam questions
POST /assessment/{track}/exam   → Submit assessment
POST /assessment/ai-analysis    → Generate AI analysis
GET  /profile                   → Edit profile
PATCH /profile                  → Update profile
DELETE /profile                 → Delete account
```

### Route Parameters
- `{track}`: Assessment track type (`body`, `mind`, `analysis`)
- `module` (optional): Filter by specific module

---

## 🎨 Components & Views

All views are built with **pure Blade templates** - Laravel's server-side templating engine. No JavaScript framework is required for rendering.

### Layout Templates
```blade
<!-- layouts/app.blade.php - Main authenticated layout -->
<!-- layouts/guest.blade.php - Guest/unauthenticated layout -->
<!-- layouts/navigation.blade.php - Navigation component -->
```

### Assessment Views (Pure Blade)
```blade
<!-- assessment/body/index.blade.php - Physical assessment intro -->
<!-- assessment/mind/index.blade.php - Mental assessment intro -->
<!-- assessment/analysis/index.blade.php - Analysis intro -->
<!-- assessment/exam.blade.php - Assessment questions display -->
```

### Dashboard Views
```blade
<!-- dashboard/dashboard.blade.php - Main user dashboard -->
```

### Profile Views
```blade
<!-- profile/edit.blade.php - Edit profile information -->
<!-- profile/update-password.blade.php - Change password -->
<!-- profile/delete-user.blade.php - Account deletion -->
```

### Reusable Components
Blade components in `resources/views/components/`:
```blade
<x-alert>Warning message</x-alert>
<x-button type="primary">Click Me</x-button>
<x-card title="Title">Card content</x-card>
```

### Template Features
- Server-side rendering (all HTML generated on server)
- Direct PHP logic in templates
- Blade directives: @if, @foreach, @switch, @extends, @section
- Component slots for content passing
- Layout inheritance

---

## 📊 Models & Database Schema

### User Model
```php
- id (Primary Key)
- name (String)
- email (String, Unique)
- email_verified_at (Timestamp, Nullable)
- password (String, Hashed)
- remember_token (String, Nullable)
- created_at, updated_at (Timestamps)
```

### AssessmentQuestion Model
```php
- id (Primary Key)
- module_name (String) - Track type: 'body', 'mind', 'analysis'
- module (String) - Category/module within track
- question_text (String) - The question
- options (JSON Array) - Answer options
- created_at, updated_at (Timestamps)
```

### AssessmentResult Model
```php
- id (Primary Key)
- user_id (Foreign Key → users.id)
- module_name (String) - Assessment track
- title (String) - Result title
- score (Integer) - Percentage score (0-100)
- mood (String) - Determined mood level
- stress (String) - Stress level assessment
- remarks (Text) - Personalized feedback
- answers (JSON) - User's answers to questions
- created_at, updated_at (Timestamps)
```

### Relationships
- **User → AssessmentResults**: One-to-many
- **AssessmentResults → AssessmentQuestions**: Many-to-many (through answers JSON)

---

## 🔐 Authentication

### Laravel Breeze
The application uses Laravel Breeze for authentication:

- Session-based authentication
- CSRF protection
- Rate limiting
- Email verification
- Password reset via secure tokens

### User Roles
Currently supports:
- **Authenticated User**: Can take assessments and view results
- **Guest**: Can only view landing page

### Secure Features
- Passwords hashed with Bcrypt
- Secure session management
- Email verification for new accounts
- Password reset with token expiration
- Profile data protection

---

## 🧪 Testing

### Running Tests
```bash
php artisan test
```

Tests are located in `tests/` directory (Feature, Unit, and Authentication tests).

---

## 💻 Development

### Development Server
```bash
# Start development server
php artisan serve

# Server will be available at http://localhost:8000
```

### Blade Templates
All views are built using **pure Blade templates** (Laravel's server-side templating engine):
- No build tools required
- Direct PHP/HTML rendering
- Changes take effect immediately
- Located in `resources/views/`

### File Structure for Views
```
resources/views/
├── assessment/          # Assessment-related views
│   ├── body/           # Body assessment
│   ├── mind/           # Mind assessment
│   ├── analysis/       # Analysis views
│   ├── exam.blade.php  # Assessment exam display
├── auth/               # Authentication views
├── dashboard/          # User dashboard
├── profile/            # Profile management
├── layouts/            # Master layouts
├── components/         # Reusable Blade components
└── welcome.blade.php   # Landing page
```

### Blade Components
Create reusable components in `resources/views/components/`:
```blade
<!-- Using a component -->
<x-button>Click Me</x-button>

<!-- Creating a component -->
<!-- resources/views/components/button.blade.php -->
<button {{ $attributes }}>{{ $slot }}</button>
```

---

## 🚢 Deployment

### Preparation
```bash
# Clear application cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Ensure storage and bootstrap directories are writable
chmod -R 775 storage bootstrap/cache
```

### Environment Setup
Create `.env` file on production server:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=<production-host>
DB_DATABASE=<production-db>
DB_USERNAME=<db-user>
DB_PASSWORD=<db-password>

MAIL_MAILER=smtp
MAIL_HOST=<mail-host>
MAIL_PORT=587
MAIL_USERNAME=<mail-user>
MAIL_PASSWORD=<mail-password>
MAIL_FROM_ADDRESS=<from-email>
```

### Database Migration
```bash
# Run migrations on production
php artisan migrate --force
```

### Web Server Configuration

**Nginx Example:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/public;

    index index.html index.htm index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Deployment Services
- **Web Server**: Apache or Nginx
- **PHP**: 8.2+ with FPM
- **Database**: MySQL 8.0+ or SQLite

### Production Checklist
- [ ] Set APP_DEBUG=false
- [ ] Set APP_ENV=production
- [ ] Generate unique APP_KEY
- [ ] Configure database credentials
- [ ] Set up email service
- [ ] Configure storage permissions (755)
- [ ] Set up SSL certificate (HTTPS)
- [ ] Test all assessment flows

---

## 👥 Contributing

### Development Workflow
1. Create a feature branch
2. Make changes following code style
3. Write tests for new features
4. Ensure all tests pass
5. Submit pull request

---

## 📄 License

This project is licensed under the MIT License. See LICENSE file for details.

---

## 📞 Support

For questions or support:
- Check the documentation above
- Check application logs: `storage/logs/`

---

## 🎓 Additional Resources

### Laravel Documentation
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Blade Templating Engine](https://laravel.com/docs/12.x/blade)
- [Eloquent ORM](https://laravel.com/docs/12.x/eloquent)
- [Routing](https://laravel.com/docs/12.x/routing)
- [Authentication](https://laravel.com/docs/12.x/authentication)
- [Controllers](https://laravel.com/docs/12.x/controllers)
- [Validation](https://laravel.com/docs/12.x/validation)

### Frontend
- [Tailwind CSS Documentation](https://tailwindcss.com)
- [Tailwind CSS Configuration](https://tailwindcss.com/docs/configuration)
## 🎓 Additional Resources

### Laravel Documentation
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Blade Templating Engine](https://laravel.com/docs/12.x/blade)
- [Eloquent ORM](https://laravel.com/docs/12.x/eloquent)
- [Routing](https://laravel.com/docs/12.x/routing)
- [Authentication](https://laravel.com/docs/12.x/authentication)

### Frontend & Testing
- [Tailwind CSS Documentation](https://tailwindcss.com)
- [Alpine.js Documentation](https://alpinejs.dev)
- [Pest PHP](https://pestphp.com)

---

**Last Updated**: May 16, 2026

**Version**: 1.0.0

**Project**: PsyCheck - Mental Health Self-Assessment Platform