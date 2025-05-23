# Student Enquiry Management System

A web-based Laravel application to manage student enquiries. It supports two roles: Admin and Super Admin. Admin can manage enquiries, while only Super Admin has access to expense tracking.

*Description
- Student Enquiry Submission Form
- Role-Based Access (Admin & Super Admin)
- Filter and Edit Enquiries by Class
- Expense Management (Restricted to Super Admin)
- Bootstrap UI

*Features
- Student Enquiry Submission Form
- Role-Based Access (Admin & Super Admin)
- Filter and Edit Enquiries by Class
- Expense Management (Restricted to Super Admin)
- Bootstrap UI

*Technologies Used
- Laravel 9
- Blade (Laravel's Templating Engine)
- Bootstrap 5
- MySQL

*Setup Instructions
1. Clone the repo:
   git clone https://github.com/kuldeeplagade/student-enquiry-management.git

2. Install dependencies:
   composer install

3. Create .env file and set up:
   cp .env.example .env
   php artisan key:generate

4. Set up database 
   Update .env → DB_CONNECTION=MySQL

5. Run migrations:
   php artisan migrate

6. Start the server:
   php artisan serve

7. Create Default Admin Users via Tinker
    // Create Admin User
    \App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('adminpass'),
    'is_super_admin' => 0
    ]);

    // Create Super Admin User
    \App\Models\User::create([
    'name' => 'Super Admin',
    'email' => 'superadmin@gmail.com',
    'password' => bcrypt('superpass'),
    'is_super_admin' => 1
    ]);

8. Login details 
    *Super Admin:
    Email: superadmin@gmail.com
    Password: superpass

    *Admin:
    Email: admin@gmail.com
    Password: adminpass







