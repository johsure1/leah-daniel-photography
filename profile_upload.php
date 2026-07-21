<?php 

require_once 'config.php';
require_once 'backend.php';

if(!isLoged()){
    header('location: login.php');
    exit;
}

$error=[];
$success=false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE){
        $upload_result = uploadImage($_FILES['image']);

        if(is_array($upload_result)){
            $error=array_merge($error,$upload_result);
        }else
        {
        $saveresult = saveImage($pdo, $_SESSION['user_id'], $upload_result);

        if($saveresult !== true){
            $error = array_merge($error, $saveresult);
        }else{
            $success = true;
    }
    }
    }

    $bio = trim($_POST['bio']);

    if($bio !== ""){
        $bio_result = saveProfileBio($pdo,$_SESSION['user_id'], $bio);
    }else
    {
        $success = true;
    }

}
$sql= "SELECT u.name, u.email, p.image, u.created_at FROM users AS u INNER JOIN profile AS p ON u.id=p.user_id WHERE u.id = :id";
$stmt=$pdo->prepare($sql);
$stmt->execute([
    ':id'=>$_SESSION['user_id']
]);
$result=$stmt->fetch();



?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Profile — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="page-hero">
    <h1>Update Profile</h1>
    <p>Change your photo and bio.</p>
</div>

<section class="page-body">
    <div class="container profile-page">
        <!-- Replace sample values with real user data from your backend -->
        <div class="profile-card" id="undiv">
            <img src="<?php echo htmlspecialchars($result['image'] ?? ''); ?>" alt="Profile photo">
            <h3><?php echo htmlspecialchars($result['name'] ?? ''); ?></h3>
            <p><?php echo htmlspecialchars($result['email'] ?? ''); ?></p>
            <p style="margin-top:10px;"><span class="status-pill status-published">Member</span></p>
        </div>

        <div class="profile-details">

        <?php if($error): ?>
            <?php foreach($error as $err): ?>
            <div class="errors">
                <p><?php echo htmlspecialchars($err); ?></p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($success): ?>
           <div><?php echo "successfully" ?></div> 
        <?php endif; ?>

            

            <div class="card">
                <h4>Update Photo &amp; Bio</h4>
                <form method="POST" action="profile_upload.php" enctype="multipart/form-data">
                    <div class="field">
                        <label for="image">Choose New Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="field">
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio" placeholder="Tell people a bit about yourself"></textarea>
                    </div>
                    <button type="submit" class="btn">Save Changes</button>
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