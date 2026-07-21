<?php 

require_once 'config.php';
require_once 'backend.php';

$error = [];
$success = false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $atitle = trim($_POST['about_title'] ?? '');
    $abody = trim($_POST['about_body'] ?? '');
    $bname = trim($_POST['business_name'] ?? '');
    $tagline = trim($_POST['tagline'] ?? '');

    if(isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE){
        $setting_result = uploadImage($_FILES['logo']);

        if(is_array( $setting_result)){
            $error = array_merge($error,  $setting_result);
        }else{
            $upload_setting_result= siteSetting($pdo,$_SESSION['role'],$atitle,$abody,$setting_result, $bname,$tagline);

            if($upload_setting_result !== true){
                $error = array_merge($error, $upload_setting_result);
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
<title>site settings</title>
<link rel="stylesheet" href="style.css">
</head>

<div class="table-wrap" style="margin-bottom:30px;">
    <h1 style="text-align:center;">site settings</h1>
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
                  <th><input type="text" name="about_title" placeholder="about title...." style="width: 100%;"></input></th> 
                </tr>
                <tr>
                  <th><textarea type="text" name="about_body" placeholder="about body...." style="width: 100%;"></textarea></th> 
                </tr>
                <tr>
                  <th><input type="text" name="busines_name" placeholder="busines_name...." style="width: 100%;"></input></th> 
                </tr>
                <tr>
                  <th><input type="text" name="tagline" placeholder="tagline...." style="width: 100%;"></input></th> 
                </tr>
                <tr>
                    <th><input type="file" name="logo" accept="image/*"></th> 
                </tr>
                <tr>
                    <th><input type="submit" name="submit" value="submit gallery"></th> 
                </tr>
            </form>
        </thead>
    </table>
</div>