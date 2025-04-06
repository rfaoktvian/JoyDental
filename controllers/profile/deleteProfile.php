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

if (isset($_GET['profile_id'])) {
    $profile_id = $_GET['profile_id'];
    
    try {
        // Check if it's the current profile
        $is_current = ($_SESSION['current_profile_id'] == $profile_id);
        
        if (deleteProfile($conn, $profile_id, $user_id)) {
            $_SESSION['message'] = "Profile deleted successfully!";
            $_SESSION['message_type'] = "success";
            
            // If we deleted the current profile, unset the session variable
            if ($is_current) {
                unset($_SESSION['current_profile_id']);
                
                // Set a new current profile
                $stmt = $conn->prepare("SELECT id FROM profiles WHERE user_id = ? AND is_primary = 1 LIMIT 1");
                $stmt->execute([$user_id]);
                $primary_profile = $stmt->fetch();
                
                if ($primary_profile) {
                    $_SESSION['current_profile_id'] = $primary_profile['id'];
                } else {
                    // If no primary profile, get the first available profile
                    $stmt = $conn->prepare("SELECT id FROM profiles WHERE user_id = ? LIMIT 1");
                    $stmt->execute([$user_id]);
                    $any_profile = $stmt->fetch();
                    
                    if ($any_profile) {
                        $_SESSION['current_profile_id'] = $any_profile['id'];
                    }
                }
            }
        } else {
            $_SESSION['message'] = "Failed to delete profile.";
            $_SESSION['message_type'] = "danger";
        }
    } catch (PDOException $e) {
        handleDatabaseError($e, '../../profile.php');
    }
}

// Redirect back to profile page
header("Location: ../../profile.php");
exit();