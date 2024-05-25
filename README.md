
## Introduction

REST API s built with Laravel that handles user authentication, medication inventory management, and customer management.

## Requirements

- PHP >= 8.2
- Composer
- Laravel 11

## Features

- User authentication with registration and login
- Role-based access control (Owner, Manager, Cashier)
- Medication inventory management
- Customer management

## Installation
```bash
git clone https://github.com/gayannad/medication-inventory
```
```bash
cd medication-inventory
```
```bash
composer install
```
```bash
cp .env.example .env
```
```bash
php artisan key:generate
```

### Database Connection

- You can use sqlite or mysql for the database connection.

## Seeding the Database

```bash
php artisan migrate:fresh  --seed
```

## Run project
```bash
php artisan serve
```












