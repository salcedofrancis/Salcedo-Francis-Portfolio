# Francis Salcedo Portfolio

My portfolio website. It has pages about me, my skills, projects, education, and experience. I used HTML, CSS, JavaScript, PHP, and MySQL to make it.

## What it does

- Shows my portfolio pages.
- Gets some page information from the database.
- Lets visitors send me a message.
- Has an admin page where I can update information and read messages.
- Works on phones and has a dark theme.

## What you need

- XAMPP, or a web host that supports PHP and MySQL.
- PHP 8.1 or later with PDO MySQL and Fileinfo enabled.
- MySQL or MariaDB.

## Run it with XAMPP

1. Copy the project folder into XAMPP's `htdocs` folder.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and import `database/portfolio.sql`.
4. Set the database details for PHP using `PORTFOLIO_DB_HOST`, `PORTFOLIO_DB_NAME`, `PORTFOLIO_DB_USER`, and `PORTFOLIO_DB_PASSWORD`.
5. Open `http://localhost/Salcedo-Francis-Portfolio/` in your browser.

If the folder has another name, use that name in the address. The SQL file creates the `portfolio` database. If you already have a database, change the first `CREATE DATABASE` and `USE portfolio` lines before importing.

## Put it online

Upload the project files to a web host that supports PHP and MySQL. Import `database/portfolio.sql`, then set the four database details in the hosting control panel. Use the database host, name, and user given by your hosting provider. Turn on HTTPS before using the admin page.

## Make an admin account

In a terminal opened in the project folder, run this command with your email address:

```sh
php scripts/create_admin.php you@example.com
```

Follow the prompt to choose a password. Then open `/admin/login.php` on your website to sign in. After the account is made, remove or disable `scripts/create_admin.php` on the live site.
