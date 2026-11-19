<?php
// Configure database credentials with environment variables or the private
// includes/database.local.php file. Never commit actual credentials.
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $privateConfig = __DIR__ . '/database.local.php';
    $fileConfig = is_file($privateConfig) ? require $privateConfig : [];
    if (!is_array($fileConfig)) $fileConfig = [];

    // Environment variables take priority; private config supports hosts such
    // as InfinityFree that may not offer custom environment variables.
    $host = getenv('PORTFOLIO_DB_HOST') ?: ($fileConfig['host'] ?? '127.0.0.1');
    $name = getenv('PORTFOLIO_DB_NAME') ?: ($fileConfig['name'] ?? 'portfolio');
    $user = getenv('PORTFOLIO_DB_USER') ?: ($fileConfig['user'] ?? 'root');
    $pass = getenv('PORTFOLIO_DB_PASSWORD');
    if ($pass === false) $pass = $fileConfig['password'] ?? '';

    if (!is_string($host) || !is_string($name) || !is_string($user) || !is_string($pass)
        || $host === '' || $name === '' || $user === '') {
        throw new RuntimeException('Database is not configured. Check the private database configuration.');
    }

    try {
        $pdo = new PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $exception) {
        // Keep detailed diagnostics in the server log, not in the page response.
        error_log('Portfolio database connection failed: ' . $exception->getMessage());
        throw new RuntimeException('Database connection failed. Check the database configuration.');
    }

    return $pdo;
}

function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void
{
    $sent = $_POST['csrf'] ?? '';
    if (!is_string($sent) || !hash_equals($_SESSION['csrf'] ?? '', $sent)) { http_response_code(403); exit('Invalid form token. Please reload and try again.'); }
}
function require_admin(): void { if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; } }
function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) return;
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params(['httponly'=>true, 'secure'=>$secure, 'samesite'=>'Lax', 'path'=>'/']);
    session_start();
}
function upload_image(string $key): ?string
{
    if (empty($_FILES[$key]) || $_FILES[$key]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $file = $_FILES[$key];
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 4 * 1024 * 1024 || !is_uploaded_file($file['tmp_name'])) throw new RuntimeException('Choose an image smaller than 4 MB.');
    $info = @getimagesize($file['tmp_name']);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $extensions = ['image/jpeg'=>'jpg', 'image/png'=>'png', 'image/gif'=>'gif', 'image/webp'=>'webp'];
    if (!$info || !isset($extensions[$mime]) || $info['mime'] !== $mime) throw new RuntimeException('Only valid JPEG, PNG, GIF, or WebP images are allowed.');
    $dir = dirname(__DIR__) . '/uploads';
    if (!is_dir($dir) && !mkdir($dir, 0750, true)) throw new RuntimeException('Upload directory is unavailable.');
    $name = bin2hex(random_bytes(20)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) throw new RuntimeException('Could not save uploaded image.');
    return 'uploads/' . $name;
}
function portfolio_setting(string $key, string $fallback = ''): string
{
    $q = db()->prepare('SELECT setting_value FROM settings WHERE setting_key = ?'); $q->execute([$key]);
    $value = $q->fetchColumn(); return $value === false ? $fallback : (string)$value;
}
start_secure_session();
?>
