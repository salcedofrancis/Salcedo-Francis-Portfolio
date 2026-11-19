# Francis Salcedo Portfolio

## About the project

This is my personal portfolio website. It shares information about me, my skills, projects, education, and experience. I made it with HTML, CSS, JavaScript, PHP, and MySQL.

## Features

- Home, About, Skills, Projects, Resume, and Contact pages.
- PHP pages can show information saved in the database.
- Contact form saves visitor messages.
- Admin pages let me manage portfolio information and read messages.
- Mobile-friendly layout and dark mode.

## What you need

- PHP 8.1 or newer.
- MySQL or MariaDB.
- A web server such as Apache. XAMPP can be used for local testing.
- PHP PDO MySQL and Fileinfo extensions enabled.

## Set up the database

1. Start MySQL in XAMPP, or open your hosting provider's database tools.
2. Open phpMyAdmin.
3. Import the `database/portfolio.sql` file.
4. The SQL file creates a database called `portfolio` and adds the tables and starter information.
5. If your host already gave you a database, follow its instructions for importing the SQL into that database. You may need to remove or change the `CREATE DATABASE` and `USE portfolio` lines at the start of the SQL file.

## Install and run the website

### On your computer with XAMPP

1. Copy the project folder into XAMPP's `htdocs` folder.
2. Start Apache and MySQL in the XAMPP Control Panel.
3. Set these database environment variables for PHP, using your own database details:
   - `PORTFOLIO_DB_HOST`
   - `PORTFOLIO_DB_NAME`
   - `PORTFOLIO_DB_USER`
   - `PORTFOLIO_DB_PASSWORD`
4. Open `http://localhost/Salcedo-Francis-Portfolio/` in your browser. If your folder has a different name, use that name in the address.

### On a web host

1. Choose a hosting plan that supports PHP and MySQL or MariaDB.
2. Upload the project files to your website's document folder.
3. Import the database SQL file using the host's database tools.
4. Add the four database environment variables in the hosting control panel. Use the database details provided by the host.
5. Turn on HTTPS and open your website to check that it works.

The site needs PHP to run. It will not work as a PHP website on GitHub Pages.

## Create an administrator account

1. Open a terminal in the project folder on a computer or server that can run PHP.
2. Run this command, replacing the example email with your own:

   ```sh
   php scripts/create_admin.php you@example.com
   ```

3. Follow the prompt to create a strong password.
4. Open `http://localhost/Salcedo-Francis-Portfolio/admin/login.php` locally, or use `/admin/login.php` on your hosted website.
5. After creating the account, remove or disable `scripts/create_admin.php` on the live website.

## Important

Do not put database passwords or administrator passwords in this project or upload them to GitHub. Keep a backup of the database. Test the website locally before putting it online.
