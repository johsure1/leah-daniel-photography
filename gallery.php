<?php 

require_once 'config.php';
require_once 'backend.php';

$error = "";
$success = false;


$gallery_images = $pdo->query("select image, title from gallery")->fetchAll();

if(!$gallery_images){
    $error = "no images yet";
}else
{
    $success = true;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gallery — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="page-hero">
    <h1>Gallery</h1>
    <p>A selection of recent work.</p>
</div>

<section class="page-body">

        <?php if($error): ?>
                <p style="background-color: var(--danger); width: 600px; text-align: center; margin: auto;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>


    <div class="container">
        <div class="gallery-grid">
            <?php foreach($gallery_images as $gallery): ?>

            <div class="gallery-item">
                <img src="<?php echo htmlspecialchars($gallery['image']); ?>" alt="Portrait session">
                <div class="caption"><?php echo htmlspecialchars($gallery['title']); ?></div>
            </div> 
            
            <?php endforeach; ?>

        </div>
    </div>
</section>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
