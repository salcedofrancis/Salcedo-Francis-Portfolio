<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
if ($argc !== 2 || !filter_var($argv[1], FILTER_VALIDATE_EMAIL)) { fwrite(STDERR, "Usage: php scripts/create_admin.php admin@example.com\n"); exit(2); }
$email = $argv[1]; fwrite(STDOUT, 'New admin password: ');
if (strncasecmp(PHP_OS, 'WIN', 3) === 0) { $password = trim((string)fgets(STDIN)); }
else { system('stty -echo'); $password = trim((string)fgets(STDIN)); system('stty echo'); fwrite(STDOUT, "\n"); }
if (strlen($password) < 12) { fwrite(STDERR, "Use at least 12 characters.\n"); exit(2); }
try { $s = db()->prepare('INSERT INTO admins(email,password_hash) VALUES(?,?)'); $s->execute([$email,password_hash($password,PASSWORD_DEFAULT)]); fwrite(STDOUT,"Admin account created. Remove or disable this setup script.\n"); }
catch(Throwable $e) { fwrite(STDERR,"Could not create account. Confirm DB setup and that this email is unused.\n"); exit(1); }
