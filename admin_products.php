<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->bind_param("s", $name);
    $select_products->execute();
    $select_products->store_result(); // Need to call store_result to use num_rows

    if ($select_products->num_rows > 0) {
        $message[] = 'Product name already exists!';
    } else {

        $insert_products = $conn->prepare("INSERT INTO `products`(name, category, details, price, image) VALUES(?,?,?,?,?)");
        $insert_products->bind_param("sssss", $name, $category, $details, $price, $image);
        $insert_products->execute();

        if ($insert_products) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'New product added!';
            }
        }
    }
}


if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="add-products">

        <h1 class="title">Add New Product</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <input type="text" name="name" class="box" required placeholder="Enter Product Name">
                    <select name="category" class="box" required>
                        <option value="" selected disabled>Select Category</option>
                        <option value="vegitables">Uniqlo</option>
                        <option value="fruits">Kids</option>
                        <option value="meat">Womens</option>
                        <option value="fish">Mens</option>
                    </select>
                </div>
                <div class="inputBox">
                    <input type="number" min="0" name="price" class="box" required placeholder="Enter Product Price">
                    <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
                </div>
            </div>
            <textarea name="details" class="box" required placeholder="Enter Product Details" cols="30" rows="10"></textarea>
            <input type="submit" class="btn" value="Add Product" name="add_product">
        </form>

    </section>

    <section class="show-products">

    <h1 class="title">Products Added</h1>

    <div class="box-container">

    <?php
     $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
     if(mysqli_num_rows($select_products) > 0){
        while($fetch_products = mysqli_fetch_assoc($select_products)){
  ?>
  <div class="box"> <!-- Add this line -->
     <div class="price">₱<?php echo $fetch_products['price']; ?></div>
     <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
     <div class="name"><?php echo $fetch_products['name']; ?></div>
     <div class="details"><?php echo $fetch_products['details']; ?></div>
     <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
     <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
  </div>
  <?php
     }
  }else{
     echo '<p class="empty">no products added yet!</p>';
  }
  ?>
</div>

   

</section>


    <script src="js/script.js"></script>

</body>

</html>
