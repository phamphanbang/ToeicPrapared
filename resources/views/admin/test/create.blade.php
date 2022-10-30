@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        <!-- <div class="admin-top-message">
            @error('name')
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $message }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            @error('email')
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $message }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            @error('password')
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $message }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
        </div> -->
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Create New Test</h4>
                    <div class="d-flex justify-content-start mt-3">
                        <div class="d-flex flex-row py-2 justify-content-between">
                            <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.test.create.generate')}}">
                                @csrf
                                <label for="template" class="mx-2 text-nowrap">Search by</label>
                                <select name="template" id="template" class="form-select">
                                    @foreach ($data["templates"] as $template )
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary ms-4 d-flex">
                                    <i class="bi bi-gear pe-2"></i>
                                    Generate
                                </button>
                            </form>
                        </div>
                    </div>
                    <form class="display-inline-block float-right w-100" method="POST" action="{{route('admin.user.store')}}">
                        @csrf
                        <div class=" mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class=" mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="public">Public</option>
                                <option value="onhold">On Hold</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row flex-wrap justify-content-start mt-3 part-nav-bar">
                            <button type="button" class="btn btn-secondary me-3 mt-2">Part N</button>
                            <button type="button" class="btn btn-secondary me-3 mt-2">Part N</button>
                            <button type="button" class="btn btn-secondary me-3 mt-2">Part N</button>
                        </div>
                        <div class="d-flex flex-column mt-3">

                        </div>
                    </form>

                    <!-- <div class="d-flex justify-content-center mt-3">
                        <form class="display-inline-block float-right w-75" method="POST" action="{{route('admin.user.store')}}">
                            @csrf
                            <div class=" mb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{ old('name')?old('name'):'' }}">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class=" mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email')?old('email'):'' }}">
                                @error('email')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success float-end">Create</button>
                        </form>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection