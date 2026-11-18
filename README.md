# Secure Dynamic Personal Portfolio

Continuation of the Francis Salcedo static portfolio. This implementation keeps the recognizable content and assets while introducing PHP/MySQL-backed content, an admin area, and a public contact form.

## Requirements
- PHP 8.1+ with PDO MySQL and Fileinfo extensions
- MySQL 8.0+ / MariaDB equivalent
- Apache with `mod_rewrite`/`.htaccess` support (or equivalent web-server rules)
- HTTPS for any deployed login/admin pages

## Setup
1. Back up the existing hosting deployment and repository before changing the live site.
2. Import `database/portfolio.sql` into the MySQL server. The SQL creates a `portfolio` database; adjust/remove `CREATE DATABASE` and `USE` if your host provides a database already.
3. Set environment variables in your hosting control panel (do not put them in committed PHP files): `PORTFOLIO_DB_HOST`, `PORTFOLIO_DB_NAME`, `PORTFOLIO_DB_USER`, and `PORTFOLIO_DB_PASSWORD`.
4. Install the project on the same hosting/domain as the midterm site. `index.php` is selected first by `.htaccess`; preserve the existing images and CSS.
5. Create the first admin with the one-time CLI command below, then delete `scripts/create_admin.php` or otherwise disable the setup script.
6. Visit `/admin/login.php`, sign in, and use the dashboard to manage profile, skills, projects, education, experience, achievements, and visitor messages.

Create the administrator from the project root using an interactive terminal. It hashes the password and refuses to create duplicate email addresses:

```sh
php scripts/create_admin.php admin@example.com
```

The script prompts for the password without echoing it. Use a unique, strong password and share evaluation credentials privately through the LMS only.

## Features implemented
- Dynamic public portfolio sections powered by MySQL.
- Authenticated admin session, session ID rotation, password hashing/verification, and five-attempt/15-minute login throttling.
- Prepared PDO queries, contextual HTML escaping, server validation, and CSRF tokens on state-changing forms.
- CRUD for skills, projects (including image upload), education, experience, and achievements; editable profile/contact settings; message read/unread/delete.
- Contact form validation, CSRF protection, and a honeypot field.
- Image upload validation using file content (`finfo` and `getimagesize`), a 4 MB cap, random filenames, and disabled script execution in uploads.

## Deployment/security notes
Credentials and administrator passwords are intentionally not included. Keep HTTPS enabled, set environment variables outside the web root where possible, back up the database, and test with your actual hosting PHP/MySQL configuration before evaluation. Progressive Git history must reflect real work: this repository update is one implementation checkpoint; make future commits as you complete and test separate features rather than fabricating historical commits. Screenshots, a recorded demo, live URL, and private LMS credentials still need to be supplied by the student.
