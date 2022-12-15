@extends('user.layouts.app')

@section('content')

<div class="d-flex flex-column py-3 px-2">
    <div class="start-tittle d-flex flex-row justify-content-center align-items-center ">
        <h3 class="m-0">{{$data["tests"]->name}}</h3>
        <a role="button" class="btn btn-outline-primary cs-light-btn ms-2" href="{{ route('user.test.show',$data['tests']->id) }}">Thoát</a>
    </div>
    <div class="start-template d-flex flex-row justify-content-center mt-2">
        <h4>Bộ đề thi : {{$data["tests"]->testTemplate->name}}</h4>
    </div>
    <form class="test-container d-flex flex-row" id="submit-test" action="{{route('user.test.submit',$data['tests']->id)}}" method="POST">
        @csrf
        <input class="d-none" type="number" name="test_id" value="{{$data['tests']->id}}">
        <input class="d-none" type="number" name="user_id" value="{{Auth::user()->id}}">
        <input class="d-none" type="text" name="type" value="{{$data['tests']->type}}">
        <div class="test-content d-flex flex-column w-85 border rounded shadow me-4 py-3 px-3 bg-white">
            @if ($data["tests"]->testTemplate->have_audio_file == 1)
            <audio controls class="w-90 mx-auto mb-4">
                <source src="{{asset('storage/'.$data['tests']->audio_file)}}" type="audio/mpeg">
            </audio>
            @endif
            <div class="part-nav" id="nav-top">
                @foreach ($data['tests']->testParts as $part )
                <button type="button" class="btn btn-outline-primary rounded-pill part-button top" part="{{$part->order_in_test}}">{{$part->name}}</button>
                @endforeach
            </div>
            @foreach ($data['tests']->testParts as $part )
            <input class="d-none" type="text" name="parts[{{$part->order_in_test}}][order_in_test]" value="{{ $part->order_in_test }}">
            @if ($part->have_cluster == 1)
            <div class="part-block mt-3" partorder="{{$part->order_in_test}}">
                
                @foreach ($part->testCluster as $cluster )
                <div class="cluster-block border-top mb-3">
                    <!-- <div class="fw-bold">{{$cluster->question_begin}}-{{$cluster->question_end}}</div> -->
                    @if ($cluster->question)
                    <div class="cluster-question p-3">
                        {!! nl2br($cluster->question) !!}
                    </div>
                    @endif
                    @foreach ($cluster->testQuestion as $question)
                    <div class="question-block mt-2 ms-2">
                        <div class="d-flex flex-row">
                            <div class="content d-flex flex-column w-100">

                                @if ($part->have_attachment == 1 && $question->attachment != null)
                                <div class="question-attachment d-flex">
                                    <img src="{{asset('storage/'.$question->attachment)}}" alt="" class="question-image m-auto">
                                </div>
                                @endif
                                <div class="d-flex">
                                    <div class="question-order" question="{{$question->id}}">
                                        <strong class="qid-click" question="{{$question->id}}">{!! $question->order_in_test !!}</strong>
                                    </div>
                                    <fieldset id="{{$question->id}}" class="w-100 ms-4" belongto="{{$part->order_in_test}}">
                                        @if ($part->have_question == 1)
                                        <div class="question-question mb-1">
                                            {!! $question->question !!}
                                        </div>
                                        @endif
                                        <div class="d-flex flex-column justify-content-between">
                                            <input class="d-none" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-none" value="none" checked="checked">
                                            <input class="d-none" type="number" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][id]" value="{{$question->id}}">
                                            <input class="d-none" type="text" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][answer]" value="{{$question->answer}}">
                                            <input class="d-none" type="text" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][type]" value="{{$part->type}}">
                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-A" value="A">
                                                <label class="form-check-label" for="questions-{{$question->id}}-A">
                                                    {!! $question->option_1 !!}
                                                </label>
                                            </div>
                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-B" value="B">
                                                <label class="form-check-label" for="questions-{{$question->id}}-B">
                                                    {!! $question->option_2 !!}
                                                </label>
                                            </div>

                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-C" value="C">
                                                <label class="form-check-label" for="questions-{{$question->id}}-C">
                                                    {!! $question->option_3 !!}
                                                </label>
                                            </div>
                                            @if ($part->num_of_answer == 4)
                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-D" value="D">
                                                <label class="form-check-label" for="questions-{{$question->id}}-D">
                                                    {!! $question->option_4 !!}
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </fieldset>
                                </div>
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
                <div class="question-block my-2 ms-2 mb-4">
                    <div class="d-flex flex-row">
                        <div class="content d-flex flex-column w-100">

                            @if ($part->have_attachment == 1 && $question->attachment != null)
                            <div class="question-attachment d-flex">
                                <img src="{{asset('storage/'.$question->attachment)}}" alt="" class="question-image ms-3">
                            </div>
                            @endif
                            <div class="d-flex mt-4">
                                <div class="question-order">
                                    <strong class="qid-click" question="{{$question->id}}">{!! $question->order_in_test !!}</strong>
                                </div>
                                <fieldset id="{{$question->id}}" class="w-100 ms-4" belongto="{{$part->order_in_test}}">
                                    @if ($part->have_question == 1)
                                    <div class="question-question mb-1">
                                        {!! $question->question !!}
                                    </div>
                                    @endif
                                    <div class="d-flex flex-column justify-content-between">
                                        <input class="d-none" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-none" value="none" checked="checked">
                                        <input class="d-none" type="number" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][id]" value="{{$question->id}}">
                                        <input class="d-none" type="text" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][answer]" value="{{$question->answer}}">
                                        <input class="d-none" type="text" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][type]" value="{{$question->type}}">
                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-A" value="A">
                                            <label class="form-check-label" for="questions-{{$question->id}}-A">
                                                {!! $question->option_1 !!}
                                            </label>
                                        </div>
                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-B" value="B">
                                            <label class="form-check-label" for="questions-{{$question->id}}-B">
                                                {!! $question->option_2 !!}
                                            </label>
                                        </div>

                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-C" value="C">
                                            <label class="form-check-label" for="questions-{{$question->id}}-C">
                                                {!! $question->option_3 !!}
                                            </label>
                                        </div>
                                        @if ($part->num_of_answer == 4)
                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="parts[{{$part->order_in_test}}][questions][{{$question->id}}][select]" id="questions-{{$question->id}}-D" value="D">
                                            <label class="form-check-label" for="questions-{{$question->id}}-D">
                                                {!! $question->option_4 !!}
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                </fieldset>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @endforeach
            <div class="part-nav">
                @foreach ($data['tests']->testParts as $part )
                <button type="button" class="btn btn-outline-primary rounded-pill part-button bot" part="{{$part->order_in_test}}">{{$part->name}}</button>
                @endforeach
            </div>
        </div>
        <div class="d-flex flex-column w-15 border rounded shadow bg-white h-fit-content">
            <div class="test-nav h-fit-content p-3 d-flex flex-column">
                <div class="test-nav-scroll d-flex flex-column">
                    @if ($data["tests"]->type != "parttest")
                    <div>
                        Thời gian còn lại:
                    </div>
                    <div class="duration time-left" id="duration" duration="{{$data['tests']->duration}}">
                        {{$data['tests']->duration}}
                    </div>
                    @endif
                    <input class="d-none" type="text" name="duration" id="test-duration" mdone="0" sdone="0" value="">
                    <input class="d-none" type="text" name="total_question" value="{{$data['tests']->num_of_question}}">
                    <button type="submit" id="button-submit-test" form="submit-test" class="btn btn-outline-primary cs-light-btn w-100 mb-3">Nộp bài</button>
                    <div>
                        <p class="text-warning">
                            <i>
                                <b>Chú ý: bạn có thể click vào số thứ tự câu hỏi trong bài để đánh dấu review</b>
                            </i>
                        </p>
                    </div>

                    @foreach ($data['tests']->testParts as $part )
                    <div class="d-flex flex-column w-100">
                        <div class="menu-name fw-bold">{{$part->name}}</div>
                        <div class="d-flex flex-row flex-wrap">
                            @foreach ($part->testQuestions as $question)
                            <button type="button" class="btn question-check" question="{{$question->id}}">{{$question->order_in_test}}</button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </form>
</div>

<script type="module">
    $(document).ready(function() {
        let duration = parseInt($('#duration').attr("duration")) * 60;
        let initTime = parseInt($('#duration').attr("duration")) * 60;
        let min = Math.floor(initTime / 60);
        let sec = initTime % 60;
        let mdone = parseInt($("#test-duration").attr("mdone"));
        let sdone = parseInt($("#test-duration").attr("sdone"));;
        let countdown = setInterval(() => {
            min = Math.floor(initTime / 60);
            sec = initTime % 60;
            let processNumber = (x) => {
                if (x < 10) return ("0" + x).slice(-2);
                return x;
            }
            let timeleft = duration - initTime;

            $("#duration").text(processNumber(min) + ":" + processNumber(sec));
            $("#test-duration").val(processNumber(Math.floor(timeleft / 60)) + ":" + processNumber(timeleft % 60));
            initTime -= 1;
            if (initTime == 0) {
                $("#button-submit-test").click();
            }
        }, 1000);

        $("div.part-block").each((i, item) => {
            if ($(item).attr('partorder') != 1) {
                $(item).addClass('d-none');
            }
        });

        $(".part-button[part='1']").toggleClass("active");

        $(".part-button").click((e) => {
            let partSelected = $(e.target).attr("part");
            console.log($(e.target).attr("part"));
            $('.part-block').each((i, item) => {
                $(item).addClass('d-none');
            });
            $("div.part-block[partorder=" + partSelected + "]").toggleClass('d-none');
            $('.part-button').each((i, item) => {
                $(item).removeClass("active");
            });
            $(".part-button[part=" + partSelected + "]").addClass("active");
            $('html, body').animate({
                scrollTop: $("#nav-top").offset().top
            }, 1000);
        });

        $(".form-check-input").click((e) => {
            let questionID = $(e.target).closest('fieldset').attr('id');
            $(".question-check[question=" + questionID + "]").addClass("done");
        });
        $(".qid-click").click((e) => {
            let questionID = $(e.target).attr('question');
            $(".question-check[question=" + questionID + "]").toggleClass("mark");
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