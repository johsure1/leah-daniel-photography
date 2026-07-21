<?php 

ob_start();

require_once 'config.php';
require_once 'backend.php';

$view = $_GET['view'] ?? '';



$select_count = (int) selectCountUsers($pdo);

$count_blog = (int) selectBlog($pdo);

$count_gallery = (int) selectGallery($pdo);

$count_message = (int) selectMessage($pdo);

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
<title>Admin Dashboard — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <div class="brand">
            <img src="<?php echo htmlspecialchars($profile['image']) ?? '' ?>" alt="logo">
            <span><?php echo htmlspecialchars($site_user['name']) ?? '' ?></span>
        </div>
        <nav>
            <a href="admin-dashboard.php" class="active"> <span class="label-text">Dashboard</span></a>
            <a href="blog.php"><span class="label-text">Blog</span></a>
            <a href="gallery.php"><span class="label-text">Gallery</span></a>
            <a href="profile.php"><span class="label-text">My Profile</span></a>
            <a href="logout.php"><span class="label-text">Logout</span></a>
            <a href="admin-dashboard.php?view=messages"><span class="label-text">messages</span></a>


        <div><h2>UPLOADS</h2></div>
            <a href="admin-dashboard.php?view=blog_upload"><span class="label-text">blog</span></a>
            <a href="admin-dashboard.php?view=gallery_upload"><span class="label-text">Gallery</span></a>
            <a href="admin-dashboard.php?view=site_setting"><span class="label-text">site settings</span></a>
        </nav>
    </aside>

    <main class="dash-main">
        <div class="dash-topbar">
            <h1>Welcome back, <?php echo htmlspecialchars($site_user['name']) ?? '' ?></h1>
            <a href="home.php" class="btn">View Site</a>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <div>
                    <div class="num"><?php echo htmlspecialchars($select_count ?? ''); ?></div>
                    <div class="label">Users</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="num"><?php echo htmlspecialchars($count_blog ?? ''); ?></div>
                    <div class="label">Blog Posts</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="num"><?php echo htmlspecialchars($count_gallery ?? ''); ?></div>
                    <div class="label">Gallery Photos</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="num"><?php echo htmlspecialchars($count_message ?? ''); ?></div>
                    <div class="label">Unread Messages</div>
                </div>
            </div>
        </div>

        


        <div>
            <?php if($view==='blog_upload'): ?>

                <?php require_once 'blog_upload.php'; ?>

            <?php elseif($view==='gallery_upload'): ?>

                <?php require_once 'gallery_upload.php'; ?>
            
            <?php elseif($view==='site_setting'): ?>

                <?php require_once 'site_settings.php'; ?>
            
            <?php elseif($view==='messages'): ?>

                <?php require_once 'messages.php'; ?>

            <?php endif; ?>

        </div>
    </main>
</div>

</body>
</html>
