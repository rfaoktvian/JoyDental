<?php
include '../AppointDoc/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik'];
    $birth_date = $_POST['birth_date'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO users (nik, birth_date, name, email, phone) 
              VALUES ('$nik', '$birth_date', '$name', '$email', '$phone')";

    mysqli_query($conn, $query);
    header("Location: profile.php");
}
?>

<form method="POST">
    <input type="text" name="nik" placeholder="NIK" pattern="\d{15}" required>
    <input type="date" name="birth_date" required>
    <input type="text" name="name" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="tel" name="phone" placeholder="Nomor HP" required>
    <button type="submit" class="btn btn-success">Tambah Profil</button>
</form>
