<?php
require_once __DIR__ . '/includes/bootstrap.php';
$name = portfolio_setting('name', 'Francis I. Salcedo');
$education = db()->query('SELECT institution, qualification, period, details FROM education ORDER BY sort_order, id DESC')->fetchAll();
$experience = db()->query('SELECT organization, role, period, details FROM experience ORDER BY sort_order, id DESC')->fetchAll();
$achievements = db()->query('SELECT title, organization, achieved_on, details FROM achievements ORDER BY sort_order, id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Resume — <?= e($name) ?></title>
  <script>(function(){try{var t=localStorage.getItem('portfolio-theme');if(!t&&window.matchMedia('(prefers-color-scheme: dark)').matches)t='dark';if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar"><div class="nav-inner"><a href="index.php" class="nav-brand"><?= e($name) ?></a><nav class="nav-links" id="navLinks"><a href="index.php">Home</a><a href="about.php">About</a><a href="skills.php">Skills</a><a href="projects.php">Projects</a><a href="resume.php" aria-current="page">Resume</a><a href="contact.php">Contact</a></nav><div class="nav-controls"><button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">☾</button><button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button></div></div></header>
  <main>
    <section class="page-hero container"><p class="section-label">Resume</p><h1>Education &amp; experience.</h1><p>My academic background, certifications, and hands-on experience so far.</p></section>
    <section class="section container"><div class="resume-cols">
      <div><h2>Education</h2><div class="timeline">
        <?php if ($education): foreach ($education as $item): ?><article class="timeline-item"><span class="timeline-date"><?= e($item['period']) ?></span><h4><?= e($item['qualification']) ?></h4><p><?= e($item['institution']) ?></p><?php if ($item['details'] !== ''): ?><p><?= nl2br(e($item['details'])) ?></p><?php endif; ?></article><?php endforeach; else: ?><p>Education details have not been added yet.</p><?php endif; ?>
      </div>
      <h2 style="margin-top:1rem">Experience</h2><div class="timeline">
        <?php if ($experience): foreach ($experience as $item): ?><article class="timeline-item"><span class="timeline-date"><?= e($item['period']) ?></span><h4><?= e($item['role']) ?></h4><p><?= e($item['organization']) ?></p><?php if ($item['details'] !== ''): ?><p><?= nl2br(e($item['details'])) ?></p><?php endif; ?></article><?php endforeach; else: ?><p>Experience details have not been added yet.</p><?php endif; ?>
      </div></div>
      <div><h2>Achievements &amp; Training</h2><div class="cert-list">
        <?php if ($achievements): foreach ($achievements as $item): ?><article class="cert-item"><h4><?= e($item['title']) ?></h4><?php if ($item['organization'] !== ''): ?><span class="cert-issuer"><?= e($item['organization']) ?></span><?php endif; ?><?php if ($item['achieved_on'] !== ''): ?><span class="cert-date"><?= e($item['achieved_on']) ?></span><?php endif; ?><?php if ($item['details'] !== ''): ?><p class="cert-desc"><?= nl2br(e($item['details'])) ?></p><?php endif; ?></article><?php endforeach; else: ?><p>Achievements and training will appear here when added in the admin area.</p><?php endif; ?>
      </div><h2 style="margin-top:2rem">Goal</h2><div class="card"><p><?= nl2br(e(portfolio_setting('career_goals', 'Aspiring to become an IT professional serving with the Philippine Army — combining technical skill with a role that serves the country.'))) ?></p></div></div>
    </div></section>
  </main>
  <footer class="site-footer"><div class="container footer-inner"><p>&copy; <?= date('Y') ?> <?= e($name) ?>. Personal Portfolio.</p><div class="footer-socials"><a href="https://www.facebook.com/francis.salcedo.26" target="_blank" rel="noopener">Facebook</a><a href="https://www.instagram.com/washi.washi.26" target="_blank" rel="noopener">Instagram</a><a href="mailto:<?= e(portfolio_setting('email', 'salcedofrancis88@gmail.com')) ?>">Email</a></div></div></footer>
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button><script src="js/script.js"></script>
</body>
</html>
