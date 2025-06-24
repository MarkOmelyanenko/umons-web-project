# Karate Club Web Project

This repository contains a Symfony application used to manage a karate club website. It includes features such as blog posts, event management and a small administration dashboard built with EasyAdmin.

## Requirements

- PHP 8.2 or higher with the following extensions enabled: `dom`, `xml`, `simplexml`
- [Composer](https://getcomposer.org/)
- A MySQL
- [Symfony CLI](https://symfony.com/download) (optional but recommended)

## Installation

1. Install the required PHP extensions and Composer.
2. Clone the repository and install the dependencies:

   ```bash
   composer install
   ```

3. Copy the example environment file and adjust the database credentials:

   ```bash
   cp .env .env.local
   # then edit .env.local and set DATABASE_URL
   ```

4. Create the database and run the migrations:

   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. Download the JavaScript dependencies used by Symfony's asset mapper:

   ```bash
   php bin/console importmap:install
   ```

## Running the Application

### Using Symfony CLI

If you have the Symfony CLI installed you can start the development server with:

```bash
symfony server:start
```
