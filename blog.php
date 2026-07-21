<?php 

require_once 'config.php';
require_once 'backend.php';



$sql =$pdo->query("select * from blog order by updated_at");
$blog_result=$sql->fetchAll();







?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blog — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="page-hero">
    <h1>Blog</h1>
    <p>Notes on light, film, and the craft.</p>
</div>

<section class="page-body">
    
    <div class="container">
        <div class="blog-grid">
          
            <?php foreach($blog_result as $r): ?>

            <div class="blog-card">
                <img src="<?php echo htmlspecialchars($r['image']); ?>" alt="Post cover">
                <div class="body">
                    <span class="meta"><span class="blog-tag"></span><?php echo htmlspecialchars($r['updated_at']); ?></span>
                    <h3><?php echo htmlspecialchars($r['description']); ?></h3>
                    <a class="read-more" href="blog-post.php?blog_view=<?php echo htmlspecialchars($r['id']); ?>">Read more </a>
                </div>
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
