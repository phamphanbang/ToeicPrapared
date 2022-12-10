<nav class="navbar navbar-expand-lg navbar-light shadow bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">
      <span class="logo-span-small">TOEICAMP</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="{{route('home')}}">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('user.test.index')}}">Đề thi online</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Blogs</a>
        </li>
        <li class="nav-item">
          @guest
          <a class="btn btn-primary login-button rounded-pill ms-2" href="{{route('user.login')}}" role="button">Đăng nhập</a>
          @endguest
          @auth
          <div class="dropdown">
            <button class="btn btn-light dropdown-toggle w-img custom-login p-0 mx-2 no-hover d-flex align-items-center" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              @if (Auth::user()->avatar)
              <div class="image-container d-inline-flex">
                <img src="{{asset('storage/'.Auth::user()->avatar)}}" alt="">
              </div>
              @else
              <i class="bi bi-person-circle avatar-icon c-gray"></i>
              @endif
              <i class="bi bi-caret-down-fill ps-1 c-gray"></i>
            </button>
            <ul class="dropdown-menu custom-dropdown shadow" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item no-hover" href="#">Trang cá nhân</a></li>
              <li><a class="dropdown-item no-hover" href="{{route('user.logout')}}">Đăng xuất</a></li>
            </ul>
          </div>
          @endauth
        </li>
      </ul>
    </div>
  </div>
</nav>