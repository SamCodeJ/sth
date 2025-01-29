// Intersection Observer for reveal animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.reveal').forEach((element) => {
    observer.observe(element);
});

// Consolidate all functionality into main.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing components...');
    // Menu functionality
    initHamburgerMenu();
    
    // Search functionality
    const searchBox = document.querySelector('.search-box, #searchBox');
    if (searchBox) {
        initSearch();
    }
    
    // Slider functionality
    const slider = document.querySelector('.simple-slider');
    if (slider) {
        initSlider();
    }

    initFloatingButton();
});

// Hamburger Menu
function initHamburgerMenu() {
    console.log('Initializing hamburger menu...');
    
    // Try different possible selectors
    const hamburger = document.querySelector('.hamburger') || 
                     document.querySelector('.mobile-menu-btn') ||
                     document.querySelector('#menuToggle');
                     
    const navLinks = document.querySelector('.nav-links') || 
                    document.querySelector('.mobile-nav') ||
                    document.querySelector('#mobileMenu');

    if (!hamburger || !navLinks) {
        console.warn('Menu elements not found');
        return;
    }

    // Define toggleMenu function globally
    window.toggleMenu = function() {
        hamburger.classList.toggle('active');
        navLinks.classList.toggle('active');
    }

    hamburger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        toggleMenu();
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
        }
    });
}

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Touch event handling for iPad
document.addEventListener('DOMContentLoaded', function() {
    // Prevent double-tap zoom on navigation
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        link.addEventListener('touchend', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                window.location.href = href;
            }
        });
    });

    // Improve touch response for project cards
    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });

        card.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Add momentum scrolling to containers
    const scrollContainers = document.querySelectorAll('.projects-grid, .tech-grid');
    scrollContainers.forEach(container => {
        container.style.webkitOverflowScrolling = 'touch';
    });
});

// Search functionality
function initSearch() {
    const searchBox = document.querySelector('.search-box, #searchBox');
    if (!searchBox) return;
    
    searchBox.addEventListener('input', function(e) {
        // Your search logic here
    });
}

// Slider functionality
function initSlider() {
    const slider = document.querySelector('.simple-slider');
    if (!slider) return;
    
    // Your slider logic here
}

// Add floating contact button
function initFloatingButton() {
    console.log('Initializing floating button...');
    
    const floatingButton = document.createElement('a');
    floatingButton.className = 'floating-contact-btn';
    floatingButton.href = 'pages/info.php';  // Updated path
    floatingButton.innerHTML = '<i class="fas fa-envelope"></i>';
    floatingButton.setAttribute('title', 'Contact Us');
    
    document.body.appendChild(floatingButton);
    console.log('Floating button added to DOM');

    // Make button visible immediately
    setTimeout(() => {
        floatingButton.classList.add('visible');
    }, 500);

    // Scroll behavior
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            floatingButton.classList.add('visible');
        } else {
            floatingButton.classList.remove('visible');
        }
    });
} 