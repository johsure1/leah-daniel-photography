



<?php 

require_once 'config.php';
require_once 'backend.php';

if(!isLoged()){
    header('location: login.php');
    exit;
}else
{
    $sql= "SELECT u.name, u.email, u.created_at, p.image, p.bio FROM users AS u INNER JOIN profile AS p ON u.id=p.user_id WHERE u.id = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
    ':id'=>$_SESSION['user_id']
    ]);
    $result=$stmt->fetch();
}





?>








<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="page-hero">
    <h1>My Profile</h1>
    <p>Manage your account details.</p>
</div>

<section class="page-body">
    <div class="container profile-page">
        <div class="profile-card">
            <img src="<?php echo htmlspecialchars($result['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($result['name'] ?? ''); ?>">
            <h3><?php echo htmlspecialchars($result['name'] ?? ''); ?></h3>
            <p><?php echo htmlspecialchars($result['email'] ?? ''); ?></p>
        </div>

        <div class="profile-details">
            <div class="card">
                <h4>Account Details</h4>
                <form method="POST" action="#">
                    <div class="field">
                        <label for="full_name">Name</label>
                        <h1><?php echo htmlspecialchars($result['name'] ?? ''); ?></h1>
                    </div>
                    <div class="field">
                        <label for="bio">Bio</label>
                        <h2 id="bio"><?php echo htmlspecialchars($result['bio'] ?? ''); ?></h2>
                        <br>
                        <h2><a href="profile_upload.php">Edit profile</a></h2>
                    </div>
                </form>
            </div>

            <div class="card">
                <h4>Membership</h4>
                <p style="color: var(--muted);">Member since <?php echo htmlspecialchars($result['created_at'] ?? ''); ?></p>
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
