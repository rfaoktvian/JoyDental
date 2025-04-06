<?php
/**
 * Get a profile by ID
 * 
 * @param PDO $conn Database connection
 * @param int $profile_id Profile ID
 * @param int $user_id User ID for security check
 * @return array|null Profile data or null if not found
 */
function getProfileById($conn, $profile_id, $user_id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM profiles WHERE id = ? AND user_id = ?");
        $stmt->execute([$profile_id, $user_id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Get all profiles for a user
 * 
 * @param PDO $conn Database connection
 * @param int $user_id User ID
 * @return array Array of profiles
 */
function getAllProfiles($conn, $user_id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM profiles WHERE user_id = ? ORDER BY is_primary DESC, full_name ASC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Create a new profile
 * 
 * @param PDO $conn Database connection
 * @param array $data Profile data
 * @param int $user_id User ID
 * @return int New profile ID
 */
function createProfile($conn, $data, $user_id) {
    try {
        // Check if this is the first profile - if yes, make it primary
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM profiles WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        $is_primary = ($result['count'] == 0) ? 1 : 0;
        
        $stmt = $conn->prepare("
            INSERT INTO profiles 
            (user_id, nik, full_name, email, phone, address, tanggal_lahir, is_primary) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $user_id,
            $data['nik'],
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['tanggal_lahir'],
            $is_primary
        ]);
        
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Update an existing profile
 * 
 * @param PDO $conn Database connection
 * @param array $data Profile data
 * @param int $profile_id Profile ID
 * @param int $user_id User ID for security check
 * @return bool True on success
 */
function updateProfile($conn, $data, $profile_id, $user_id) {
    try {
        $stmt = $conn->prepare("
            UPDATE profiles 
            SET nik = ?, full_name = ?, email = ?, phone = ?, address = ?, tanggal_lahir = ?
            WHERE id = ? AND user_id = ?
        ");
        
        return $stmt->execute([
            $data['nik'],
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['tanggal_lahir'],
            $profile_id,
            $user_id
        ]);
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Delete a profile
 * 
 * @param PDO $conn Database connection
 * @param int $profile_id Profile ID
 * @param int $user_id User ID for security check
 * @return bool True on success
 */
function deleteProfile($conn, $profile_id, $user_id) {
    try {
        // Check if this is the primary profile
        $stmt = $conn->prepare("SELECT is_primary FROM profiles WHERE id = ? AND user_id = ?");
        $stmt->execute([$profile_id, $user_id]);
        $profile = $stmt->fetch();
        
        if ($profile && $profile['is_primary'] == 1) {
            // If deleting primary profile, find another profile to make primary
            $stmt = $conn->prepare("SELECT id FROM profiles WHERE user_id = ? AND id != ? LIMIT 1");
            $stmt->execute([$user_id, $profile_id]);
            $next_profile = $stmt->fetch();
            
            if ($next_profile) {
                $stmt = $conn->prepare("UPDATE profiles SET is_primary = 1 WHERE id = ?");
                $stmt->execute([$next_profile['id']]);
            }
        }
        
        // Delete the profile
        $stmt = $conn->prepare("DELETE FROM profiles WHERE id = ? AND user_id = ?");
        return $stmt->execute([$profile_id, $user_id]);
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Set a profile as primary
 * 
 * @param PDO $conn Database connection
 * @param int $profile_id Profile ID
 * @param int $user_id User ID for security check
 * @return bool True on success
 */
function setPrimaryProfile($conn, $profile_id, $user_id) {
    try {
        // Begin transaction
        $conn->beginTransaction();
        
        // Reset all profiles to non-primary
        $stmt = $conn->prepare("UPDATE profiles SET is_primary = 0 WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        // Set the selected profile as primary
        $stmt = $conn->prepare("UPDATE profiles SET is_primary = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$profile_id, $user_id]);
        
        // Commit the transaction
        $conn->commit();
        return true;
    } catch (PDOException $e) {
        // Rollback the transaction if something failed
        $conn->rollBack();
        throw $e;
    }
}

/**
 * Upload profile image
 * 
 * @param PDO $conn Database connection
 * @param array $file File information from $_FILES
 * @param int $profile_id Profile ID
 * @param int $user_id User ID for security check
 * @return string|false Path to the uploaded image or false on failure
 */
function uploadProfileImage($conn, $file, $profile_id, $user_id) {
    try {
        // Check if profile belongs to user
        $stmt = $conn->prepare("SELECT id FROM profiles WHERE id = ? AND user_id = ?");
        $stmt->execute([$profile_id, $user_id]);
        
        if ($stmt->rowCount() == 0) {
            return false;
        }
        
        // Check for errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_info = getimagesize($file['tmp_name']);
        
        if (!$file_info || !in_array($file_info['mime'], $allowed_types)) {
            return false;
        }
        
        // Generate a unique filename
        $upload_dir = 'uploads/profiles/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $filename = uniqid('profile_') . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $target_file = $upload_dir . $filename;
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Update the profile with the new image path
            $stmt = $conn->prepare("UPDATE profiles SET profile_image = ? WHERE id = ?");
            $stmt->execute([$target_file, $profile_id]);
            
            return $target_file;
        }
        
        return false;
    } catch (PDOException $e) {
        throw $e;
    }
}