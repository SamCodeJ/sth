document.addEventListener('DOMContentLoaded', function() {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    
    function showSlide(n) {
        // Hide all slides
        slides.forEach(slide => slide.style.display = 'none');
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Reset index if out of bounds
        currentSlide = n >= slides.length ? 0 : n < 0 ? slides.length - 1 : n;
        
        // Show current slide
        slides[currentSlide].style.display = 'block';
        dots[currentSlide].classList.add('active');
    }
    
    function nextSlide() {
        showSlide(currentSlide + 1);
    }
    
    function previousSlide() {
        showSlide(currentSlide - 1);
    }
    
    // Event listeners for buttons
    document.querySelector('.next').addEventListener('click', nextSlide);
    document.querySelector('.prev').addEventListener('click', previousSlide);
    
    // Event listeners for dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
    });
    
    // Auto advance slides
    setInterval(nextSlide, 5000);
    
    // Show first slide
    showSlide(0);
}); 