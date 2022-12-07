@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="add-message row w-100">
        <div class="admin-top-message">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ $error }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
            @endif
        </div>
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Create New Test</h4>
                    <div class="d-flex justify-content-start mt-3 align-items-center">
                        <div class="d-flex flex-row py-2 justify-content-between">
                            <form class="d-flex flex-row justify-content-start align-items-center" id="generate" method="POST" action="{{route('admin.test.generate')}}">
                                @csrf
                                <label for="template" class="mx-2 text-nowrap">Template</label>
                                <select name="template" id="template" class="form-select">
                                    @foreach ($data["templates"] as $template )
                                    @if (!empty($data['template']))
                                    <option {!! $data['template']->id == $template->id ? 'selected':'' !!} value="{{$template->id}}">{{$template->name}}</option>
                                    @else
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary ms-4 d-flex" form="generate">
                                    <i class="bi bi-gear pe-2"></i>
                                    Generate
                                </button>
                            </form>

                        </div>
                        @if (!empty($data['template']))
                        <button type="submit" id="create-test-submit" form="create-test" class="btn btn-success d-block h-fit-content ms-auto">Create Test</button>
                        @endif
                    </div>
                    @if (!empty($data['template']))
                    <form class="display-inline-block float-right w-100" id="create-test" method="POST" action="{{route('admin.test.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class=" mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text inp-check" class="form-control" id="name" name="name" value="" required>
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class=" mb-4">
                            <label for="type" class="form-label">Test's Type</label>
                            <select name="type" id="type" class="form-select" disabled>
                                <option {!! $data['template']->type == 'fulltest' ? 'selected' : '' !!} value="fulltest">Full Test</option>
                                <option {!! $data['template']->type == 'minitest' ? 'selected' : '' !!} value="minitest">Mini Test</option>
                                <option {!! $data['template']->type == 'parttest' ? 'selected' : '' !!} value="parttest">Part Test</option>
                            </select>
                        </div>
                        <div class=" mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="public">Public</option>
                                <option value="onhold">On Hold</option>
                            </select>
                        </div>
                        <div class=" mb-4">
                            <label for="num_of_question" class="form-label">Total question</label>
                            <input type="number" class="form-control" id="num_of_question" name="num_of_question" value="{{$data['template']->num_of_question}}" readonly>
                        </div>
                        <div class=" mb-4">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="number" class="form-control" id="duration" name="duration" value="{{$data['template']->duration}}" readonly>
                        </div>
                        @if ($data['template']->have_score_range == '1')
                        <div class=" mb-4">
                            <label for="score_range" class="form-label">Score range</label>
                            <input type="number" class="form-control" id="score_range" name="score_range" value="">
                        </div>
                        @endif

                        @if ($data['template']->have_audio_file == '1')
                        <div class=" mb-4">
                            <label for="audio_file" class="form-label">Audio File</label>
                            <input type="file" class="form-control file-check" id="audio_file" name="audio_file" message="Test audio file" required>
                        </div>
                        @endif

                        <input type="number" class="d-none" id="test_type_id" name="test_type_id" value="{{$data['template']->id}}">

                        <div class="d-flex flex-row flex-wrap justify-content-start mt-3 part-nav-bar">
                            @foreach ($data['template']->partTemplates as $part)
                            <button type="button" class="btn btn-secondary me-3 mt-2 part-button" part="{{$part->order_in_test}}">{{$part->name}}</button>
                            @endforeach
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <!-- Loop each part -->
                            @foreach ($data['template']->partTemplates as $part)
                            <div class="d-flex flex-column p-3 border rounded mt-2 part-block" id="{{$part->order_in_test}}" question="{{$part->num_of_question}}">
                                <h2>{{$part->name}}</h2>
                                <!-- order_in_test -->
                                <input type="number" class="d-none" id="part[{{$part->order_in_test}}][order_in_test]" name="part[{{$part->order_in_test}}][order_in_test]" value="{{$part->order_in_test}}" readonly>
                                <input type="text" class="d-none" id="part[{{$part->order_in_test}}][name]" name="part[{{$part->order_in_test}}][name]" value="{{$part->name}}" readonly>
                                <div class=" mb-4">
                                    <label for="part[{{$part->order_in_test}}][description]" class="form-label">Part description</label>
                                    <textarea type="number" class="form-control" id="part[{{$part->order_in_test}}][description]" name="part[{{$part->order_in_test}}][description]" readonly>{{trim($part->description)}}</textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="w-40">
                                        <label for="part[{{$part->order_in_test}}][num_of_question]" class="form-label">Total question</label>
                                        <input type="number" class="form-control" id="part[{{$part->order_in_test}}][num_of_question]" name="part[{{$part->order_in_test}}][num_of_question]" value="{{$part->num_of_question}}" readonly>
                                    </div>
                                    <div class="w-40">
                                        <label for="part[{{$part->order_in_test}}][num_of_answer]" class="form-label">Total answer of each question</label>
                                        <input type="number" class="form-control" id="part[{{$part->order_in_test}}][num_of_answer]" name="part[{{$part->order_in_test}}][num_of_answer]" value="{{$part->num_of_answer}}" readonly>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="w-40">
                                        <label for="part[{{$part->order_in_test}}][have_cluster]" class="form-label">Part has cluster</label>
                                        <select name="part[{{$part->order_in_test}}][fake_cluster]" id="part[{{$part->order_in_test}}][fake_cluster]" class="form-select" disabled>
                                            <option {!! $part->have_cluster == 1 ? 'selected':'' !!} value="yes">Yes</option>
                                            <option {!! $part->have_cluster == 0 ? 'selected':'' !!} value="no">No</option>
                                        </select>
                                        <input type="text" class="d-none" id="part[{{$part->order_in_test}}][have_cluster]" name="part[{{$part->order_in_test}}][have_cluster]" value="{!! $part->have_cluster == 1 ? 'yes':'no' !!}" readonly>
                                    </div>
                                    <!-- Part have question ?-->
                                    <div class="w-40">
                                        <label for="part[{{$part->order_in_test}}][have_question]" class="form-label">Question has content </label>
                                        <select name="part[{{$part->order_in_test}}][fake_question]" id="part[{{$part->order_in_test}}][fake_question]" class="form-select" disabled>
                                            <option {!! $part->have_question == 1 ? 'selected':'' !!} value="yes">Yes</option>
                                            <option {!! $part->have_question == 0 ? 'selected':'' !!} value="no">No</option>
                                        </select>
                                        <input type="text" class="d-none" id="part[{{$part->order_in_test}}][have_question]" name="part[{{$part->order_in_test}}][have_question]" value="{!! $part->have_question == 1 ? 'yes':'no' !!}" readonly>
                                    </div>
                                </div>

                                <!-- Part have cluster ? -->

                                <!-- Part have attachment ?-->
                                <div class="w-40">
                                    <label for="part[{{$part->order_in_test}}][have_attachment]" class="form-label">Question has attachment </label>
                                    <select name="part[{{$part->order_in_test}}][fake_attachment]" id="part[{{$part->order_in_test}}][fake_attachment]" class="form-select" disabled>
                                        <option {!! $part->have_question == 1 ? 'selected':'' !!} value="yes">Yes</option>
                                        <option {!! $part->have_question == 0 ? 'selected':'' !!} value="no">No</option>
                                    </select>
                                    <input type="text" class="d-none" id="part[{{$part->order_in_test}}][have_attachment]" name="part[{{$part->order_in_test}}][have_attachment]" value="{!! $part->have_attachment == 1 ? 'yes':'no' !!}" readonly>
                                </div>
                                <div class="question-block">
                                    <!-- Part has cluster -->
                                    @if ($part->have_cluster == 1)
                                    <!-- Loop each cluster -->
                                    @foreach ($part->clusterTemplate as $cluster)
                                    <!-- Loop each question in cluster -->
                                    @for ($i = 0;$i < $cluster->num_in_part;$i++)
                                        <div class="question-cluster d-flex flex-column p-3 border rounded mt-2" question="{{$cluster->num_of_question}}" index="{{$i}}">
                                            <div class="d-flex flex-row justify-content-between mb-2">
                                                <p class="cluster-id fw-bold">xxx</p>
                                                <button type="button" class="btn btn-secondary btn-collapse float-end w-fit-content" status="Expand">Collapse</button>
                                            </div>
                                            <div class="collapsable">
                                                @if ($cluster->have_question == 1)
                                                <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question_content]">Cluster question</label>
                                                <textarea class="form-control txt-check" rows="3" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question_content]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question_content]" temp4required></textarea>
                                                @endif

                                                @if ($cluster->have_attachment == 1)
                                                <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][attachment]">Atachment</label>
                                                <input class="form-control inp-check" type="file" id="part[{{$part->order_in_test}}][cluster][{{$i}}][attachment]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][attachment]" required>
                                                @endif


                                                <input class="form-control d-none order-in-part" type="number" id="part[{{$part->order_in_test}}][cluster][{{$i}}][order_in_part]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][order_in_part]" value="{{$i+1}}">
                                                <input class="form-control d-none question-begin" type="number" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question_begin]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question_begin]" value="">
                                                <input class="form-control d-none question-end" type="number" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question_end]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question_end]" value="">



                                                @for ($j = 0;$j< $cluster->num_of_question;$j++)
                                                    <div class="question have-cluster d-flex flex-column mt-4">
                                                        <p class="question-id fw-bold">1.</p>

                                                        <div class="d-flex flex-column w-100" belongtopart="{{$part->order_in_test}}">
                                                            <input type="text" class="d-none question-order-in-test {{ $j==0?'first':'' }} {{ $j==$cluster->num_of_question-1?'last':'' }}" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][order_in_test]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][order_in_test]" value="">

                                                            @if ($part->have_question == 1)
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][question]">Question</label>
                                                            <textarea class="form-control txt-check" rows="3" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][question]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][question]" required></textarea>
                                                            @endif

                                                            @if ($part->have_attachment == 1)
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][atachment]">Atachment</label>
                                                            <input class="form-control file-check" type="file" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][atachment]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][atachment]" required>
                                                            @endif

                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="w-40">
                                                                    <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_1]">Option 1</label>
                                                                    <input type="text" class="form-control inp-check" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_1]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_1]" value="A." required>
                                                                </div>
                                                                <div class="w-40">
                                                                    <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_2]">Option 2</label>
                                                                    <input type="text" class="form-control inp-check" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_2]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_2]" value="B." required>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="w-40">
                                                                    <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_3]">Option 3</label>
                                                                    <input type="text" class="form-control inp-check" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_3]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_3]" value="C." required>
                                                                </div>
                                                                <div class="w-40">
                                                                    @if ($part->num_of_answer == 4)
                                                                    <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_4]">Option 4</label>
                                                                    <input type="text" class="form-control inp-check" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_4]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_4]" value="D." required>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][answer]">Answer</label>
                                                            <select name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][answer]" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][answer]" class="form-select">
                                                                <option value="option_1">A</option>
                                                                <option value="option_2">B</option>
                                                                <option value="option_3">C</option>
                                                                @if ($part->num_of_answer == 4)
                                                                <option value="option_4">D</option>
                                                                @endif
                                                            </select>

                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][explanation]">Explanation</label>
                                                            <textarea class="form-control" rows="3" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][explanation]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][explanation]"></textarea>
                                                        </div>
                                                    </div>
                                                    @endfor
                                            </div>

                                        </div>
                                        @endfor

                                        @endforeach
                                        @else
                                        <!-- Part dont have cluster -->
                                        @for ($i = 1;$i < $part->num_of_question+1;$i++ )
                                            <div class="question d-flex flex-column mt-4">
                                                <p class="question-id fw-bold mb-0">1.</p>
                                                <div class="d-flex flex-column w-100" belongtopart="{{$part->order_in_test}}">
                                                    <!-- order_in_test -->
                                                    <input type="text" class="d-none question-order-in-test {{ $i==1?'first':'' }} {{ $i==$part->num_of_question+1?'last':'' }}" id="part[{{$part->order_in_test}}][question][{{$i}}][order_in_test]" name="part[{{$part->order_in_test}}][question][{{$i}}][order_in_test]" value="">

                                                    @if ($part->have_question==1)
                                                    <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][question]">Question</label>
                                                    <textarea class="form-control txt-check" rows="3" id="part[{{$part->order_in_test}}][question][{{$i}}][question]" name="part[{{$part->order_in_test}}][question][{{$i}}][question]" required></textarea>
                                                    @endif

                                                    @if ($part->have_attachment==1)
                                                    <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][attachment]">Atachment</label>
                                                    <input class="form-control file-check" type="file" id="part[{{$part->order_in_test}}][question][{{$i}}][attachment]" name="part[{{$part->order_in_test}}][question][{{$i}}][attachment]" required>
                                                    @endif
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div class="w-40">
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][option_1]">Option 1</label>
                                                            <input type="text inp-check" class="form-control" id="part[{{$part->order_in_test}}][question][{{$i}}][option_1]" name="part[{{$part->order_in_test}}][question][{{$i}}][option_1]" value="A." required>
                                                        </div>
                                                        <div class="w-40">
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][option_1]">Option 2</label>
                                                            <input type="text inp-check" class="form-control" id="part[{{$part->order_in_test}}][question][{{$i}}][option_2]" name="part[{{$part->order_in_test}}][question][{{$i}}][option_2]" value="B." required>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div class="w-40">
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][option_3]">Option 3</label>
                                                            <input type="text inp-check" class="form-control" id="part[{{$part->order_in_test}}][question][{{$i}}][option_3]" name="part[{{$part->order_in_test}}][question][{{$i}}][option_3]" value="C." required>
                                                        </div>
                                                        <div class="w-40">
                                                            @if ($part->num_of_answer == 4)
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][option_4]">Option 4</label>
                                                            <input type="text inp-check" class="form-control" id="part[{{$part->order_in_test}}][question][{{$i}}][option_4]" name="part[{{$part->order_in_test}}][question][{{$i}}][option_4]" value="D." required>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][answer]">Answer</label>
                                                    <select name="part[{{$part->order_in_test}}][question][{{$i}}][answer]" id="part[{{$part->order_in_test}}][question][{{$i}}][answer]" class="form-select">
                                                        <option value="option_1">A</option>
                                                        <option value="option_2">B</option>
                                                        <option value="option_3">C</option>
                                                        @if ($part->num_of_answer == 4)
                                                        <option value="option_4">D</option>
                                                        @endif
                                                    </select>

                                                    <label class="form-label" for="part[{{$part->order_in_test}}][question][{{$i}}][explanation]">Explanation</label>
                                                    <textarea class="form-control" rows="3" id="part[{{$part->order_in_test}}][question][{{$i}}][explanation]" name="part[{{$part->order_in_test}}][question][{{$i}}][explanation]"></textarea>
                                                </div>
                                            </div>
                                            @endfor
                                            @endif
                                </div>

                            </div>
                            @endforeach

                        </div>
                        <!-- <button type="submit" class="d-none" id="create-button" form="create-test"></button> -->
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $("div.part-block").each((i, item) => {
            if ($(item).attr('id') != 1) {
                $(item).addClass('d-none');
            }
        });

        $(".part-button[part='1']").toggleClass("btn-secondary btn-primary");

        $(".part-button").click((e) => {
            let partSelected = $(e.target).attr("part");
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

        let previous_num_of_question = 0;
        $(".part-block").each((i, item) => {
            let question_begin = 1 + previous_num_of_question;
            $(item).find('.question').each((j, citem) => {
                $(citem).find('.question-id').text(question_begin);
                $(citem).find('.question-order-in-test').attr("value", question_begin);
                question_begin++;
            });
            previous_num_of_question += parseInt($(item).attr("question"));
        })

        $(".question-cluster").each((i, item) => {
            let question_begin = $(item).find(".first").attr("value");
            let question_end = $(item).find(".last").attr("value");
            $(item).find(".cluster-id").text(question_begin + "-" + question_end);
            $(item).find(".question-begin").attr("value", question_begin);
            $(item).find(".question-end").attr("value", question_end);
        });

        $("#create-test-submit").click((e) => {
            $(".file-check").each((i, item) => {
                if (item.files.length === 0) {
                    let message = $(item).attr("message");
                    createAlert(message);
                    return false;
                }
            })
        })

        function createAlert(message) {
            let ele = '<div class="admin-top-message"><div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">';
            ele += message + " cannot be empty";
            ele += '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';

            $(".add-message").prepend(ele);
            setTimeout(function() {
                $(".admin-top-message").remove();
            }, 4000);
        }
    });
</script>
@endsection