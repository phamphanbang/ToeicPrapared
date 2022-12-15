@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12 border shadow rounded bg-white">
                <div class="test-container-block p-2">
                    <h1 class="fw-bolder">{{$data["tests"]->name}}</h1>
                    <div>
                        <span><strong>Bộ đề thi: {{$data["tests"]->testTemplate->name }}</strong></span>
                    </div>
                    <div class="test-attr d-flex flex-row">
                        <div>
                            <i class="bi bi-clock"></i>
                            <span>Thời gian làm bài:
                                @if ($data["tests"]->type != "parttest")
                                {{$data["tests"]->duration}}
                                @else
                                Không giới hạn
                                @endif

                            </span>
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
                    @auth
                    @if ($data["histories_count"] > 0)
                    <div class="test-histories d-flex w-100 flex-column my-3">
                        <div>
                            <h3>Kết quả làm bài của bạn:</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Ngày làm bài</th>
                                    <th scope="col">Kết quả</th>
                                    <th scope="col">Thời gian làm bài</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data["histories"] as $history)
                                <tr>
                                    <th scope="row">{{$history->created_at->format("d/m/Y") }}</th>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div>
                                                {{ $history->right_question }}/{{ $history->total_question }}
                                                @if ($history->test->type == "fulltest")
                                                ( Điểm : {{$history->score}} )
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($data["tests"]->type != "parttest")
                                        {{$history->duration}}
                                        @else
                                        Không giới hạn
                                        @endif
                                    </td>
                                    <td><a href="{{route('user.test.result',[$data['tests']->id,$history->id])}}">Xem chi tiết</a></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if ($data["histories_count"] > 3)
                        <div>
                            <a href="{{route('user.info.history',Auth()::user()->id)}}">Xem tất cả >></a>
                        </div>
                        @endif
                    </div>
                    @endif

                    @endauth
                    <div class="test-prepare mt-4 mb-4">
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-circle"></i>
                            <div>
                                Bạn đã sẵn sàng làm bài thi ? Để đạt được kết quả tốt nhất , bạn cần dành ra {{$data["tests"]->duration}} phút cho đề thi này.
                            </div>
                        </div>
                        @guest
                        <div>
                            <p>Vui lòng <a href="{{route('user.login')}}" class="text-decoration-none">đăng nhập</a> để bắt đầu làm bài.</p>
                        </div>
                        @endguest
                        @auth
                        <a href="{{route('user.test.start',$data['tests']->id)}}" role="button" class="btn btn-primary rounded login-button">Bắt đầu thi</a>
                        @endauth
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