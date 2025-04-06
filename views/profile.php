<?php
session_start();
require_once 'config/koneksi.php';
require_once 'pages/profile/profile_functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile switching
if (isset($_GET['switch_to']) && !empty($_GET['switch_to'])) {
    $switch_profile_id = $_GET['switch_to'];
    try {
        // Check if profile belongs to user
        $stmt = $conn->prepare("SELECT id FROM profiles WHERE id = ? AND user_id = ?");
        $stmt->execute([$switch_profile_id, $user_id]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['current_profile_id'] = $switch_profile_id;
        } else {
            $_SESSION['message'] = "Invalid profile selection.";
            $_SESSION['message_type'] = "danger";
        }
    } catch (PDOException $e) {
        handleDatabaseError($e);
    }
}

// Get current profile ID or set to primary profile if not set
$current_profile_id = null;
if (isset($_SESSION['current_profile_id'])) {
    $current_profile_id = $_SESSION['current_profile_id'];
} else {
    // Try to get primary profile
    try {
        $stmt = $conn->prepare("SELECT id FROM profiles WHERE user_id = ? AND is_primary = 1 LIMIT 1");
        $stmt->execute([$user_id]);
        $primary_profile = $stmt->fetch();
        
        if ($primary_profile) {
            $current_profile_id = $primary_profile['id'];
            $_SESSION['current_profile_id'] = $current_profile_id;
        }
    } catch (PDOException $e) {
        handleDatabaseError($e);
    }
}

// Initialize empty variables
$profile = null;
$nik = $full_name = $email = $phone = $address = $tanggal_lahir = $profile_image = '';

// Get profile data if a profile is selected
if ($current_profile_id) {
    try {
        $profile = getProfileById($conn, $current_profile_id, $user_id);
        
        if ($profile) {
            $nik = $profile['nik'];
            $full_name = $profile['full_name'];
            $email = $profile['email'];
            $phone = $profile['phone'];
            $address = $profile['address'];
            $tanggal_lahir = $profile['tanggal_lahir'];
            $profile_image = !empty($profile['profile_image']) ? $profile['profile_image'] : 'assets/default-profile.jpg';
        } else {
            // If profile not found, clear the session variable
            unset($_SESSION['current_profile_id']);
            $current_profile_id = null;
        }
    } catch (PDOException $e) {
        handleDatabaseError($e);
    }
}

// Get all profiles for this user
$profiles = [];
try {
    $profiles = getAllProfiles($conn, $user_id);
} catch (PDOException $e) {
    handleDatabaseError($e);
}

// Include the view file
include 'views/profile_view.php';
?>