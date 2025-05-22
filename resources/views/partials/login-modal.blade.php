{{-- resources/views/partials/login-modal.blade.php --}}

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      {{-- 1) Email-entry view --}}
      <div id="login-form-view">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold" id="loginModalLabel">Masuk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="loginForm" novalidate>
            @csrf
            <div class="mb-3">
              <label for="login-email" class="form-label small">Email</label>
              <input type="email" name="email" id="login-email" class="form-control" required>
              <div class="invalid-feedback">Masukkan alamat email yang valid.</div>
            </div>
            <button type="submit" id="login-submit" class="btn btn-danger w-100 py-2" disabled>
              Selanjutnya
            </button>
          </form>
        </div>
      </div>

      {{-- 2) Password-entry view --}}
      <div id="password-view" class="d-none">
        <div class="modal-header border-0 d-flex justify-content-between align-items-center">
          <h5 class="modal-title fw-bold m-0">Masuk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="passwordForm" method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
              <label class="form-label small mb-1">Email</label>
              <div class="d-flex justify-content-between align-items-center">
                <span id="password-email-display" class="fw-semibold"></span>
                <button type="button" id="btn-change-email" class="btn btn-link text-danger small text-decoration-none">
                  Ubah
                </button>
              </div>
            </div>

            {{-- Password --}}
            <div class="mb-3 position-relative">
              <label for="login-password" class="form-label small mb-1">Kata Sandi</label>
              <div class="input-group">
                <input type="password" name="password" id="login-password" class="form-control rounded" required
                  placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary border-start-0" id="togglePassword"
                  style="outline:none; box-shadow:none;" onfocus="this.blur()">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              {{-- placeholder for error --}}
              <div id="password-error" class="invalid-feedback" style="display:none;"></div>
            </div>

            {{-- Remember + Forgot --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small mb-0" for="remember">Ingat saya</label>
              </div>
              <button type="button" class="btn btn-link text-danger small text-decoration-none"
                onclick="location.href='{{ route('password.request') }}'">
                Lupa kata sandi?
              </button>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-2 rounded">Masuk</button>
          </form>
        </div>
      </div>

      {{-- 3) Email-not-found view --}}
      <div id="email-not-found-view" class="d-none">
        <div class="modal-header border-0 justify-content-center">
          <h5 class="modal-title fw-bold text-center">Email belum terdaftar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-1">Lanjut daftar dengan email ini</p>
          <p id="unregistered-email" class="fw-semibold mb-2"></p>
          <div class="d-flex gap-2 mt-3">
            <button id="btn-cancel-register" class="btn btn-outline-danger flex-fill py-2">Ubah</button>
            <button id="btn-go-register" class="btn btn-danger flex-fill py-2">Ya, Daftar</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  const checkEmailUrl = "{{ route('check.email') }}";

  document.getElementById('loginForm').addEventListener('submit', async e => {
    e.preventDefault();
    const email = document.getElementById('login-email').value.trim();
    if (!email) return;

    const url = `${checkEmailUrl}?email=${encodeURIComponent(email)}`;
    try {
      const res = await fetch(url);
    } catch (err) {
      console.error(err);
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const modalEl = document.getElementById('loginModal');
    const emailView = document.getElementById('login-form-view');
    const passView = document.getElementById('password-view');
    const notView = document.getElementById('email-not-found-view');
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('login-email');
    const submitBtn = document.getElementById('login-submit');
    const unregEmail = document.getElementById('unregistered-email');
    const passEmailDisp = document.getElementById('password-email-display');
    const togglePwdBtn = document.getElementById('togglePassword');
    const btnChange = document.getElementById('btn-change-email');
    const btnCancelReg = document.getElementById('btn-cancel-register');
    const btnGoReg = document.getElementById('btn-go-register');

    const passwordForm = document.getElementById('passwordForm');
    const pwdInput = document.getElementById('login-password');
    const pwdErrorDiv = document.getElementById('password-error');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    passwordForm.addEventListener('submit', async e => {
      e.preventDefault();
      // clear previous error
      pwdInput.classList.remove('is-invalid');
      pwdErrorDiv.style.display = 'none';
      pwdErrorDiv.textContent = '';

      const formData = new FormData(passwordForm);

      try {
        const res = await fetch("{{ route('login') }}", {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: formData
        });

        // On success, Laravel will redirect you. Fetch follows redirects by default,
        // but we can just send the browser to the “intended” URL:
        if (res.ok) {
          window.location.href = '/home'; // or wherever your app’s home/dashboard is
          return;
        }

        // 422 → validation error, likely wrong credentials
        if (res.status === 422) {
          const data = await res.json();
          const msg = (data.errors && data.errors.password)
            ? data.errors.password[0]
            : 'Kredensial salah.';
          pwdErrorDiv.textContent = msg;
          pwdErrorDiv.style.display = 'block';
          pwdInput.classList.add('is-invalid');
          return;
        }

        console.error('Unexpected status:', res.status);
      } catch (err) {
        console.error(err);
      }
    });

    function resetAll() {
      emailView.classList.remove('d-none');
      passView.classList.add('d-none');
      notView.classList.add('d-none');
      loginForm.reset();
      passwordForm.reset();
      submitBtn.setAttribute('disabled', '');
      emailInput.classList.remove('is-invalid');

      const pwd = document.getElementById('login-password');
      const icon = document.querySelector('#togglePassword i');
      if (pwd) {
        pwd.type = 'password';
      }
      if (icon) {
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }

    emailInput.addEventListener('invalid', e => e.preventDefault());
    emailInput.addEventListener('input', () => {
      const ok = /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(emailInput.value.trim());
      if (ok) {
        submitBtn.removeAttribute('disabled');
        emailInput.classList.remove('is-invalid');
      } else {
        submitBtn.setAttribute('disabled', '');
        emailInput.classList.add('is-invalid');
      }
    });

    loginForm.addEventListener('submit', async e => {
      e.preventDefault();
      const email = emailInput.value.trim();
      if (!email) return;

      try {
        const res = await fetch('/check-email?email=' + encodeURIComponent(email));
        if (res.ok) {
          passEmailDisp.textContent = email;
          passwordForm.email = email;

          emailView.classList.add('d-none');
          notView.classList.add('d-none');
          passView.classList.remove('d-none');
        } else if (res.status === 404) {
          unregEmail.textContent = email;
          emailView.classList.add('d-none');
          passView.classList.add('d-none');
          notView.classList.remove('d-none');
        }
      } catch (err) {
        console.error(err);
      }
    });

    togglePwdBtn.addEventListener('click', () => {
      const pwd = document.getElementById('login-password');
      const icon = togglePwdBtn.querySelector('i');
      if (pwd.type === 'password') {
        pwd.type = 'text'; icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        pwd.type = 'password'; icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    });

    btnChange.addEventListener('click', resetAll);
    btnCancelReg.addEventListener('click', resetAll);

    modalEl.addEventListener('hidden.bs.modal', resetAll);
  });
</script>