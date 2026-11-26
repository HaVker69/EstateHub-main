# EstateHub – Real Estate Management Platform

EstateHub is a web application designed for listing, browsing, searching, and managing real estate properties. The platform supports three levels of access: guests, registered users, and administrators.

The application is built using the Laravel framework, with a MySQL database and Bootstrap for the user interface.

## Team Members

- Kristina Arsenijević
- Miloš Stevanović
- Predrag Krsmanović

## Technologies

- **Backend:** PHP 8.4, Laravel 12
- **Database:** MySQL
- **Frontend:** Blade, Bootstrap 5, JavaScript
- **Tools and Libraries:** Composer, npm, Vite, Spatie Laravel Permission
- **Architecture and Features:** MVC, Eloquent ORM, Migrations, Form Requests, Policies
- **Containerization:** Docker, Docker Compose, FrankenPHP

## Features

### Guest Users

- Browse approved property listings
- Search and filter properties
- View detailed property information
- Register and log in

### Registered Users

- Create, edit, and delete their own property listings
- Submit inquiries about properties
- Schedule property viewings
- Add properties to favorites
- Manage their own listings, inquiries, and scheduled viewings
- Newly created or updated listings are submitted for administrator approval

### Administrators

- Manage user accounts and roles
- Review, approve, and reject property listings
- Provide rejection reasons
- Edit and delete listings
- Manage property types
- View platform statistics

## Local Installation

### Prerequisites

Make sure the following tools are installed:

- PHP 8.4 or later
- Composer
- Node.js 18 or later
- MySQL 8 or later

### 1. Clone the Repository

```bash
git clone <REPOSITORY_URL>
cd EstateHub
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure the Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your MySQL database connection in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=estatehub
DB_USERNAME=root
DB_PASSWORD=
```

Create a database named `estatehub` before proceeding.

### 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

Create the symbolic link for public storage:

```bash
php artisan storage:link
```

### 5. Start the Application

Run the Laravel development server:

```bash
php artisan serve
```

In a separate terminal, start Vite:

```bash
npm run dev
```

The application will be available at:

`http://127.0.0.1:8000`

## Test Accounts

The following accounts are available after running the seeders:

| Role | Email | Password |
|---|---|---|
| Administrator | admin@estatehub.test | password |
| User | kristina@estatehub.test | password |
| User | milos@estatehub.test | password |
| User | predrag@estatehub.test | password |

**Note:** These accounts are intended for local development and testing only. Do not use these credentials in a production environment.

## Docker Setup

The project supports Docker Compose and includes a Laravel application running with FrankenPHP and a MySQL 8.4 database.

### 1. Configure the Environment

Copy the Docker environment example:

```bash
cp .env.docker.example .env
```

Configure the following variables in the `.env` file:

- `APP_URL`
- `DB_PASSWORD`
- `DB_ROOT_PASSWORD`
- `APP_PORT`

Generate your own application key:

```bash
docker compose run --rm app php artisan key:generate --show
```

Copy the generated key into the `APP_KEY` variable in your `.env` file.

### 2. Build and Start the Containers

```bash
docker compose up -d --build
```

### 3. Initialize the Database

On the first run, execute the migrations and seeders:

```bash
docker compose exec app php artisan migrate --seed
```

The Docker environment initializes the essential application data:

- User roles
- Administrator account
- Property types

Unlike the local development setup, the Docker initialization does not create demo users or sample property listings.

### 4. Access the Application

The application will be available on the port specified by the `APP_PORT` variable in your `.env` file.

**Note:** Docker Compose uses named volumes to persist MySQL database data and uploaded property images.

## Testing

The test suite uses an in-memory SQLite database, allowing tests to run independently of the MySQL database.

Run the tests using:

```bash
php artisan test
```

## License

This project was developed as part of an academic project and serves as a demonstration of web application development using the Laravel framework.