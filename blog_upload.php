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

    $description = trim($_POST['description']);
    $content = trim($_POST['content']);

    if(isset($_FILES['image']) && $_FILES['image'] !== UPLOAD_ERR_NO_FILE){

        $image_destination = uploadImage($_FILES['image']);

        if(is_array($image_destination)){
            $error = array_merge($error, $image_destination);
        }else
        {
            $save_blog_result = saveBlog($pdo,$image_destination, $content, $description, $_SESSION['user_id']);
            
            if($save_blog_result !== true){
                $error=array_merge($error, $save_blog_result);
            }else{
                $success = true;
                exit;
            }

        }
    }



}


?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — Leah Daniel Photography</title>
<link rel="stylesheet" href="style.css">
</head>

<div class="table-wrap" style="margin-bottom:30px;">
    <h1 style="text-align:center;">blog upload</h1>
    <table>

        <?php if($error): ?>
            <?php foreach($error as $err): ?>
                <p style="background-color: var(--danger); width: 600px; text-align: center; margin: auto;"><?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($success): ?>
            <p style="background-color: var(--success); width: 600px; text-align: center; margin: auto;"><?php echo "successfull uploaded"; ?></p>
        <?php endif; ?>


        <thead>
            <form method="POST" enctype="multipart/form-data">
                <tr>
                  <th><textarea type="text" name="description" placeholder="add description" style="width: 100%;"></textarea></th> 
                </tr>
                <tr>
                    <th><textarea type="text" name="content" placeholder="add content" style="width: 100%;"></textarea></th> 
                </tr>
                <tr>
                    <th><input type="file" name="image" accept="image/*"></th> 
                </tr>
                <tr>
                    <th><input type="submit" name="submit" value="submit"></th> 
                </tr>
            </form>
        </thead>
    </table>
</div>