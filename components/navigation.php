<nav class="navbar">
    <div class="nav-left">
        <div class="logo">
            <img src="<?php echo $isHomePage ? 'images/sth.png' : '../images/sth.png'; ?>" alt="Stellar Tech Hub Logo" class="logo-img">
            <span class="company-name">Stellar Tech Hub</span>
        </div>
    </div>
    
    <div class="nav-right">
        <div class="nav-links">
            <a href="<?php echo $isHomePage ? 'index.php' : '../index.php'; ?>" class="nav-link">Home</a>
            <a href="<?php echo $isHomePage ? 'pages/services.php' : 'services.php'; ?>" class="nav-link">Services</a>
            <a href="<?php echo $isHomePage ? 'pages/projects.php' : 'projects.php'; ?>" class="nav-link">Projects</a>
            <a href="<?php echo $isHomePage ? 'pages/info.php' : 'info.php'; ?>" class="nav-link">Info</a>
            <a href="<?php echo $isHomePage ? 'pages/more.php' : 'more.php'; ?>" class="nav-link">More</a>
            <a href="<?php echo $isHomePage ? 'pages/about.php' : 'about.php'; ?>" class="nav-link">About Us</a>
            <a href="<?php echo $isHomePage ? 'pages/webinar-register.php' : 'webinar-register.php'; ?>" class="register-btn">Register Now</a>
        </div>
        
        <button class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>

<script>
function toggleSearch() {
    const searchBox = document.getElementById('searchBox');
    searchBox.classList.toggle('active');
    if (searchBox.classList.contains('active')) {
        document.getElementById('searchInput').focus();
    }
}

function performSearch() {
    const searchTerm = document.getElementById('searchInput').value.trim();
    if (searchTerm) {
        // You can customize this to search specific content or redirect to a search results page
        alert('Searching for: ' + searchTerm);
        // Example: window.location.href = 'search-results.php?q=' + encodeURIComponent(searchTerm);
    }
}

// Close search box when clicking outside
document.addEventListener('click', function(event) {
    const searchBox = document.getElementById('searchBox');
    const searchBtn = document.querySelector('.search-btn');
    
    if (!searchBox.contains(event.target) && !searchBtn.contains(event.target)) {
        searchBox.classList.remove('active');
    }
});

// Handle Enter key in search input
document.getElementById('searchInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        performSearch();
    }
});
</script> 