{{-- Sidebar --}}
<nav id="sidebar">
  <div class="d-flex logos align-items-center justify-content-center">
    <h4 class="fw-bold text-theme mt-3 ms-2 text-poppins">Note App</h4>
  </div>
  <a class="sidebar-item {{ Request::is('users*') ? ' active' : '' }}" href="{{ url('users') }}" style="margin-top: 1.5rem">
    <i class="fa-solid fa-users"></i>
    <p class="my-auto">Manage users</p>
  </a>
  {{-- Belum kelar --}}
  @role('super_admin')
  <a class="sidebar-item{{ Request::is('admins*') ? ' active' : '' }}" href="{{ url('admins') }}">
    <i class="fa-solid fa-user"></i>
    <p class="my-auto">Admins</p>
  </a>
  @endrole

</nav>


{{-- Mobile --}}
<nav class="navbar navbar-expand-lg bg-light d-md-none">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler"f type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="#">Features</a>
        <a class="nav-link" href="#">Pricing</a>
        <a class="nav-link disabled">Disabled</a>
      </div>
    </div>
  </div>
</nav>