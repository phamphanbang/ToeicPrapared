<div class="container m-0 p-0 w-25">
    <div class="row justify-content-center mx-2">
        <div class="col-md-8 p-0 w-100">
            <div class="list-group">
                <a href="{{ route('admin.user.index')}}" class="list-group-item list-group-item-action rounded-0 {{ Request::is('admin/user*') ? 'active' : '' }}" aria-current="true">
                <i class="bi bi-person-circle pe-2"></i>User
                </a>
                <a href="{{ route('admin.blog.index')}}" class="list-group-item list-group-item-action rounded-0 {{ Request::is('admin/blog*') ? 'active' : '' }}">
                <i class="bi bi-book pe-2"></i>
                Blog
                </a>
                <a href="#" class="list-group-item list-group-item-action">A third link item</a>
                <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
                <a href="#" class="list-group-item list-group-item-action disabled rounded-0" tabindex="-1" aria-disabled="true">A disabled link item</a>
            </div>
        </div>
    </div>
</div>