<nav id="sidebar" class="sidebar">
  <div class="sidebar-header d-flex align-items-center px-3 py-2">
    <button class="btn btn-sm text-white" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link active"
        data-label="Dashboard">
        <i class="fas fa-home"></i>
        <span class="sidebar-text ms-2">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link"
        data-label="Janji Temu">
        <i class="fas fa-calendar-alt"></i>
        <span class="sidebar-text ms-2">Janji Temu</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link"
        data-label="Janji Temu">
        <i class="fas fa-user-md"></i>
        <span class="sidebar-text ms-2">Dokter</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link"
        data-label="Janji Temu">
        <i class="fas fa-hospital"></i>
        <span class="sidebar-text ms-2">Poliklinik</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link"
        data-label="Janji Temu">
        <i class="fas fa-notes-medical"></i>
        <span class="sidebar-text ms-2">Tiket Antrian</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link"
        data-label="Janji Temu">
        <i class="fas fa-user"></i>
        <span class="sidebar-text ms-2">Profil</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('login') }}"
        class="nav-link"
        data-label="Janji Temu">
        <i class="fas fa-question-circle"></i>
        <span class="sidebar-text ms-2">Bantuan</span>
      </a>
    </li>
  </ul>
</nav>


<style>
  /* Base sidebar */
  .sidebar {
    background: #d32f2f;
    color: #fff;
    width: 240px;
    height: 100vh;
    overflow-y: auto;
    transition: width .2s;
  }

  /* Header padding */
  .sidebar-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }

  #sidebarToggle {
    background: transparent;
    border: none;
    font-size: 1.25rem;
    padding: 0.25rem;
  }

  #sidebarToggle:focus {
    outline: none;
    box-shadow: none;
  }

  /* Links */
  .sidebar .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: .75rem 1rem;
    transition: background .2s, color .2s;
  }

  .sidebar .nav-link i {
    font-size: 1.25rem;
    vertical-align: middle;
  }

  .sidebar .nav-link .sidebar-text {
    vertical-align: middle;
  }

  /* Active link: red background, white text */
  .sidebar .nav-link.active {
    background: #b71c1c;
    color: #fff;
  }

  .sidebar .nav-link.active i {
    color: #fff;
  }

  /* Hover */
  .sidebar .nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  /* Collapsed state */
  body.sidebar-collapsed .sidebar {
    width: 56px;
  }

  /* Hide text in collapsed */
  body.sidebar-collapsed .sidebar-text {
    display: none;
  }

  /* Center icons in collapsed */
  body.sidebar-collapsed .sidebar .nav-link {
    text-align: center;
    padding: .75rem 0;
  }

  body.sidebar-collapsed .sidebar .nav-link i {
    margin: 0;
  }

  /* Tooltip on hover, using data-label */
  body.sidebar-collapsed .sidebar .nav-link {
    position: relative;
  }

  body.sidebar-collapsed .sidebar .nav-link:hover::after {
    content: attr(data-label);
    position: absolute;
    left: 60px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.75);
    color: #fff;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    white-space: nowrap;
    font-size: 0.875rem;
    z-index: 2000;
  }

  /* Ensure content shifts over */
  #content-wrapper {
    margin-left: 240px;
    transition: margin-left .2s;
  }

  body.sidebar-collapsed #content-wrapper {
    margin-left: 56px;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('sidebarToggle');
    toggle?.addEventListener('click', () => {
      document.body.classList.toggle('sidebar-collapsed');
    });
  });
</script>