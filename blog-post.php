<?php 

require_once 'config.php';
require_once 'backend.php';

if(!isloged()){
    header('location: login.php');
    exit;
}

$blog_post = (int)$_GET['blog_view'];

$sql = "select description, image, published_at, content from blog where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id'=>$blog_post
]);
$blog_post_result=$stmt->fetch();





?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chasing Golden Hour — Blog</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="page-hero">
    <h1>Chasing Golden Hour</h1>
</div>

<section class="page-body">
    <div class="container" style="max-width:760px;">
        <div class="blog-post">
            <img src="<?php echo htmlspecialchars($blog_post_result['image']); ?>" alt="" style="border-radius: var(--radius); margin-bottom: 20px;">
            <p class="meta"><?php echo htmlspecialchars($blog_post_result['published_at']); ?></p>
            <h1><?php echo htmlspecialchars($blog_post_result['description']); ?></h1>
            <p><?php echo htmlspecialchars($blog_post_result['content']); ?></p>
            <a href="blog.php" class="btn btn-outline" style="margin-top: 20px; color: var(--ink); border-color: var(--ink);">&larr; Back to blog</a>
        </div>
    </div>
</section>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
