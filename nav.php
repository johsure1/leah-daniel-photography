<?php 
require_once 'config.php';
require_once 'backend.php';

if(isLoged()){
    $sql= "SELECT u.name, u.email, p.image, u.created_at FROM users AS u INNER JOIN profile AS p ON u.id=p.user_id WHERE u.id = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        ':id'=>$_SESSION['user_id']
        ]);
    $result=$stmt->fetch();
}

$site = selectSettings($pdo);


?>

<div class="navbar">
    <div class="logo">
        <a href="home"><img src="<?php echo htmlspecialchars($site['logo'] ?? '') ?>" alt="Leah Daniel logo"></a>
    </div>
    <div class="menus" id="menus">
        <a href="home" class="active">Home</a>

        
        <a href="blog">blog</a>

        <a href="gallery">Gallery</a>
        
        
        <a href="about">About</a>

        <a href="contact">Contact</a>


        <?php if(isLoged()): ?>
            
            <a href="profile">Profile</a>
            <a href="logout">logout</a>

        <?php endif; ?>

        <?php if(isLoged() && $_SESSION['role'] === 'super_admin'): ?>
            <a href="admin-dashboard">admin</a>
        <?php endif; ?>

        

    </div>
    <div class="togle-btn" id="togleBtn">
        <span class="menu-icon">&#9776;</span>
    </div>
</div>