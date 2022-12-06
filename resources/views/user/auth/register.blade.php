@extends('user.layouts.app')

@section('content')

<div class="login-container w-100 d-flex justify-content-center align-items-center">
    <div class="form-container w-30 border p-4 shadow">
        <form method="POST" action="{{route('user.registration.post')}}" class="">
            @csrf
            <p class="login-text">Đăng ký ngay để bắt đầu trải nghiệm luyện thi TOEIC tại <b> TOEICAMP </b></p>
            <div class=" mb-3">
                <label for="name" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')?old('name'):'' }}">
                @error('name')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Tài khoản Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email')?old('email'):'' }}">
                @error('email')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password" class="form-control" name="password">
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="w-100 d-flex justify-content-end my-2">
                <button type="submit" class="btn btn-primary login-button">Đăng Ký</button>
            </div>

            <a href="{{route('user.login')}}" class="d-block">Bạn đã có tài khoản ? Đăng nhập ngay tại đây !</a>
        </form>
    </div>

</div>


@endsection