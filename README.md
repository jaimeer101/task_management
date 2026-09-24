
## Project Name
Task Management System
## Project Description
A system where users can manage their tasks
## Tech Stack
**Frontend (Client):**
* **Framework:** [Vue 3](https://vuejs.org/) (Composition API)
* **Glue / Routing:** [Inertia.js](https://inertiajs.com/)
* **UI & Styling:** [Bootstrap 5](https://getbootstrap.com/) & [AdminLTE 4](https://adminlte.io/)
* **Icons:** Bootstrap Icons
* **Build Tool:** [Vite](https://vitejs.dev/)

**Backend (Server):**
* **Language:** PHP 8.5
* **Framework:** Laravel 13
* **Authentication:** Laravel Breeze (Inertia Stack)
* **Database:** MySQL

## Instrucions to install
1. clone the project
2. create database in your server
3. if no env, copy .env.example and rename it .env
4. update database connection in the .env \
DB_CONNECTION=mysql\
DB_HOST=database server ip\
DB_PORT=database server port\
DB_DATABASE=database name\
DB_USERNAME=database username\
DB_PASSWORD=database password
5. Install composer
composer install
6. Install node
npm install
7. Run migration
php artisan migrate
8. Run the below command to insert data \
php artisan db:seed
9. Generate application key \
php artisan key:generate
9. Run php artisan serve
10. In separate tab run npm run serve


## Login Credentials
### Administrator
**Username:** admin@taskmanager.com \
**Password:** password123

### User 1
**Username:** user1@taskmanager.com \
**Password:** password123

### User 2
**Username:** user2@taskmanager.com \
**Password:** password123