<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $action = (string)($_POST['action'] ?? '');

    if ($id && in_array($action, ['read', 'unread', 'delete'], true)) {
        if ($action === 'delete') {
            $statement = db()->prepare('DELETE FROM messages WHERE id = ?');
            $statement->execute([$id]);
        } else {
            $statement = db()->prepare('UPDATE messages SET is_read = ? WHERE id = ?');
            $statement->execute([$action === 'read' ? 1 : 0, $id]);
        }
    }

    header('Location: messages.php');
    exit;
}

$messages = db()->query('SELECT id, name, email, subject, message, is_read, created_at FROM messages ORDER BY created_at DESC, id DESC')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact messages — Admin</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .message-list { display:grid; gap:1rem; }
    .message-card { padding:1.25rem; border:1px solid #d5d9e2; border-radius:12px; background:var(--surface,#fff); }
    .message-card.unread { border-left:5px solid #4f46e5; }
    .message-meta { color:#667085; overflow-wrap:anywhere; }
    .message-actions { display:flex; flex-wrap:wrap; gap:.5rem; margin-top:1rem; }
    .message-actions button { cursor:pointer; padding:.55rem .8rem; }
  </style>
</head>
<body>
  <main class="section container">
    <p><a href="dashboard.php">← Back to dashboard</a></p>
    <h1>Contact messages</h1>
    <?php if (!$messages): ?>
      <p>No messages have been received yet. Messages submitted through the public contact form will appear here.</p>
    <?php else: ?>
      <div class="message-list">
        <?php foreach ($messages as $message): ?>
          <article class="message-card <?= (int)$message['is_read'] === 0 ? 'unread' : '' ?>">
            <h2><?= e($message['subject']) ?></h2>
            <p class="message-meta">
              From <?= e($message['name']) ?> &lt;<a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a>&gt;
              · <?= e($message['created_at']) ?>
              · <?= (int)$message['is_read'] === 1 ? 'Read' : 'Unread' ?>
            </p>
            <p><?= nl2br(e($message['message'])) ?></p>
            <div class="message-actions">
              <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$message['id'] ?>">
                <button name="action" value="<?= (int)$message['is_read'] === 1 ? 'unread' : 'read' ?>">
                  Mark <?= (int)$message['is_read'] === 1 ? 'unread' : 'read' ?>
                </button>
              </form>
              <form method="post" onsubmit="return confirm('Delete this message permanently?')">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$message['id'] ?>">
                <button name="action" value="delete">Delete</button>
              </form>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
