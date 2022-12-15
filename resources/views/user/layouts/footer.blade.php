<div class="footer border-top shadow-top">
    <div class="my-4 d-flex flex-row w-100">
        <div class="footer-logo d-flex flex-column w-20 ps-4 ms-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="logo-span-small p-0">TOEICAMP</span>
            </a>
            <small class="d-block mb-2">© 2022</small>
            <div class="logo-block d-flex flex-row">
                <a class="logo-social" href="#">
                    <i class="bi bi-facebook"></i>
                </a>
                <a class="logo-social" href="#">
                    <i class="bi bi-twitter"></i>
                </a>
                <a class="logo-social" href="#">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a class="logo-social" href="#">
                    <i class="bi bi-youtube"></i>
                </a>
            </div>
        </div>
        <div class="footer-info d-flex flex-row justify-content-end w-80">
            <div class="footer-resource d-flex flex-column px-2">
                <span class="resource-span">Tài nguyên</span>
                <a class="resource-link" href="{{route('user.test.type','fulltest')}}">Full Test</a>
                <a class="resource-link" href="{{route('user.test.type','parttest')}}">Part Test</a>
                <a class="resource-link" href="{{route('user.test.type','minitest')}}">Mini Test</a>
            </div>
            <div class="footer-resource d-flex flex-column px-2 me-4">
                <span class="resource-span">TOEICAMP</span>
                <a class="resource-link" href="{{ route('contact') }}">Liên Hệ</a>
                <a class="resource-link" href="{{ route('security') }}">Điều khoản bảo mật</a>
                <a class="resource-link" href="{{ route('usage') }}">Điều khoản sử dụng</a>
            </div>
        </div>
    </div>
</div>