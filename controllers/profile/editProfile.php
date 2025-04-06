<?php
session_start();
require_once '../../config/koneksi.php';
require_once 'profile_functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle different actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update' && isset($_POST['profile_id'])) {
        // Update profile
        $profile_id = $_POST['profile_id'];
        
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
                // Check if NIK already exists (except for this profile)
                $stmt = $conn->prepare("SELECT id FROM profiles WHERE nik = ? AND id != ? AND user_id != ?");
                $stmt->execute([$_POST['nik'], $profile_id, $user_id]);
                
                if ($stmt->rowCount() > 0) {
                    $_SESSION['message'] = "NIK already registered by another user. Please use a different NIK.";
                    $_SESSION['message_type'] = "danger";
                } else {
                    // Update profile
                    $profile_data = [
                        'nik' => $_POST['nik'],
                        'full_name' => $_POST['full_name'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'] ?? '',
                        'tanggal_lahir' => $_POST['tanggal_lahir']
                    ];
                    
                    if (updateProfile($conn, $profile_data, $profile_id, $user_id)) {
                        $_SESSION['message'] = "Profile updated successfully!";
                        $_SESSION['message_type'] = "success";
                    } else {
                        $_SESSION['message'] = "No changes were made.";
                        $_SESSION['message_type'] = "info";
                    }
                }
            } catch (PDOException $e) {
                handleDatabaseError($e, '../../profile.php');
            }
        }
    } elseif ($action === 'upload_photo' && isset($_POST['profile_id'])) {
        // Upload profile photo
        $profile_id = $_POST['profile_id'];
        
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            try {
                $result = uploadProfileImage($conn, $_FILES['profile_image'], $profile_id, $user_id);
                
                if ($result) {
                    $_SESSION['message'] = "Profile photo uploaded successfully!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Failed to upload profile photo. Please check the file type and size.";
                    $_SESSION['message_type'] = "danger";
                }
            } catch (PDOException $e) {
                handleDatabaseError($e, '../../profile.php');
            }
        } else {
            $_SESSION['message'] = "No file was uploaded.";
            $_SESSION['message_type'] = "warning";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    
    if ($action === 'set_primary' && isset($_GET['profile_id'])) {
        // Set profile as primary
        $profile_id = $_GET['profile_id'];
        
        try {
            if (setPrimaryProfile($conn, $profile_id, $user_id)) {
                $_SESSION['message'] = "Primary profile updated successfully!";
                $_SESSION['message_type'] = "success";
                $_SESSION['current_profile_id'] = $profile_id;
            } else {
                $_SESSION['message'] = "Failed to update primary profile.";
                $_SESSION['message_type'] = "danger";
            }
        } catch (PDOException $e) {
            handleDatabaseError($e, '../../profile.php');
        }
    }
}

// Redirect back to profile page
header("Location: ../../profile.php");
exit();