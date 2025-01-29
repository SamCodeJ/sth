let testimonialIndex = 0;
const testimonials = document.querySelectorAll('.testimonial');
const track = document.querySelector('.testimonial-track');

function moveTestimonial(direction) {
    testimonialIndex = testimonialIndex + direction;
    
    if (testimonialIndex < 0) {
        testimonialIndex = testimonials.length - 1;
    } else if (testimonialIndex >= testimonials.length) {
        testimonialIndex = 0;
    }
    
    const offset = -testimonialIndex * 100;
    track.style.transform = `translateX(${offset}%)`;
}

// Auto scroll testimonials
setInterval(function() {
    moveTestimonial(1);
}, 6000); 