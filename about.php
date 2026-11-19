<?php
require_once __DIR__ . '/includes/bootstrap.php';

$name = portfolio_setting('name', 'Francis I. Salcedo');
$biography = portfolio_setting('biography', 'I am studying Information Technology at Negros Oriental State University and enjoy building systems that solve practical problems.');
$careerGoals = portfolio_setting('career_goals', 'My goal is to become an IT professional serving with the Philippine Army, applying my technical skills in a role that also serves the country.');
$interestSetting = portfolio_setting('interests', 'Gaming, Playing Guitar, Singing');
$interests = array_filter(array_map('trim', explode(',', $interestSetting)));
$education = db()->query('SELECT institution, qualification, period, details FROM education ORDER BY sort_order, id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About — <?= e($name) ?></title>
  <script>
    (function () {
      try {
        var t = localStorage.getItem('portfolio-theme');
        if (!t && window.matchMedia('(prefers-color-scheme: dark)').matches) t = 'dark';
        if (t) document.documentElement.setAttribute('data-theme', t);
      } catch (e) {}
    })();
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar">
    <div class="nav-inner">
      <a href="index.php" class="nav-brand"><?= e($name) ?></a>
      <nav class="nav-links" id="navLinks">
        <a href="index.php">Home</a>
        <a href="about.php" aria-current="page">About</a>
        <a href="skills.html">Skills</a>
        <a href="projects.html">Projects</a>
        <a href="resume.html">Resume</a>
        <a href="contact.html">Contact</a>
      </nav>
      <div class="nav-controls">
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">☾</button>
        <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>
      </div>
    </div>
  </header>

  <main>
    <section class="page-hero container">
      <p class="section-label">About Me</p>
      <h1>Getting to know me.</h1>
      <p>A bit of background on where I've studied, where I'm headed, and what I do outside of school.</p>
    </section>

    <section class="section container">
      <div class="grid-2">
        <div>
          <h2>Background</h2>
          <p><?= nl2br(e($biography)) ?></p>
          <h2 style="margin-top: 2rem;">Career Goals</h2>
          <p><?= nl2br(e($careerGoals)) ?></p>
        </div>
        <div class="about-facts">
          <h2>Education</h2>
          <?php if ($education): ?>
            <?php foreach ($education as $item): ?>
              <div class="fact-item">
                <h4><?= e($item['qualification']) ?></h4>
                <p><?= e($item['institution']) ?><?= $item['period'] !== '' ? ' — ' . e($item['period']) : '' ?></p>
                <?php if ($item['details'] !== ''): ?><p><?= nl2br(e($item['details'])) ?></p><?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Education details have not been added yet.</p>
          <?php endif; ?>
          <div class="fact-item" style="border-bottom: none;">
            <h4>Interests</h4>
            <div class="interest-tags">
              <?php foreach ($interests as $interest): ?><span><?= e($interest) ?></span><?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <p>&copy; <?= date('Y') ?> <?= e($name) ?>. Personal Portfolio.</p>
      <div class="footer-socials">
        <a href="https://www.facebook.com/francis.salcedo.26" target="_blank" rel="noopener">Facebook</a>
        <a href="https://www.instagram.com/washi.washi.26" target="_blank" rel="noopener">Instagram</a>
        <a href="mailto:<?= e(portfolio_setting('email', 'salcedofrancis88@gmail.com')) ?>">Email</a>
      </div>
    </div>
  </footer>
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button>
  <script src="js/script.js"></script>
</body>
</html>
