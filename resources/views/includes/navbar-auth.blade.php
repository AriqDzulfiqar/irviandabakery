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
            <li class="nav-item active">
              <a href="{{route('home')}}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{route('menu')}}" class="nav-link">Menu</a>
            </li>
            <li class="nav-item">
              <a href="{{route('contactus')}}" class="nav-link">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>