@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row">
        <!-- @if(session()->has('deleteUserSuccessfully'))
        <div class="alert alert-success ms-5 my-3 d-flex" role="alert">
            {{ session()->get('deleteUserSuccessfully') }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif -->
        <div class="col-lg-12 grid-margin stretch-card px-5 pt-4 w-100">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">User</h4>
                    <div class="d-flex flex-row py-2 justify-content-between">
                        <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.user.search')}}">
                            @csrf
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control d-inline-block ms-2">
                            <label for="search-by" class="mx-2 text-nowrap">Search by</label>
                            <select name="by" id="search-by" class="form-select">
                                <option value="id">Blog's Id</option>
                                <option value="name">Blog's Name</option>
                                <option value="author">Author's Name</option>
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
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @foreach ($data["blogs"] as $blog)
                            <tbody>
                                <tr>
                                    <td class="">{{ $blog->id }}</td>
                                    <td class="">{{ $blog->name }}</td>
                                    <td class="">{{ $blog->user()->name }}</td>
                                    <td class="text-center">
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
                                        <input type="submit" class="d-none" form="{{ 'delete-'.$user->id }}" id="{{ 'submit-delete-'.$blog->id }}" />
                                        <form action="{{ route('admin.blog.destroy',$blog->id) }}" method="post" id="{{ 'delete-'.$blog->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
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