@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        <div class="admin-top-message">
            @error('name')
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $message }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            @error('email')
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $message }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            @error('password')
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $message }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
        </div>
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="mb-3 d-flex flex-row align-items-center">
                        <a class="btn btn-primary" href="{{url()->previous()}}" role="button">
                            <i class="bi bi-arrow-left pe-2"></i>
                            Back
                        </a>
                        <a class="btn btn-primary ms-auto" href="{{route('admin.test.edit',$data['test']->id)}}" role="button">
                            <i class="bi bi-pencil-square pe-2"></i>
                            Edit
                        </a>
                    </div>
                    <h3>{{$data['test']->name}}</h3>
                    <div class="d-flex flex-column w-100">
                        <audio controls>
                            <source src="{{asset('storage/'.$data['test']->audio_file)}}" type="audio/mpeg">
                        </audio>
                        <div class="main-test d-flex flex-row mt-2 w-100">
                            <div class="content d-flex flex-column w-100">
                                <div class="part-nav">
                                    @foreach ($data['test']->testParts as $part )
                                    <button type="button" class="btn btn-secondary part-button" part="{{$part->order_in_test}}">{{$part->name}}</button>
                                    @endforeach
                                </div>
                                <div class="part-test">
                                    @foreach ($data['test']->testParts as $part )
                                    @if ($part->have_cluster == 1)
                                    <div class="part-block mt-3" partorder="{{$part->order_in_test}}">
                                        <h3>{{$part->name}}</h3>
                                        @foreach ($part->testCluster as $cluster )
                                        <div class="cluster-block">
                                            <div class="fw-bold">{{$cluster->question_begin}}-{{$cluster->question_end}}</div>
                                            @if ($cluster->question)
                                            <div class="cluster-question">
                                                {!! nl2br($cluster->question) !!}
                                            </div>
                                            @endif
                                            @if ($cluster->attachment)
                                            <div class="cluster-attachment">
                                                <img src="{{asset('storage/'.$cluster->attachment)}}" alt="">
                                            </div>
                                            @endif
                                            @foreach ($cluster->testQuestion as $question)
                                            <div class="question-block mt-2 ms-2">
                                                <div class="d-flex flex-row">
                                                    <div class="fw-bold me-2">{!! $question->order_in_test !!}</div>
                                                    <div class="content d-flex flex-column w-100">
                                                        @if ($part->have_question == 1)
                                                        <div class="question-question">
                                                            {!! $question->question !!}
                                                        </div>
                                                        @endif
                                                        @if ($part->have_attachment == 1)
                                                        <div class="question-attachment d-flex">
                                                            <img src="{{asset('storage/'.$question->attachment)}}" alt="" class="question-image m-auto">
                                                        </div>
                                                        @endif
                                                        <fieldset id="{{$question->order_in_test}}" class="w-100" belongto="{{$part->order_in_test}}">
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="form-check w-40">
                                                                    <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                    <label class="form-check-label" for="">
                                                                        {!! $question->option_1 !!}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check w-40">
                                                                    <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                    <label class="form-check-label" for="">
                                                                        {!! $question->option_2 !!}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="form-check w-40">
                                                                    <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                    <label class="form-check-label" for="">
                                                                        {!! $question->option_3 !!}
                                                                    </label>
                                                                </div>
                                                                @if ($part->num_of_answer == 4)
                                                                <div class="form-check w-40">
                                                                    <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                    <label class="form-check-label" for="">
                                                                        {!! $question->option_4 !!}
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="part-block mt-3" partorder="{{$part->order_in_test}}">
                                        @foreach ($part->testQuestions as $question)
                                        <div class="question-block my-2 ms-2">
                                            <div class="d-flex flex-row">
                                                <div class="fw-bold me-2">{!! $question->order_in_test !!}</div>
                                                <div class="content d-flex flex-column w-100">
                                                    @if ($part->have_question == 1)
                                                    <div class="question-question">
                                                        {!! $question->question !!}
                                                    </div>
                                                    @endif
                                                    @if ($part->have_attachment == 1)
                                                    <div class="question-attachment d-flex">
                                                        <img src="{{asset('storage/'.$question->attachment)}}" alt="" class="question-image m-auto">
                                                    </div>
                                                    @endif
                                                    <fieldset id="{{$question->order_in_test}}" class="w-100" belongto="{{$part->order_in_test}}">
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <div class="form-check w-40">
                                                                <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                <label class="form-check-label" for="">
                                                                    {!! $question->option_1 !!}
                                                                </label>
                                                            </div>
                                                            <div class="form-check w-40">
                                                                <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                <label class="form-check-label" for="">
                                                                    {!! $question->option_2 !!}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <div class="form-check w-40">
                                                                <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                <label class="form-check-label" for="">
                                                                    {!! $question->option_3 !!}
                                                                </label>
                                                            </div>
                                                            @if ($part->num_of_answer == 4)
                                                            <div class="form-check w-40">
                                                                <input class="form-check-input" type="radio" name="{{$question->order_in_test}}" id="">
                                                                <label class="form-check-label" for="">
                                                                    {!! $question->option_4 !!}
                                                                </label>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="test-nav border p-2 h-fit-content ms-3 d-flex flex-column">
                                <div class="test-nav-scroll d-flex flex-column">
                                    <div class="duration" id="duration" duration="{{$data['test']->duration}}">
                                        {{$data['test']->duration}}
                                    </div>
                                    @foreach ($data['test']->testParts as $part )
                                    <div class="d-flex flex-column w-100">
                                        <div class="menu-name fw-bold">{{$part->name}}</div>
                                        <div class="d-flex flex-row flex-wrap">
                                            @foreach ($part->testQuestions as $question)
                                            <button type="button" class="question-check btn btn-secondary me-2 mt-2" question="{{$question->order_in_test}}">{{$question->order_in_test}}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success mt-3">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        let initTime = parseInt($('#duration').attr("duration")) * 60;
        let min = 0;
        let sec = 0;
        let countdown = setInterval(() => {
            min = Math.floor(initTime / 60);
            sec = initTime % 60;
            $("#duration").text(min + ":" + sec);
            initTime -= 1;
        }, 1000);

        $("div.part-block").each((i, item) => {
            if ($(item).attr('partorder') != 1) {
                $(item).addClass('d-none');
            }
        });

        $(".part-button[part='1']").toggleClass("btn-secondary btn-primary");

        $(".part-button").click((e) => {
            let partSelected = $(e.target).attr("part");
            console.log($(e.target).attr("part"));
            $('.part-block').each((i, item) => {
                $(item).addClass('d-none');
            });
            $("div.part-block[partorder=" + partSelected + "]").toggleClass('d-none');
            $('.part-button').each((i, item) => {
                $(item).addClass("btn-secondary");
                $(item).removeClass("btn-primary");
            });
            $(".part-button[part=" + partSelected + "]").addClass("btn-primary");
            $(".part-button[part=" + partSelected + "]").removeClass("btn-secondary");
        });

        $(".form-check-input").click((e) => {
            let questionID = $(e.target).closest('fieldset').attr('id');
            console.log($(".question-check[question=" + questionID + "]").attr('question'))
            $(".question-check[question=" + questionID + "]").addClass("btn-primary").removeClass("btn-secondary");
        });

        $(".question-check").click((e) => {
            let questionID = $(e.target).attr('question');
            let question = $("fieldset#" + questionID);
            let questionBlock = question.closest(".question-block");
            let part = question.attr("belongto");
            $('.part-button').each((i, item) => {
                $(item).addClass("btn-secondary");
                $(item).removeClass("btn-primary");
            });
            $('.part-block').each((i, item) => {
                $(item).addClass('d-none');
            });

            $("div.part-block[partorder=" + part + "]").toggleClass('d-none');
            $(".part-button[part=" + part + "]").addClass("btn-primary");
            $(".part-button[part=" + part + "]").removeClass("btn-secondary");

            questionBlock.addClass("question-highlight");

            $('html, body').animate({
                scrollTop: questionBlock.offset().top
            }, 2000);

            setTimeout(function() {
                questionBlock.removeClass("question-highlight");
            }, 3000);
        });
    });
</script>

@endsection