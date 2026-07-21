<?php 

require_once 'config.php';
require_once 'backend.php';

$error=[];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result=loginUser($pdo, $email,$password);

    if($result === true  &&  $_SESSION['role'] === 'super_admin'){
        header('location: admin-dashboard.php');
        exit;
    }



    if($result===true){

        header('location: home.php');
        exit;
    }else{
        $error = $result;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">
        <a href="home.php"><img src="assets/logo.jpg" alt="Leah Daniel logo"></a>
    </div>
    <div class="menus" id="menus">
        <a href="gallery.php">Gallery</a>
        <a href="blog.php">Blog</a>
        <a href="contact.php">Contact</a>
        <a href="login.php" class="active">Login</a>
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
    </div>
    <div class="togle-btn" id="togleBtn">
        <span class="menu-icon">&#9776;</span>
    </div>
</div>

<div class="form-wrap">
    <div class="form-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Log in to manage your profile and bookings.</p>

        <?php if ($error): ?>
        <div class="errors">
            <?php foreach($error as $err): ?>
                <p><?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>        

        <form method="POST" action="#">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" >
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Your password" >
            </div>
            <div class="form-meta">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-block">Log In</button>
        </form>
        <p class="form-footer">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
