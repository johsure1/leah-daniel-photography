<?php 

require_once 'config.php';
require_once 'backend.php';

if(!isLoged()){
    header('location: login.php');
    exit;
}

$error = [];

$success= false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $title = trim($_POST['title'] ?? '');

    if(isset($_FILES['img']) && $_FILES['img']['error'] !== UPLOAD_ERR_NO_FILE){
        $gallery_image_result = uploadImage($_FILES['img']);

        if(is_array( $gallery_image_result)){
            $error = array_merge($error,  $gallery_image_result);
        }else{
            $upload_gallery_result= uploadGallery($pdo,$gallery_image_result,$_SESSION['user_id'], $title);

            if($upload_gallery_result !== true){
                $error = array_merge($error, $upload_gallery_result);
            }else
            {
                $success = true;
            }
        }
    }
}


?>






<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>

<div class="table-wrap" style="margin-bottom:30px;">
    <h1 style="text-align:center;">gallery upload</h1>
    <table>

        <?php if($error): ?>
            <?php foreach($error as $err): ?>
                <p style="background-color: var(--danger); width: 600px; text-align: center; margin: auto;"><?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($success): ?>
            <p style="background-color: var(--success); width: 600px; text-align: center; margin: auto;"><?php echo "successfull uploaded an image"; ?></p>
        <?php endif; ?>


        <thead>
            <form method="POST" enctype="multipart/form-data">
                <tr>
                  <th><input type="text" name="title" placeholder="add title" style="width: 100%;"></input></th> 
                </tr>
                <tr>
                    <th><input type="file" name="img" accept="image/*"></th> 
                </tr>
                <tr>
                    <th><input type="submit" name="submit" value="submit gallery"></th> 
                </tr>
            </form>
        </thead>
    </table>
</div>