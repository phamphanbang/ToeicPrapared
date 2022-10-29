@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row">
        <div class="admin-top-message">
            @if(session()->has('deleteUserSuccessfully'))
            <div class="alert alert-success ms-5 my-3 d-flex w-fit-content" role="alert">
                {{ session()->get('deleteUserSuccessfully') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('profileChangeSuccess'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ session()->get('profileChangeSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('registerSuccess'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content " role="alert">
                {{ session()->get('registerSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="col-lg-12 grid-margin stretch-card px-5 pt-4 w-100">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">User</h4>
                    <div class="d-flex flex-row py-2 justify-content-between flex-nowrap">
                        <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.user.search')}}">
                            @csrf
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control d-inline-block ms-2" value="{{request('search')?request('search'):'' }}">
                            <label for="search-by" class="mx-2 text-nowrap">Search by</label>
                            <select name="by" id="search-by" class="form-select">
                                <option {!! request('by')=="id"?'selected':'' !!} value="id">Id</option>
                                <option {!! request('by')=="name"?'selected':'' !!} value="name">Name</option>
                                <option {!! request('by')=="email"?'selected':'' !!} value="email">Email</option>
                            </select>
                            <button type="submit" class="btn btn-primary ms-4 d-flex">
                                <i class="bi bi-search pe-2"></i>
                                Search
                            </button>
                        </form>
                        <a href="{{route('admin.user.create')}}" class="btn btn-success ">
                            <i class="bi bi-plus pe-2"></i>Create new user</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="">Id</th>
                                    <th class="">Name</th>
                                    <th class="">Email</th>
                                    <th class="">Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @foreach ($data["users"] as $user)
                            <tbody>
                                <tr>
                                    <td class="">{{ $user->id }}</td>
                                    <td class="">{{ $user->name }}</td>
                                    <td class="">{{ $user->email }}</td>
                                    <td class="">
                                        @if ($user->role == 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                        @elseif ($user->role == 'modder')
                                        <span class="badge bg-warning text-dark">Modder</span>
                                        @else
                                        <span class="badge bg-secondary">User</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary px-1 py-0 mx-1" href="{{route('admin.user.edit',$user->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-pencil-square pe-2"></i>
                                                Edit
                                            </label>
                                        </a>
                                        @if ($user->role == 'admin')
                                        <a class="confirm btn btn-danger px-1 py-0 mx-1 disabled " item-id="user_id" item-type="user">
                                            <label class="badge badge-danger">
                                                <i class="bi bi-trash pe-2"></i>
                                                Delete
                                            </label>
                                        </a>
                                        @else
                                        <div class="btn btn-danger px-1 py-0 mx-1">
                                            <label for="{{ 'submit-delete-'.$user->id }}" class="badge badge-danger">
                                                <i class="bi bi-trash pe-2"></i>
                                                Delete
                                            </label>
                                        </div>
                                        <input type="submit" class="d-none" form="{{ 'delete-'.$user->id }}" id="{{ 'submit-delete-'.$user->id }}" />
                                        <form action="{{ route('admin.user.destroy',$user->id) }}" method="post" id="{{ 'delete-'.$user->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
                        @if ($data["users"]->count() == 0)
                            <div class="d-flex justify-content-center ">
                                <h4>No result found</h4>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="ms-4">
                    {{ $data["users"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection