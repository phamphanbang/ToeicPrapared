@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row">
        @if(session()->has('registerSuccess'))
        <div class="alert alert-success ms-5 mt-3 mb-0 w-auto d-flex " role="alert">
        {{ session()->get('registerSuccess') }}
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session()->has('profileChangeSuccess'))
        <div class="alert alert-success ms-5 mt-3 mb-0 w-auto d-flex" role="alert">
        {{ session()->get('profileChangeSuccess') }}
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="col-lg-12 grid-margin stretch-card px-5 pt-4 w-100">
            <div class="card w-50">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Edit User {{$data["user"]->name }}</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <form class="display-inline-block float-right w-75" method="POST" action="{{route('admin.user.update',$data['user']->id)}}">
                            @csrf
                            @method('PUT')
                            <div class=" mb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{$data['user']->name}}">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class=" mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{$data['user']->email}}">
                                <input type="email" class="d-none" name="old_email" value="{{ $data['user']->email }}">
                                @error('email')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success float-end">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection