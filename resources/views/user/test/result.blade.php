@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12 border shadow rounded bg-white">
                <div class="test-container-block p-2">
                    <h1 class="fw-bolder">Kết quả thi: {{$data["tests"]->name}}</h1>
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
                    <div class="d-flex flex-row mt-3">
                        <div class="row w-100">
                            <div class="col-md-4">
                                <div class="d-flex flex-column p-3 border rounded bg-gray-custom">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="me-1 d-flex">
                                            <i class="bi bi-check-lg"></i>
                                            <p class="ms-2 me-1 d-inline-block">
                                                Kết quả làm bài:
                                            </p>
                                        </div>
                                        <div>
                                            {{ $data["result"]->right_question }}/{{ $data["result"]->total_question }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="me-1 d-flex">
                                            <i class="bi bi-clock"></i>
                                            <p class="ms-2 me-1 d-inline-block">
                                                Thời gian hoàn thành:
                                            </p>
                                        </div>
                                        <div>
                                            {{ $data["result"]->duration}}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="me-1 d-flex">
                                            <i class="bi bi-journal-check"></i>
                                            <p class="ms-2 me-1 d-inline-block">
                                                Điểm bài thi:
                                            </p>
                                        </div>
                                        <div>
                                            {{ $data["result"]->right_question }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="w-100 d-flex justify-content-end">
                                    <div class="w-30 h-100 ">
                                        <div class="result-question-container p-3 border rounded d-flex flex-column align-items-center h-100">
                                            <div>
                                                <i class="bi bi-check-circle-fill fs-2 txt-green "></i>
                                            </div>
                                            <h4 class="text-center txt-green">Trả lời đúng</h4>
                                            <h2>
                                                {{ $data["result"]->right_question }}
                                            </h2>
                                            <h6 class="text-center">câu hỏi</h6>
                                        </div>
                                    </div>
                                    <div class="w-30 h-100 ms-3">
                                        <div class="result-question-container p-3 border rounded d-flex flex-column align-items-center h-100">
                                            <div>
                                                <i class="bi bi-x-circle-fill fs-2 txt-red "></i>
                                            </div>
                                            <h4 class="text-center txt-red">Trả lời sai</h4>
                                            <h2>
                                                {{ $data["result"]->wrong_question }}
                                            </h2>
                                            <h6 class="text-center">câu hỏi</h6>
                                        </div>
                                    </div>
                                    <div class="w-30 h-100 ms-3">
                                        <div class="result-question-container p-3 border rounded d-flex flex-column align-items-center h-100">
                                            <div>
                                                <i class="bi bi-dash-circle-fill fs-2 txt-gray"></i>
                                            </div>
                                            <h4 class="text-center txt-grey">Bỏ qua</h4>
                                            <h2>
                                                {{ $data["result"]->empty_question }}
                                            </h2>
                                            <h6 class="text-center">câu hỏi</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="test-prepare mt-4 mb-4">
                        <a href="{{route('user.test.detail',[$data['tests']->id,$data['result']->id])}}" role="button" class="btn btn-primary rounded login-button">Xem kết quả chi tiết</a>
                        <a href="{{route('user.test.start',$data['tests']->id)}}" role="button" class="btn btn-primary rounded login-button">Làm lại bài thi</a>
                    </div>
                    <div class="test-info">
                        <h2>Đáp án</h2>
                        @foreach ($data["parts"] as $part)
                        <div class="test-part my-3">
                            <h4>#{{$part["name"]}}</h4>
                            <div class="column-2">
                                @foreach ($part["questions"] as $question)
                                <div class="d-flex align-items-center my-2">
                                    <div class="question-order">
                                        <strong class="qid-click">{!! $question["order_in_test"] !!}</strong>
                                    </div>
                                    <div class="d-flex ms-2 align-items-center">
                                        <span>{{ $question["answer"] }}</span>
                                        <div class="mx-2">:</div>
                                        @if ($question["status"] == "none")
                                        <span>Chưa trả lời</span>
                                        @elseif ($question["status"] == "right")
                                        <span>{{ $question["select"] }}</span>
                                        <i class="bi bi-check txt-green fs-4"></i>
                                        @else
                                        <span class="text-decoration-line-through">{{ $question["select"] }}</span>
                                        <i class="bi bi-x txt-red fs-4"></i>
                                        @endif

                                    </div>
                                </div>
                                @endforeach
                            </div>
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
                    @guest
                    <div>
                        <p>Vui lòng <a href="{{route('user.login')}}" class="text-decoration-none">đăng nhập</a> để bình luận.</p>
                    </div>
                    @endguest
                    @auth
                    <form action="{{route('user.test.comment',$data['tests']->id)}}" method="POST" class="d-flex flex-row justify-content-between mt-1">
                        @csrf
                        <input type="number" class="d-none" name="comment_set_id" value="{{$data['tests']->comment_set_id}}">
                        <input type="number" class="d-none" name="user_id" value="{{Auth::user()->id}}">
                        <textarea name="comment" id="" rows="1" class="form-control ps-4" placeholder="Chia sẻ cảm nghĩ của bạn ..."></textarea>
                        <button type="submit" class="btn btn-primary login-button">Gửi</button>
                    </form>
                    @endauth
                    <div class="comment-list mt-2">
                        @if ($data["num_of_comments"] == 0)
                        <div class="fst-italic">
                            Chưa có bình luận nào. Hãy trở thành người đầu tiên bình luận bài này.
                        </div>
                        @else
                        @foreach ($data["comments"] as $comment)
                        <div class="comment-user d-flex flex-row w-100 justify-content-between my-2">
                            <div class="d-flex">
                                <div class="user-ava">
                                    <i class="bi bi-person-circle avatar-icon c-gray"></i>
                                </div>
                                <div class="user-content px-3">
                                    <div>
                                        <strong>{{$comment->user->name}}</strong> , {{$comment->created_at->format("F j, Y, g:i a") }}
                                    </div>
                                    <div>
                                        {!! nl2br($comment->comment) !!}
                                    </div>
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
                        @endforeach
                        @endif
                        <div class="my-2">
                            {{ $data["comments"]->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection