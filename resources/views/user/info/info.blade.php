@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12 border shadow rounded bg-white">
                <form class="display-inline-block float-right w-75" method="POST" action="{{route('admin.user.update',$data['user']->id)}}" enctype="multipart/form-data">
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
                    <div class=" mb-4">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option {!! $data['user']->role == 'admin' ?'selected':'' !!} value="admin">Admin</option>
                            <option {!! $data['user']->role == 'modder' ?'selected':'' !!} value="modder">Modder</option>
                            <option {!! $data['user']->role == 'user' ?'selected':'' !!} value="user">User</option>
                        </select>
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
                    <div class="mb-4 d-flex flex-column">
                        @if ($data['user']->avatar != null)
                        <div class="image-container">
                            <img src="{{asset('storage/'.$data['user']->avatar)}}" alt="">
                        </div>
                        @else
                        <i class="bi bi-person-circle avatar-icon"></i>
                        @endif
                        <label for="avatar" class="form-label">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                        @error('avatar')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success float-end">
                        <i class="bi bi-pencil-square pe-2"></i>
                        Edit
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<script type="module">



</script>

@endsection