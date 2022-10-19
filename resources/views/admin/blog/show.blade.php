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
                    <div class="border border-4 rounded-pill shadow mb-3"></div>
                    <div class="d-flex flex-row align-items-center ">
                        <h5>Author: {{$data["blog"]->user->name}}</h5>
                        <div class="ms-auto">
                            <h5 class="text-end mb-2">Updated: {{$data["blog"]->updated_at}}</h5>
                            <h6 class="text-end mt-2 mb-0">Published: {{$data["blog"]->created_at}}</h6>
                        </div>
                    </div>
                    <div class="border border-4 rounded-pill shadow mt-3"></div>
                    <h1 class="card-title display-inline-block my-4 text-center ">{{$data["blog"]->name}}</h1>
                    <div>
                        {!! $data["blog"]->blog !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection