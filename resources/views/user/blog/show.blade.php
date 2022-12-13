@extends('user.layouts.app')

@section('content')

<div class="content-header mt-2">
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-md-9 col-12 border shadow rounded bg-white">
                <div class="test-container-block p-2">
                    <div class="mb-2 fs-6 d-flex">
                        <a href="{{route('user.blog.index')}}" class="text-decoration-none">Blog</a>
                        <i class="bi bi-chevron-right ms-2"></i>
                        <p class="ms-2 mb-1">{{$data["blog"]->name}}</p>
                    </div>
                    <h1 class="card-title display-inline-block my-2 fw-bold ">{{$data["blog"]->name}}</h1>
                    <p>Ngày đăng: {{ $data["blog"]->created_at->format("d/m/Y") }}</p>
                    <div class="w-100 my-3">
                        <img src="{{asset('storage/'.$data['blog']->banner)}}" class="w-100 banner-img" alt="">
                    </div>
                    <div class="cluster-question">
                        {!! nl2br($data["blog"]->glossary) !!}
                    </div>
                    <div class="mx-auto mb-3 border w-40">
                        <h4 class="text-center fw-bold">Mục lục</h4>
                        <div class="block-menu px-4">
                        </div>
                    </div>
                    <div class="block-content">
                        {!! $data["blog"]->blog !!}
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
                    <form action="{{route('user.blog.comment',$data['blog']->id)}}" method="POST" class="d-flex flex-row justify-content-between mt-1">
                        @csrf
                        <input type="number" class="d-none" name="comment_set_id" value="{{$data['blog']->comment_set_id}}">
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

<script type="module">
    $(document).ready(() => {
        $(".block-content").children("h2").each((i,item)=>{
            $(item).attr("id","tittle"+i);
            $(".block-menu").append("<a href='#"+"tittle"+i +"' class='text-decoration-none d-block'>" +$(item).text() + "</a>")
        });

        $(".block-content").find("td").each((i,item)=>{
            $(item).addClass("border ps-2 pt-2");
        });

    })


</script>

@endsection