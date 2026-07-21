<?php 

require_once 'config.php';
require_once 'backend.php';

if(!isLoged()){
    header('location: login.php');
    exit;
}

$sql = "select name,email from users where id = :id";
$stmt=$pdo->prepare($sql);
$stmt->execute([':id' => $_SESSION['user_id']]);
$user=$stmt->fetch();




$error=[];
$success = false;

if($_SERVER['REQUEST_METHOD']==='POST'){
    $message = trim($_POST['message']);
    $subject = trim($_POST['subject']);

    $result = sendMessage($pdo, $user['name'],$user['email'],$_SESSION['user_id'],$subject,$message);
    if($result===true){
        $success=true;
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
<title>Contact — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="page-hero">
    <h1>Get in Touch</h1>
    <p>Booking an event or just have a question? Send a message below.</p>
</div>

<section class="page-body">
    <div class="container" style="display:flex; justify-content:center;">
        <div class="form-card form-wide">
            <h2>Contact Me</h2>
            <p class="subtitle">I usually reply within 1–2 business days.</p>

            <?php if ($success): ?>
                <div class="success">thanks your message has been sent</div>
            <?php endif; ?>

            <?php if($error): ?>
                <?php foreach($error as $err): ?>
                    <p><?php echo htmlspecialchars($err); ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="POST" action="#">
                <div class="field-row">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                </div>
                <div class="field">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="What's this about?">
                </div>
                <div class="field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Tell me a bit about your shoot..." required></textarea>
                </div>
                <button type="submit" class="btn btn-block">Send Message</button>
            </form>
        </div>
    </div>
</section>

<footer class="site-footer">
    <p>&copy; 2026 Leah Daniel Photography &middot; Turning memories into timeless images.</p>
</footer>
<script src="script.js"></script>
</body>
</html>
