const hamburger = document.getElementById('hamburger');
const navOverlay = document.getElementById('nav-overlay');
const closeBtn = document.getElementById('close-btn');
const navbar = document.getElementById('navbar');

const tl = gsap.timeline({ paused: true, reversed: true });

tl.to(navOverlay, { duration: 0.7, left: '0%', ease: 'power2.inOut' })
    .fromTo(navOverlay.querySelector('h2'),
        { opacity: 0, y: -30 },
        { opacity: 1, y: 0, duration: 0.6, delay: 0.2 }, "-=0.5")
    .fromTo(navOverlay.querySelectorAll('ul li a'),
        { opacity: 0, y: 30 },
        { opacity: 1, y: 0, stagger: 0.2, ease: 'power2.out', pointerEvents: 'all', delay: 0.3 }, "-=0.4")
    .fromTo(closeBtn,
        { opacity: 0 },
        { opacity: 1, duration: 0.3, pointerEvents: 'all', delay: 0.1 }, "-=0.6");

function toggleMenu() {
    if (tl.reversed()) {
        tl.play();
        document.body.style.overflow = 'hidden'; 
        setTimeout(() => {
            navOverlay.querySelector('a').focus(); 
        }, 700); 
        trapFocus();
    } else {
        tl.reverse();
        document.body.style.overflow = ''; 
        navOverlay.removeEventListener('keydown', handleFocusTrap);
    }
}

// Event listeners
hamburger.addEventListener('click', toggleMenu);
closeBtn.addEventListener('click', toggleMenu);

hamburger.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') toggleMenu();
});

closeBtn.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') toggleMenu();
});

const navLinks = navOverlay.querySelectorAll('ul li a');
navLinks.forEach(link => {
    link.addEventListener('click', toggleMenu);
});

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

function debounce(func, wait) {
    let timeout;
    return function () {
        const context = this,
            args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

const focusableElementsString = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]';
let firstFocusableElement;
let lastFocusableElement;

function trapFocus() {
    const focusableElements = navOverlay.querySelectorAll(focusableElementsString);
    if (focusableElements.length === 0) return;

    firstFocusableElement = focusableElements[0];
    lastFocusableElement = focusableElements[focusableElements.length - 1];

    navOverlay.addEventListener('keydown', handleFocusTrap);
}

function handleFocusTrap(e) {
    if (e.key !== 'Tab') return;

    if (e.shiftKey) { 
        if (document.activeElement === firstFocusableElement) {
            e.preventDefault();
            lastFocusableElement.focus();
        }
    } else { 
        if (document.activeElement === lastFocusableElement) {
            e.preventDefault();
            firstFocusableElement.focus();
        }
    }
}

window.addEventListener('resize', debounce(() => {
    if (window.innerWidth > 768) {
        if (!tl.reversed()) {
            toggleMenu();
        }
    }
}, 200));
