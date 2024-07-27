# Book Management Application Setup Instructions

# 1. Clone the repository
git clone https://github.com/marrwan/book-management.git
cd book-management

# 2. Install dependencies
composer install
npm install

# 3. Create and configure the .env file
cp .env.example .env
nano .env

# 4. Generate application key
php artisan key:generate

# 5. Set up the database
# - Update the .env file with your database information
# - Run the migrations
php artisan migrate

# 6. Run the development server
php artisan serve
npm run dev
