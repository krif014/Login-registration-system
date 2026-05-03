🔐 PHP Login, Registration & User Management System (CRUD API Included)

A modern PHP + MySQL authentication system featuring:

User registration & login
Secure password hashing
Session-based authentication
Protected dashboard
Full REST-like CRUD API for users
Responsive UI dashboard

This project demonstrates how real-world authentication systems and user management APIs work in backend applications.

🚀 Tech Stack

✨ Features
🔐 Authentication System
User Registration
Secure Login
Password Hashing (password_hash)
Session-based authentication
Logout system
📊 Dashboard
Protected user dashboard
Displays all registered users
Search functionality
Responsive UI
⚙️ CRUD API (NEW)
Get all users
Get single user
Create user
Update user
Delete user
🧠 API Endpoints
📥 GET ALL USERS
GET /Api.php
📥 GET SINGLE USER
GET /Api.php?id=1
➕ CREATE USER
POST /Api.php
{
  "username": "john",
  "email": "<john@gmail.com>",
  "password": "123456"
}
✏️ UPDATE USER
PUT /Api.php
{
  "id": 1,
  "username": "john_updated",
  "email": "<newmail@gmail.com>"
}
❌ DELETE USER
DELETE /Api.php?id=1
🖼️ Project Preview
<p align="center"> <a href="./Register.png"> <img src="./Register.png" width="45%" /> </a> <a href="./Login.png"> <img src="./Login.png" width="45%" /> </a> </p> <p align="center"> <a href="./Dashboard.png"> <img src="./Dashboard.png" width="45%" /> </a> <a href="./database.png"> <img src="./database.png" width="45%" /> </a> </p>

👉 Includes:

Registration page
Login page
Dashboard UI
Database structure
API system
📁 Project Structure
krif-login/
│
├── db.php          # Database connection (PDO)
├── register.php    # User registration
├── login.php       # User login
├── dashboard.php   # Protected dashboard
├── logout.php      # Logout system
├── Api.php         # REST CRUD API
│
└── assets/
📋 Requirements
PHP 7.4+
MySQL
Apache Server
XAMPP / WAMP / Laragon
⚙️ Installation
1️⃣ Clone Project
git clone <https://github.com/YOUR-USERNAME/YOUR-REPO.git>
2️⃣ Move to server
C:\xampp\htdocs\krif-login
3️⃣ Start server
Apache
MySQL
4️⃣ Create database
CREATE DATABASE krif_login;

USE krif_login;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
5️⃣ Run project
<http://localhost/krif-login/register.php>
🔄 How It Works
📝 Register
User fills form
Password is hashed
Data stored in MySQL
🔐 Login
Credentials checked
Password verified
Session created
📊 Dashboard
Only logged-in users can access
Displays all users from database
⚙️ API
Provides full CRUD access to users
Can be used with frontend apps (React, JS, etc.)
🛡️ Security Features
Password hashing (password_hash)
Prepared statements (PDO & MySQLi)
Session authentication
Input escaping
Protected dashboard
🚀 Future Improvements
🔐 Role-based access (Admin / User)
🧾 Soft delete system
📊 Admin analytics dashboard
🔑 JWT authentication (API upgrade)
📱 React / frontend integration
🔍 Pagination & search API
🤝 Contributing
⭐ Star this repo
🍴 Fork it
📥 Submit pull requests
📄 License

Free for educational use.

👤 Author

UWIMANA Krif
