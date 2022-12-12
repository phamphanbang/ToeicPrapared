@extends('user.layouts.app')

@section('content')
<div class="home-section p-2">
    @guest
    <div class="panel-container p-3 d-flex align-items-center justify-content-center" style="background-image: url('/asset/images/bg-panel.png');">
        <div class="panel-content d-flex flex-column w-80">
            <div class="d-flex w-100 justify-content-center">
                <h1 class="panel-tittle">Thi thử TOEIC online 2022 miễn phí</h1>
            </div>
            <p class="panel-content">Chào mừng đến với TOEICAMP, trang web TOEIC miễn phí cung cấp cho người học các bài luyện tập theo từng part, đề thi thử . Bắt đầu hành trình chinh phục chứng chỉ TOEIC với các bài luyện tập trên trang web của chúng tôi ngay hôm nay!</p>
            <!-- <div class="panel-button-holder d-flex w-100 justify-content-center">
                <a class="btn btn-primary login-button rounded-pill ms-2" href="{{route('user.registration')}}" role="button">Đăng ký ngay tại đây</a>
            </div> -->
        </div>
    </div>
    @endguest
    @auth
    <div class="w-100 py-3 user-panel">
        <div class="d-flex flex-row justify-content-between w-100 align-items-center">
            <div class="ms-3">
                <h1 class="fw-bold text-blue">Xin chào , {{Auth::user()->name}}!</h1>
            </div>
            <div class="d-flex flex-row me-3">
                <div class="d-flex flex-column p-2 align-items-center">
                    <span class="text-blue">Điểm hiện tại</span>
                    <span class="fw-bold fs-3">100</span>
                </div>
                <div class="d-flex flex-column p-2 align-items-center">
                    <span class="text-blue">Điểm hiện tại</span>
                    <span class="fw-bold fs-3">100</span>
                </div>
                <div class="d-flex flex-column p-2 align-items-center">
                    <span class="text-blue">Điểm hiện tại</span>
                    <span class="fw-bold fs-3">100</span>
                </div>
                <div class="d-flex flex-column p-2 align-items-center">
                    <a role="button" class="btn btn-light no-hover">
                        <i class="bi bi-pen fw-bold fs-4 text-blue"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="ms-3">
                <h2 class="fw-bold text-blue">Kết quả luyện thi mới nhất</h2>
            </div>
            @if ($data["histories_count"] == 0)
            <div>
                <p class="ms-3 fst-italic">Bạn chưa làm đề nào cả.</p>
            </div>
            @else
            <div class="row w-80 px-3">
                @foreach ($data["histories"] as $history)
                <div class="col-md-3 px-2 py-1 mb-2">
                    <div class="item-wraper p-3 mb-1 d-flex flex-column justify-content-between border rounded">
                        <a href="{{route('user.test.result',[$history->test->id,$history->id])}}" class="no-text-deco">
                            <h3 class="text-wrap">{{$history->test->name}}</h3>
                            <div>
                                <span>{{$history->test->type}}</span>
                            </div>
                            <div>
                                <i class="bi bi-calendar"></i>
                                <span>Ngày làm bài: {{ $history->created_at->format("d/m/Y") }}</span>
                            </div>
                            <div>
                                <i class="bi bi-clock"></i>
                                <span>Thời gian làm bài: {{ $history->duration }}</span>
                            </div>
                            <div>
                                <i class="bi bi-journals"></i>
                                <span>Kết quả: {{ $history->right_question}}/{{ $history->total_question }}</span>
                            </div>
                            @if ($history->test->type == "fulltest")
                            <div>
                                <i class="bi bi-question-circle"></i>
                                <span>Điểm: {{ $history->right_question }}</span>
                            </div>
                            @endif

                        </a>
                        <a href="{{route('user.test.result',[$history->test->id,$history->id])}}" class="text-decoration-none">[Xem chi tiết]</a>

                    </div>
                </div>
                @endforeach
                <a href="#" class="text-decoration-none fs-5"> Xem tất cả >></a>
            </div>
            
            @endif
        </div>
    </div>
    @endauth
</div>

<div class="home-section my-4">
    <div class="container">
        <h2 class="home-h2 text-center fw-bold">Đề thi FULL TEST mới nhất</h2>
        <div class="d-flex flex-wrap m-0">
            @foreach ($data["tests"] as $test)
            <div class="col-md-3 px-2 py-1 mb-4">
                <div class="item-wraper p-3 mb-1 d-flex flex-column justify-content-between border rounded">
                    <a href="{{route('user.test.show',$test->id)}}" class="no-text-deco">
                        <h3 class="text-wrap">{{$test->name}}</h3>
                        <div>
                            <span>Bộ đề thi: {{ $test->testTemplate->name }}</span>
                        </div>
                        <div>
                            <i class="bi bi-clock"></i>
                            <span>Thời gian làm bài: {{ $test->duration }} phút</span>
                        </div>
                        <div>
                            <i class="bi bi-journals"></i>
                            <span>Số phần thi: {{ $test->testTemplate->num_of_part }} phần</span>
                        </div>
                        <div>
                            <i class="bi bi-question-circle"></i>
                            <span>Số câu hỏi: {{ $test->num_of_question }}</span>
                        </div>
                    </a>
                    <a href="{{route('user.test.show',$test->id)}}" class="btn btn-outline-primary cs-light-btn mt-2">Chi tiết</a>

                </div>

            </div>
            @endforeach


        </div>
    </div>
</div>

<div class="home-section my-4">
    <div class="container">
        <h2 class="home-h2 text-center fw-bold">Mô phỏng bài thi TOEIC</h2>
        <div class="d-flex flex-row justify-content-between">
            <div class="test-item-panel mini-panel">
                <div class="test-item-panel-main">
                    <div class="test-item-panel-main-title">
                        MINI TEST
                    </div>
                    <div class="test-item-panel-main-decs">
                        Làm bài mini test với số lượng câu hỏi và thời gian giảm một nửa so với bài thi thật
                    </div>
                </div>
                <div class="test-item-panel-function w-100 d-flex flex-row-reverse">
                    <a href="{{route('user.test.type','minitest')}}" role="button" class="btn btn-primary rounded login-button panel-button">Luyện tập</a>
                </div>
            </div>
            <div class="test-item-panel part-panel">
                <div class="test-item-panel-main">
                    <div class="test-item-panel-main-title">
                        PART TEST
                    </div>
                    <div class="test-item-panel-main-decs">
                        Làm bài part test với số lượng câu hỏi luyện tập theo từng phần giống trong đề thi thật
                    </div>
                </div>
                <div class="test-item-panel-function w-100 d-flex flex-row-reverse">
                    <a href="{{route('user.test.type','parttest')}}" role="button" class="btn btn-primary rounded login-button panel-button">Luyện tập</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="home-section my-4">
    <div class="container">
        <h2 class="home-h2 text-center fw-bold">Blog mới nhất</h2>
        <div class="d-flex flex-wrap m-0">
            <div class="col-md-3 px-2 py-1 mb-4">
                <div class="item-wraper p-3 mb-1 d-flex flex-column justify-content-between border">
                    <a href="#" class="no-text-deco">
                        <h3 class="text-wrap">ESL 2022 Test 1</h3>
                        <div>
                            <span>Bộ đề thi: ESL 2022</span>
                        </div>
                        <div>
                            <i class="bi bi-clock"></i>
                            <span>Thời gian làm bài: 120 phút</span>
                        </div>
                        <div>
                            <i class="bi bi-journals"></i>
                            <span>Số phần thi: 7 phần</span>
                        </div>
                        <div>
                            <i class="bi bi-question-circle"></i>
                            <span>Số câu hỏi: 200</span>
                        </div>
                    </a>
                    <a href="#" class="btn btn-outline-primary cs-light-btn mt-2">Chi tiết</a>

                </div>

            </div>

        </div>
    </div>
</div>


@endsection