<?php 
$isHomePage = false;
include '../components/pages_header.php'; 
?>

<main class="more-page">
    <?php include '../components/navigation.php'; ?>
    
    <section class="page-header">
        <h1><i class="fas fa-ellipsis-h"></i> More Resources</h1>
        <p>Additional resources and opportunities for our students</p>
    </section>

    <section class="more-content">
        <div class="resources-grid">
            <div class="resource-card">
                <div class="resource-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h2>Learning Resources</h2>
                <div class="resource-list">
                    <a href="#" class="resource-link">
                        <i class="fas fa-file-pdf"></i>
                        <span>Course Materials</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-video"></i>
                        <span>Video Tutorials</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-book"></i>
                        <span>E-Books Library</span>
                    </a>
                </div>
            </div>

            <div class="resource-card">
                <div class="resource-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h2>Career Support</h2>
                <div class="resource-list">
                    <a href="#" class="resource-link">
                        <i class="fas fa-file-alt"></i>
                        <span>Resume Templates</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-handshake"></i>
                        <span>Interview Preparation</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-building"></i>
                        <span>Job Opportunities</span>
                    </a>
                </div>
            </div>

            <div class="resource-card">
                <div class="resource-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h2>Community</h2>
                <div class="resource-list">
                    <a href="#" class="resource-link">
                        <i class="fas fa-comments"></i>
                        <span>Discussion Forums</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Tech Events</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-user-friends"></i>
                        <span>Alumni Network</span>
                    </a>
                </div>
            </div>

            <div class="resource-card">
                <div class="resource-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h2>Certifications</h2>
                <div class="resource-list">
                    <a href="#" class="resource-link">
                        <i class="fas fa-award"></i>
                        <span>Industry Certifications</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Course Certificates</span>
                    </a>
                    <a href="#" class="resource-link">
                        <i class="fas fa-medal"></i>
                        <span>Skill Badges</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../components/footer.php'; ?> 