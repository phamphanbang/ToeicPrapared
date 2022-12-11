@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12 border shadow rounded bg-white">
                <div class="test-container-block p-2">
                    <h1>{{$data["tests"]->name}}</h1>
                    <div>
                        <span><strong>Bộ đề thi: {{$data["tests"]->testTemplate->name }}</strong></span>
                    </div>
                    <div class="test-attr d-flex flex-row">
                        <div>
                            <i class="bi bi-clock"></i>
                            <span>Thời gian làm bài: {{$data["tests"]->duration}}</span>
                        </div>
                        <div class="mx-2">|</div>
                        <div>
                            <i class="bi bi-journals"></i>
                            <span>Số phần thi: {{$data["tests"]->testTemplate->num_of_part}} phần</span>
                        </div>
                        <div class="mx-2">|</div>
                        <div>
                            <i class="bi bi-question-circle"></i>
                            <span>Số câu hỏi: {{$data["tests"]->num_of_question}}</span>
                        </div>
                    </div>
                    <div class="test-prepare mt-4 mb-4">
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-circle"></i>
                            <div>
                                Bạn đã sẵn sàng làm bài thi ? Để đạt được kết quả tốt nhất , bạn cần dành ra {{$data["tests"]->duration}} phút cho đề thi này.
                            </div>
                        </div>
                        <a href="{{route('user.test.start',$data['tests']->id)}}" role="button" class="btn btn-primary rounded login-button">Bắt đầu thi</a>
                    </div>
                    <div class="test-info">
                        <h2>Thông tin đề thi</h2>
                        @foreach ($data["tests"]->testParts as $part)
                        <div class="test-part">
                            <h4>#{{$part->name}} ( {{ $part->num_of_question }} câu hỏi) </h4>
                            <p>{{$part->description}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-md-9 col-12 border shadow rounded bg-white">
                <div class="comment-block py-3">
                    <h4 class="fw-bold">Bình luận</h4>
                    <form action="" method="POST" class="d-flex flex-row justify-content-between mt-1">
                        <textarea name="" id="" rows="1" class="form-control ps-4" placeholder="Chia sẻ cảm nghĩ của bạn ..."></textarea>
                        <button type="submit" class="btn btn-primary login-button">Gửi</button>
                    </form>
                    <div class="comment-list mt-2">
                        <div class="fst-italic">
                            Chưa có bình luận nào. Hãy trở thành người đầu tiên bình luận bài này.
                        </div>
                        <div class="comment-user d-flex flex-row">
                            <div class="user-ava">
                                <i class="bi bi-person-circle avatar-icon c-gray"></i>
                            </div>
                            <div class="user-content px-3">
                                <div>
                                    <strong>Adam Johnson</strong> , Dec. 11,2022
                                </div>
                                <div>
                                    Mọi người cho mình hỏi cách triển khai ý cho bài writing task 2 nhanh và logic được không ạ? Thường mọi người áp dụng cách nào share mình với ạ
                                </div>
                            </div>
                            <div class="user-option">
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-light p-2 no-hover" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Xoá bình luận</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection