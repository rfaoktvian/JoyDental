<nav id="sidebar">
  <ul class="nav flex-column">

    <li class="nav-item">
      <button id="sidebarToggle" class="nav-link toggle-btn">
        <i class="fas fa-bars"></i>
        <span class="sidebar-text">Menu</span> {{-- optional label when expanded --}}
      </button>
    </li>

    @foreach($sidebarMenu as $item)
    <li class="nav-item">
      <a href="{{ route($item['route']) }}" class="nav-link {{ Request::routeIs($item['route']) ? 'active' : '' }}">
      <i class="{{ $item['icon'] }}"></i>
      <span class="sidebar-text">{{ $item['label'] }}</span>
      </a>
    </li>
  @endforeach

  </ul>
</nav>