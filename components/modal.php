<div class="modal" id="contactModal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Let's Connect</h2>
        <form id="contactForm" action="includes/contact.php" method="POST">
            <div class="form-group">
                <input type="text" name="name" required placeholder="Your Name">
            </div>
            <div class="form-group">
                <input type="email" name="email" required placeholder="Your Email">
            </div>
            <div class="form-group">
                <textarea name="message" required placeholder="Your Message"></textarea>
            </div>
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</div> 