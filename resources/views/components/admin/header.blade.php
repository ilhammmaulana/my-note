<header class="d-flex justify-content-between header-dashboard">
    <h3 class="fw-bold text-poppins text-theme">{{ $page }}</h3>
    <a href="#" id="user-link" class="header-dropdown px-3 d-flex align-items-center gap-1">
        
        <h6 class="pt-1 pe-3 header-dropdown text-muted">
            {{ auth()->user()->name }}
        </h6>
        <img src="{{ auth()->user()->photo === null ? asset('assets/images/default.jpg') : url(auth()->user()->photo) }}" width="40" alt="{{ 'image '.auth()->user()->name }}" class="rounded-circle header-dropdown" >
        <i class="fa-solid fa-caret-down"></i>
    </a>
    <div id="user-menu" class="menu">
        <ul>
          
            <li class="">
                <form method="POST" action={{ route('logout') }}>
                    @method('DELETE')
                    @csrf
                    <i class="fa-solid fa-right-from-bracket ms-4"></i>
                    <button type="submit">
                            Logout 
                    </button>
                </form>
            </li>
            <li>
                <a href="{{ url('profile') }}">
                    <i class="fa fa-solid fa-user me-auto"></i>
                    <p>Profile</p>
                </a>
            </li>
         
        </ul>
    </div>
</header>