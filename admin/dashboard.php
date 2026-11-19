<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_admin();

$counts = [];
foreach (['projects', 'skills', 'messages', 'experience', 'education', 'achievements'] as $table) {
    // Table names are fixed in this allow-list, not provided by a request.
    $counts[$table] = (int)db()->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <main class="section container">
    <p>Signed in as <?= e($_SESSION['admin_email'] ?? '') ?></p>
    <h1>Portfolio dashboard</h1>
    <div class="interest-tags">
      <?php foreach ($counts as $label => $count): ?>
        <span><?= e(ucfirst($label)) ?>: <?= $count ?></span>
      <?php endforeach; ?>
    </div>
    <h2>Manage content</h2>
    <div class="interest-tags">
      <?php foreach ([
          'profile' => 'Profile & settings',
          'skills' => 'Skills',
          'projects' => 'Projects',
          'education' => 'Education',
          'experience' => 'Experience',
          'achievements' => 'Achievements',
      ] as $key => $label): ?>
        <a class="btn btn-outline" href="content.php?type=<?= e($key) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
      <a class="btn btn-outline" href="messages.php">Messages (<?= $counts['messages'] ?>)</a>
    </div>
    <p><a class="btn btn-outline" href="../index.php">View website</a></p>
    <form method="post" action="logout.php">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <button class="btn btn-primary" type="submit">Log out</button>
    </form>
  </main>
</body>
</html>
