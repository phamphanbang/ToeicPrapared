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
                    </div>
                    <h4 class="card-title display-inline-block">Edit test {{$data['test']->name}}</h4>
                    <div class="d-flex justify-content-start mt-3 align-items-center">

                        <button type="submit" form="create-test" class="btn btn-success d-block h-fit-content ms-auto">Update Test</button>
                    </div>
                    <form class="display-inline-block float-right w-100" id="create-test" method="POST" action="{{route('admin.test.update',$data['test']->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class=" mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$data['test']->name}}" required>
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class=" mb-4">
                            <label for="type" class="form-label">Test's Type</label>
                            <select name="type" id="type" class="form-select" disabled>
                                <option {!! $data['test']->type == 'fulltest' ? 'selected' : '' !!} value="fulltest">Full Test</option>
                                <option {!! $data['test']->type == 'minitest' ? 'selected' : '' !!} value="minitest">Mini Test</option>
                                <option {!! $data['test']->type == 'parttest' ? 'selected' : '' !!} value="parttest">Part Test</option>
                            </select>
                        </div>
                        <div class=" mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option {!! $data['test']->status == 1 ? "selected" : "" !!} value="public">Public</option>
                                <option {!! $data['test']->status == 0 ? "selected" : "" !!} value="onhold">On Hold</option>
                            </select>
                        </div>
                        <div class=" mb-4">
                            <label for="num_of_question" class="form-label">Total question</label>
                            <input type="number" class="form-control" id="num_of_question" name="num_of_question" value="{{$data['test']->num_of_question}}" readonly>
                        </div>
                        <div class=" mb-4">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="number" class="form-control" id="duration" name="duration" value="{{$data['test']->duration}}" readonly>
                        </div>
                        @if ($data['test_template']->have_score_range == '1')
                        <div class=" mb-4">
                            <label for="score_range" class="form-label">Score range</label>
                            <input type="number" class="form-control" id="score_range" name="score_range" value="{{$data['test']->score_range}}">
                        </div>
                        @endif

                        @if ($data['test_template']->have_audio_file == '1')
                        <div class="d-flex flex-column">
                            <audio controls>
                                <source src="{{asset('storage/'.$data['test']->audio_file)}}" type="audio/mpeg">
                            </audio>
                            <label for="audio_file" class="form-label">Upload new audio file</label>
                            <input type="file" class="form-control" id="audio_file" name="audio_file">
                        </div>
                        @endif

                        <div class="d-flex flex-row flex-wrap justify-content-start mt-3 part-nav-bar">
                            @foreach ($data['test']->testParts as $part)
                            <button type="button" class="btn btn-secondary me-3 mt-2 part-button" part="{{$part->order_in_test}}">{{$part->name}}</button>
                            @endforeach
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <!-- Loop each part -->
                            @foreach ($data['test']->testParts as $part)
                            <div class="d-flex flex-column p-3 border rounded mt-2 part-block" id="{{$part->order_in_test}}" question="{{$part->num_of_question}}">
                                <h2>{{$part->name}}</h2>
                                <!-- order_in_test -->
                                <input type="number" class="d-none" name="part[{{$part->order_in_test}}][id]" value="{{$part->id}}">
                                <!-- <input type="number" class="d-none" id="part[{{$part->order_in_test}}][order_in_test]" name="part[{{$part->order_in_test}}][order_in_test]" value="{{$part->order_in_test}}" readonly> -->
                                <input type="text" class="d-none" name="" value="{{$part->name}}" readonly>
                                <div class=" mb-4">
                                    <label class="form-label">Part description</label>
                                    <textarea type="number" class="form-control" readonly>{{trim($part->description)}}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="part[{{$part->order_in_test}}][type]" class="form-label">Part type</label>
                                    <select name="part[{{$part->order_in_test}}][fake_type]" id="part[{{$part->order_in_test}}][fake_cluster]" class="form-select" disabled>
                                        <option {!! $part->type == "reading" ? 'selected':'' !!} value="reading">Reading</option>
                                        <option {!! $part->type == "listening" ? 'selected':'' !!} value="listening">Listening</option>
                                    </select>
                                    <input type="text" class="d-none" id="part[{{$part->order_in_test}}][type]" name="part[{{$part->order_in_test}}][type]" value="{{$part->type}}" readonly>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="w-40">
                                        <label class="form-label">Total question</label>
                                        <input type="number" class="form-control" value="{{$part->num_of_question}}" readonly>
                                    </div>
                                    <div class="w-40">
                                        <label class="form-label">Total answer of each question</label>
                                        <input type="number" class="form-control" value="{{$part->num_of_answer}}" readonly>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="w-40">
                                        <label class="form-label">Part has cluster</label>
                                        <select class="form-select" disabled>
                                            <option {!! $part->have_cluster == 1 ? 'selected':'' !!} value="yes">Yes</option>
                                            <option {!! $part->have_cluster == 0 ? 'selected':'' !!} value="no">No</option>
                                        </select>
                                    </div>
                                    <!-- Part have question ?-->
                                    <div class="w-40">
                                        <label class="form-label">Question has content </label>
                                        <select class="form-select" disabled>
                                            <option {!! $part->have_question == 1 ? 'selected':'' !!} value="yes">Yes</option>
                                            <option {!! $part->have_question == 0 ? 'selected':'' !!} value="no">No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Part have cluster ? -->

                                <!-- Part have attachment ?-->
                                <div class="w-40">
                                    <label class="form-label">Question has attachment </label>
                                    <select class="form-select" disabled>
                                        <option {!! $part->have_question == 1 ? 'selected':'' !!} value="yes">Yes</option>
                                        <option {!! $part->have_question == 0 ? 'selected':'' !!} value="no">No</option>
                                    </select>
                                </div>
                                <div class="question-block">
                                    <!-- Part has cluster -->
                                    @if ($part->have_cluster == 1)
                                    <!-- Loop each cluster -->
                                    @foreach ($part->testCluster as $cluster)
                                    <div class="question-cluster d-flex flex-column p-3 border rounded mt-2">
                                        <div class="d-flex flex-row justify-content-between mb-2">
                                            <p class="cluster-id fw-bold">{{$cluster->question_begin}}-{{$cluster->question_end}}</p>
                                            <button type="button" class="btn btn-secondary btn-collapse float-end w-fit-content" status="Expand">Collapse</button>
                                        </div>
                                        <div class="collapsable">
                                            @if ($cluster->question != null)
                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$cluster->id}}][cluster_question]">Cluster question</label>
                                            <textarea class="form-control" rows="3" id="part[{{$part->order_in_test}}][cluster][{{$cluster->id}}][cluster_question]" name="part[{{$part->order_in_test}}][cluster][{{$cluster->id}}][cluster_question]" required>{!! $cluster->question !!}</textarea>
                                            @endif

                                            <input class="d-none " type="number" id="part[{{$part->order_in_test}}][cluster][{{$cluster->id}}][id]" name="part[{{$part->order_in_test}}][cluster][{{$cluster->id}}][id]" value="{{$cluster->id}}">

                                            @foreach ($cluster->testQuestion as $question)
                                            <div class="question have-cluster d-flex flex-column mt-4">
                                                <p class="question-id fw-bold">{{ $question->order_in_test }}.</p>
                                                
                                                <div class="d-flex flex-column w-100">
                                                    <input type="number" class="d-none" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][id]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][id]" value="{{$question->id}}">

                                                    @if ($part->have_question == 1)
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][question]">Question</label>
                                                    <textarea class="form-control" rows="3" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][question]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][question]" required>{!! $question->question !!}</textarea>
                                                    @endif

                                                    @if ($part->have_attachment == 1 && $question->attachment != null)
                                                    <img src="{{asset('storage/'.$question->attachment)}}" alt="" class="small-img m-auto">
                                                    
                                                    @endif
                                                    @if ($part->have_attachment == 1)
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][attachment]">Select new attachment</label>
                                                    <input class="form-control" type="file" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][attachment]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][attachment]" placeholder="Upload new image">
                                                    @endif
                                                    

                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div class="w-40">
                                                            <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_1]">Option 1</label>
                                                            <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_1]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_1]" value="{{ $question->option_1 }}" required>
                                                        </div>
                                                        <div class="w-40">
                                                            <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_2]">Option 2</label>
                                                            <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_2]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_2]" value="{{ $question->option_2 }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div class="w-40">
                                                            <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_3]">Option 3</label>
                                                            <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_3]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_3]" value="{{ $question->option_3 }}" required>
                                                        </div>
                                                        <div class="w-40">
                                                            @if ($part->num_of_answer == 4)
                                                            <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_4]">Option 4</label>
                                                            <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_4]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][option_4]" value="{{ $question->option_4 }}" required>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][answer]">Answer</label>
                                                    <select name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][answer]" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][answer]" class="form-select">
                                                        <option {!! $question->answer == "A" ? "selected":"" !!} value="A">A</option>
                                                        <option {!! $question->answer == "B" ? "selected":"" !!} value="B">B</option>
                                                        <option {!! $question->answer == "C" ? "selected":"" !!} value="C">C</option>
                                                        @if ($part->num_of_answer == 4)
                                                        <option {!! $question->answer == "D" ? "selected":"" !!} value="D">D</option>
                                                        @endif
                                                    </select>

                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][explanation]">Explanation</label>
                                                    <textarea class="form-control" rows="3" id="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][explanation]" name="part[{{ $part->order_in_test }}][cluster][{{ $cluster->id }}][question][{{$question->id}}][explanation]">{!! $question->explanation !!}</textarea>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @endforeach
                                    @else
                                    <!-- Part dont have cluster -->
                                    @foreach ($part->testQuestions as $question)
                                    <div class="question d-flex flex-column mt-4">
                                        <p class="question-id fw-bold mb-0">{{ $question->order_in_test }}.</p>
                                        <div class="d-flex flex-column w-100" belongtopart="{{$part->order_in_test}}">
                                            <!-- order_in_test -->
                                            <input type="number" class="d-none " id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][id]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][id]" value="{{$question->id}}">
                                            
                                            @if ($part->have_question==1)
                                            <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][question]">Question</label>
                                            <textarea class="form-control" rows="3" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][question]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][question]" required>{!! $question->question !!}</textarea>
                                            @endif

                                            @if ($part->have_attachment==1 && $question->attachment != null)
                                            <img src="{{asset('storage/'.$question->attachment)}}" alt="" class="small-img m-auto">
                                            @endif
                                            @if ($part->have_attachment==1 )
                                            <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][attachment]">Select new attachment</label>
                                            <input class="form-control" type="file" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][attachment]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][attachment]">
                                            @endif
                                            
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="w-40">
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_1]">Option 1</label>
                                                    <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_1]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_1]" value="{{ $question->option_1 }}" required>
                                                </div>
                                                <div class="w-40">
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_1]">Option 2</label>
                                                    <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_2]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_2]" value="{{ $question->option_2 }}" required>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class="w-40">
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_3]">Option 3</label>
                                                    <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_3]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_3]" value="{{ $question->option_3 }}" required>
                                                </div>
                                                <div class="w-40">
                                                    @if ($part->num_of_answer == 4)
                                                    <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_4]">Option 4</label>
                                                    <input type="text" class="form-control" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_4]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][option_4]" value="{{ $question->option_4 }}" required>
                                                    @endif
                                                </div>
                                            </div>

                                            <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][answer]">Answer</label>
                                            <select name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][answer]" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][answer]" class="form-select">
                                                <option {!! $question->answer == "A" ? "selected":"" !!} value="A">A</option>
                                                <option {!! $question->answer == "B" ? "selected":"" !!} value="B">B</option>
                                                <option {!! $question->answer == "C" ? "selected":"" !!} value="C">C</option>
                                                @if ($part->num_of_answer == 4)
                                                <option {!! $question->answer == "D" ? "selected":"" !!} value="D">D</option>
                                                @endif
                                            </select>

                                            <label class="form-label" for="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][explanation]">Explanation</label>
                                            <textarea class="form-control" rows="3" id="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][explanation]" name="part[{{ $part->order_in_test }}][question][{{$question->order_in_test}}][explanation]">{!! $question->explanation !!}</textarea>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>

                            </div>
                            @endforeach

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $("div.part-block").each((i, item) => {
            if ($(item).attr('id') != 1) {
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
            $("#" + partSelected).toggleClass('d-none');
            $('.part-button').each((i, item) => {
                $(item).addClass("btn-secondary");
                $(item).removeClass("btn-primary");
            });
            $(".part-button[part=" + partSelected + "]").addClass("btn-primary");
            $(".part-button[part=" + partSelected + "]").removeClass("btn-secondary");
        });


        $(document).on('click', '.btn-collapse', function() {
            let collapse = $(this).parent().siblings(".collapsable");
            $(collapse).toggleClass("d-none");
            $(this).toggleClass("btn-secondary");
            $(this).toggleClass("btn-primary");
            if ($(this).attr("status") == "Expand") {
                $(this).attr("status", "Collapse");
                $(this).text("Expand")
            } else {
                $(this).attr("status", "Expand");
                $(this).text("Collapse")
            }
        });

        $("#create-test").submit(function(e) {
            $("#create-test").find("[required]").each((i, item) => {
                if (trim($(item).val()) == "") {

                    e.preventDefault(e);

                }
            })
        })
    });
</script>
@endsection