# File Storage System with Auto-Expiry

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)](https://php.net)
[![RabbitMQ](https://img.shields.io/badge/RabbitMQ-FF6600?logo=rabbitmq&logoColor=white)](https://www.rabbitmq.com)

A secure web application for storing PDF/DOCX files with automatic 24-hour expiration.

## Features

- 🚀 Asynchronous file upload
- Automatic file deletion
- File management dashboard
- RabbitMQ integration

## Requirements

- PHP 8.2+
- MySQL 5.7+
- Laravel 11+

## Quick Start

1. **Clone Repository**
```bash
git clone https://github.com/Vakhoo/form-upload.git
cd form-upload

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure .env file
Set up db connection

# Run migrations
php artisan migrate

# Start the app
php artisan serve
npm run dev

# In SEPARATE terminal tab
php artisan queue:work
