<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "log_reg";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Failed to connect to data bank: " . mysqli_connect_error());
}
?>