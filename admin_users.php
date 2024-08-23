<?php
include 'config.php';
session_start();

// Check if admin is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit; // Stop further execution
}

// Delete user if delete parameter is set
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM `users` WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header('location: admin_users.php');
        exit; // Stop further execution
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="user-accounts">
        <h1 class="title">Admin Users</h1>

        <div class="box-container">
            <?php
            // Retrieve all users
            $select_users_query = "SELECT id, name, email, user_type FROM `users`";
            $result = $conn->query($select_users_query);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="box">
                        <p>User ID: <span><?php echo $row['id']; ?></span></p>
                        <p>Username: <span><?php echo $row['name']; ?></span></p>
                        <p>Email: <span><?php echo $row['email']; ?></span></p>
                        <p>User Type: <span style="color:<?php echo ($row['user_type'] == 'admin') ? 'var(--orange)' : ''; ?>"><?php echo $row['user_type']; ?></span></p>
                        <?php if ($_SESSION['admin_id'] && $row['user_type'] != 'admin') { ?>
                            <a href="admin_users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete</a>
                        <?php } ?>
                    </div>
            <?php
                }
            } else {
                echo "<p>No users found.</p>";
            }
            ?>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>

</html>
