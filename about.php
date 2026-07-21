<?php 

require_once 'config.php';
require_once 'backend.php';

$site = selectSettings($pdo);

$site_user = selectUsers($pdo);

if(isLoged()){
    $profile = selectProfile($pdo, $_SESSION['user_id']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php'; ?>

<div class="page-hero">
    <h1>About <?php echo htmlspecialchars($site_user['name']) ?? '' ?></h1>
    <p><?php echo htmlspecialchars($site['tagline']) ?? '' ?></p>
</div>

<section class="page-body">
    <div class="container about-grid">
        <img src="<?php echo htmlspecialchars($site_user['image']) ?? '' ?>" alt="Leah Daniel">
        <div>
            <h2>Hi, I'm  <?php echo htmlspecialchars($site_user['name']) ?? '' ?>.</h2>
            <p><?php echo htmlspecialchars($site['about_title']) ?? '' ?></p>
            <p><?php echo htmlspecialchars($site['about_body']) ?? '' ?></p>
            <div class="skills-list">
                <span>Portraits</span>
                <span>Weddings</span>
                <span>Street Photography</span>
                <span>Editorial</span>
                <span>Lightroom &amp; Retouching</span>
            </div>
        </div>
    </div>
</section>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
