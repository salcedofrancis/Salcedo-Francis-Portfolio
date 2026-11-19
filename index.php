<?php
require_once __DIR__ . '/includes/bootstrap.php';

$name = portfolio_setting('name', 'Francis I. Salcedo');
$intro = portfolio_setting('introduction', 'Information Technology student at Negros Oriental State University');
$bio = portfolio_setting('biography', 'I enjoy building practical web and desktop systems, from records management to internship tracking tools.');
$profileImage = portfolio_setting('profile_image', 'images/profilepic.jpg');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title><?= e($name) ?> — Portfolio</title>
  <script>(function(){try{var t=localStorage.getItem('portfolio-theme');if(!t&&window.matchMedia('(prefers-color-scheme: dark)').matches)t='dark';if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar"><div class="nav-inner"><a href="index.php" class="nav-brand"><?= e($name) ?></a><nav class="nav-links" id="navLinks"><a href="index.php" aria-current="page">Home</a><a href="about.php">About</a><a href="skills.php">Skills</a><a href="projects.php">Projects</a><a href="resume.php">Resume</a><a href="contact.php">Contact</a></nav><div class="nav-controls"><button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">☾</button><button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button></div></div></header>
  <main><section class="hero container"><div class="hero-text"><p class="hero-eyebrow">Welcome to my portfolio</p><h1>Hi, I'm <?= e($name) ?>.</h1><p class="hero-tagline"><?= e($intro) ?></p><p class="hero-desc"><?= nl2br(e($bio)) ?></p><div class="hero-actions"><a href="projects.php" class="btn btn-primary">View My Projects</a><a href="contact.php" class="btn btn-outline">Get In Touch</a></div></div><div class="avatar-wrap"><div class="avatar-shape"><img src="<?= e($profileImage) ?>" alt="<?= e($name) ?> profile photo"></div></div></section></main>
  <footer class="site-footer"><div class="container footer-inner"><p>&copy; <?= date('Y') ?> <?= e($name) ?>. Personal Portfolio.</p><div class="footer-socials"><a href="https://www.facebook.com/francis.salcedo.26" target="_blank" rel="noopener">Facebook</a><a href="https://www.instagram.com/washi.washi.26" target="_blank" rel="noopener">Instagram</a><a href="mailto:<?= e(portfolio_setting('email', 'salcedofrancis88@gmail.com')) ?>">Email</a></div></div></footer>
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button><script src="js/script.js"></script>
</body>
</html>
