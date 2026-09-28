/* 1. Mobile navigation toggle
   2. Dark / light theme toggle + localStorage
   3. Active navigation link highlighting
   4. Scroll-to-top button
   5. Typing effect (Home page hero)
   6. Contact form validation
*/

document.addEventListener('DOMContentLoaded', function () {
  initMobileNav();
  initThemeToggle();
  setActiveNavLink();
  initScrollTopButton();
  initTypingEffect();
  initContactForm();
  initSkillBars();
});

function initMobileNav() {
  const hamburger = document.getElementById('hamburger');
  const navLinks = document.getElementById('navLinks');
  if (!hamburger || !navLinks) return;

  hamburger.addEventListener('click', function () {
    const isOpen = navLinks.classList.toggle('open');
    hamburger.setAttribute('aria-expanded', isOpen);
    hamburger.classList.toggle('is-active', isOpen);
  });

  // Close the mobile menu after a link is tapped
  navLinks.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      navLinks.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    });
  });
}

/*
   2. Dark / light theme toggle with localStorage
   Remembers the visitor's preferred theme across pages
   and across visits.
*/
function initThemeToggle() {
  const toggleBtn = document.getElementById('themeToggle');
  const root = document.documentElement;
  const savedTheme = localStorage.getItem('portfolio-theme');

  // Apply saved theme (or fall back to the system preference) on load
  if (savedTheme) {
    root.setAttribute('data-theme', savedTheme);
  } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    root.setAttribute('data-theme', 'dark');
  }
  updateToggleIcon();

  if (!toggleBtn) return;

  toggleBtn.addEventListener('click', function () {
    const current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', next);
    localStorage.setItem('portfolio-theme', next);
    updateToggleIcon();
  });

  function updateToggleIcon() {
    if (!toggleBtn) return;
    const isDark = root.getAttribute('data-theme') === 'dark';
    toggleBtn.textContent = isDark ? '☀' : '☾';
    toggleBtn.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
  }
}

/*
   3. Active navigation link highlighting
*/
function setActiveNavLink() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a').forEach(function (link) {
    const linkPage = link.getAttribute('href');
    if (linkPage === currentPage) {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    }
  });
}

/*
   4. Scroll-to-top button
*/
function initScrollTopButton() {
  const btn = document.getElementById('scrollTopBtn');
  if (!btn) return;

  window.addEventListener('scroll', function () {
    if (window.scrollY > 400) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  });

  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/*
   5. Typing effect
   Cycles through a list of roles/titles on the Home page
   hero, typing and deleting each one letter by letter.
*/
function initTypingEffect() {
  const el = document.getElementById('typingText');
  if (!el) return;

  const phrases = ['Gamer.', 'IT Student.', 'Aspiring IT Professional.'];
  let phraseIndex = 0;
  let charIndex = 0;
  let deleting = false;

  function tick() {
    const current = phrases[phraseIndex];

    if (!deleting) {
      charIndex++;
      el.textContent = current.slice(0, charIndex);
      if (charIndex === current.length) {
        deleting = true;
        setTimeout(tick, 1400); // pause before deleting
        return;
      }
    } else {
      charIndex--;
      el.textContent = current.slice(0, charIndex);
      if (charIndex === 0) {
        deleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length;
      }
    }

    setTimeout(tick, deleting ? 45 : 90);
  }

  tick();
}

/*
   7. Skill bar animation (Skills page)
   Fills each language's progress bar to its stored level
   shortly after the page loads, giving a small animated
   effect instead of the bar just appearing full.
*/
function initSkillBars() {
  const bars = document.querySelectorAll('.skill-bar-fill');
  if (!bars.length) return;

  setTimeout(function () {
    bars.forEach(function (bar) {
      const level = bar.getAttribute('data-level') || 0;
      bar.style.width = level + '%';
    });
  }, 200);
}

/*
   6. Contact form validation
*/
function initContactForm() {
  const form = document.getElementById('contactForm');
  if (!form) return;

  const nameField = document.getElementById('name');
  const emailField = document.getElementById('email');
  const messageField = document.getElementById('message');
  const statusBox = document.getElementById('formStatus');

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const nameValid = validateField(nameField, function (value) {
      return value.trim().length >= 2;
    }, 'Please enter your name (at least 2 characters).');

    const emailValid = validateField(emailField, function (value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
    }, 'Please enter a valid email address.');

    const messageValid = validateField(messageField, function (value) {
      return value.trim().length >= 10;
    }, 'Message should be at least 10 characters long.');

    if (nameValid && emailValid && messageValid) {
      statusBox.textContent = 'Thanks, ' + nameField.value.trim() + '! Your message has been noted. I\'ll get back to you soon.';
      statusBox.classList.add('success');
      form.reset();
    } else {
      statusBox.classList.remove('success');
      statusBox.textContent = '';
    }
  });

  // Re-validate a field as soon as the visitor fixes it
  [nameField, emailField, messageField].forEach(function (field) {
    field.addEventListener('input', function () {
      if (field.classList.contains('invalid')) {
        field.classList.remove('invalid');
        document.getElementById(field.id + 'Error').textContent = '';
      }
    });
  });

  function validateField(field, testFn, message) {
    const errorEl = document.getElementById(field.id + 'Error');
    const isValid = testFn(field.value);
    if (!isValid) {
      field.classList.add('invalid');
      errorEl.textContent = message;
    } else {
      field.classList.remove('invalid');
      errorEl.textContent = '';
    }
    return isValid;
  }
}
