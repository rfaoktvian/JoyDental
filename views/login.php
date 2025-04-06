<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppointDoc - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets//css//styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="card login-card w-100 h-100">
            <div class="row g-0 h-100">
                <!-- Left Panel -->
                <div class="col-md-5 left-panel d-flex flex-column justify-content-between">
                    <div class="banner-image h-100 d-flex flex-column justify-content-between">
                        <div class="logo">
                            <h2 class="text-danger"><i class="fas fa-heartbeat text-danger"></i>AppointDoc</h2>
                            <img src="../assets//img//login_photo.png" alt="">
                        </div>
                    </div>
                </div>
                
                <!-- Right Panel -->
               
                <div class="col-md-7 right-panel d-flex align-items-center  justify-content-center position-relative">
                    <div class="back-btn">
                        <a href="../public/index.php">
                            <i class="bi bi-arrow-left-circle"></i>
                        </a>
                    </div> 
                    <div class="w-75">
                        <h2 class="fw-bold text-center mb-2">Selamat Datang Kembali</h2>
                        <p class="text-center mb-4">Belum punya akun? 
                        <a href="../public/register.php" class="text-primary">Sign up</a></p>
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Email address" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Your password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" placeholder="Password" required>
                                    <span class="input-group-text toggle-password"><i class="far"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="login-btn my-3">Log in</button>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-primary">Forgot password?</a>
                            </div>
                        </form>
                        <div class="mt-4">
                            <p class="text-center text-muted">Or log in with:</p>
                            <div class="social-login">
                                <a href="#" class="social-icon google"><i class="fab fa-google"></i></a>
                                <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon apple"><i class="fab fa-apple"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/auth.js"></script>
</body>
</html>