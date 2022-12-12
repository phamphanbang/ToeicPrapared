@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12">
                <h1 class="mb-2">Thư viện đề thi</h1>
                <div class="test-type mb-2">
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn  {{ Request::is('test') ? 'cs-test-type-btn-active' : '' }} " href="{{route('user.test.index')}}" role="button">Tất cả</a>
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn  {{ Request::is('test/fulltest') ? 'cs-test-type-btn-active' : '' }}" href="{{route('user.test.type','fulltest')}}" role="button">Full Test</a>
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn  {{ Request::is('test/minitest') ? 'cs-test-type-btn-active' : '' }}" href="{{route('user.test.type','minitest')}}" role="button">Mini Test</a>
                    <a class="btn btn-outline-light rounded-pill cs-test-type-btn  {{ Request::is('test/parttest') ? 'cs-test-type-btn-active' : '' }}" href="{{route('user.test.type','parttest')}}" role="button">Part Test</a>
                </div>
                <form action="{{route('user.test.search')}}" method="POST">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-8">
                            <input type="text"  name="search" class="form-control" placeholder="Nhập từ khoá bạn muốn tìm kiếm" value="{{request('search')?request('search'):'' }}">
                        </div>
                        <div class="col-4">
                            <input type="text" id="by" name="by" class="d-none"  value="none">
                            <select id="search-by" class="form-select" request="{!! (!request()->has("by") || request('by') == "none" ) ? 'none':request('by')  !!}">
                                <option disabled {!! (!request()->has("by") || request('by') == "none" ) ? 'selected':''  !!} value="none">-- Chọn bộ đề thi --</option>
                                @foreach ($data["templates"] as $template)
                                <option value="{{$template->id}}" {!! request('by')==$template->id?'selected':'' !!}>{{$template->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary login-button">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mb-2 pt-4 border-top border-3">
        <div class="row justify-content-center mt-2">
            <div class="col-md-9 col-12">
                <div class="row">
                    @if ($data["tests"]->count() == 0)
                    <div>
                        <p class="fs-5 fst-italic">Không có đề thi nào trùng khớp với kết quả tìm kiếm của bạn.</p>
                    </div>
                    @else
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
                    @endif

                </div>
                <div>
                    {{ $data["tests"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>

</div>

<script type="module">
    $(document).ready(function() {
        $("#by").val($("#search-by").find(":selected").val());

       $("#search-by").change((e) => {
            $("#by").val($("#search-by").val());
       })
    });

</script>

@endsection