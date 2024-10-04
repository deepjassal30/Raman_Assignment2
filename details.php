<?php
require('dbinit.php');

// Check if a delete request has been made
if (isset($_GET['chocolate_id'])) {
    $chocolate_id = $_GET['chocolate_id'];

    // Delete query
    $query = "DELETE FROM chocolates WHERE ChocolateID = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $chocolate_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header("Location: details.php"); // Redirect after successful deletion
        exit();
    } else {
        echo "Error deleting chocolate: " . mysqli_error($dbc);
    }
}

// Fetch all chocolates
$query = "SELECT * FROM chocolates";
$results = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chocolate List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <a href="insert.php"><h1>Admin Portal Chocolate List</h1></a>
        <a href="insert.php"><button>Add New Chocolate Details</button></a>
    </header>

    <table>
        <thead>
            <tr><th colspan="8" scope="colgroup"><h2>Chocolate List</h2></th></tr>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Product Added By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($results)) {
                echo "<tr>";
                echo "<td>{$row['ChocolateID']}</td>";
                echo "<td>{$row['ChocolateName']}</td>";
                echo "<td>{$row['ChocolateDescription']}</td>";
                echo "<td>{$row['Brand']}</td>";
                echo "<td>{$row['QuantityAvailable']}</td>";
                echo "<td>\${$row['Price']}</td>";
                echo "<td>{$row['ProductAddedBy']}</td>";
                
                // Update the delete link to point to the same page
                echo "<td>
                        <a href='edit.php?chocolate_id={$row['ChocolateID']}'>Edit</a> |
                        <a href='?chocolate_id={$row['ChocolateID']}'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
    <footer>
        <p>Ramandeep Kaur - Student Number: 8961688</p>
    </footer>
</body>
</html>
