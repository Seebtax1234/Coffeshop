<?php
require 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    $stmt = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $stmt->bind_param('si', $update_payment, $order_id);
    
    if ($stmt->execute()) {
        $message[] = 'Payment status has been updated!';
    } else {
        $message[] = 'Failed to update payment status!';
    }

    $stmt->close();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    $stmt = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $stmt->bind_param('i', $delete_id);
    
    if ($stmt->execute()) {
        header('Location: admin_orders.php');
        exit();
    } else {
        $message[] = 'Failed to delete order!';
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">
    <h1 class="title">Receipt</h1>
    <div class="box-container">

        <?php
        $result = $conn->query("SELECT * FROM `orders`");

        if ($result && $result->num_rows > 0) {
            while ($order = $result->fetch_assoc()) {
                ?>
                <div class="box">
                    <p> User ID: <span><?php echo htmlspecialchars($order['user_id']); ?></span> </p>
                    <p> Placed On: <span><?php echo htmlspecialchars($order['placed_on']); ?></span> </p>
                    <p> Name: <span><?php echo htmlspecialchars($order['name']); ?></span> </p>
                    <p> Number: <span><?php echo htmlspecialchars($order['number']); ?></span> </p>
                    <p> Email: <span><?php echo htmlspecialchars($order['email']); ?></span> </p>
                    <p> Address: <span><?php echo htmlspecialchars($order['address']); ?></span> </p>
                    <p> Total Products: <span><?php echo htmlspecialchars($order['total_products']); ?></span> </p>
                    <p> Total Price: <span>₱<?php echo htmlspecialchars($order['total_price']); ?></span> </p>
                    <p> Payment Method: <span><?php echo htmlspecialchars($order['method']); ?></span> </p>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                        <select name="update_payment" >
                            <option disabled selected><?php echo htmlspecialchars($order['payment_status']); ?></option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                        <input type="submit" name="update_order" value="Update" class="option-btn">
                        <a href="admin_orders.php?delete=<?php echo htmlspecialchars($order['id']); ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
                        <a href="#" style="background:green" class="option-btn" onclick="window.print()">Print</a>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
        ?>
    </div>
</section>

<script src="js/script.js"></script>

</body>

</html>
