@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        <!-- <div class="admin-top-message">
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
        </div> -->
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Create New Test</h4>
                    <div class="d-flex justify-content-start mt-3">
                        <div class="d-flex flex-row py-2 justify-content-between">
                            <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.test.create.generate')}}">
                                @csrf
                                <label for="template" class="mx-2 text-nowrap">Template</label>
                                <select name="template" id="template" class="form-select">
                                    @foreach ($data["templates"] as $template )
                                    <option {!! $data['template']->id == $template->id ? 'selected':'' !!} value="{{$template->id}}">{{$template->name}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary ms-4 d-flex">
                                    <i class="bi bi-gear pe-2"></i>
                                    Generate
                                </button>
                            </form>
                        </div>
                    </div>
                    <form class="display-inline-block float-right w-100" method="POST" action="{{route('admin.user.store')}}">
                        @csrf
                        <div class=" mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
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
                            <label for="num_of_question" class="form-label">Duration</label>
                            <input type="number" class="form-control" id="duration" name="duration" value="{{$data['template']->duration}}" readonly>
                        </div>
                        @if ($data['template']->have_score_range == '1')
                        <div class=" mb-4">
                            <label for="num_of_question" class="form-label">Score range</label>
                            <input type="number" class="form-control" id="score_range" name="score_range" value="">
                        </div>
                        @endif

                        <div class="d-flex flex-row flex-wrap justify-content-start mt-3 part-nav-bar">
                            @foreach ($template->partTemplates as $part)
                            <button type="button" class="btn btn-secondary me-3 mt-2 part-button" part="{{$part->order_in_test}}">{{$part->name}}</button>
                            @endforeach
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <!-- Loop each part -->
                            @foreach ($template->partTemplates as $part)
                            <div class="d-flex flex-column p-3 border rounded mt-2 part-block" id="{{$part->order_in_test}}">
                                <h2>{{$part->name}}</h2>
                                <div class="question-block">
                                    <!-- Part has cluster -->
                                    @if ($part->have_cluster == 1)
                                    <!-- Loop each cluster -->
                                    @foreach ($part->clusterTemplate as $cluster)
                                    <!-- Loop each question in cluster -->
                                    @for ($i = 0;$i < $cluster->num_in_part;$i++)
                                        <div class="question-cluster d-flex flex-column p-3 border rounded mt-2" question="{{$cluster->num_of_question}}" start="">
                                            <div class="d-flex flex-row justify-content-between mb-2">
                                                <p class="question-id fw-bold">xxx</p>
                                                <button type="button" class="btn btn-secondary btn-collapse float-end w-fit-content" status="Expand">Collapse</button>
                                            </div>
                                            <div class="collapsable">
                                                <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question]"></textarea>

                                                <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][attachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[{{$part->order_in_test}}][cluster][{{$i}}][attachment]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][attachment]">

                                                @for ($j = 0;$j< $cluster->num_of_question;$j++)
                                                    <div class="question d-flex flex-column mt-4">
                                                        <p class="question-id fw-bold">1.</p>

                                                        <div class="d-flex flex-column w-100">
                                                            <input type="text" class="d-none" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][order_in_test]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][order_in_test]" value="">

                                                            @if ($part->have_question == 1)
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][question]">Question</label>
                                                            <textarea class="form-control" rows="3" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][question]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][question]"></textarea>
                                                            @endif
                                                            @if ($part->have_attachment == 1)
                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][atachment]">Atachment</label>
                                                            <input class="form-control" type="file" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][atachment]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][atachment]">
                                                            @endif

                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_1]">Option 1</label>
                                                            <input type="text" class="form-control" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_1]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_1]" value="A.">

                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_2]">Option 2</label>
                                                            <input type="text" class="form-control" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_2]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_2]" value="B.">

                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_3]">Option 3</label>
                                                            <input type="text" class="form-control" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_3]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_3]" value="C.">

                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_4]">Option 4</label>
                                                            <input type="text" class="form-control" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_4]" name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][option_4]" value="D.">

                                                            <label class="form-label" for="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][answer]">Answer</label>
                                                            <select name="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][answer]" id="part[{{$part->order_in_test}}][cluster][{{$i}}][question][{{$j}}][answer]" class="form-select">
                                                                <option value="option_1">A</option>
                                                                <option value="option_2">B</option>
                                                                <option value="option_3">C</option>
                                                                <option value="option_4">D</option>
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

                                        @endif
                                </div>
                                <!-- <div class="question-block">
                                    <div class="question d-flex flex-row mt-4">
                                        <p class="question-id fw-bold">1.</p>
                                        <div class="d-flex flex-column w-100">
                                            <label class="form-label" for="part[1][question][1][question]">Question</label>
                                            <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                            <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                            <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                            <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                            <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                            <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                            <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                            <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                            <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                <option value="option_1">A</option>
                                                <option value="option_2">B</option>
                                                <option value="option_3">C</option>
                                                <option value="option_4">D</option>
                                            </select>
                                            <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                            <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            @endforeach
                            <!-- <div class="d-flex flex-column p-3 border rounded mt-2 part-block" id="1">
                                <h2>Part 1</h2>
                                <div class="question-block">
                                    <div class="question d-flex flex-row mt-4">
                                        <p class="question-id fw-bold">1.</p>
                                        <div class="d-flex flex-column w-100">
                                            <label class="form-label" for="part[1][question][1][question]">Question</label>
                                            <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                            <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                            <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                            <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                            <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                            <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                            <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                            <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                            <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                <option value="option_1">A</option>
                                                <option value="option_2">B</option>
                                                <option value="option_3">C</option>
                                                <option value="option_4">D</option>
                                            </select>
                                            <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                            <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                        </div>
                                    </div>
                                    <div class="question d-flex flex-row mt-4">
                                        <p class="question-id fw-bold">2.</p>
                                        <div class="d-flex flex-column w-100">
                                            <label class="form-label" for="part[1][question][1][question]">Question</label>
                                            <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                            <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                            <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                            <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                            <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                            <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                            <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                            <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                            <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                            <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                <option value="option_1">A</option>
                                                <option value="option_2">B</option>
                                                <option value="option_3">C</option>
                                                <option value="option_4">D</option>
                                            </select>
                                            <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                            <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column p-3 border rounded mt-2 part-block d-none" id="2">
                                <h2>Part 2</h2>
                                <div class="question-block">
                                    <div class="question-cluster d-flex flex-column p-3 border rounded mt-2" question="3" start="1">
                                        <p class="question-id fw-bold">1 - 3</p>
                                        <div class="question d-flex flex-row mt-4">
                                            <p class="question-id fw-bold">1.</p>
                                            <div class="d-flex flex-column w-100">
                                                <input type="text" class="form-control" id="part[1][question][1][order_in_text]" name="part[1][question][1][order_in_text]" value="1">
                                                <label class="form-label" for="part[1][question][1][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                                <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                                <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                                <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                                <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                                <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                    <option value="option_1">A</option>
                                                    <option value="option_2">B</option>
                                                    <option value="option_3">C</option>
                                                    <option value="option_4">D</option>
                                                </select>
                                                <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                            </div>
                                        </div>
                                        <div class="question d-flex flex-row mt-4">
                                            <p class="question-id fw-bold">1.</p>
                                            <div class="d-flex flex-column w-100">
                                                <label class="form-label" for="part[1][question][1][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                                <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                                <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                                <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                                <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                                <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                    <option value="option_1">A</option>
                                                    <option value="option_2">B</option>
                                                    <option value="option_3">C</option>
                                                    <option value="option_4">D</option>
                                                </select>
                                                <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                            </div>
                                        </div>
                                        <div class="question d-flex flex-row mt-4">
                                            <p class="question-id fw-bold">1.</p>
                                            <div class="d-flex flex-column w-100">
                                                <label class="form-label" for="part[1][question][1][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                                <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                                <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                                <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                                <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                                <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                    <option value="option_1">A</option>
                                                    <option value="option_2">B</option>
                                                    <option value="option_3">C</option>
                                                    <option value="option_4">D</option>
                                                </select>
                                                <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column p-3 border rounded mt-2 part-block d-none" id="3">
                                <h2>Part 3</h2>
                                <div class="question-block">
                                    <div class="question-cluster d-flex flex-column p-3 border rounded mt-2" question="3" start="1">
                                        <p class="question-id fw-bold">1 - 3</p>
                                        <div class="question d-flex flex-row mt-4">
                                            <p class="question-id fw-bold">1.</p>
                                            <div class="d-flex flex-column w-100">
                                                <input type="text" class="form-control" id="part[1][question][1][order_in_text]" name="part[1][question][1][order_in_text]" value="1">
                                                <label class="form-label" for="part[1][question][1][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                                <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                                <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                                <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                                <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                                <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                    <option value="option_1">A</option>
                                                    <option value="option_2">B</option>
                                                    <option value="option_3">C</option>
                                                    <option value="option_4">D</option>
                                                </select>
                                                <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                            </div>
                                        </div>
                                        <div class="question d-flex flex-row mt-4">
                                            <p class="question-id fw-bold">1.</p>
                                            <div class="d-flex flex-column w-100">
                                                <label class="form-label" for="part[1][question][1][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                                <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                                <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                                <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                                <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                                <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                    <option value="option_1">A</option>
                                                    <option value="option_2">B</option>
                                                    <option value="option_3">C</option>
                                                    <option value="option_4">D</option>
                                                </select>
                                                <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                            </div>
                                        </div>
                                        <div class="question d-flex flex-row mt-4">
                                            <p class="question-id fw-bold">1.</p>
                                            <div class="d-flex flex-column w-100">
                                                <label class="form-label" for="part[1][question][1][question]">Question</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][question]" name="part[1][question][1][question]"></textarea>
                                                <label class="form-label" for="part[1][question][1][atachment]">Atachment</label>
                                                <input class="form-control" type="file" id="part[1][question][1][atachment]" name="part[1][question][1][atachment]">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 1</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_1]" name="part[1][question][1][option_1]" value="A.">
                                                <label class="form-label" for="part[1][question][1][option_1]">Option 2</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_2]" name="part[1][question][1][option_2]" value="B.">
                                                <label class="form-label" for="part[1][question][1][option_3]">Option 3</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_3]" name="part[1][question][1][option_3]" value="C.">
                                                <label class="form-label" for="part[1][question][1][option_4]">Option 4</label>
                                                <input type="text" class="form-control" id="part[1][question][1][option_4]" name="part[1][question][1][option_4]" value="D.">
                                                <label class="form-label" for="part[1][question][1][answer]">Answer</label>
                                                <select name="part[1][question][1][answer]" id="part[1][question][1][answer]" class="form-select">
                                                    <option value="option_1">A</option>
                                                    <option value="option_2">B</option>
                                                    <option value="option_3">C</option>
                                                    <option value="option_4">D</option>
                                                </select>
                                                <label class="form-label" for="part[1][question][1][explanation]">Explanation</label>
                                                <textarea class="form-control" rows="3" id="part[1][question][1][explanation]" name="part[1][question][1][explanation]"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(".part-button").click((e) => {
        let partSelected = $(e.target).attr("part");
        console.log($(e.target).attr("part"));
        $('.part-block').each((i, item) => {
            $(item).addClass('d-none');
        });
        $('#' + partSelected).removeClass('d-none');
    });


    $(document).on('click','.btn-collapse', function (){
        let collapse = $(this).parent().siblings(".collapsable");
        $(collapse).toggleClass("d-none");
        $(this).toggleClass("btn-secondary");
        $(this).toggleClass("btn-primary");
        if($(this).attr("status") == "Expand") {
            $(this).attr("status","Collapse");
            $(this).text("Expand")
        }
        else {
            $(this).attr("status","Expand");
            $(this).text("Collapse")
        }
    });

    // $(".btn-collapse").click((e) => {
    //     let checkCollapse = $(e.target).attr("iscollapse");
    //     console.log($(e.target).closest(".collapsable"));
    //     $(e.target).closest(".collapsable").toggleClass("d-none");
    //     // if (checkCollapse == "true") {
    //     //     $(e.target).closest(".collapsable").removeClass("d-none");
    //     //     $(e.target).attr("iscollapse","false");
    //     // }
    //     // else {
    //     //     $(e.target).closest(".collapsable").addClass("d-none");
    //     //     $(e.target).attr("iscollapse","true");
    //     // }
    // });
</script>
@endsection