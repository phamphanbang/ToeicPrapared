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
                            <a href="{{route('user.info.history',$data['user']->id)}}" class="text-decoration-none px-2 py-3 active">Kết quả luyện thi</a>
                        </li>
                        <li class="info-nav">
                            <a href="{{route('user.info.plan',$data['user']->id)}}" class="text-decoration-none px-2 py-3">Kế hoạch rèn luyện</a>
                        </li>
                    </ul>
                    @if ($data["histories_count"] == 0)
                    <div>
                        <p class="fst-italic">Bạn chưa làm đề thi nào cả.</p>
                    </div>
                    @else
                    @foreach ($data["histories"] as $history)
                    <div class="user-history w-100">
                        <h3 class="fw-bold">{{$history->test->name}}</h3>
                        <div class="w-100">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Ngày làm bài</th>
                                        <th scope="col">Kết quả </th>
                                        <th scope="col">Thời gian làm</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                        <td>@if ($history->test->type != "parttest")
                                            {{ $history->duration }}
                                            @else
                                            Không giới hạn
                                            @endif
                                        </td>
                                        <td><a href="{{route('user.test.result',[$history->test->id,$history->id])}}">Xem chi tiết</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <div>
                        {{ $data["histories"]->links("pagination::bootstrap-4") }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script type="module">



</script>

@endsection