<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management - AppointDoc</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="profile_view">
    <!-- Header -->
    <header class="profile-header ">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php" class="text-decoration-none">
                <i class="fas fa-heartbeat text-danger ">AppointDoc</i>
                <br>
                <span class="ms-5 text-black-50 fs-6 fst-italic subtitle">by RS Siaga Sedia</span>
                </a>
                <div>
                    <a href="dashboard.php" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="logout.php" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Status Messages -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        
        <div class="row">
            <!-- Profile Image and Basic Info -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="profile-image-container">
                        <img src="<?php echo !empty($profile_image) ? $profile_image : 'assets/default-profile.jpg'; ?>" 
                             alt="Profile Image" class="profile-image" id="profileImageDisplay">
                        <h3 class="mt-3" id="displayName">
                            <?php echo !empty($full_name) ? $full_name : 'Profile Name'; ?>
                        </h3>
                        <p class="text-muted" id="displayEmail">
                            <?php echo !empty($email) ? $email : 'appointdoc@example.com'; ?>
                        </p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" 
                                    data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                                <i class="fas fa-camera"></i> Change Photo
                            </button>
                            <?php if(isset($profile) && $profile && $profile['is_primary'] != 1): ?>
                                <button type="button" class="btn btn-sm btn-outline-success mt-2 ms-2" 
                                         onclick="setAsPrimary(<?php echo $current_profile_id; ?>)">
                                    <i class="fas fa-star"></i> Set as Primary
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Profile List for Switching -->
                <div class="profile-list">
                    <h5><i class="fas fa-users"></i> Available Profiles</h5>
                    <div id="profilesList">
                        <!-- Profile cards will be populated here -->
                        <?php if(!empty($profiles)): ?>
                            <?php foreach($profiles as $prof): ?>
                                <div class="profile-card <?php echo ($prof['id'] == $current_profile_id) ? 'active-profile' : ''; ?>" 
                                     data-profile-id="<?php echo $prof['id']; ?>">
                                    <h6><?php echo $prof['full_name']; ?></h6>
                                    <small class="text-muted">NIK: <?php echo $prof['nik']; ?></small>
                                    <?php if($prof['is_primary'] == 1): ?>
                                        <span class="primary-badge">Primary</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No profiles available. Create your first profile.
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-add w-100 mt-3" id="createNewProfileBtn">
                        <i class="fas fa-plus"></i> Create New Profile
                    </button>
                </div>
            </div>
            
            <!-- Profile Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="form-header">
                        <h3><i class="fas fa-user-edit"></i> <span id="formTitle">Edit Profile</span></h3>
                    </div>
                    <div class="card-body">
                        <div id="statusMessage"></div>
                        
                        <form id="profileForm" method="post" action="pages/profile/editProfile.php">
                            <input type="hidden" name="action" id="formAction" value="update">
                            <input type="hidden" name="profile_id" id="profileId" value="<?php echo $current_profile_id; ?>">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan)*</label>
                                    <input type="text" class="form-control" id="nik" name="nik" 
                                           value="<?php echo !empty($nik) ? $nik : ''; ?>" required
                                           pattern="[0-9]{16}" maxlength="16">
                                    <small class="text-muted">16 digit nomor KTP</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir*</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                                           value="<?php echo !empty($tanggal_lahir) ? $tanggal_lahir : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap*</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?php echo !empty($full_name) ? $full_name : ''; ?>" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo !empty($email) ? $email : ''; ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon*</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo !empty($phone) ? $phone : ''; ?>" required
                                           pattern="[0-9]{10,13}">
                                    <small class="text-muted">Format: 08xxxxxxxxxx</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3"><?php echo !empty($address) ? $address : ''; ?></textarea>
                            </div>
                            
                            <div class="profile-footer">
                                <div class="action-buttons">
                                    <button type="submit" id="btnSave" class="btn btn-save me-2">
                                        <i class="fas fa-save"></i> <span id="saveButtonText">Simpan Perubahan</span>
                                    </button>
                                    <button type="button" id="btnDelete" class="btn btn-delete me-2" onclick="confirmDelete()">
                                        <i class="fas fa-trash"></i> Hapus Profil
                                    </button>
                                    <button type="button" id="btnCancel" class="btn btn-cancel" style="display: none;" onclick="cancelForm()">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                </div>
                                <div class="switch-container">
                                    <select class="form-select me-2" id="profileSwitch">
                                        <option value="">Pilih Profil</option>
                                        <?php if(!empty($profiles)): ?>
                                            <?php foreach($profiles as $prof): ?>
                                                <?php if($prof['id'] != $current_profile_id): ?>
                                                    <option value="<?php echo $prof['id']; ?>"><?php echo $prof['full_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <button type="button" class="btn btn-switch" onclick="switchProfile()">
                                        <i class="fas fa-exchange-alt"></i> Switch
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Upload Modal -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPhotoModalLabel">Change Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="photoUploadForm" method="post" action="pages/profile/editProfile.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="upload_photo">
                        <input type="hidden" name="profile_id" value="<?php echo $current_profile_id; ?>">
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Select Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profile_image" accept="image/*" required>
                            <small class="text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                        </div>
                        <div class="text-center mt-2">
                            <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><i class="fas fa-exclamation-triangle text-danger"></i> Are you sure you want to delete this profile? This action cannot be undone.</p>
                    <p>All appointments and medical records associated with this profile will also be deleted.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteProfile()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle form mode (create/edit)
        function setFormMode(mode) {
            if (mode === 'create') {
                document.getElementById('formTitle').textContent = 'Create New Profile';
                document.getElementById('formAction').value = 'create';
                document.getElementById('profileId').value = '';
                document.getElementById('profileForm').reset();
                document.getElementById('saveButtonText').textContent = 'Create Profile';
                document.getElementById('btnDelete').style.display = 'none';
                document.getElementById('btnCancel').style.display = 'inline-block';
                // Change form action to add profile
                document.getElementById('profileForm').action = 'pages/profile/addProfile.php';
            } else {
                document.getElementById('formTitle').textContent = 'Edit Profile';
                document.getElementById('formAction').value = 'update';
                document.getElementById('saveButtonText').textContent = 'Simpan Perubahan';
                document.getElementById('btnDelete').style.display = 'inline-block';
                document.getElementById('btnCancel').style.display = 'none';
                // Change form action to edit profile
                document.getElementById('profileForm').action = 'pages/profile/editProfile.php';
            }
        }
        
        // Handle create new profile button
        document.getElementById('createNewProfileBtn').addEventListener('click', function() {
            setFormMode('create');
        });
        
        // Handle cancel button
        function cancelForm() {
            // Reload current profile data
            window.location.reload();
        }
        
        // Handle delete confirmation
        function confirmDelete() {
            var modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }
        
        // Handle delete profile
        function deleteProfile() {
            // Redirect to delete profile page with profile ID
            window.location.href = 'pages/profile/deleteProfile.php?profile_id=' + document.getElementById('profileId').value;
        }
        
        // Handle switch profile
        function switchProfile() {
            var profileId = document.getElementById('profileSwitch').value;
            if (profileId) {
                window.location.href = 'profile.php?switch_to=' + profileId;
            }
        }

        // Handle set as primary profile
        function setAsPrimary(profileId) {
            window.location.href = 'pages/profile/editProfile.php?action=set_primary&profile_id=' + profileId;
        }

        // Profile cards click event for switching
        document.querySelectorAll('.profile-card').forEach(card => {
            card.addEventListener('click', function() {
                var profileId = this.getAttribute('data-profile-id');
                window.location.href = 'profile.php?switch_to=' + profileId;
            });
        });

        // Image preview for upload
        document.getElementById('profileImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>