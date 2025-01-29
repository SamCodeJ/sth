// Animation on scroll
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    });

    // Observe all service cards
    document.querySelectorAll('.service-card').forEach((card) => {
        observer.observe(card);
    });

    // Mobile menu toggle
    const menuButton = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (menuButton) {
        menuButton.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }
});

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
}); 