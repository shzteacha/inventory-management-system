# Inventory Management System

A web-based inventory management application developed using PHP and MySQL during an internship project.

The application provides a centralized interface for managing inventory-related records and supporting day-to-day stock operations.

## Project Overview

This project was developed as an internship project. The repository uses the general project title **Inventory Management System** and does not include the original project or organization name.

## Main Features

Based on the modules and pages included in the source code, the application covers:

- **User access and account management** – login, logout, user records, and account settings.
- **Employee management** – add, view, edit, search, and delete employee records.
- **Inventory management** – maintain inventory records and perform add, edit, delete, and search operations.
- **Product and category management** – manage product records and product categories.
- **Supplier management** – maintain supplier information.
- **Stock movement** – manage stock transaction records and related import/export functions.
- **Point of sale (POS)** – includes POS-related pages and transaction handling.
- **QR/barcode scanning pages** – scanning interfaces are included in the project.

Feature availability and behaviour depend on the database configuration and the project files.

## Technology Stack

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Bootstrap
- jQuery
- DataTables
- Chart.js

## Project Structure

```text
inventory-management-system/
├── css/                 # Stylesheets
├── img/                 # Image assets
├── includes/            # Shared PHP components and database connection
├── js/                  # JavaScript files
├── pages/               # Application modules and page handlers
├── vendor/              # Front-end libraries and dependencies
├── database/
│   └── schema.sql       # Sanitized database structure (without original records)
├── README.md
└── .gitignore
```

## Local Setup

This is a legacy PHP/MySQL application. The following steps provide a starting point for running it locally:

1. Install a local PHP/MySQL environment such as XAMPP or Laragon.
2. Place the project folder in the local web server's document root.
3. Create a MySQL database named `inventory_management_system`.
4. Import `database/schema.sql` into the database.
5. Open `includes/connection.php` and update the database host, username, password, and database name to match your local environment.
6. Start Apache and MySQL.
7. Open the project in your browser using your local server URL.

> **Important:** The supplied SQL file contains database structure only. Original database records have been excluded to avoid exposing personal or organization-specific information. You may need to create suitable test records locally before all modules can be tested.

## Database and Privacy

- The original database export and its records are not included.
- Do not commit real employee details, company records, passwords, access tokens, or production database credentials.
- Use synthetic test data when demonstrating the application.
- Confirm that you have permission to publish internship-related source code before making this repository public.

## Project Context

**Project type:** Internship project  
**Project title:** Inventory Management System  
**Contributor:** Shaza Batrisyia

This repository describes the project at a general level and intentionally omits the original organization and internal project name.

## Notes

The project includes third-party front-end libraries and template assets. Their original license and attribution files should be retained when redistributing those components.
