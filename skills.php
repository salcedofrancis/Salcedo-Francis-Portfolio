<?php
require_once __DIR__ . '/includes/bootstrap.php';
$name = portfolio_setting('name', 'Francis I. Salcedo');
$skills = db()->query('SELECT name, category, proficiency FROM skills ORDER BY sort_order, name')->fetchAll();
$groups = [];
foreach ($skills as $skill) {
    $category = trim((string)$skill['category']) ?: 'Skills';
    $groups[$category][] = $skill;
}
function skill_level_label($level): string {
    if ($level === null || $level === '') return 'In progress';
    $level = (int)$level;
    if ($level >= 75) return 'Advanced';
    if ($level >= 45) return 'Intermediate';
    return 'Basic';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skills — <?= e($name) ?></title>
  <script>(function(){try{var t=localStorage.getItem('portfolio-theme');if(!t&&window.matchMedia('(prefers-color-scheme: dark)').matches)t='dark';if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar"><div class="nav-inner">
    <a href="index.php" class="nav-brand"><?= e($name) ?></a>
    <nav class="nav-links" id="navLinks">
      <a href="index.php">Home</a><a href="about.php">About</a><a href="skills.php" aria-current="page">Skills</a><a href="projects.php">Projects</a><a href="resume.php">Resume</a><a href="contact.php">Contact</a>
    </nav>
    <div class="nav-controls"><button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">☾</button><button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button></div>
  </div></header>
  <main>
    <section class="page-hero container"><p class="section-label">Skills</p><h1>What I work with.</h1><p>Languages, tools, and platforms I've used across coursework and personal projects.</p></section>
    <section class="section container">
      <?php if ($groups): foreach ($groups as $category => $items): ?>
        <div class="skills-group"><h3><?= e($category) ?></h3><div class="skill-detail-grid">
          <?php foreach ($items as $skill): $level = $skill['proficiency'] === null ? 0 : max(0, min(100, (int)$skill['proficiency'])); ?>
            <article class="skill-item"><div class="skill-item-head"><h4><?= e($skill['name']) ?></h4><span class="skill-level-tag"><?= e(skill_level_label($skill['proficiency'])) ?></span></div>
              <div class="skill-bar-track"><div class="skill-bar-fill" data-level="<?= $level ?>"></div></div>
              <?php if ($skill['category'] !== ''): ?><p><?= e($skill['category']) ?></p><?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div></div>
      <?php endforeach; else: ?><p>Skills have not been added yet.</p><?php endif; ?>
    </section>
  </main>
  <footer class="site-footer"><div class="container footer-inner"><p>&copy; <?= date('Y') ?> <?= e($name) ?>. Personal Portfolio.</p><div class="footer-socials"><a href="https://www.facebook.com/francis.salcedo.26" target="_blank" rel="noopener">Facebook</a><a href="https://www.instagram.com/washi.washi.26" target="_blank" rel="noopener">Instagram</a><a href="mailto:<?= e(portfolio_setting('email', 'salcedofrancis88@gmail.com')) ?>">Email</a></div></div></footer>
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button><script src="js/script.js"></script>
</body>
</html>
