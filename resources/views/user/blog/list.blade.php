@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12">
                <h1 class="mb-2">Blogs</h1>
                <form action="{{route('user.blog.search')}}" method="POST">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-8">
                            <input type="text" name="search" class="form-control" placeholder="Nhập từ khoá bạn muốn tìm kiếm" value="{{request('search')?request('search'):'' }}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary login-button">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mb-2 pt-4 border-top border-3">
        <div class="row justify-content-center mt-2">
            <div class="col-md-9 col-12">
                <div class="row">
                    @if ($data["blogs"]->count() == 0)
                    <div>
                        <p class="fs-5 fst-italic">Không có blog nào trùng khớp với kết quả tìm kiếm của bạn.</p>
                    </div>
                    @else
                    @foreach ($data["blogs"] as $blog)
                    <div class="col-md-12 px-2 py-1 mb-4">
                        <div class="blog-wrapper d-flex flex-row rounded shadow">
                            <a class="d-block banner-holder text-decoration-none" href="{{route('user.blog.show',$blog->id)}}">
                                <img src="{{asset('storage/'.$blog->banner)}}" class="w-20rem h-11rem" alt="">
                            </a>
                            <div class="blog-info d-flex flex-column ">
                                <a class="d-block text-decoration-none fs-5 fw-bolder mt-2 ms-2 blog-link" href="{{route('user.blog.show',$blog->id)}}" >{{$blog->name}}</a>
                                <p class="mt-1 ms-2 mb-0 fw-small">Ngày đăng: {{$blog->created_at->format("d/m/Y")}}</p>
                                <p class="blog-description ms-2 mb-0 mt-2">{{$blog->glossary}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
                <div>
                    {{ $data["blogs"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>

</div>

<script type="module">
    $(document).ready(function() {
        $("#by").val($("#search-by").find(":selected").val());

        $("#search-by").change((e) => {
            $("#by").val($("#search-by").val());
        })
    });
</script>

@endsection