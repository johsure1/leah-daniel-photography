<?php 

require_once 'config.php';
require_once 'backend.php';

$error = [];


if($_SERVER['REQUEST_METHOD'] === 'POST'){

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$result = registerAccount($pdo, $name, $email, $password, $confirm_password);

if($result === true){
    header('location: login.php');
    exit;
}else
{
    $error = $result;
}

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="form-wrap">
    <div class="form-card">
        <h2>Create Account</h2>
        <p class="subtitle">Join to save favorites and track bookings.</p>
        
        <?php if ($error): ?>
        <div class="errors">
            <?php foreach($error as $err): ?>
                <p><?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="field">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="name" placeholder="Leah Daniel" >
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" >
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="At least 8 characters" >
            </div>
            <div class="field">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password">
            </div>
            <button type="submit" class="btn btn-block">Create Account</button>
        </form>
        <p class="form-footer">Already have an account? <a href="login.php">Log in</a></p>
    </div>
</div>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
