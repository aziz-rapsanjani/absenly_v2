<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Absenly</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('https://i.ibb.co.com/WNz2Rq88/bg-1.jpg');
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      min-height: 100vh;
    }

    .login-card {
      border: 1px solid rgba(255, 255, 255, 0.15);
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
    }

    .input-group-text {
      background: rgba(255, 255, 255, 0.1);
      color: #93c5fd;
      border-color: rgba(255, 255, 255, 0.15);
    }

    .form-control {
      background: rgba(255, 255, 255, 0.05);
      color: #fff;
      border-color: rgba(255, 255, 255, 0.15);
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      border-color: #60a5fa;
      box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.4);
    }

    .form-control:focus~.input-group-text,
    .input-group:focus-within .input-group-text {
      border-color: #60a5fa;
    }

    .btn-toggle-pw {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #93c5fd;
    }

    .btn-toggle-pw:hover {
      color: #fff;
      background: rgba(255, 255, 255, 0.15);
    }

    .dropdown-menu {
      background: #0a1e46;
      border: 1px solid #60a5fa;
    }

    .dropdown-item {
      color: #dbeafe;
    }

    .dropdown-item:hover,
    .dropdown-item.active {
      background: rgba(59, 130, 246, 0.25);
      color: #fff;
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center py-5">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5">

        <div class="card login-card text-white rounded-4 shadow-lg p-3 p-sm-4">
          <div class="card-body">

            <div class="text-center mb-4">
              <h2 class="fw-bold lh-sm mb-1" id="cardTitle">Absenly</h2>
              <p class="text-uppercase tracking-wider small text-white mb-0">Absensi Berbasis QR Code</p>
            </div>

            <div class="mb-4">
              <label class="form-label small fw-bold text-uppercase tracking-wide">Masuk Sebagai</label>
              <div class="dropdown w-100" id="roleDropdown">
                <button
                  class="btn btn-outline-light w-100 d-flex align-items-center justify-content-between py-2.5 px-3 dropdown-toggle"
                  type="button" id="dropdownRoleButton" data-bs-toggle="dropdown" aria-expanded="false">
                  <span><i class="fa-solid fa-user text-info me-2"></i><span id="csText">Siswa</span></span>
                </button>
                <ul class="dropdown-menu w-100 shadow" aria-labelledby="dropdownRoleButton">
                  <li>
                    <a class="dropdown-item active py-2.5 px-3 d-flex justify-content-between align-items-center"
                      href="#" id="opt-siswa" onclick="selectRole('Siswa')">
                      <div>
                        <div class="fw-semibold">Siswa</div>
                        <div class="small text-white-50">Login dengan NISN</div>
                      </div>
                      <i class="fa-solid fa-check check-icon"></i>
                    </a>
                  </li>
                  <li>
                    <hr class="dropdown-divider bg-light opacity-10 my-0">
                  </li>
                  <li>
                    <a class="dropdown-item py-2.5 px-3 d-flex justify-content-between align-items-center" href="#"
                      id="opt-guru" onclick="selectRole('Guru')">
                      <div>
                        <div class="fw-semibold">Guru</div>
                        <div class="small text-white-50">Login dengan Username</div>
                      </div>
                      <i class="fa-solid fa-check check-icon d-none"></i>
                    </a>
                  </li>
                  <li>
                    <hr class="dropdown-divider bg-light opacity-10 my-0">
                  </li>
                  <li>
                    <a class="dropdown-item py-2.5 px-3 d-flex justify-content-between align-items-center" href="#"
                      id="opt-admin" onclick="selectRole('Admin Sekolah')">
                      <div>
                        <div class="fw-semibold">Admin Sekolah</div>
                        <div class="small text-white-50">Hak akses penuh sistem</div>
                      </div>
                      <i class="fa-solid fa-check check-icon d-none"></i>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="mt-2.5">
                <span class="badge bg-primary bg-opacity-25 border border-primary text-white px-2.5 py-1.5"
                  id="roleBadge">
                  <i class="fa-solid fa-graduation-cap me-1"></i> Mode Siswa Aktif
                </span>
              </div>
            </div>

            <hr class="bg-light opacity-15 my-4">

            <?php if (!empty($error)): ?>
              <div
                class="alert alert-danger d-flex align-items-center bg-danger bg-opacity-15 border-danger text-danger-emphasis py-2 px-3 mb-3 rounded-3"
                role="alert">
                <i class="fa-solid fa-circle-exclamation me-2 fs-6"></i>
                <div class="small"><?php echo htmlspecialchars($error); ?></div>
              </div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="<?php echo base_url('auth/login'); ?>" novalidate>
              <input type="hidden" name="role" id="roleHidden" value="Siswa">
              <div class="mb-3">
                <label for="username" class="form-label small fw-bold text-uppercase tracking-wide">Username</label>
                <div class="input-group has-validation">
                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                  <input type="text"
                    class="form-control py-2.5 <?php echo form_error('username') ? 'is-invalid' : ''; ?>" id="username"
                    name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan username kamu"
                    autocomplete="username" required>
                  <?php if (form_error('username')): ?>
                    <div class="invalid-feedback d-block text-white"><?php echo form_error('username'); ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label small fw-bold text-uppercase tracking-wide">Kata Sandi</label>
                <div class="input-group has-validation">
                  <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                  <input type="password"
                    class="form-control py-2.5 <?php echo form_error('password') ? 'is-invalid' : ''; ?>" id="password"
                    name="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                  <button class="btn btn-toggle-pw" type="button" onclick="togglePw()"
                    aria-label="Tampilkan kata sandi">
                    <i class="fa-solid fa-eye-slash" id="eyeIcon"></i>
                  </button>
                  <?php if (form_error('password')): ?>
                    <div class="invalid-feedback d-block text-white"><?php echo form_error('password'); ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between mb-4 mt-2">
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    style="cursor: pointer;">
                  <label class="form-check-label small text-white-50 user-select-none" for="remember"
                    style="cursor: pointer;">
                    Ingat saya
                  </label>
                </div>
              </div>
              <button type="submit"
                class="btn btn-primary w-100 py-2.5 fw-bold text-uppercase tracking-wide shadow-sm rounded-3"
                id="btnLogin">
                Masuk sebagai Siswa
              </button>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function selectRole(role) {
      document.getElementById('csText').textContent = role;

      const roles = ['Siswa', 'Guru', 'Admin Sekolah'];
      const ids = { 'Siswa': 'opt-siswa', 'Guru': 'opt-guru', 'Admin Sekolah': 'opt-admin' };

      roles.forEach(r => {
        const item = document.getElementById(ids[r]);
        const check = item.querySelector('.check-icon');
        if (r === role) {
          item.classList.add('active');
          check.classList.remove('d-none');
        } else {
          item.classList.remove('active');
          check.classList.add('d-none');
        }
      });

      switchRole(role);
    }

    function switchRole(role) {
      document.getElementById('roleHidden').value = role;

      document.getElementById('btnLogin').textContent = 'Masuk sebagai ' + role;

      const btnLogin = document.getElementById('btnLogin');
      const badge = document.getElementById('roleBadge');
      const triggerBtn = document.getElementById('dropdownRoleButton');
      const iconTrigger = triggerBtn.querySelector('.fa-solid');

      btnLogin.className = "btn w-100 py-2.5 fw-bold text-uppercase tracking-wide shadow-sm rounded-3 ";
      badge.className = "badge px-2.5 py-1.5 border ";
      iconTrigger.className = "fa-solid me-2 ";

      if (role === 'Guru') {
        btnLogin.classList.add('btn-info', 'text-white');
        badge.classList.add('bg-info', 'bg-opacity-25', 'border-info');
        badge.innerHTML = `<i class="fa-solid fa-chalkboard-user me-1"></i> Mode Guru Aktif`;
        iconTrigger.classList.add('fa-chalkboard-user', 'text-info');
      } else if (role === 'Admin Sekolah') {
        btnLogin.classList.add('btn-warning');
        badge.classList.add('bg-warning', 'bg-opacity-25', 'border-warning');
        badge.innerHTML = `<i class="fa-solid fa-user-shield me-1"></i> Mode Admin Aktif`;
        iconTrigger.classList.add('fa-user-shield', 'text-warning');
      } else {
        btnLogin.classList.add('btn-primary');
        badge.classList.add('bg-primary', 'bg-opacity-25', 'border-primary');
        badge.innerHTML = `<i class="fa-solid fa-graduation-cap me-1"></i> Mode Siswa Aktif`;
        iconTrigger.classList.add('fa-user', 'text-info');
      }
    }

    function togglePw() {
      const pwInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      if (pwInput.type === 'password') {
        pwInput.type = 'text';
        eyeIcon.className = 'fa-solid fa-eye';
      } else {
        pwInput.type = 'password';
        eyeIcon.className = 'fa-solid fa-eye-slash';
      }
    }

    <?php $swal = $this->session->flashdata('swal'); ?>
    <?php if ($swal): ?>
      Swal.fire({
        icon: '<?= $swal['icon']; ?>',
        title: '<?= $swal['title']; ?>',
        text: '<?= $swal['text']; ?>',
        confirmButtonColor: '#2196f3'
      });
    <?php endif; ?>
  </script>
</body>

</html>