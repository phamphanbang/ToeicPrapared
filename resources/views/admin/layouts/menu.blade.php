<div class="container m-0 p-0 w-25">
    <div class="row justify-content-center mx-2">
        <div class="col-md-8 p-0 w-100">
            <div class="list-group">
                <a href="{{ route('admin.user.index')}}" class="list-group-item list-group-item-action rounded-0 {{ Request::is('admin/user*') ? 'active' : '' }}" aria-current="true">
                <i class="bi bi-person-circle pe-2"></i>User Management
                </a>
                <a href="{{ route('admin.blog.index')}}" class="list-group-item list-group-item-action rounded-0 {{ Request::is('admin/blog*') ? 'active' : '' }}">
                <i class="bi bi-book pe-2"></i>
                Blog Management
                </a>
                @if (Auth::user()->role == "admin")
                <a href="{{ route('admin.template.index')}}" class="list-group-item list-group-item-action rounded-0 {{ Request::is('admin/template*') ? 'active' : '' }}">
                <i class="bi bi-journal-code pe-2"></i>
                Template Management
                </a>
                @endif
                <a href="{{ route('admin.test.index')}}" class="list-group-item list-group-item-action rounded-0 {{ Request::is('admin/test*') ? 'active' : '' }}">
                <i class="bi bi-journal-check pe-2"></i>
                Test Management
                </a>
            </div>
        </div>
    </div>
</div>