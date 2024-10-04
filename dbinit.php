<?php
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');

$query = "CREATE DATABASE IF NOT EXISTS chocolates";
mysqli_query($dbc, $query) OR die('Error creating database: ' . mysqli_error($dbc));

mysqli_select_db($dbc, 'chocolates') OR die('Could not select the database: ' . mysqli_error($dbc));

$query = "CREATE TABLE IF NOT EXISTS chocolates (
    ChocolateID INT AUTO_INCREMENT PRIMARY KEY,
    ChocolateName VARCHAR(100) NOT NULL,
    ChocolateDescription TEXT NOT NULL,
    Brand VARCHAR(100) NOT NULL,
    QuantityAvailable INT NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    ProductAddedBy VARCHAR(50) DEFAULT 'Ramandeep kaur'
)";
$result = mysqli_query($dbc, $query);
?>
