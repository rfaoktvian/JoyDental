<?php
include '../AppointDoc/config/koneksi.php';

$id = $_POST['id'];
$nik = $_POST['nik'];
$birth_date = $_POST['birth_date'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$query = "UPDATE users SET nik='$nik', birth_date='$birth_date', name='$name', email='$email', phone='$phone' WHERE id=$id";
mysqli_query($conn, $query);

header("Location: profile.php");
?>
