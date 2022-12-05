<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-1">
    <div class="container" style="margin:0px;max-width:100%">
        <a class="navbar-brand" href="{{ route('admin.user.index') }}">
            <span class="logo-span-small">TOEICAMP</span>
        </a>

        <!-- <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->avatar)
                <div class="image-container mx-2" style="width:5%;">
                    <img src="{{asset('storage/'.Auth::user()->avatar)}}" alt="">
                </div>
                @else
                <i class="bi bi-person-circle avatar-icon"></i>
                @endif
                {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav me-auto">
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex flex-row align-items-center justify-content-end" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @if (Auth::user()->avatar)
                        <div class="image-container mx-2" style="width:5%;">
                            <img src="{{asset('storage/'.Auth::user()->avatar)}}" alt="">
                        </div>
                        @else
                        <i class="bi bi-person-circle avatar-icon"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                            {{ __('Logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>