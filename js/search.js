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