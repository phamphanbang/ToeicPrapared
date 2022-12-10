@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12">
                <h1 class="mb-2">Thư viện đề thi</h1>
                <div class="test-type mb-2">
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn  cs-test-type-btn-active" href="#" role="button">Tất cả</a>
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn " href="#" role="button">Full Test</a>
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn " href="#" role="button">Mini Test</a>
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn " href="#" role="button">Part Test</a>
                </div>
                <form action="" method="get">
                    <div class="row mb-2">
                        <div class="col-8">
                            <input type="text" class="form-control" placeholder="Nhập từ khoá bạn muốn tìm kiếm">
                        </div>
                        <div class="col-4">
                            <select class="form-select">
                                <option disabled selected value="">-- Chọn bộ đề thi --</option>
                                @foreach ($data["templates"] as $template)
                                <option value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <button type="button" class="btn btn-primary login-button">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mb-2 pt-4 border-top">
        <div class="row justify-content-center mt-2">
            <div class="col-md-9 col-12">
                <div class="row">
                    @foreach ($data["tests"] as $test)
                    <div class="col-md-3 px-2 py-1 mb-4">
                        <div class="item-wraper p-3 mb-1 d-flex flex-column justify-content-between border">
                            <a href="{{route('user.test.show',$test->id)}}" class="no-text-deco">
                                <h3 class="text-wrap">{{$test->name}}</h3>
                                <div>
                                    <span>Bộ đề thi: {{$test->testTemplate->name}}</span>
                                </div>
                                <div>
                                    <i class="bi bi-clock"></i>
                                    <span>Thời gian làm bài: {{$test->duration}}</span>
                                </div>
                                <div>
                                    <i class="bi bi-journals"></i>
                                    <span>Số phần thi: {{$test->testTemplate->num_of_part}} phần</span>
                                </div>
                                <div>
                                    <i class="bi bi-question-circle"></i>
                                    <span>Số câu hỏi: {{$test->num_of_question}}</span>
                                </div>
                            </a>
                            <a href="{{route('user.test.show',$test->id)}}" class="btn btn-outline-primary cs-light-btn mt-2">Chi tiết</a>

                        </div>
                    </div>
                    @endforeach
                </div>
                <div >
                    {{ $data["tests"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection