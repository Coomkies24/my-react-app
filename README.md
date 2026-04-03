<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align="center">Activity 2: Eloquent Relationships</h1>

<p align="center">
A Laravel project demonstrating One-to-One, One-to-Many, and Many-to-Many relationships.
</p>

---

## 📌 Objective

This project demonstrates the three types of Eloquent Relationships in Laravel:

- One-to-One  
- One-to-Many  
- Many-to-Many  

All relationships are implemented in a single Laravel project.

---

## 🧩 Project Concept

This system represents a **Library Management System** where:

- A **Member** has a Membership Card  
- A **Category** contains many Books  
- Members can borrow multiple Books, and Books can be borrowed by multiple Members  

---

## 🔗 Relationships Implemented

### 1️⃣ One-to-One
**Member → MembershipCard**

- Each Member has one Membership Card  
- Each Membership Card belongs to one Member  

---

### 2️⃣ One-to-Many
**Category → Books**

- One Category can have many Books  
- Each Book belongs to one Category  

---

### 3️⃣ Many-to-Many
**Member ↔ Books**

- A Member can borrow many Books  
- A Book can be borrowed by many Members  

---

## 🗄️ Database Structure

Tables used:

- members  
- membership_cards  
- categories  
- books  
- book_member (pivot table)  

---

## 🧪 Sample Data

### Members and their Books
- Daniel Casimiro → Physics Basics, Chemistry Intro  
- Maria Santos → Physics Basics  

### Books and their Members
- Physics Basics → Daniel Casimiro, Maria Santos  
- Chemistry Intro → Daniel Casimiro  

---

## ▶️ How to Run the Project

```bash
git clone https://github.com/YOUR-USERNAME/YOUR-REPO.git
cd YOUR-REPO

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed
php artisan serve

Open in browser:
http://127.0.0.1:8000/
