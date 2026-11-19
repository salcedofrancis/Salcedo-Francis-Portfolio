<?php
require_once __DIR__ . '/includes/bootstrap.php';

$name = portfolio_setting('name', 'Francis I. Salcedo');
$email = portfolio_setting('email', 'salcedofrancis88@gmail.com');
$notice = '';
$noticeType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $visitor = trim((string)($_POST['name'] ?? ''));
    $visitorEmail = trim((string)($_POST['email'] ?? ''));
    $message = trim((string)($_POST['message'] ?? ''));
    $honeypot = trim((string)($_POST['website'] ?? ''));

    if ($honeypot !== '') {
        // Silently accept automated spam without storing it.
        $notice = 'Thanks for your message.';
        $noticeType = 'success';
    } elseif (strlen($visitor) < 2 || strlen($visitor) > 100 ||
        !filter_var($visitorEmail, FILTER_VALIDATE_EMAIL) || strlen($visitorEmail) > 190 ||
        strlen($message) < 10 || strlen($message) > 10000) {
        $notice = 'Please enter a name, valid email address, and a message between 10 and 10,000 characters.';
        $noticeType = 'error';
    } else {
        $statement = db()->prepare('INSERT INTO messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())');
        $statement->execute([$visitor, $visitorEmail, 'Portfolio contact', $message]);
        $notice = 'Thanks for your message. It has been sent.';
        $noticeType = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact — <?= e($name) ?></title>
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
        <a href="about.php">About</a>
        <a href="skills.html">Skills</a>
        <a href="projects.html">Projects</a>
        <a href="resume.html">Resume</a>
        <a href="contact.php" aria-current="page">Contact</a>
      </nav>
      <div class="nav-controls">
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">☾</button>
        <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>
      </div>
    </div>
  </header>

  <main>
    <section class="page-hero container">
      <p class="section-label">Contact</p>
      <h1>Let's talk.</h1>
      <p>Have a question or an opportunity in mind? Reach out through the form or any of the channels below.</p>
    </section>

    <section class="section container">
      <div class="contact-wrap">
        <div>
          <div class="contact-info-item"><div class="icon">@</div><div><h4>Email</h4><p><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p></div></div>
          <div class="contact-info-item"><div class="icon">f</div><div><h4>Facebook</h4><p><a href="https://www.facebook.com/francis.salcedo.26" target="_blank" rel="noopener">facebook.com/francis.salcedo.26</a></p></div></div>
          <div class="contact-info-item"><div class="icon">ig</div><div><h4>Instagram</h4><p><a href="https://www.instagram.com/washi.washi.26" target="_blank" rel="noopener">@washi.washi.26</a></p></div></div>
        </div>

        <div class="card">
          <?php if ($notice !== ''): ?>
            <p class="form-status <?= e($noticeType) ?>" role="status"><?= e($notice) ?></p>
          <?php endif; ?>
          <form id="contactForm" action="contact.php" method="post" novalidate>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="form-group" aria-hidden="true" style="position:absolute;left:-10000px;">
              <label for="website">Leave this field empty</label>
              <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" placeholder="Your full name" required maxlength="100" value="<?= e($_POST['name'] ?? '') ?>">
              <span class="error-msg" id="nameError"></span>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="you@example.com" required maxlength="190" value="<?= e($_POST['email'] ?? '') ?>">
              <span class="error-msg" id="emailError"></span>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" placeholder="Write your message here..." required minlength="10" maxlength="10000"><?= e($_POST['message'] ?? '') ?></textarea>
              <span class="error-msg" id="messageError"></span>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
            <div class="form-status" id="formStatus" aria-live="polite"></div>
          </form>
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
        <a href="mailto:<?= e($email) ?>">Email</a>
      </div>
    </div>
  </footer>
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button>
  <script src="js/script.js"></script>
</body>
</html>
