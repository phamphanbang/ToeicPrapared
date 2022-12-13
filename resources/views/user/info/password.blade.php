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
        @if(session()->has('fail'))
        <div class="alert alert-danger ms-5 my-3 d-flex w-fit-content" role="alert">
            {{ session()->get('fail') }}
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
                            <a href="{{route('user.info.info',$data['user']->id)}}" class="text-decoration-none px-2 py-3 ">Thông tin cá nhân</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.password',$data['user']->id)}}" class="text-decoration-none px-2 py-3 active">Thay đổi mật khẩu</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.history',$data['user']->id)}}" class="text-decoration-none px-2 py-3">Kết quả luyện thi</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.plan',$data['user']->id)}}" class="text-decoration-none px-2 py-3">Kế hoạch rèn luyện</a>
                        </li>
                    </ul>
                    <form class="display-inline-block float-right w-80 mx-auto" method="POST" action="{{route('user.info.changepass',$data['user']->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="pastpass" class="form-label">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="pastpass" name="pastpass" placeholder="Nhập mật khẩu của bạn" required>
                            @error('pastpass')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
                            @error('password')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" required>
                            @error('password')
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