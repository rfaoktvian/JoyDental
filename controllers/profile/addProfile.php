<?php
session_start();
require_once '../../config/koneksi.php';
require_once 'profile_functions.php';


$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['nik', 'full_name', 'email', 'phone', 'tanggal_lahir'];
    $is_valid = true;
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $is_valid = false;
            $_SESSION['message'] = "All required fields must be filled.";
            $_SESSION['message_type'] = "danger";
            break;
        }
    }
    
    // Validate NIK format
    if ($is_valid && (!is_numeric($_POST['nik']) || strlen($_POST['nik']) != 16)) {
        $is_valid = false;
        $_SESSION['message'] = "NIK must be 16 digits.";
        $_SESSION['message_type'] = "danger";
    }
    
    if ($is_valid) {
        try {
            // Check if NIK already exists
            $stmt = $conn->prepare("SELECT id FROM profiles WHERE nik = ? AND user_id != ?");
            $stmt->execute([$_POST['nik'], $user_id]);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = "NIK already registered. Please use a different NIK.";
                $_SESSION['message_type'] = "danger";
            } else {
                // Create new profile
                $profile_data = [
                    'nik' => $_POST['nik'],
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'] ?? '',
                    'tanggal_lahir' => $_POST['tanggal_lahir']
                ];
                
                $new_profile_id = createProfile($conn, $profile_data, $user_id);
                
                if ($new_profile_id) {
                    $_SESSION['message'] = "Profile created successfully!";
                    $_SESSION['message_type'] = "success";
                    $_SESSION['current_profile_id'] = $new_profile_id;
                } else {
                    $_SESSION['message'] = "Failed to create profile.";
                    $_SESSION['message_type'] = "danger";
                }
            }
        } catch (PDOException $e) {
            handleDatabaseError($e, '../../profile.php');
        }
    }
}

// Redirect back to profile page
header("Location: ../../profile.php");
exit();