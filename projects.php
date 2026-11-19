<?php
require_once __DIR__ . '/includes/bootstrap.php';
$name = portfolio_setting('name', 'Francis I. Salcedo');
$projects = db()->query('SELECT title, description, image_path, technologies, project_url FROM projects ORDER BY sort_order, id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projects — <?= e($name) ?></title>
  <script>(function(){try{var t=localStorage.getItem('portfolio-theme');if(!t&&window.matchMedia('(prefers-color-scheme: dark)').matches)t='dark';if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar"><div class="nav-inner"><a href="index.php" class="nav-brand"><?= e($name) ?></a><nav class="nav-links" id="navLinks"><a href="index.php">Home</a><a href="about.php">About</a><a href="skills.php">Skills</a><a href="projects.php" aria-current="page">Projects</a><a href="resume.php">Resume</a><a href="contact.php">Contact</a></nav><div class="nav-controls"><button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">☾</button><button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button></div></div></header>
  <main>
    <section class="page-hero container"><p class="section-label">Projects</p><h1>Things I've built.</h1><p>A mix of web and desktop systems built for school requirements and personal practice.</p></section>
    <section class="section container"><div class="projects-grid">
      <?php if ($projects): foreach ($projects as $project): ?>
        <article class="project-card">
          <?php if ($project['image_path'] !== ''): ?><div class="project-media"><img src="<?= e($project['image_path']) ?>" alt="<?= e($project['title']) ?>"></div><?php endif; ?>
          <div class="project-body"><h3><?= e($project['title']) ?></h3><p><?= nl2br(e($project['description'])) ?></p>
            <?php $url = trim((string)$project['project_url']); if ($url !== '' && preg_match('~^https?://~i', $url)): ?><a href="<?= e($url) ?>" target="_blank" rel="noopener noreferrer" class="project-link">View project →</a><?php endif; ?>
            <?php $technologies = array_filter(array_map('trim', explode('·', (string)$project['technologies']))); if ($technologies): ?><div class="project-tech"><?php foreach ($technologies as $technology): ?><span><?= e($technology) ?></span><?php endforeach; ?></div><?php endif; ?>
          </div>
        </article>
      <?php endforeach; else: ?><p>Projects have not been added yet.</p><?php endif; ?>
    </div></section>
  </main>
  <footer class="site-footer"><div class="container footer-inner"><p>&copy; <?= date('Y') ?> <?= e($name) ?>. Personal Portfolio.</p><div class="footer-socials"><a href="https://www.facebook.com/francis.salcedo.26" target="_blank" rel="noopener">Facebook</a><a href="https://www.instagram.com/washi.washi.26" target="_blank" rel="noopener">Instagram</a><a href="mailto:<?= e(portfolio_setting('email', 'salcedofrancis88@gmail.com')) ?>">Email</a></div></div></footer>
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button><script src="js/script.js"></script>
</body>
</html>
