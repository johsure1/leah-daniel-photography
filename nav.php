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
        <a href="home.php"><img src="<?php echo htmlspecialchars($site['logo'] ?? '') ?>" alt="Leah Daniel logo"></a>
    </div>
    <div class="menus" id="menus">
        <a href="home.php" class="active">Home</a>

        
        <a href="blog.php">blog</a>
        
        
        <a href="about.php">About</a>


        <?php if(isLoged()): ?>
            
            <a href="profile.php">Profile</a>
            <a href="logout.php">logout</a>

        <?php endif; ?>

        <?php if(isLoged() && $_SESSION['role'] === 'super_admin'): ?>
            <a href="admin-dashboard.php">admin</a>
        <?php endif; ?>

        

    </div>
    <div class="togle-btn" id="togleBtn">
        <span class="menu-icon">&#9776;</span>
    </div>
</div>



