<nav
      class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
      data-aos="fade-down"
    >
      <div class="container">
        <a href="{{route('home')}}" class="navbar-brand"
          ><img src="/images/logo 1.svg" alt="logo"
        /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarResponsive"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
              <a href="{{route('home')}}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{route('menu')}}" class="nav-link">Menu</a>
            </li>
            <li class="nav-item">
              <a href="{{route('contactus')}}" class="nav-link">Contact Us</a>
            </li>
            @guest
                <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
            </li>
            <li class="nav-item">
              <a
                href="{{ route('login') }}"
                class="btn btn-success nav-link px-4 text-white"
                >Sign In</a
              >
            </li>
            @endguest
            
          </ul>

          @auth
            <!-- Dekstop Menu-->
          <ul class="navbar-nav d-none d-lg-flex">
            <li class="nav-item dropdown">
              <a
                href="#"
                class="nav-link"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
              >
                <img
                  src="/images/icon-user.png"
                  alt=""
                  class="rounded-circle mr-2 profile-picture"
                />Hi, {{ Auth::user()->name }}
                </a>

              <div class="dropdown-menu">
                <a href="{{ route('dashboard-account') }}" class="dropdown-item"
                  >Settings</a
                >
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
                        
                  <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none">
                     @csrf    
                    </form>
              </div>
            </li>
            <li class="nav-item">
              <a href="{{route('cart')}}" class="nav-link d-inline">
                @php
                $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
                @endphp

                @if ($carts > 0)
                    <img src="/images/shopping-cart-filled.svg" alt="" />
                    <div class="card-badge">{{ $carts }}<div>
                @else
                    <img src="/images/shopping-cart-empty.svg" alt="" />
                @endif
                  
              </a>
            </li>
          </ul>

          <ul class="navbar-nav d-block d-lg-none">
            <li class="nav-item dropdown">
              <a
                href="#"
                class="nav-link"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
              >
                <img
                  src="/images/icon-user.png"
                  alt=""
                  class="rounded-circle mr-2 profile-picture"
                />Hi, {{ Auth::user()->name }}
                </a>

              <div class="dropdown-menu">
                <a href="{{ route('dashboard-account') }}" class="dropdown-item"
                  >Settings</a
                >
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
                        
                  <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none">
                     @csrf    
                    </form>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav d-block d-lg-none">
            <li class="nav-item">
              <a href="{{route('cart')}}" class="nav-link d-inline-block">Cart</a>
            </li>
          </ul>
          @endauth
        </div>
      </div>
    </nav>