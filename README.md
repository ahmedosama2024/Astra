
# # 🌟 Astra Project - Product & Category Management System

## 🚀 Overview

**Astra** is a Laravel-based application for managing **products**, **categories**, and **dynamic pricing**. It includes:

- ✅ Full CRUD operations for products and categories  
- 🔄 Many-to-many relationships between products and categories  
- ⏱️ Time-based pricing management  
- 🔐 Authentication via Laravel Passport  
- 👥 Role-based permissions using Laratrust  
- 🧪 Comprehensive test coverage  

---

## ✨ Features

### 🔧 Core Functionality

- **Product Management:** Create, read, update, and delete products  
- **Category Management:** Organize products into multiple categories  
- **Dynamic Pricing:** Set prices valid for specific date ranges  
- **Current Price Lookup:** Automatically determine the valid price based on the current date  

### 🛡️ Security

- **JWT Authentication** via Laravel Passport  
- **Role-based permissions**: Admin, Manager, User  
- **Protected API endpoints**

---

## 🛠️ Technical Specifications
## 🌐 Website Endpoints

```http
GET     api/categories
GET     api/categories/{category}
GET     api/categories/{category}/products
GET     api/categories/{category}/products/{product}
POST    api/login
DELETE  api/logout
POST    api/signup

Admin Endpoints
GET     api/admin/categories
GET     api/admin/categories/{category}
PUT     api/admin/categories/{category}
DELETE  api/admin/categories/{category}

GET     api/admin/categories/{category}/products
POST    api/admin/categories/{category}/products
GET     api/admin/categories/{category}/products/{product}
PUT     api/admin/categories/{category}/products/{product}
DELETE  api/admin/categories/{category}/products/{product}

POST    api/admin/login
DELETE  api/admin/logout

GET     api/admin/prices
POST    api/admin/prices
GET     api/admin/prices/{price}
PUT     api/admin/prices/{price}
DELETE  api/admin/prices/{price}

GET     api/admin/roles
GET     api/admin/roles/{role}
DELETE  api/admin/roles/{role}

PUT     api/admin/users/{user}

🧩 Installation

git clone https://github.com/your-repo/astra-project.git
cd astra-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan passport:install
npm install && npm run dev
php artisan serve

🧪 Testing

php artisan test

🤝 Contributing
Please see the CONTRIBUTING file for guidelines.

🔐 Security
If you discover any security-related issues, please email us directly instead of using the issue tracker.

🙌 Credits
All Contributors

📄 License
The MIT License (MIT). See LICENSE for more information.
