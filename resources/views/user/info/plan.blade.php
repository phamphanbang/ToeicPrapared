@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2 position-relative">
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
                            <a href="{{route('user.info.password',$data['user']->id)}}" class="text-decoration-none px-2 py-3 ">Thay đổi mật khẩu</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.history',$data['user']->id)}}" class="text-decoration-none px-2 py-3 ">Kết quả luyện thi</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.plan',$data['user']->id)}}" class="text-decoration-none px-2 py-3 active">Kế hoạch rèn luyện</a>
                        </li>
                    </ul>
                    @if ($data["plan"] == null)
                    <h2 class="fw-bold">Tạo kế hoạch rèn luyện mới</h2>
                    <p class="">
                        Chức năng này cho phép bạn tạo kế hoạch rèn luyện cho bản thân.Bạn có thể nhập trình độ TOEIC hiện tại của bạn , điểm mục tiêu muốn hướng tới , hạn cuối để đạt điểm mục tiêu và phần cần luyện tập.
                        Nếu bạn đã làm đề thi <b>Full Test</b>, trình độ hiện tại sẽ được cập nhật tự động .
                        Nếu bạn chưa làm đề thi nào , bạn có thể nhập vào trình độ hiện tại theo đánh giá của bản thân hoặc làm đề thi <b>Full Test</b> <a href="{{route('user.test.type','fulltest')}}" class="text-decoration-none fw-bold">tại đây</a>
                        Tại trang chủ bạn sẽ nhận được các đề thi <b>Part Test</b> được hệ thống khuyến khích bạn luyện tập để nâng cao trình độ hiện tại.
                    </p>
                    <form class="display-inline-block float-right w-80 mx-auto" method="POST" action="{{route('user.info.plan.create',$data['user']->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="current_score" class="form-label">Trình độ hiện tại</label>
                            <input type="number" class="form-control" id="current_score" name="current_score" min="0" max="990" required>
                        </div>
                        <div class="mb-4">
                            <label for="goal_score" class="form-label">Mục tiêu cần đạt</label>
                            <input type="number" class="form-control" id="goal_score" name="goal_score" min="0" max="990" required>
                        </div>
                        <div class="mb-4">
                            <label for="date_end" class="form-label">Hạn cuối để đạt điểm mục tiêu</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" min="{!! date('Y-m-d') !!}" required>
                        </div>
                        <div class="mb-4">
                            <label for="part_suggestion" class="form-label">Phần cần luyện tập</label>
                            <select class="form-select" aria-label="Default" name="part_suggestion" id="part_suggestion">
                                <option value="1" selected>Part 1</option>
                                <option value="2">Part 2</option>
                                <option value="3">Part 3</option>
                                <option value="4">Part 4</option>
                                <option value="5">Part 5</option>
                                <option value="6">Part 6</option>
                                <option value="7">Part 7</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-pencil-square pe-2"></i>
                                Tạo mới
                            </button>
                        </div>

                    </form>
                    @else
                    <h2 class="fw-bold">Cập nhật kế hoạch rèn luyện</h2>
                    <p class="">
                        Chức năng này cho phép bạn tạo kế hoạch rèn luyện cho bản thân.Bạn có thể nhập trình độ TOEIC hiện tại của bạn , điểm mục tiêu muốn hướng tới , hạn cuối để đạt điểm mục tiêu và phần cần luyện tập.
                        Nếu bạn đã làm đề thi <b>Full Test</b>, trình độ hiện tại sẽ được cập nhật tự động .
                        Nếu bạn chưa làm đề thi nào , bạn có thể nhập vào trình độ hiện tại theo đánh giá của bản thân hoặc làm đề thi <b>Full Test</b> <a href="{{route('user.test.type','fulltest')}}" class="text-decoration-none fw-bold">tại đây</a>.
                        Tại trang chủ bạn sẽ nhận được các đề thi <b>Part Test</b> được hệ thống khuyến khích bạn luyện tập để nâng cao trình độ hiện tại.
                    </p>
                    <form class="display-inline-block float-right w-80 mx-auto" method="POST" action="{{route('user.info.plan.update',[$data['user']->id,$data['plan']->id])}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="current_score" class="form-label">Trình độ hiện tại</label>
                            <input type="number" class="form-control" id="current_score" name="current_score" min="0" max="990" required value="{{$data['plan']->current_score}}">
                        </div>
                        <div class="mb-4">
                            <label for="goal_score" class="form-label">Mục tiêu cần đạt</label>
                            <input type="number" class="form-control" id="goal_score" name="goal_score" min="0" max="990" required value="{{$data['plan']->goal_score}}">
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">Trạng thái</label>
                            <input type="text" class="form-control" id="status" name="status" value="{{$data['plan']->status}}" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="date_end" class="form-label">Hạn cuối để đạt điểm mục tiêu</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" min="{!! date('Y-m-d') !!}" required value="{{$data['plan']->date_end}}">
                        </div>
                        <div class="mb-4">
                            <label for="part_suggestion" class="form-label">Phần cần luyện tập</label>
                            <select class="form-select" aria-label="Default" name="part_suggestion" id="part_suggestion" svalue="{{$data['plan']->part_suggestion}}">
                                <option value="1">Part 1</option>
                                <option value="2">Part 2</option>
                                <option value="3">Part 3</option>
                                <option value="4">Part 4</option>
                                <option value="5">Part 5</option>
                                <option value="6">Part 6</option>
                                <option value="7">Part 7</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-pencil-square pe-2"></i>
                                Lưu thay đổi
                            </button>
                        </div>

                    </form>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>

<script type="module">
    $(document).ready(() => {
        let pg = $("#part_suggestion").attr("svalue");
        $("#part_suggestion select[value='" + pg + "']").attr("selected", true);

        const message = {
            ongoing: "Đang thực hiện",
            success: "Đã hoàn thành",
            fail: "Không hoàn thành"
        }

        let status = $("#status").val();
        $("#status").val(message[status]);

    })
</script>

@endsection