<?php
@include 'config.php';

if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">ET<span>QT</span></a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="shop.php">Shop</a>
         <a href="orders.php">Orders</a>
         <a href="about.php">About</a>
        
      </nav>

      <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                $wishlist_count_query = "SELECT * FROM `wishlist` WHERE user_id = '$user_id'";
                $wishlist_count_result = mysqli_query($conn, $wishlist_count_query);
                $wishlist_num_rows = mysqli_num_rows($wishlist_count_result);
            ?>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $cart_count_query = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
                $cart_count_result = mysqli_query($conn, $cart_count_query);
                $cart_num_rows = mysqli_num_rows($cart_count_result);
            ?>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <div class="profile">
   <?php
      $select_profile_query = "SELECT * FROM `users` WHERE id = '$user_id'";
      $select_profile_result = mysqli_query($conn, $select_profile_query);
      $fetch_profile = mysqli_fetch_assoc($select_profile_result);
      $image_filename = $fetch_profile['image']; // Get the image filename from the database
      
      // Check if image filename already includes directory prefix
      $image_path = (strpos($image_filename, "uploaded_img/") === 0) ? $image_filename : "uploaded_img/" . $image_filename;
      
      //if (file_exists($image_path)) {
      //    echo '<img src="'.$image_path.'" alt="">';
      //} else {
      //    echo '<p>Image not found</p>';
      //    // Check if the directory exists
      //    if (!is_dir("uploaded_img/")) {
      //        echo "<p>Directory 'uploaded_img/' does not exist</p>";
      //    } else {
      //        // Get list of files in directory to check permissions
      //        $files = scandir("uploaded_img/");
      //        echo "<p>Files in directory:</p>";
      //        print_r($files);
      //    }
      //}
   ?>
   <img src="<?php echo $image_path; ?>" alt="">
   <p><?php echo $fetch_profile['name']; ?></p>
   <a href="user_profile_update.php" class="btn">Update Profile</a>
   <a href="logout.php" class="delete-btn">Logout</a>
   <div class="flex-btn">
      <a href="login.php" class="btn">Admin Login</a>
     
   </div>
</div>


   </div>

</header>
