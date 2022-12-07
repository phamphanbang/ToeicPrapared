@extends('user.layouts.app')

@section('content')
<div class="home-section p-2">
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
</div>

<div class="home-section my-4">
    <div class="container">
        <h2 class="home-h2 text-center fw-bold">Đề thi FULL TEST mới nhất</h2>
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