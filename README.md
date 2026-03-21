# 🔐 PHP Login & Registration System

A simple and secure authentication system built using **PHP**, **MySQL**, **PDO**, **sessions**, and **password hashing**.

This project demonstrates how user authentication works in a real-world web application.

---

## 🚀 Tech Stack

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-Secure%20DB-orange?style=for-the-badge)

---

## ✨ Features

- 🔑 User Registration  
- 🔐 Secure Login System  
- 🛡️ Password Hashing (`password_hash`)  
- 🔒 Session-Based Authentication  
- 📄 Protected Dashboard  
- 🚪 Secure Logout  

---
## 🖼️ Image Preview

<p align="center">
 <a href="./Register.png">
  <img src="./Register.png" width="45%" />
 </a> 
<a href="./Login.png">
<img src="./Login.png" width="45%" />
</a>
<br/>
<a href="./Dashboard.png">
<img src="./Dashboard.png" width="45%" />
</a>   
<a href="./database.png">
<img src="./database.png" width="45%" />
</a>
</p>

👉 These images show:
- Registration page  
- Login page  
- Dashboard  
- Database structure  

---


## 📁 Project Structure

```text id="m2v9qp"
krif-login/
│
├── db.php           # Database connection (PDO)
├── register.php     # User registration
├── login.php        # User login
├── dashboard.php    # Protected page
└── logout.php       # Logout and destroy session
📋 Requirements
PHP 7.4 or higher
MySQL
Apache Server
XAMPP / WAMP / Laragon (recommended)
⚙️ Installation Guide
1️⃣ Clone the Repository
git clone https://github.com/YOUR-USERNAME/krif-login.git

Move the project into your server directory:

C:\xampp\htdocs\
2️⃣ Start Server

Start:

Apache
MySQL
3️⃣ Create Database

Run this in phpMyAdmin or MySQL:

CREATE DATABASE krif_login;

USE krif_login;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
4️⃣ Configure Database

Open db.php and update:

$host = 'localhost';
$db = 'krif_login';
$user = 'root';
$password = '';
5️⃣ Run the Application

Open in your browser:

http://localhost/krif-login/register.php

👉 Register a new user
👉 Then login:

http://localhost/krif-login/login.php
🔄 How It Works
📝 Registration
Form data sent via $_POST
Password is securely hashed using password_hash()
User data stored in MySQL
🔐 Login
Credentials are verified
Password checked using password_verify()
Session is created
User is redirected to dashboard
📊 Dashboard
Protected page
Only accessible if user is logged in
Redirects to login if not authenticated
🚪 Logout
Session is destroyed
User is redirected to login page
🛡️ Security Features
Password hashing 🔐
Prepared statements (PDO)
Session-based authentication
Protection against unauthorized access
🧠 Learning Objectives

This project helps you understand:

PHP backend development
MySQL database operations
User authentication systems
Session management
Secure password handling
🤝 Contributing

If you like this project:

⭐ Star this repository
🍴 Fork it
📥 Submit pull requests

Contributions are welcome!

📄 License

This project is open-source and free to use for educational purposes.

👤 Author

UWIMANA Krif
