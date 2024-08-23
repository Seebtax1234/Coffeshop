<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_product'])) {

    $pid = $_POST['pid'];
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
    $old_image = $_POST['old_image'];

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, details = ?, price = ? WHERE id = ?");
    $update_product->bind_param("ssssi", $name, $category, $details, $price, $pid);
    $update_product->execute();

    $message = array(); // Initialize empty array for messages
    $message[] = 'Product updated successfully!';

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {

            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->bind_param("si", $image, $pid);
            $update_image->execute();

            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/' . $old_image);
                $message[] = 'Image updated successfully!';
            }
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
    <title>update products</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="update-product">

        <h1 class="title">update product</h1>

        <?php
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->bind_param("i", $update_id);
        $select_products->execute();
        $select_products->bind_result($id, $name, $category, $details, $price, $image);
        while ($select_products->fetch()) {
        ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="old_image" value="<?= $image; ?>">
                <input type="hidden" name="pid" value="<?= $id; ?>">
                <img src="uploaded_img/<?= $image; ?>" alt="">
                <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="update product name" name="name">
                <input type="number" name="price" min="0" placeholder="enter product price" required class="box" value="<?= $price; ?>">
                <select name="category" class="box" required>
                    <option selected><?= $category; ?></option>
                    <option value="vegitables">Uniqlo</option>
                    <option value="fruits">Kids</option>
                    <option value="meat">Womens</option>
                    <option value="fish">Mens</option>
                </select>
                <textarea name="details" class="box" required placeholder="update product details" cols="30" rows="10"><?php echo $fetch_products['details']; ?></textarea>
                <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                <div class="flex-btn">
                    <input type="submit" class="btn" value="update product" name="update_product">
                    <a href="admin_products.php" class="option-btn">go back</a>
                </div>
            </form>
        <?php
        }
        $select_products->close();
        ?>

    </section>

    <script src="js/script.js"></script>

</body>

</html>
