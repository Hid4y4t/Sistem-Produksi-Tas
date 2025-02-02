<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ud_hartono_collection';
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}
?>
