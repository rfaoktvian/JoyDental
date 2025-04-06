<?php
session_start();
include '../AppointDoc/config/koneksi.php';

// Ambil semua profil pengguna
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Cek apakah pengguna mengganti akun
if (isset($_POST['switch_account'])) {
    $_SESSION['active_user'] = $_POST['selected_user'];
    header("Location: profile.php"); // Refresh halaman
    exit;
}

// Ambil data user aktif
$activeUserId = $_SESSION['active_user'] ?? null;
$activeUser = null;
if ($activeUserId) {
    $queryUser = "SELECT * FROM users WHERE id = $activeUserId";
    $resultUser = mysqli_query($conn, $queryUser);
    $activeUser = mysqli_fetch_assoc($resultUser);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppointDoc - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles.css">
</head>
<body class="profile">
    <nav class="prof navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-heartbeat text-danger"></i> AppointDoc
            </a>
            <div class="ling navbar-nav ms-auto">
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="../../img/photo_profile.jpg" class="rounded-circle mb-3 w-100 h-100" alt="Profile Picture">
                        <h4><?php echo $activeUser['name'] ?? 'Profile Name'; ?></h4>
                        <p><?php echo $activeUser['email'] ?? 'appointdoc@example.com'; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        <form action="update_profile.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $activeUserId; ?>">

                            <div class="mb-3">
                                <label for="NIK" class="form-label">NIK</label>
                                <input type="text" class="form-control" name="NIK" value="<?php echo $activeUser['NIK'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="date_of_birth" value="<?php echo $activeUser['tanggal_lahir'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $activeUser['name'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $activeUser['email'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo $activeUser['phone'] ?? ''; ?>">
                            </div>

                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </form>

                        <!-- Tombol Delete -->
                        <form action="delete_profile.php" method="POST" class="mt-2">
                            <input type="hidden" name="user_id" value="<?php echo $activeUserId; ?>">
                            <button type="submit" class="btn btn-danger">Delete Profile</button>
                        </form>

                        <!-- Switch Account -->
                        <form action="profile.php" method="POST" class="mt-2">
                            <label for="switchAccount" class="form-label">Switch Account:</label>
                            <select name="selected_user" class="form-select">
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $activeUserId) echo 'selected'; ?>>
                                        <?php echo $row['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <button type="submit" name="switch_account" class="btn btn-warning mt-2">Switch Account</button>
                        </form>

                        <!-- Tombol Tambah Profile -->
                        <a href="add_profile.php" class="btn btn-primary mt-2">Add Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
