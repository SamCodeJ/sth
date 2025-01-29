document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for fade-in elements
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                
                // Add delay for child elements
                const children = entry.target.querySelectorAll('[data-animation]');
                children.forEach((child, index) => {
                    child.style.setProperty('--delay', index + 1);
                });
            }
        });
    }, {
        threshold: 0.1
    });

    // Observe all sections
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });

    // Observe individual elements with animations
    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });

    // Stats counter animation
    const stats = document.querySelectorAll('.stat-number');
    stats.forEach((stat, index) => {
        const target = parseInt(stat.getAttribute('data-target'));
        stat.style.setProperty('--delay', index + 1);
        
        if (target) {
            let current = 0;
            const increment = target / 50;
            const updateCount = () => {
                if (current < target) {
                    current += increment;
                    stat.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCount);
                } else {
                    stat.textContent = target;
                }
            };
            updateCount();
        }
    });
}); 