<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chocolate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h1>Admin Portal Chocolate List</h1>
        <a href="details.php"><button>show all chocolate details</button></a>
    </header>
    <form class="form" action="insert.php" method="post">
        <h2>Add New Chocolate</h2>
        <div class="input-container">
            <input type="text" name="chocolate_name" placeholder="Chocolate Name" required>
        </div>
        <div class="input-container">
            <textarea name="chocolate_description" placeholder="Chocolate Description" required></textarea>
        </div>
        <div class="input-container">
            <input type="text" name="brand" placeholder="Brand" required>
        </div>
        <div class="input-container">
            <input type="number" name="quantity_available" placeholder="Quantity Available" required>
        </div>
        <div class="input-container">
            <input type="number" step="0.01" name="price" placeholder="Price" required>
        </div>
        
        <button type="submit">Add Chocolate</button>
        
    </form>
    
    <?php
    require('dbinit.php');
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Input validation
        $errors = [];
        if (empty($_POST['chocolate_name'])) {
            $errors[] = "Chocolate Name is required.";
        }
        if (empty($_POST['chocolate_description'])) {
            $errors[] = "Chocolate Description is required.";
        }
        if (empty($_POST['brand'])) {
            $errors[] = "Chocolate brand is required.";
        }
        if (empty($_POST['quantity_available'])) {
            $errors[] = "Quantity Available is required.";
        }
        if (empty($_POST['price'])) {
            $errors[] = "Price is required.";
        }

        if (count($errors) == 0) {
            // Prepare data
            $chocolate_name = mysqli_real_escape_string($dbc, trim($_POST['chocolate_name']));
            $chocolate_description = mysqli_real_escape_string($dbc, trim($_POST['chocolate_description']));
            $brand = mysqli_real_escape_string($dbc, trim($_POST['brand']));
            $quantity_available = (int) $_POST['quantity_available'];
            $price = (float) $_POST['price'];

            // Insert query
            $query = "INSERT INTO chocolates (ChocolateName, ChocolateDescription, QuantityAvailable, Price, Brand) 
                VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($dbc, $query);
            mysqli_stmt_bind_param($stmt, 'ssids', $chocolate_name, $chocolate_description, $quantity_available, $price, $brand);
           

            if (mysqli_stmt_execute($stmt)) {
                header("Location: details.php");
            } else {
                echo "Error adding chocolate: " . mysqli_error($dbc);
            }
        } else {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    }
    ?>
    
    <footer>
    <p>Ramandeep kaur - Student Number: 8961688</p>
</footer>
</body>
</html>
