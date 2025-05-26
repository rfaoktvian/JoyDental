@extends('layouts.app')

@section('content')
  <!-- Main Content -->
  <div class="main-content">
    <div class="container-fluid">
    <div class="row g-4">
      <!-- Profile Card -->
      <div class="col-lg-4">
      <div class="card profile-card">
        <div class="card-body text-center p-4">
        <div class="profile-image-container mb-4">
          <img src="doctors_login.png" alt="Profile Picture" class="profile-image rounded-circle">
          <div class="edit-photo bg-secondary">
          <i class="fas fa-camera"></i>
          </div>
        </div>
        <h4 class="mb-1">Walidddd</h4>
        <p class="text-muted">walid@example.com</p>
        <div class="d-grid gap-2 mt-4">
          <button class="btn btn-outline-primary">
          <i class="fas fa-key me-2"></i>Ubah Kata Sandi
          </button>
          <button class="btn btn-outline-danger">
          <i class="fas fa-sign-out-alt me-2"></i>Keluar
          </button>
        </div>
        </div>
      </div>

      <!-- Info Card -->
      <div class="card mt-4">
        <div class="card-body">
        <h5 class="card-title">Info</h5>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-phone me-2"></i>Telepon</span>
          <span class="info-value">081234567890</span>
        </div>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-envelope me-2"></i>Email</span>
          <span class="info-value">walid@example.com</span>
        </div>
        <div class="info-item">
          <span class="info-label"><i class="fas fa-map-marker-alt me-2"></i>Alamat</span>
          <span class="info-value">Jl. Contoh No. 123, Kota Jakarta</span>
        </div>
        </div>
      </div>
      </div>

      <!-- Identity Management -->
      <div class="col-lg-8">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Identitas Saya</h5>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addIdentityModal">
          <i class="fas fa-plus me-1"></i> Tambah Identitas
        </button>
        </div>
        <div class="card-body">
        <!-- Identity Tabs -->
        <ul class="nav nav-tabs mb-3" id="identityTabs" role="tablist">
          <li class="nav-item" role="presentation">
          <button class="nav-link active" id="identity-1-tab" data-bs-toggle="tab" data-bs-target="#identity-1"
            type="button" role="tab" aria-controls="identity-1" aria-selected="true">
            Walidddd (Utama)
          </button>
          </li>
          <li class="nav-item" role="presentation">
          <button class="nav-link" id="identity-2-tab" data-bs-toggle="tab" data-bs-target="#identity-2"
            type="button" role="tab" aria-controls="identity-2" aria-selected="false">
            Ahmad
          </button>
          </li>
        </ul>

        <!-- Identity Content -->
        <div class="tab-content" id="identityTabsContent">
          <!-- First Identity -->
          <div class="tab-pane fade show active" id="identity-1" role="tabpanel" aria-labelledby="identity-1-tab">
          <form>
            <div class="form-group-wrapper mb-4">
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">NIK</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" value="3201234567890001">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Nama Lengkap</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" value="Walidddd">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
              <div class="col-sm-9">
              <input type="date" class="form-control" value="1995-05-15">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
              <div class="col-sm-9">
              <select class="form-select">
                <option selected>Laki-laki</option>
                <option>Perempuan</option>
              </select>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">No. Handphone</label>
              <div class="col-sm-9">
              <input type="tel" class="form-control" value="081234567890">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-9">
              <textarea class="form-control" rows="3">Jl. Contoh No. 123, Kota Jakarta</textarea>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Status</label>
              <div class="col-sm-9">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" checked disabled>
                <label class="form-check-label">Identitas Utama</label>
              </div>
              </div>
            </div>
            <div class="text-end mt-4">
              <button type="button" class="btn btn-outline-secondary me-2">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
            </div>
          </form>
          </div>

          <!-- Second Identity -->
          <div class="tab-pane fade" id="identity-2" role="tabpanel" aria-labelledby="identity-2-tab">
          <form>
            <div class="form-group-wrapper mb-4">
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">NIK</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" value="3201234567890002">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Nama Lengkap</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" value="Ahmad">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
              <div class="col-sm-9">
              <input type="date" class="form-control" value="2015-10-20">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
              <div class="col-sm-9">
              <select class="form-select">
                <option selected>Laki-laki</option>
                <option>Perempuan</option>
              </select>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">No. Handphone</label>
              <div class="col-sm-9">
              <input type="tel" class="form-control" value="081234567891">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-9">
              <textarea class="form-control" rows="3">Jl. Contoh No. 123, Kota Jakarta</textarea>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Hubungan</label>
              <div class="col-sm-9">
              <select class="form-select">
                <option selected>Anak</option>
                <option>Istri/Suami</option>
                <option>Orang Tua</option>
                <option>Saudara</option>
                <option>Lainnya</option>
              </select>
              </div>
            </div>
            <div class="text-end mt-4">
              <button type="button" class="btn btn-danger me-2">Hapus</button>
              <button type="button" class="btn btn-outline-secondary me-2">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
            </div>
          </form>
          </div>
        </div>
        </div>
      </div>

      <!-- Family Members -->
      <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Keluarga Saya</h5>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addFamilyModal">
          <i class="fas fa-plus me-1"></i> Tambah Anggota Keluarga
        </button>
        </div>
        <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
          <thead>
            <tr>
            <th>Nama</th>
            <th>NIK</th>
            <th>Tanggal Lahir</th>
            <th>Hubungan</th>
            <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td>Ahmad</td>
            <td>3201234567890002</td>
            <td>20 Okt 2015</td>
            <td><span class="badge bg-info">Anak</span></td>
            <td>
              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
              data-bs-target="#editModal">Edit</button>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
              data-bs-target="#deleteModal">Hapus</button>
            </td>
            </tr>
            <tr>
            <td>Siti</td>
            <td>3201234567890003</td>
            <td>15 Mar 1998</td>
            <td><span class="badge bg-info">Istri</span></td>
            <td>
              <button class="btn btn-sm btn-outline-primary">Edit</button>
              <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </td>
            </tr>
          </tbody>
          </table>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal Tambah Identitas -->
  <div class="modal fade" id="addIdentityModal" tabindex="-1" aria-labelledby="addIdentityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="addIdentityModalLabel">Tambah Identitas Baru</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">NIK <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" placeholder="Masukkan NIK" required>
          <div class="form-text">NIK terdiri dari 16 digit angka</div>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="date" class="form-control" required>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-9">
          <select class="form-select">
          <option selected>Laki-laki</option>
          <option>Perempuan</option>
          </select>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">No. Handphone <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="tel" class="form-control" placeholder="Masukkan nomor handphone" required>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Alamat</label>
        <div class="col-sm-9">
          <textarea class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Hubungan</label>
        <div class="col-sm-9">
          <select class="form-select">
          <option selected>Diri Sendiri</option>
          <option>Anak</option>
          <option>Istri/Suami</option>
          <option>Orang Tua</option>
          <option>Saudara</option>
          <option>Lainnya</option>
          </select>
        </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-primary">Simpan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal Tambah Anggota Keluarga -->
  <div class="modal fade" id="addFamilyModal" tabindex="-1" aria-labelledby="addFamilyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="addFamilyModalLabel">Tambah Anggota Keluarga</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">NIK <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" placeholder="Masukkan NIK" required>
          <div class="form-text">NIK terdiri dari 16 digit angka</div>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="date" class="form-control" required>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-9">
          <select class="form-select">
          <option selected>Laki-laki</option>
          <option>Perempuan</option>
          </select>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">No. Handphone <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="tel" class="form-control" placeholder="Masukkan nomor handphone" required>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Alamat</label>
        <div class="col-sm-9">
          <textarea class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
        </div>
        </div>
        <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Hubungan <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <select class="form-select" required>
          <option selected>Pilih Hubungan</option>
          <option>Anak</option>
          <option>Istri/Suami</option>
          <option>Orang Tua</option>
          <option>Saudara</option>
          <option>Lainnya</option>
          </select>
        </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-primary">Simpan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Konfirmasi Keluar -->
  <div class="modal fade modal-confirm" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Keluar</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="icon-box">
        <i class="fas fa-sign-out-alt text-warning"></i>
      </div>
      <h4 class="modal-title mt-3">Keluar dari AppointDoc?</h4>
      <p class="mb-0 mt-3">Apakah Anda yakin ingin keluar dari sistem?</p>
      <p class="text-muted small mt-2">Semua perubahan yang belum disimpan akan hilang.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <a href="index.html" class="btn btn-danger">Ya, Keluar</a>
      </div>
    </div>
    </div>
  </div>
  <!-- Modal Edit Identitas Keluarga -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
      <h5 class="modal-title" id="editModalLabel">Edit Identitas Keluarga</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="editFormIdentitas">
        <input type="hidden" id="editId" name="id">
        <div class="row mb-3">
        <div class="col-md-6">
          <label for="editNIK" class="form-label required-field">NIK</label>
          <input type="text" class="form-control" id="editNIK" name="nik" placeholder="NIK sesuai KTP" required
          maxlength="16" pattern="[0-9]{16}">
          <div class="invalid-feedback">NIK harus 16 digit angka</div>
        </div>
        <div class="col-md-6">
          <label for="editNama" class="form-label required-field">Nama Lengkap</label>
          <input type="text" class="form-control" id="editNama" name="nama" placeholder="Nama lengkap sesuai KTP"
          required>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
          <label for="editTanggalLahir" class="form-label required-field">Tanggal Lahir</label>
          <input type="date" class="form-control" id="editTanggalLahir" name="tanggalLahir" required>
        </div>
        <div class="col-md-6">
          <label for="editJenisKelamin" class="form-label">Jenis Kelamin</label>
          <select class="form-select" id="editJenisKelamin" name="jenisKelamin">
          <option value="">Pilih Jenis Kelamin</option>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
          </select>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
          <label for="editNoHP" class="form-label required-field">No. Handphone</label>
          <input type="tel" class="form-control" id="editNoHP" name="noHP" placeholder="Contoh: 08123456789"
          required pattern="[0-9]{10,13}">
          <div class="invalid-feedback">No HP harus berupa angka (10-13 digit)</div>
        </div>
        <div class="col-md-6">
          <label for="editHubungan" class="form-label required-field">Hubungan</label>
          <select class="form-select" id="editHubungan" name="hubungan" required>
          <option value="">Pilih Hubungan</option>
          <option value="Diri Sendiri">Diri Sendiri</option>
          <option value="Suami">Suami</option>
          <option value="Istri">Istri</option>
          <option value="Anak">Anak</option>
          <option value="Ayah">Ayah</option>
          <option value="Ibu">Ibu</option>
          <option value="Lainnya">Lainnya</option>
          </select>
        </div>
        </div>
        <div class="mb-3">
        <label for="editAlamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="editAlamat" name="alamat" rows="3"
          placeholder="Alamat lengkap"></textarea>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-primary" id="btnSimpanEdit">Simpan Perubahan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal Hapus Identitas Keluarga -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
      <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="deleteId" name="id">
      <p>Apakah Anda yakin ingin menghapus data identitas keluarga <strong id="deleteNama"></strong>?</p>
      <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Perhatian: Tindakan ini tidak dapat
        dibatalkan!</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Bootstrap & Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <!-- JavaScript untuk toggle sidebar -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const body = document.body;

    // Event listener untuk menu keluar
    const logoutLink = document.querySelector('.sidebar .nav-item:last-child .nav-link');
    if (logoutLink) {
      logoutLink.addEventListener('click', function (e) {
      e.preventDefault(); // Mencegah link langsung diikuti
      const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
      logoutModal.show();
      });
    }

    // Fungsi toggle yang diperbarui
    sidebarToggle.addEventListener('click', function () {
      body.classList.toggle('sidebar-collapsed');
    });

    // Fungsi untuk modal Edit
    const editModal = document.getElementById('editModal');
    if (editModal) {
      editModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const id = button.getAttribute('data-id');
      const nik = button.getAttribute('data-nik');
      const nama = button.getAttribute('data-nama');
      const lahir = button.getAttribute('data-lahir');
      const hubungan = button.getAttribute('data-hubungan');

      // Set nilai ke form
      document.getElementById('editId').value = id;
      document.getElementById('editNIK').value = nik;
      document.getElementById('editNama').value = nama;

      // Format tanggal dari "20 Okt 2015" ke format "2015-10-20" untuk input date
      if (lahir) {
        const months = {
        'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04',
        'Mei': '05', 'Jun': '06', 'Jul': '07', 'Agu': '08',
        'Sep': '09', 'Okt': '10', 'Nov': '11', 'Des': '12'
        };

        const dateParts = lahir.split(' ');
        if (dateParts.length === 3) {
        const day = dateParts[0].padStart(2, '0');
        const month = months[dateParts[1]];
        const year = dateParts[2];

        if (day && month && year) {
          document.getElementById('editTanggalLahir').value = `${year}-${month}-${day}`;
        }
        }
      }

      // Set hubungan
      const hubunganSelect = document.getElementById('editHubungan');
      for (let i = 0; i < hubunganSelect.options.length; i++) {
        if (hubunganSelect.options[i].value === hubungan) {
        hubunganSelect.selectedIndex = i;
        break;
        }
      }

      // Ambil data lainnya melalui AJAX (dalam implementasi nyata)
      // Contoh simulasi data tambahan
      document.getElementById('editNoHP').value = '08123456789'; // Data simulasi
      document.getElementById('editJenisKelamin').value = hubungan === 'Istri' ? 'P' : 'L'; // Data simulasi
      document.getElementById('editAlamat').value = 'Jl. Contoh No. 123, Kota'; // Data simulasi
      });
    }

    // Fungsi untuk modal Hapus
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
      deleteModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const id = button.getAttribute('data-id');
      const nama = button.getAttribute('data-nama');

      document.getElementById('deleteId').value = id;
      document.getElementById('deleteNama').textContent = nama;
      });
    }

    });

    function removeUnwantedIframes() {
    // Mencari semua iframe dengan URL yang berisi "remove.video"
    const iframes = document.querySelectorAll('iframe[src*="remove.video"]');

    // Menghapus iframe dan parent div-nya jika ditemukan
    iframes.forEach(iframe => {
      const parentDiv = iframe.parentElement;
      if (parentDiv && parentDiv.tagName === 'DIV') {
      console.log('Menghapus iframe yang tidak diinginkan:', iframe.src);
      parentDiv.remove();
      }
    });
    }

    // Jalankan segera setelah DOM dimuat
    document.addEventListener('DOMContentLoaded', removeUnwantedIframes);

    // Jalankan lagi setelah beberapa detik untuk menangani injeksi yang tertunda
    setTimeout(removeUnwantedIframes, 1000);
    setTimeout(removeUnwantedIframes, 3000);

    // Tambahkan MutationObserver untuk mendeteksi perubahan DOM
    const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      if (mutation.addedNodes.length) {
      removeUnwantedIframes();
      }
    });
    });

    // Mulai mengamati perubahan pada dokumen
    observer.observe(document.documentElement, {
    childList: true,
    subtree: true
    });

    // Handler untuk tombol Simpan pada modal Edit
    const btnSimpanEdit = document.getElementById('btnSimpanEdit');
    if (btnSimpanEdit) {
    btnSimpanEdit.addEventListener('click', function () {
      const form = document.getElementById('editFormIdentitas');

      // Cek validasi form
      if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
      return;
      }

      // Ambil semua data form
      const formData = {
      id: document.getElementById('editId').value,
      nik: document.getElementById('editNIK').value,
      nama: document.getElementById('editNama').value,
      tanggalLahir: document.getElementById('editTanggalLahir').value,
      jenisKelamin: document.getElementById('editJenisKelamin').value,
      noHP: document.getElementById('editNoHP').value,
      hubungan: document.getElementById('editHubungan').value,
      alamat: document.getElementById('editAlamat').value
      };

      // Implementasi untuk pengiriman data (AJAX) akan ditambahkan di sini
      console.log('Data yang dikirim:', formData);

      // Simulasi sukses dan tutup modal (dalam implementasi nyata, ini akan dilakukan setelah AJAX sukses)
      const modal = bootstrap.Modal.getInstance(editModal);
      modal.hide();

      // Tampilkan notifikasi sukses (opsional)
      alert('Data berhasil diperbarui!');

      // Refresh halaman atau update tampilan tabel
      // window.location.reload();
    });
    }

    // Handler untuk tombol Hapus pada modal konfirmasi
    const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
    if (btnKonfirmasiHapus) {
    btnKonfirmasiHapus.addEventListener('click', function () {
      const id = document.getElementById('deleteId').value;

      // Implementasi untuk pengiriman data hapus (AJAX) akan ditambahkan di sini
      console.log('ID yang dihapus:', id);

      // Simulasi sukses dan tutup modal
      const modal = bootstrap.Modal.getInstance(deleteModal);
      modal.hide();

      // Tampilkan notifikasi sukses (opsional)
      alert('Data berhasil dihapus!');

      // Refresh halaman atau update tampilan tabel
      // window.location.reload();
    });
    }
    // Fungsi untuk mengaktifkan tombol Edit pada tabel
    function editIdentitas(id) {
    // Implementasi untuk membuka modal edit dan mengambil data melalui AJAX
    const editButton = document.createElement('button');
    editButton.setAttribute('data-bs-toggle', 'modal');
    editButton.setAttribute('data-bs-target', '#editModal');
    editButton.setAttribute('data-id', id);
    // Set atribut lainnya jika tersedia dari data
    document.body.appendChild(editButton);
    editButton.click();
    document.body.removeChild(editButton);
    }

    // Fungsi untuk mengaktifkan tombol Hapus pada tabel
    function hapusIdentitas(id, nama) {
    // Implementasi untuk membuka modal hapus
    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('data-bs-toggle', 'modal');
    deleteButton.setAttribute('data-bs-target', '#deleteModal');
    deleteButton.setAttribute('data-id', id);
    deleteButton.setAttribute('data-nama', nama);
    document.body.appendChild(deleteButton);
    deleteButton.click();
    document.body.removeChild(deleteButton);
    }
  </script>
@endsection