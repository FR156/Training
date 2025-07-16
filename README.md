# File Upload Vulnerabilities Educational Website

This project demonstrates common file upload vulnerabilities in a safe, controlled environment for educational purposes.

## Purpose

The website intentionally contains security vulnerabilities to help developers:
- Understand common file upload security risks
- Learn how attackers exploit these vulnerabilities
- Practice securing file upload functionality

## Setup Instructions

1. **Prerequisites**:
   - PHP 7.4+ with file uploads enabled
   - MySQL 5.7+
   - Node.js (for Tailwind CSS)

2. **Database Setup**:
   - Create a MySQL database and import the schema from `database.sql`
   - Update database credentials in `includes/config.php`

3. **Install Dependencies**:
   ```bash
   npm install -D tailwindcss
   npx tailwindcss -i ./src/input.css -o ./assets/css/output.css --watch