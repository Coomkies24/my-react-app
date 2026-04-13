<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align="center">Library Management System (Eloquent Relationships + CRUD & Middleware)</h1>

<p align="center">
A full-stack Laravel & React (Inertia.js) project demonstrating database relationships, full CRUD functionality, and Role-Based Access Control (RBAC).
</p>

---

## 🎯 Objectives Completed

This repository contains the completion of two major activities:

**1. Activity 2: Eloquent Relationships**
- Implemented One-to-One, One-to-Many, and Many-to-Many relationships.

**2. Activity: Middleware + CRUD Integration**
- Built a modern Single Page Application (SPA) UI using React and Inertia.js.
- Implemented Full CRUD (Create, Read, Update, Delete) for Books.
- Applied server-side and client-side protection using Laravel Middleware and Policies.
- Created dynamic UI behavior based on User Roles (Admin vs. Member).

---

## 🚀 Features

* **Eager Loading:** Efficiently loads related database models (e.g., loading Categories with Books) to prevent N+1 query problems.
* **Role-Based UI:** The React interface automatically hides restricted actions (Create, Edit, Delete) if the logged-in user is not an Admin.
* **Backend Security:** Custom `AdminMiddleware` and `UserPolicy` ensure that even if the frontend is bypassed, unauthorized API requests are blocked with a `403 Forbidden` error.

---

## 🔗 Database Relationships

### One-to-One
**Member → MembershipCard**
- Each Member has one Membership Card.
- Each Membership Card belongs to one Member.

### One-to-Many
**Category → Books**
- One Category can have many Books.
- Each Book belongs to one Category.

### Many-to-Many
**Member ↔ Books**
- A Member can borrow many Books.
- A Book can be borrowed by many Members.

---

## Screenshots

### 1. Member View (Read-Only Access)
Regular members can view the catalog and eager-loaded categories, but administrative actions are restricted and display as "View Only".

<img width="1919" height="962" alt="Screenshot 2026-04-13 162726" src="https://github.com/user-attachments/assets/ec83a623-51d3-42e3-8db2-5e957e38764c" />

### 2. Admin View (Full CRUD Access)
Administrators have access to the "Add New Book" form, as well as inline "Edit" and "Delete" buttons to manage the inventory.

<img width="1919" height="957" alt="Screenshot 2026-04-13 163047" src="https://github.com/user-attachments/assets/01dd339f-b24d-45a0-9f55-6e5101f97b50" />

---

## ⚙️ How to Run the Project

```bash
# 1. Clone the repository
git clone [https://github.com/YOUR-USERNAME/YOUR-REPO.git](https://github.com/YOUR-USERNAME/YOUR-REPO.git)
cd YOUR-REPO

# 2. Install PHP and Node dependencies
composer install
npm install

# 3. Setup Environment
cp .env.example .env
php artisan key:generate

# 4. Migrate and Seed the database (Creates test Admins and Members)
php artisan migrate:fresh --seed

# 5. Start the development servers (Run these in two separate terminals)
php artisan serve
npm run dev
````

*Open in browser: http://127.0.0.1:8000/*

-----

## ERD (Entity Relationship Diagram)

The database architecture for this project.

\<img width="462" height="471" alt="Eloquent Relationship drawio" src="https://github.com/user-attachments/assets/04e86ab8-04ed-48f1-8812-6a1fb234a1ea" /\>

```
