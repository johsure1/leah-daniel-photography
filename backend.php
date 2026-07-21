<?php 

require_once 'config.php';






#a function to check if email exists

function emailExists($pdo,$email){
    $sql = 'select id from users where email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch() !== false;

}




#function to register a new account

function registerAccount($pdo,$name,$email,$password, $confirm_password){
$error = [];

if($name==="" || $email === "" || $password === ""){
    $error[] ="please fill all the records";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error[] = "enter a valid email";
}

if($password !== $confirm_password){
    if(strlen($password)<8){
        $error[] = "password must match and must contain at least 8 characters";
    }
}

if(!empty($error)){
    return $error;
}

if(emailExists($pdo,$email)){
    $error[]= "email already exists";
    return $error;
}




try{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "insert into users (name, email, password) values (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'=>$name,
        ':email'=>$email,
        ':password'=>$hash
    ]);


}catch(PDOException $e)
{
   $error[]= 'something went wrong please try again to register a new account';
    }

return true;

}





#a function to login user

function loginUser($pdo,$email,$password){
    $error=[];

    if($email === '' || $password === ''){
        $error[] = "please fill all email and password";
        return $error; 
    }

    $sql = "select id, name, role, password from users where email = :email";
    $stmt =$pdo->prepare($sql);
    $stmt->execute([':email'=>$email]);
    $result=$stmt->fetch();

    if(!$result){
        $error[]="incorrect email or password";
        return $error;
    }

    if(!password_verify($password, $result['password'] )){
        $error[] = "incorrect password";
        return $error;
    }

    $_SESSION['user_id'] = $result['id'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['role'] = $result['role'];

    return true;
}




#a function to check if user is logged in

function isLoged(){
    return isset($_SESSION['user_id']);
}




#a function for sending message(contact form)

function sendMessage($pdo,$name,$email,$user_id,$subject,$message){

    $error=[];
    if($message==="" || $subject===""){
        $error[] ="please fill all the field";
    }
    try{
        $sql = "insert into contact (user_id,email,subject,message,name) values (:user_id, :email, :subject, :message, :name)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message,
            ':name' => $name
        ]);
    return true;

    }catch(PDOException $e){
        $error[] = "something went wrong please try again";
        return $error;

    }
}



#a function to upload image

function uploadImage($file){
    $error = [];

    if(!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE){
        $error[] = "please select an image to upload";
        return $error;
    }

    if($file['error'] !== UPLOAD_ERR_OK){
        $error[] ="there was a problem uploading your file";
        return $error;
    }

    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
    $detected_type = mime_content_type($file['tmp_name']);

    if(!in_array($detected_type, $allowed_types)){
        $error[] = "only png, jpg, and jpeg are allowed";
        return $error;
    }

    $max_size = 2 * 1024 * 1024;
    if($file['size']>$max_size){
        $error[] = "file should not be greater than 2mb!";
        return $error;
    }

    $pathinfo = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newname = uniqid('file_', true) . '.' . $pathinfo;
    $destination = 'assets/uploads/' . $newname;

    if(!move_uploaded_file($file['tmp_name'], $destination)){
        $error[] = "failed to save the uploaded file";
        return $error;
    }

    return $destination;
}


#a function to save the image

function saveImage($pdo, $user_id, $filepath){
    $sql = "select id from profile where user_id = :user_id ";
    $stmt =$pdo->prepare($sql);
    $stmt->execute([
        ':user_id'=>$user_id
    ]);
    $id = $stmt->fetch();


    try{
        if($id){
            $update = "update profile set image = :image where user_id = :user_id";
            $stmti=$pdo->prepare($update);
            $stmti->execute([
                ':image'=>$filepath,
                ':user_id'=>$user_id
            ]);
        }else
        {
            $insert = "insert into profile (user_id, image) values (:user_id, :image)";
            $stmti = $pdo->prepare($insert);
            $stmti->execute([
                ':user_id'=>$user_id,
                ':image'=>$filepath
            ]);
        }

        return true;
    }catch(PDOException $e)
    {
        return ["something went wrong!"];
    }
}




# a function to save bio information

function saveProfileBio($pdo,$user_id, $bio){

    $stmti = $pdo->prepare("select id from profile where user_id = :user_id");
    $stmti->execute([
        ':user_id'=>$user_id
    ]);
    $id = $stmti->fetch();


    try{
        if($id){
            $sql = "update profile set bio = :bio where user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':bio'=>$bio,
                ':user_id'=>$user_id
            ]);
        }else
        {
            $sql = "insert into profile (user_id, bio) values (:user_id, :bio)";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                ':user_id'=>$user_id,
                ':bio'=>$bio
            ]);
        }

        return true;
    }catch(PDOException $e)
    {
        return ["something went wrong saving your bio"];
    }
}




# a function to save blog


function saveBlog($pdo,$image,$content,$description,$user_id){
    $error=[];

    if($image === "" || $content === "" || $description === "" || $user_id === "")
        {
            $error[]="all fields are required";
            return $error;
        }

    try{
        $sql = "INSERT INTO blog (image,content,description,user_id) VALUES (:image, :content, :description, :user_id) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':image'=>$image,
            ':content'=>$content,
            ':description'=>$description,
            ':user_id'=>$user_id
        ]);
        return true;
    }catch(PDOException $e)
    {
        $error[]="something went wrong!!!!";
        return $error;
    }

}



#a function to upload gallery

function uploadGallery($pdo,$img,$uid,$title='image'){
    $error = [];

    if($img === "" || $uid === ""){
        $error[] = "all fields are required";
        return $error;
    }

    try{
        $sql = "insert into gallery (user_id, title, image)  values (:uid, :title, :image) ";
        $stmt = $pdo->prepare($sql);
        $stmt ->execute([
            ':uid'=>$uid,
            ':title'=>$title,
            ':image'=>$img
        ]);

        return true;
    }catch(PDOException $e){
        $error[]= "something went wrong uploading your gallery";
        return $error;
    }

}



function siteSetting($pdo, $role, $title, $body, $logo, $name, $tagline){
    $error = [];
    
    if($role !== 'super_admin'){
        $error[] = "you dont have permision"; 
        return $error;
    }

    try{

        $check = $pdo->query("SELECT id FROM site_setting WHERE id = 1");
        $existing = $check->fetch();


        if($existing){
            $sql = "update site_setting set about_title = :about_title, about_body = :about_body, business_name = :business_name, tagline = :tagline, logo = :logo  where id=1";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                 ':about_title'=>$title,
                ':about_body'=>$body,
                ':business_name'=>$name,
                ':tagline'=>$tagline,
                ':logo'=>$logo
                ]);
        }else
        {
            $sql = "insert into site_setting (id, about_title, about_body, business_name, tagline, logo) values (1, :about_title, :about_body, :business_name, :tagline, :logo)";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                ':about_title'=>$title,
                ':about_body'=>$body,
                ':business_name'=>$name,
                ':tagline'=>$tagline,
                ':logo'=>$logo
            ]);
        }            



    return true;

    }catch(PDOException $e){

        $error[]="something went wrong.  " ;
        return $error;

    }
}




function selectSettings($pdo){
    $stmt=$pdo->query("select * from site_setting where id=1")->fetch();
    return $stmt;
}




function selectUsers($pdo){
    $stmt=$pdo->query("select * from users where role = 'super_admin'")->fetch();
    return $stmt;
}

function selectProfile($pdo, $id){
    $sql = "select image from profile where user_id = :id ";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        ':id'=>$id
    ]);
    $result=$stmt->fetch();

    return $result;

}



function selectCountUsers($pdo){
    $sql =$pdo->query("select count(email) from users");
    return $sql->fetchColumn();
}

function selectBlog($pdo){
    $sql =$pdo->query("select count(id) from blog");
    return $sql->fetchColumn();
}


function selectGallery($pdo){
    $sql =$pdo->query("select count(id) from gallery");
    return $sql->fetchColumn();
}

function selectMessage($pdo){
    $sql =$pdo->query("select count(id) from contact");
    return $sql->fetchColumn();
}

function selectContact($pdo){
    $sql =$pdo->query("select u.name, c.email, c.message, c.created_at from users as u inner join contact as c on u.id=c.user_id");
    return $sql->fetchAll();
}





?>