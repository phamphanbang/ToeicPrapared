@extends('user.layouts.app')

@section('content')

<div class="d-flex flex-column py-3 px-2">
    <div class="start-tittle d-flex flex-row justify-content-center align-items-center ">
        <h3 class="m-0">{{$data["tests"]->name}}</h3>
        <a role="button" href="{{route('user.test.result',[$data['tests']->id,$data['result']->id])}}" class="btn btn-outline-primary cs-light-btn ms-2">Quay trở lại</a>
    </div>
    <div class="start-template d-flex flex-row justify-content-center mt-2">
        <h4>Bộ đề thi : {{$data["tests"]->testTemplate->name}}</h4>
    </div>
    <form class="test-container d-flex flex-row" id="submit-test" action="{{route('user.test.submit',$data['tests']->id)}}" method="POST">
        @csrf
        <input class="d-none" type="number" name="test_id" value="{{$data['tests']->id}}">
        <input class="d-none" type="number" name="user_id" value="{{Auth::user()->id}}">
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
            @foreach ($data["parts"] as $part )
            @if ($part['have_cluster'] == 1)
            <div class="part-block mt-3" partorder="{{$part['order_in_test']}}">
                <h3>{{$part['name']}}</h3>
                @foreach ($part["clusters"] as $cluster )
                <div class="cluster-block border-top mb-3">
                    @if ($cluster['question'])
                    <div class="cluster-question p-3">
                        {!! nl2br($cluster['question']) !!}
                    </div>
                    @endif
                    @if ($cluster['attachment'])
                    <div class="cluster-attachment">
                        <img src="{{asset('storage/'.$cluste['attachment'])}}" alt="">
                    </div>
                    @endif
                    @foreach ($cluster['questions'] as $question)
                    <div class="question-block mt-2 ms-2" qselect="{{$question['select']}}" qanswer="{{$question['answer']}}" qid="{{ $question['id'] }}">
                        <div class="d-flex flex-row">
                            <div class="content d-flex flex-column w-100">

                                @if ($part['have_attachment'] == 1)
                                <div class="question-attachment d-flex">
                                    <img src="{{asset('storage/'.$question['attachment'])}}" alt="" class="question-image m-auto">
                                </div>
                                @endif
                                <div class="d-flex">
                                    <div class="question-order" question="{{$question['id']}}">
                                        <strong class="qid-click" question="{{$question['id']}}">{!! $question['order_in_test'] !!}</strong>
                                    </div>
                                    <fieldset id="{{$question['id']}}" class="w-100 ms-4" belongto="{{$part['order_in_test']}}">
                                        @if ($part['have_question'] == 1)
                                        <div class="question-question mb-1">
                                            {!! $question['question'] !!}
                                        </div>
                                        @endif
                                        <div class="d-flex flex-column justify-content-between">
                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-A" value="A">
                                                <label for="questions-{{$question['id']}}-A">
                                                    {!! $question['option_1'] !!}
                                                </label>
                                            </div>
                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-B" value="B">
                                                <label for="questions-{{$question['id']}}-B">
                                                    {!! $question['option_2'] !!}
                                                </label>
                                            </div>

                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-C" value="C">
                                                <label for="questions-{{$question['id']}}-C">
                                                    {!! $question['option_3'] !!}
                                                </label>
                                            </div>
                                            @if ($part['num_of_answer'] == 4)
                                            <div class="form-check w-40">
                                                <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-D" value="D">
                                                <label for="questions-{{$question['id']}}-D">
                                                    {!! $question['option_4'] !!}
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                        @if ($question["status"] != "right")
                                        <div>
                                            <p class="right-answer">Đáp án đúng: {{ $question["answer"] }}</p>
                                        </div>
                                        @endif
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
            <div class="part-block mt-3" partorder="{{$part['order_in_test']}}">
                @foreach ($part["questions"] as $question)
                <div class="question-block my-2 ms-2 mb-4" qselect="{{$question['select']}}" qanswer="{{$question['answer']}}" qid="{{ $question['id'] }}">
                    <div class="d-flex flex-row">
                        <div class="content d-flex flex-column w-100">

                            @if ($part['have_attachment'] == 1)
                            <div class="question-attachment d-flex">
                                <img src="{{asset('storage/'.$question['attachment'])}}" alt="" class="question-image ms-3">
                            </div>
                            @endif
                            <div class="d-flex mt-4">
                                <div class="question-order">
                                    <strong class="qid-click" question="{{$question['id']}}">{!! $question['order_in_test'] !!}</strong>
                                </div>
                                <fieldset id="{{$question['id']}}" class="w-100 ms-4" belongto="{{$part['order_in_test']}}">
                                    @if ($part['have_question'] == 1)
                                    <div class="question-question mb-1">
                                        {!! $question->question !!}
                                    </div>
                                    @endif
                                    <div class="d-flex flex-column justify-content-between">
                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-A" value="A">
                                            <label for="questions-{{$question['id']}}-A">
                                                {!! $question['option_1'] !!}
                                            </label>
                                        </div>
                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-B" value="B">
                                            <label for="questions-{{$question['id']}}-B">
                                                {!! $question['option_2'] !!}
                                            </label>
                                        </div>

                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-C" value="C">
                                            <label for="questions-{{$question['id']}}-C">
                                                {!! $question['option_3'] !!}
                                            </label>
                                        </div>
                                        @if ($part['num_of_answer'] == 4)
                                        <div class="form-check w-40">
                                            <input class="form-check-input" type="radio" name="questions[{{$question['id']}}][select]" disabled id="questions-{{$question['id']}}-D" value="D">
                                            <label for="questions-{{$question['id']}}-D">
                                                {!! $question['option_4'] !!}
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                    @if ($question["status"] != "right")
                                    <div>
                                        <p class="right-answer">Đáp án đúng: {{ $question["answer"] }}</p>
                                    </div>
                                    @endif
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
                    <div>
                        Thời gian hoàn thành:
                    </div>
                    <div class="duration time-left" id="duration" duration="{{$data['tests']->duration}}">
                        {{$data['result']->duration}}
                    </div>
                    <input class="d-none" type="text" name="duration" id="test-duration" mdone="0" sdone="0" value="">
                    <input class="d-none" type="text" name="total_question" value="{{$data['tests']->num_of_question}}">
                    <!-- <button type="submit" id="button-submit-test" form="submit-test" class="btn btn-outline-primary cs-light-btn w-100 mb-3">Nộp bài</button> -->
                    <!-- <div>
                        <p class="text-warning">
                            <i>
                                <b>Chú ý: bạn có thể click vào số thứ tự câu hỏi trong bài để đánh dấu review</b>
                            </i>
                        </p>
                    </div> -->

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

        // $(".form-check-input").click((e) => {
        //     let questionID = $(e.target).closest('fieldset').attr('id');
        //     $(".question-check[question=" + questionID + "]").addClass("done");
        // });
        // $(".qid-click").click((e) => {
        //     let questionID = $(e.target).attr('question');
        //     $(".question-check[question=" + questionID + "]").toggleClass("mark");
        // });

        $(".question-block").each((i, item) => {
            let answer = $(item).attr("qanswer");
            let qid = $(item).attr("qid");
            let select = $(item).attr("qselect");
            let status = "";
            if (select == "none") status = "none";
            else {
                status = answer == select ? "right" : "wrong";
            }
            const choice = {
                right: "result-right",
                wrong: "result-wrong",
                none: "result-none"
            };
            let color = choice[status];
            if (status != "none") {
                $("#questions-" + qid + "-" + select).attr("checked", true);
                $("#questions-" + qid + "-" + select).addClass("radio-gray");
                $("#questions-" + qid + "-" + select).parent("div").addClass(color);
            }

            $("button[question="+qid +" ]").addClass(color);

        })

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