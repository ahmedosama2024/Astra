Astra Project - Product & Category Management System
Overview
Astra is a Laravel-based application for managing products, categories, and dynamic pricing. The system features:

Complete CRUD operations for products and categories

Many-to-many relationships between products and categories

Time-based pricing management

Authentication via Laravel Passport

Role-based permissions using Laratrust

Comprehensive test coverage

Features
Core Functionality
Product Management: Create, read, update, and delete products

Category Management: Organize products into multiple categories

Dynamic Pricing: Set prices valid for specific date ranges

Current Price Lookup: Automatically determine the valid price based on current date

Security
JWT Authentication via Laravel Passport

Role-based permissions (Admin, Manager, User)

Protected API endpoints

Technical Specifications
Database Schema
products
- id
- name
- image_url
- description
- created_at
- updated_at

categories
- id
- name
- created_at
- updated_at

category_product (pivot)
- category_id
- product_id

prices
- id
- product_id
- price (decimal)
- start_date (date)
- end_date (date)
- created_at
- updated_at


======================Website Endpoints===========
GET|HEAD        api/categories ............................ categories.index › Website\CategoryController@index
  GET|HEAD        api/categories/{category} ................... categories.show › Website\CategoryController@show
  GET|HEAD        api/categories/{category}/products categories.products.index › Website\ProductController@index
  GET|HEAD        api/categories/{category}/products/{product} categories.products.show › Website\ProductControl…
  POST            api/login ................................................ login › Website\AuthController@login
  DELETE          api/logout ............................................. logout › Website\AuthController@logout
  POST            api/signup ............................................. signup › Website\AuthController@signup
=====================Admin Endpoints================
GET|HEAD        api/admin/categories .................. admin.categories.index › Admin\CategoryController@index
  GET|HEAD        api/admin/categories/{category} ......... admin.categories.show › Admin\CategoryController@show
  PUT|PATCH       api/admin/categories/{category} ..... admin.categories.update › Admin\CategoryController@update
  DELETE          api/admin/categories/{category} ... admin.categories.destroy › Admin\CategoryController@destroy
  GET|HEAD        api/admin/categories/{category}/products admin.categories.products.index › Admin\ProductContro…
  POST            api/admin/categories/{category}/products admin.categories.products.store › Admin\ProductContro…
  GET|HEAD        api/admin/categories/{category}/products/{product} admin.categories.products.show › Admin\Prod…
  PUT|PATCH       api/admin/categories/{category}/products/{product} admin.categories.products.update › Admin\Pr…
  DELETE          api/admin/categories/{category}/products/{product} admin.categories.products.destroy › Admin\P…
  POST            api/admin/login ...................................... admin.login › Admin\AuthController@login
  DELETE          api/admin/logout ................................... admin.logout › Admin\AuthController@logout
  GET|HEAD        api/admin/prices ............................. admin.prices.index › Admin\PriceController@index
  POST            api/admin/prices ............................. admin.prices.store › Admin\PriceController@store
  GET|HEAD        api/admin/prices/{price} ....................... admin.prices.show › Admin\PriceController@show
  PUT|PATCH       api/admin/prices/{price} ................... admin.prices.update › Admin\PriceController@update
  DELETE          api/admin/prices/{price} ................. admin.prices.destroy › Admin\PriceController@destroy
  GET|HEAD        api/admin/roles ................................ admin.roles.index › Admin\RoleController@index
  GET|HEAD        api/admin/roles/{role} ........................... admin.roles.show › Admin\RoleController@show
  DELETE          api/admin/roles/{role} ..................... admin.roles.destroy › Admin\RoleController@destroy
  PUT|PATCH       api/admin/users/{user} ................... admin.users.update › Admin\UserRoleController@update

  Installation
  git clone https://github.com/your-repo/astra-project.git
cd astra-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan passport:install
npm install && npm run dev
php artisan serve

Testing
php artisan test

Contributing
Please see CONTRIBUTING for details.

Security
If you discover any security related issues, please email <EMAIL> instead of using the issue tracker.

Credits
- [<NAME>](https://github.com/your-name)
- [All Contributors](../../contributors)

License
The MIT License (MIT). Please see LICENSE for more information.