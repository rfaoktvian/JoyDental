<?php
$host = "localhost";
$user = "root"; // Sesuaikan dengan username database
$pass = ""; // Sesuaikan dengan password database
$dbname = "appointdoc"; // Nama database

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
