@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row">
        <div class="admin-top-message">
            @if(session()->has('deleteBlogSuccessfully'))
            <div class="alert alert-success ms-5 my-3 d-flex w-fit-content" role="alert">
                {{ session()->get('deleteBlogSuccessfully') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('blogChangeSuccess'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ session()->get('blogChangeSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('blogCreateSuccess'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content " role="alert">
                {{ session()->get('blogCreateSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="col-lg-12 grid-margin stretch-card px-5 pt-4 w-100">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Blog</h4>
                    <div class="d-flex flex-row py-2 justify-content-between">
                        <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.blog.search')}}">
                            @csrf
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control d-inline-block ms-2" value="{{request('search')?request('search'):'' }}">
                            <label for="search-by" class="mx-2 text-nowrap">Search by</label>
                            <select name="by" id="search-by" class="form-select">
                                <option {!! request('by')=="id" ?'selected':'' !!} value="id">Blog's Id</option>
                                <option {!! request('by')=="name" ?'selected':'' !!} value="name">Blog's Name</option>
                                <option {!! request('by')=="author" ?'selected':'' !!} value="author">Author's Name</option>
                            </select>
                            <button type="submit" class="btn btn-primary ms-4 d-flex">
                                <i class="bi bi-search pe-2"></i>
                                Search
                            </button>
                        </form>
                        <a href="{{route('admin.blog.create')}}" class="btn btn-success ">
                            <i class="bi bi-plus pe-2"></i>Create new blog</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="">Id</th>
                                    <th class="">Name</th>
                                    <th class="">Author</th>
                                    <th class="">Create at</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @foreach ($data["blogs"] as $blog)
                            <tbody>
                                <tr>
                                    <td class="">{{ $blog->id }}</td>
                                    <td class="">{{ $blog->name }}</td>
                                    <td class="">{{ $blog->user->name }}</td>
                                    <td class="">{{ $blog->created_at }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info px-1 py-0" href="{{route('admin.blog.show',$blog->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-eye pe-2"></i>
                                                Show
                                            </label>
                                        </a>
                                        <a class="btn btn-primary px-1 py-0" href="{{route('admin.blog.edit',$blog->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-pencil-square pe-2"></i>
                                                Edit
                                            </label>
                                        </a>
                                        <div class="btn btn-danger px-1 py-0">
                                            <label for="{{ 'submit-delete-'.$blog->id }}" class="badge badge-danger">
                                                <i class="bi bi-trash pe-2"></i>
                                                Delete
                                            </label>
                                        </div>
                                        <input type="submit" class="d-none" form="{{ 'delete-'.$blog->id }}" id="{{ 'submit-delete-'.$blog->id }}" />
                                        <form action="{{ route('admin.blog.destroy',$blog->id) }}" method="post" id="{{ 'delete-'.$blog->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
                        @if ($data["blogs"]->count() == 0)
                            <div class="d-flex justify-content-center ">
                                <h4>No record available</h4>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="ms-4">
                    {{ $data["blogs"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection