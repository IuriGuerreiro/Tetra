# Tetra CPD Management System

## Overview

Tetra is a web-based Continuing Professional Development (CPD) management system for educational organizations. It allows administrators to create, edit, and manage CPD courses, delivery modes, and users. The platform supports secure authentication, role-based access (admin and regular users), and a modern, responsive UI for managing professional development activities.

## Features
- **User Authentication:** Secure login/logout, session management, and role-based access control (admin/user).
- **CPD Management:** Create, edit, view, and delete CPD courses with details such as title, rationale, objectives, outcomes, procedures, delivery mode, assessment, and images.
- **Delivery Modes:** Manage delivery modes (e.g., Workshop, Interactive Talk) with CRUD operations and relational integrity.
- **User Management:** Admins can create, edit, and manage users.
- **Responsive UI:** Modern, accessible, and mobile-friendly admin interface.
- **Security:** Input validation, session security, and permission checks throughout.
- **Database Migrations:** SQL migration files for evolving the schema, including delivery mode normalization.

## Folder Structure
```
/c:/Program Files/Ampps/www/Tetra/
├── src/
│   ├── admin/                # Admin panel (HTML/PHP views)
│   ├── Controllers/          # PHP controllers (CPD, DeliveryMode, User)
│   ├── config/               # Configuration files
│   └── includes/             # Shared includes (header, footer, etc.)
├── migrations/               # SQL migration files
├── public/assets/            # Images, CSS, JS
└── README.md                 # Project documentation
```

## Setup
1. **Requirements:**
   - PHP 7.4+
   - MySQL/MariaDB
   - AMPPS/XAMPP or similar local server
2. **Clone the repository:**
   - Place the project in your web server root (e.g., `www` or `htdocs`).
3. **Database:**
   - Import the SQL migration files from `/migrations/` to set up the schema and seed delivery modes.
4. **Configuration:**
   - Edit `/src/config/config.php` with your database credentials and environment settings.
5. **Assets:**
   - Place images and static files in `/public/assets/` as needed.
6. **Start the server:**
   - Access the app via your local server (e.g., `http://localhost/Tetra/src/admin/`).

## Usage
- **Login:**
  - Access the login page and enter your credentials.
- **Admin Panel:**
  - Manage CPDs, delivery modes, and users from the navigation menu.
- **CPD Management:**
  - Create, edit, view, and delete CPDs. Assign delivery modes using the normalized dropdown.
- **Delivery Modes:**
  - Add, edit, or remove delivery modes. Cannot delete a mode in use by a CPD.
- **User Management:**
  - Admins can manage user accounts and permissions.

## Security
- All user input is validated and sanitized.
- Only admins can perform create, update, and delete operations.
- Sessions are securely managed.
- SQL queries use prepared statements to prevent injection.

## Contribution
- Fork the repository and submit pull requests for improvements.
- Follow PHP best practices and maintain separation of concerns (controllers, views, config).
- Write clear commit messages and document major changes.

## License
This project is proprietary and for internal use by the organization. Contact the maintainer for licensing or collaboration inquiries.


## How to change parameters of CPDs or whatelse it may be needed (DO NOT TRY THIS WITHOUT KNOWLEDGE)
- Attetion This may destroy the website So make an backup
- Get the edit, create, list and view of the thing you wanna change (its in Admin folder), get the migrations folder, trow it in the chatGpt and ask for it, get check everything related to the CPDs for example all the CPDs admin pages, then get the CPDs from the page folder and ask it to change it too!
 **Got errors**: get the page of it and put it in ChatGpt...
- Now you either broke everything, maybe its insecure but works, Or the Best way ALL WORKS !!!