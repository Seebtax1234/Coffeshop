<?php
@include 'config.php';

if(isset($_POST['submit'])){
   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

   // File upload handling
   $target_directory = "uploaded_img/";
   $target_file = $target_directory . basename($_FILES["image"]["name"]);
   $uploadOk = 1;
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
   // Check if image file is a actual image or fake image
   $check = getimagesize($_FILES["image"]["tmp_name"]);
   if($check !== false) {
      $uploadOk = 1;
   } else {
      $message[] = "File is not an image.";
      $uploadOk = 0;
   }
   
   // Check file size
   if ($_FILES["image"]["size"] > 500000) {
      $message[] = "Sorry, your file is too large.";
      $uploadOk = 0;
   }
   
   // Allow certain file formats
   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
   && $imageFileType != "gif" ) {
      $message[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
   }
   
   // Check if $uploadOk is set to 0 by an error
   if ($uploadOk == 0) {
      $message[] = "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
   } else {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
         $query = "INSERT INTO `users` (name, email, password, image) VALUES ('$name', '$email', '$pass', '$target_file')";
         if(mysqli_query($conn, $query)) {
            $message[] = 'Registered successfully!';
            header('location:login.php');
         } else {
            $message[] = "Error: " . $query . "<br>" . mysqli_error($conn);
         }
      } else {
         $message[] = "Sorry, there was an error uploading your file.";
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<img class="wave" src="imgBG/wave.png">
<div class="container1">
    <div class="img">
        <img src="imgBG/bg.svg">  
    </div>
    <section class="form-container">
       <form action="" method="post" class="login-content" enctype="multipart/form-data">
          <img src="imgBG/avatar.svg">
          <h3>Register Now</h3>
          <input type="text" name="name" class="box" placeholder="Enter your username" required>
          <input type="email" name="email" class="box" placeholder="Enter your email" required>
          <input type="password" name="pass" class="box" placeholder="Enter your password" required>
          <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
          <input type="file" name="image" class="box" accept="image/*" >
          <input type="submit" class="btn" name="submit" value="Register Now">
          <p>Already have an account? <a href="login.php">Login Now</a></p>
       </form>
    </section>
</div>

</body>
</html>
