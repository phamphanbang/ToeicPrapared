@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="mb-3 d-flex flex-row align-items-center">
                        <a class="btn btn-primary" href="{{route('admin.blog.index')}}" role="button">
                            <i class="bi bi-arrow-left pe-2"></i>
                            Back
                        </a>
                        <a class="btn btn-primary ms-auto" href="{{route('admin.blog.edit',$data['blog']->id)}}" role="button">
                            <i class="bi bi-pencil-square pe-2"></i>
                            Edit
                        </a>
                    </div>
                    <h1 class="card-title display-inline-block my-2 fw-bold ">{{$data["blog"]->name}}</h1>
                    <p>Ngày đăng: {{ $data["blog"]->created_at->format("d/m/Y") }}</p>
                    <div class="w-100 my-3">
                        <img src="{{asset('storage/'.$data['blog']->banner)}}" class="w-100 banner-img" alt="">
                    </div>
                    <div class="mx-auto mb-3 border w-40">
                        <h4 class="text-center fw-bold">Mục lục</h4>
                        <div class="block-menu px-4">
                        </div>
                    </div>
                    <div class="block-content">
                        {!! $data["blog"]->blog !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(() => {
        $(".block-content").children("h2").each((i,item)=>{
            $(item).attr("id","tittle"+i);
            $(".block-menu").append("<a href='#"+"tittle"+i +"' class='text-decoration-none d-block'>" +$(item).text() + "</a>")
        });

        $(".block-content").find("td").each((i,item)=>{
            $(item).addClass("border ps-2 pt-2");
        });

    })


</script>

@endsection