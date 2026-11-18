<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pdo = db();
$skills = $pdo->query('SELECT name, category, proficiency FROM skills ORDER BY sort_order, name')->fetchAll();
$projects = $pdo->query('SELECT title, description, image_path, technologies, project_url FROM projects ORDER BY sort_order, id DESC')->fetchAll();
$education = $pdo->query('SELECT institution, qualification, period, details FROM education ORDER BY sort_order, id DESC')->fetchAll();
$experience = $pdo->query('SELECT organization, role, period, details FROM experience ORDER BY sort_order, id DESC')->fetchAll();
$achievements = $pdo->query('SELECT title, organization, achieved_on, details FROM achievements ORDER BY sort_order, id DESC')->fetchAll();
$name = portfolio_setting('name', 'Francis I. Salcedo');
$intro = portfolio_setting('introduction', 'IT student who enjoys building practical web and desktop systems.');
$bio = portfolio_setting('biography', 'I study Information Technology at Negros Oriental State University and enjoy creating useful software.');
$email = portfolio_setting('email', 'salcedofrancis88@gmail.com');
$profileImage = portfolio_setting('profile_image', 'images/profilepic.jpg');
$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form_type'] ?? '') === 'contact') {
    verify_csrf();
    $visitor = trim((string)($_POST['name'] ?? '')); $visitorEmail = trim((string)($_POST['email'] ?? ''));
    $subject = trim((string)($_POST['subject'] ?? '')); $message = trim((string)($_POST['message'] ?? ''));
    if (!empty($_POST['website'] ?? '') || strlen($visitor) > 100 || !filter_var($visitorEmail, FILTER_VALIDATE_EMAIL) || strlen($visitorEmail) > 190 || strlen($subject) > 180 || $message === '' || strlen($message) > 5000) {
        $notice = 'Please provide a valid name, email, subject, and message.';
    } else {
        $s = $pdo->prepare('INSERT INTO messages (name,email,subject,message,created_at) VALUES (?,?,?,?,NOW())');
        $s->execute([$visitor, $visitorEmail, $subject, $message]);
        $notice = 'Thanks for your message. It has been sent.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?=e($name)?> — Portfolio</title><link rel="stylesheet" href="css/style.css"></head><body>
<header class="navbar"><div class="nav-inner"><a class="nav-brand" href="#home"><?=e($name)?></a><nav class="nav-links"><a href="#about">About</a><a href="#skills">Skills</a><a href="#projects">Projects</a><a href="#journey">Education & Experience</a><a href="#contact">Contact</a></nav></div></header>
<main><section class="hero container" id="home"><div class="hero-text"><p class="hero-eyebrow">Welcome to my portfolio</p><h1>Hi, I'm <?=e($name)?>.</h1><p class="hero-tagline"><?=e($intro)?></p><p class="hero-desc"><?=e($bio)?></p><div class="hero-actions"><a class="btn btn-primary" href="#projects">View My Projects</a><a class="btn btn-outline" href="#contact">Get In Touch</a></div></div><div class="avatar-wrap"><div class="avatar-shape"><img src="<?=e($profileImage)?>" alt="Profile photo of <?=e($name)?>"></div></div></section>
<section class="section container" id="about"><h2>About Me</h2><p><?=e($bio)?></p><?php if ($achievements): ?><h3>Achievements</h3><div class="grid-2"><?php foreach($achievements as $a): ?><article class="card"><h4><?=e($a['title'])?></h4><p><?=e($a['organization'])?> · <?=e($a['achieved_on'])?></p><p><?=e($a['details'])?></p></article><?php endforeach ?></div><?php endif ?></section>
<section class="section container" id="skills"><h2>Skills</h2><div class="interest-tags"><?php foreach($skills as $skill): ?><span><?=e($skill['name'])?><?= $skill['category'] ? ' · '.e($skill['category']) : '' ?></span><?php endforeach ?></div></section>
<section class="section container" id="projects"><h2>Projects</h2><div class="projects-grid"><?php foreach($projects as $project): ?><article class="project-card"><?php if ($project['image_path']): ?><div class="project-media"><img src="<?=e($project['image_path'])?>" alt="<?=e($project['title'])?>"></div><?php endif ?><div class="project-body"><h3><?=e($project['title'])?></h3><p><?=nl2br(e($project['description']))?></p><p><?=e($project['technologies'])?></p><?php if ($project['project_url']): ?><a class="project-link" href="<?=e($project['project_url'])?>" rel="noopener noreferrer">View project →</a><?php endif ?></div></article><?php endforeach ?></div></section>
<section class="section container" id="journey"><h2>Education & Experience</h2><div class="grid-2"><div><h3>Education</h3><?php foreach($education as $item): ?><article class="fact-item"><h4><?=e($item['qualification'])?></h4><p><?=e($item['institution'])?> · <?=e($item['period'])?></p><p><?=e($item['details'])?></p></article><?php endforeach ?></div><div><h3>Experience</h3><?php foreach($experience as $item): ?><article class="fact-item"><h4><?=e($item['role'])?></h4><p><?=e($item['organization'])?> · <?=e($item['period'])?></p><p><?=e($item['details'])?></p></article><?php endforeach ?></div></div></section>
<section class="section container" id="contact"><h2>Contact</h2><p>Send me a message or email <a href="mailto:<?=e($email)?>"><?=e($email)?></a>.</p><?php if($notice): ?><p role="status"><?=e($notice)?></p><?php endif ?><div class="card"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="form_type" value="contact"><div class="form-group"><label for="name">Name</label><input id="name" name="name" maxlength="100" required></div><div class="form-group"><label for="email">Email</label><input id="email" name="email" type="email" maxlength="190" required></div><div class="form-group"><label for="subject">Subject</label><input id="subject" name="subject" maxlength="180" required></div><div class="form-group"><label for="message">Message</label><textarea id="message" name="message" maxlength="5000" required></textarea></div><div style="position:absolute;left:-10000px" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div><button class="btn btn-primary" type="submit">Send Message</button></form></div></section></main>
<footer class="site-footer"><div class="container footer-inner"><p>&copy; <?=date('Y')?> <?=e($name)?>. Personal Portfolio.</p><a href="admin/login.php">Admin</a></div></footer></body></html>
