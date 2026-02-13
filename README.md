# PHP Login and Registration System

This is a simple authentication system built using PHP, MySQL, PDO, sessions, and password hashing.

It allows users to:

- Register an account
- Login securely
- Access a protected dashboard
- Logout safely

---

## Requirements

- PHP 7.4 or higher
- MySQL
- Apache server
- XAMPP, WAMP, or Laragon (recommended for local setup)

---

## Project Structure

krif-login/
│
├── db.php
├── register.php
├── login.php
├── dashboard.php
└── logout.php

---

## Installation Guide

### 1. Clone the Repository

git clone https://github.com/YOUR-USERNAME/krif-login.git

Move the folder into your server directory.

For XAMPP:
C:\xampp\htdocs\

---

### 2. Start Server

Start Apache and MySQL.

---

### 3. Create Database

Open MySQL CLI or phpMyAdmin and run:

CREATE DATABASE krif_login;

USE krif_login;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---

### 4. Configure Database Connection

Open db.php and make sure the database credentials are correct:

$host = 'localhost';
$db   = 'krif_login';
$user = 'root';
$password = '';

If your MySQL has a password, update $password.

---

### 5. Run the Application

Open in browser:

http://localhost/krif-login/register.php

Register a new user.

Then login at:

http://localhost/krif-login/login.php

---

## How It Works

Registration:
- Form data is sent using $_POST
- Password is hashed using password_hash()
- User is stored in the database

Login:
- User enters credentials
- Password is verified using password_verify()
- Session is created
- User is redirected to dashboard

Dashboard:
- Only accessible if session exists
- Redirects to login if not authenticated

Logout:
- Session is destroyed
- User is redirected to login

---


---

## Author

UWIMANA Krif
