<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stellar Tech Hub - Empowering You</title>
    <link rel="icon" type="image/x-icon" href="images/sth.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="js/simple-slider.js" defer></script>
    <style>
    .fab-button {
        position: fixed;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    /* First button (info) */
    .fab-button:first-child {
        bottom: 20px;
        background: #34495e;
        
    }

    /* Second button (webinar) */
    .fab-webinar {
        bottom: 90px; /* 20px + 50px + 20px spacing */
        background: #f39c12;
    }

    /* Theme toggle button */
    .fab-theme {
        bottom: 160px; /* 90px + 50px + 20px spacing */
        background: #34495e;
    }

    .fab-button i {
        color: white;
        font-size: 20px;
    }

    /* Hide/Show icons based on theme */
    .dark-icon {
        display: none;
    }

    [data-theme="dark"] .light-icon {
        display: none;
    }

    [data-theme="dark"] .dark-icon {
        display: block;
    }
    </style>
</head>
<body> 

<a href="info.php" class="fab-button" title="More Information">
    <i class="fas fa-info"></i>
</a>

<!-- Add this right after the first FAB in components/pages_header.php -->
<a href="pages/webinar-register.php" class="fab-button fab-webinar" title="Free ML Webinar">
    <i class="fas fa-video"></i>
</a>

<!-- Add after the existing FABs (around line 22) -->
<!-- <button class="fab-button fab-theme" title="Toggle Theme" id="themeToggle">
    <i class="fas fa-sun light-icon"></i>
    <i class="fas fa-moon dark-icon"></i>
</button> -->
<!-- Add before closing </head> tag -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    
    // Check for saved theme preference or default to 'light'
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    themeToggle.addEventListener('click', () => {
        let theme = document.documentElement.getAttribute('data-theme');
        let newTheme = theme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
});
</script>
