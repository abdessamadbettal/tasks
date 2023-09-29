## Laravel Vue Jwt tailwind mangoDb Example Project
simple web application that allows users to create and manage a list of tasks using laravel , vue , tailwind , jwt, and mongoDB folowing best practices and coding standards and also CI CD


# Setup

```
composer install
cp .env.example .env
```

copy .env.example to .env and update the following lines to use mongoDB
```
DB_CONNECTION=mongodb
DB_DATABASE=tasks_db
DB_DSN=mongodb+srv://yourMongoDbUrl
```

then
```
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
```

# Usage

Run the backend
```
php artisan serve
```

Run the front-end
```
cd vue
npm install
npm run dev
```

Browse the website using
http://localhost:5173


# Testing
add your .env.testing file and update the following lines to use mongoDB
```
DB_DATABASE=tasks_db_test
```

then

Run the tests
```
php artisan test
```

# Postman Collection
for postman collection you can find it here
https://www.postman.com/crimson-crater-867589/workspace/tasks

