<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit; // Ensure script stops execution after redirect
}

// Initialize $fetch_profile variable to avoid undefined variable error
$fetch_profile = array();

// Fetch user profile details
$fetch_profile_query = $conn->prepare("SELECT name, email, password, image FROM `users` WHERE id = ?");
if ($fetch_profile_query) {
    $fetch_profile_query->bind_param("i", $user_id);
    $fetch_profile_query->execute();
    $fetch_profile_query->bind_result($name, $email, $password, $image);
    $fetch_profile_query->fetch();
    $fetch_profile_query->close();
}

// Handle form submission
if (isset($_POST['update_profile'])) {
   // Your update profile code goes here
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update user profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <section class="update-profile">

      <h1 class="title">update profile</h1>

      <form action="" method="POST" enctype="multipart/form-data">
         <img src="uploaded_img/<?php echo $image; ?>" alt="">
         <div class="flex">
            <div class="inputBox">
               <span>username :</span>
               <input type="text" name="name" value="<?php echo $name; ?>" placeholder="update username" required class="box">
               <span>email :</span>
               <input type="email" name="email" value="<?php echo $email; ?>" placeholder="update email" required class="box">
               <span>update pic :</span>
               <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
               <input type="hidden" name="old_image" value="<?php echo $image; ?>">
            </div>
            <div class="inputBox">
               <input type="hidden" name="old_pass" value="<?php echo $password; ?>">
               <span>old password :</span>
               <input type="password" name="update_pass" placeholder="enter previous password" class="box">
               <span>new password :</span>
               <input type="password" name="new_pass" placeholder="enter new password" class="box">
               <span>confirm password :</span>
               <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
            </div>
         </div>
         <div class="flex-btn">
            <input type="submit" class="btn" value="update profile" name="update_profile">
            <a href="home.php" class="option-btn">go back</a>
         </div>
      </form>

   </section>

   <?php include 'footer.php'; ?>


   <script src="js/script.js"></script>

</body>

</html>
