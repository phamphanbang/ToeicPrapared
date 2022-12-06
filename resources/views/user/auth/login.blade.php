@extends('user.layouts.app')

@section('content')

<div class="login-container w-100 d-flex justify-content-center align-items-center">
    <div class="form-container w-30 border p-4 shadow">
        <form method="POST" action="{{route('user.login.post')}}" class="">
            @csrf
            <p class="login-text">Đăng nhập ngay để bắt đầu trải nghiệm luyện thi TOEIC tại <b> TOEICAMP </b></p>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
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
                @if(session()->has('loginFail'))
                <p class="text-danger">{{ session()->get('loginFail') }}</p>
                @endif
            </div>
            <div class="w-100 d-flex justify-content-end my-2">
                <button type="submit" class="btn btn-primary login-button">Đăng nhập</button>
            </div>

            <a href="{{route('user.registration')}}" class="d-block">Bạn chưa có tài khoản ? Đăng ký ngay tại đây</a>
        </form>
    </div>

</div>


@endsection