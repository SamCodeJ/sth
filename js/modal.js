function openModal(modalId) {
    document.getElementById(modalId + 'Modal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId + 'Modal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking the close button
document.querySelectorAll('.close-modal').forEach(button => {
    button.onclick = function() {
        this.closest('.modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}); 