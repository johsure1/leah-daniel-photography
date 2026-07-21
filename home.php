<?php 
require_once 'config.php';
require_once 'backend.php';

if(!isLoged()){
    header('location: login.php');
    exit;
}

 $profile = selectProfile($pdo, $_SESSION['user_id']);

?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leah Daniel Photography — Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php'; ?>

<section class="profile">
    <div class="image">
        <img src="<?php echo htmlspecialchars($profile['image']) ?? '' ?>" alt="Leah Daniel portrait">
        <div class="profile-description">
            <h1>Hi! I'm Leah Daniel</h1>
            <h3>Photography &amp; Visual Storytelling</h3>
            <p>Turning memories into timeless images.</p>
        </div>
        <div class="buttons">
            <a href="gallery.php" class="button">View Gallery</a>
            <a href="contact.php" class="button">Contact Me</a>
        </div>
    </div>
</section>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
