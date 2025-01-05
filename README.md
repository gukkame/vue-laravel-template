# Laravel + Vue App Setup Instructions

## Prerequisites

Make sure you have the following installed:
- PHP >= 7.3
- Composer
- Node.js & npm
- Laravel CLI

## Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/gukkame/vue-laravel-template.git
    cd laravel-php-template
    ```

2. **Install PHP dependencies:**
    ```sh
    composer install
    ```

3. **Install Node.js dependencies:**
    ```sh
    npm install
    ```

4. **Copy the `.env.example` file to `.env`:**
    ```sh
    cp .env.example .env
    ```

5. **Generate the application key:**
    ```sh
    php artisan key:generate
    ```

6. **Configure your `.env` file:**
    - Set your database credentials
    - Configure other environment variables as needed

7. **Run database migrations:**
    ```sh
    php artisan migrate
    ```

## Running the Application

1. **Start the Laravel development server:**
    ```sh
    php artisan serve
    ```
    ```sh
    npm run dev
    ```

2. **Access the application:**
    Open your browser and navigate to `http://localhost:8000`

## Additional Commands

- **Build assets for production:**
  ```sh
  npm run production
  ```

## Troubleshooting

- Ensure all prerequisites are installed and properly configured.
- Check the `.env` file for correct settings.
- Review the Laravel and Vue documentation for additional help.
