@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2 position-relative">
    <div class="admin-top-message w-fit-content position-absolute top-0 end-0">
        @if(session()->has('success'))
        <div class="alert alert-success ms-5 my-3 d-flex w-fit-content" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12 border shadow rounded bg-white">
                <div class="info-container w-100 p-4 d-flex flex-column ">
                    <h1>Thông tin cá nhân</h1>
                    <ul class="w-100 d-flex flex-row p-0 info-ul">
                        <li class="info-nav">
                            <a href="{{route('user.info.info',$data['user']->id)}}" class="text-decoration-none px-2 py-3 active">Thông tin cá nhân</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.password',$data['user']->id)}}" class="text-decoration-none px-2 py-3">Thay đổi mật khẩu</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.history',$data['user']->id)}}" class="text-decoration-none px-2 py-3">Kết quả luyện thi</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.plan',$data['user']->id)}}" class="text-decoration-none px-2 py-3">Kế hoạch rèn luyện</a>
                        </li>
                    </ul>
                    <form class="display-inline-block float-right w-80 mx-auto" method="POST" action="{{route('user.info.update',$data['user']->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class=" mb-4">
                            <label for="name" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{$data['user']->name}}">
                            <input type="name" class="d-none" name="old_name" value="{{ $data['user']->name }}">
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
                        <div class="mb-4 d-flex flex-column">
                            @if ($data['user']->avatar != null)
                            <div class="info-update w-100">
                                <img src="{{asset('storage/'.$data['user']->avatar)}}" alt="">
                            </div>
                            @else
                            <i class="bi bi-person-circle avatar-icon avatar-update"></i>
                            @endif
                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            @error('avatar')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-pencil-square pe-2"></i>
                                Lưu thay đổi
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<script type="module">



</script>

@endsection