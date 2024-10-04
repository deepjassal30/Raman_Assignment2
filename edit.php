<?php
require('dbinit.php');

if (isset($_GET['chocolate_id'])) {
    $chocolate_id = $_GET['chocolate_id'];
    $query = "SELECT * FROM chocolates WHERE ChocolateID = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $chocolate_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Chocolate not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Input validation
    $errors = [];
    if (empty($_POST['chocolate_name'])) {
        $errors[] = "Chocolate Name is required.";
    }
    if (empty($_POST['chocolate_description'])) {
        $errors[] = "Chocolate Description is required.";
    }
    if (empty($_POST['quantity_available'])) {
        $errors[] = "Quantity Available is required.";
    }
    if (empty($_POST['price'])) {
        $errors[] = "Price is required.";
    }

    if (count($errors) == 0) {
        // Update query
        $query = "UPDATE chocolates SET ChocolateName = ?, ChocolateDescription = ?, QuantityAvailable = ?, Price = ?, Brand = ? WHERE ChocolateID = ?";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, 'ssissi', $_POST['chocolate_name'], $_POST['chocolate_description'], $_POST['quantity_available'], $_POST['price'], $_POST['brand'], $_POST['chocolate_id']);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: details.php");
            exit();
        } else {
            echo "Error updating chocolate: " . mysqli_error($dbc);
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Chocolate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="insert.php"><h1>Admin Portal Chocolate List</h1></a>
        <a href="insert.php"><button>Add New Chocolate Details</button></a>
    </header>
    <form class="form" action="edit.php?chocolate_id=<?php echo $row['ChocolateID']; ?>" method="post">
        <h2>Edit Chocolate</h2>
        <div class="input-container">
            <input type="hidden" name="chocolate_id" value="<?php echo $row['ChocolateID']; ?>">
            <input type="text" name="chocolate_name" value="<?php echo $row['ChocolateName']; ?>" placeholder="Chocolate Name" required>
        </div>
        <div class="input-container">
            <textarea name="chocolate_description" placeholder="Chocolate Description" required><?php echo $row['ChocolateDescription']; ?></textarea>
        </div>
        <div class="input-container">
            <input type="text" name="brand" value="<?php echo $row['Brand']; ?>" placeholder="Brand" required>
        </div>
        <div class="input-container">
            <input type="number" name="quantity_available" value="<?php echo $row['QuantityAvailable']; ?>" placeholder="Quantity Available" required>
        </div>
        <div class="input-container">
            <input type="number" step="0.01" name="price" value="<?php echo $row['Price']; ?>" placeholder="Price" required>
        </div>
        
        <button type="submit">Update Chocolate</button>
    </form>
    <footer>
    <p>Ramandeep kaur - Student Number: 8961688</p>
</footer>
</body>
</html>
