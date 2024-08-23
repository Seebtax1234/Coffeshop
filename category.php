<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_wishlist'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->bind_param("si", $p_name, $user_id);
    $check_wishlist_numbers->execute();
    $check_wishlist_numbers->store_result();

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->bind_param("si", $p_name, $user_id);
    $check_cart_numbers->execute();
    $check_cart_numbers->store_result();

    if ($check_wishlist_numbers->num_rows > 0) {
        $message[] = 'already added to wishlist!';
    } elseif ($check_cart_numbers->num_rows > 0) {
        $message[] = 'already added to cart!';
    } else {
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->bind_param("issss", $user_id, $pid, $p_name, $p_price, $p_image);
        $insert_wishlist->execute();
        $message[] = 'added to wishlist!';
    }
}

if (isset($_POST['add_to_cart'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->bind_param("si", $p_name, $user_id);
    $check_cart_numbers->execute();
    $check_cart_numbers->store_result();

    if ($check_cart_numbers->num_rows > 0) {
        $message[] = 'already added to cart!';
    } else {

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_wishlist_numbers->bind_param("si", $p_name, $user_id);
        $check_wishlist_numbers->execute();
        $check_wishlist_numbers->store_result();

        if ($check_wishlist_numbers->num_rows > 0) {
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->bind_param("si", $p_name, $user_id);
            $delete_wishlist->execute();
        }

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->bind_param("isssis", $user_id, $pid, $p_name, $p_price, $p_qty, $p_image);
        $insert_cart->execute();
        $message[] = 'added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>category</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <section class="products">

        <h1 class="title">products categories</h1>

        <div class="box-container">

            <?php
            $category_name = $_GET['category'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
            $select_products->bind_param("s", $category_name);
            $select_products->execute();
            $select_products->store_result();
            $select_products->bind_result($id, $name, $price, $description, $category, $image);

            if ($select_products->num_rows > 0) {
                while ($select_products->fetch()) {
            ?>
                    <form action="" class="box" method="POST">
                        <div class="price">$<span><?= $price; ?></span>/-</div>
                        <a href="view_page.php?pid=<?= $id; ?>" class="fas fa-eye"></a>
                        <img src="uploaded_img/<?= $image; ?>" alt="">
                        <div class="name"><?= $name; ?></div>
                        <input type="hidden" name="pid" value="<?= $id; ?>">
                        <input type="hidden" name="p_name" value="<?= $name; ?>">
                        <input type="hidden" name="p_price" value="<?= $price; ?>">
                        <input type="hidden" name="p_image" value="<?= $image; ?>">
                        <input type="number" min="1" value="1" name="p_qty" class="qty">
                        <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
                        <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">no products available!</p>';
            }
            ?>

        </div>

    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</
