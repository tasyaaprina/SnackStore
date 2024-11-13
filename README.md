# Snack Store with Laravel and Filament

This is a Laravel-based e-commerce platform, built using Filament for an intuitive admin dashboard. The platform allows for product management, order handling, and more.

## Features

- **Product Management**: Manage products, categories, and stock.
- **Order Management**: Track and manage customer orders with statuses.
- **User Roles**: Role-based access control to the Filament dashboard.
- **Image Uploads**: Upload and manage product images with previews.
- **Dynamic Slug Generation**: Automatic slugs for categories and products.
- **Relational Data**: Order details with multiple products and quantities per order.

## Requirements

- PHP >= 8.1
- Composer
- Node.js and npm (for frontend assets)
- MySQL or another supported database
- Laravel 11
- Filament (latest version)

## Installation

Follow these steps to set up and run the project on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/mhdthariq/SnackStore.git
cd SnackStore
```

### 2. Install Dependencies

Install the PHP dependencies with Composer:

```bash
composer install
```

Install the JavaScript dependencies:

```bash
npm install
```

### 3. Create a `.env` File

Create a `.env` file by copying the example:

```bash
cp .env.example .env
```

### 4. Generate Application Key

Generate an application key for encryption:

```bash
php artisan key:generate
```

### 5. Configure Database

Open the `.env` file and configure your database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run Migrations and Seeders

Run migrations to create database tables, and optionally seed the database with example data.

```bash
php artisan migrate
php artisan db:seed
```

### 7. Set Up Storage Link

Create a symbolic link from `public/storage` to `storage/app/public` for image uploads.

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

Compile the frontend assets using:

```bash
npm run dev
```

For production, use:

```bash
npm run build
```

### 9. Start the Server

Run the Laravel development server:

```bash
php artisan serve
```

## Using the Application

Visit `http://localhost:8000` in your browser. To access the Filament dashboard, go to `http://localhost:8000/admin` and log in with your admin credentials.

## Configuration for Image Uploads

Images are stored in `storage/app/public/products_images`. Ensure your `.env` file includes the correct `FILESYSTEM_DISK` setting:

```env
FILESYSTEM_DISK=public
```

If you encounter CORS issues, make sure your `.htaccess` file is correctly configured to allow access to images.

## Additional Notes

If you need unique IDs for orders, update the `Order` model as shown below:

```php
protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->id = uniqid('order_');
    });
}
```

## Troubleshooting

- **Route not found errors**: Run `php artisan route:clear` and `php artisan cache:clear`.
- **CORS issues**: Configure your `.htaccess` for image access if using Apache, or configure your CORS policy in Laravel if using other servers.
