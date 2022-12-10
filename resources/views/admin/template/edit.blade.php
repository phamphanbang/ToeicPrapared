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
                    <div class="mb-3 d-flex flex-row align-items-center">
                        <a class="btn btn-primary" href="{{url()->previous()}}" role="button">
                            <i class="bi bi-arrow-left pe-2"></i>
                            Back
                        </a>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title display-inline-block">Edit {{$data["template"]->name}} Template</h4>
                        <button type="button" id="check-template" class="btn btn-primary ">Check Template</button>
                        <button type="submit" id="update-template" form="update_template" class="btn btn-success d-none">Update Template</button>
                    </div>
                    <form class="display-inline-block float-right w-75 template-form" method="POST" action="{{route('admin.template.update',$data['template']->id)}}" id="update_template">
                        @csrf
                        @method('PUT')
                        <div class=" mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input required type="text" class="form-control" id="name" name="name" value="{{$data['template']->name}}">
                            <input type="name" class="d-none" name="old_name" value="{{ $data['template']->name }}">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class=" mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea required class="form-control" rows="3" id="description" name="description">{{trim($data['template']->description)}}</textarea>
                        </div>
                        <div class=" mb-4">
                            <label for="num_of_part" class="form-label">Total parts</label>
                            <input required type="number" class="form-control" id="num_of_part" name="num_of_part" value="{{$data['template']->num_of_part}}">
                        </div>
                        <div class=" mb-4">
                            <label for="num_of_question" class="form-label">Total questions</label>
                            <input required type="number" class="form-control" id="num_of_question" name="num_of_question" value="{{$data['template']->num_of_question}}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="type" class="form-label">Test's Type</label>
                            <select name="type" id="type" class="form-select">
                                <option {!! $data['template']->type == 'fulltest' ?'selected':'' !!} value="fulltest">Full Test</option>
                                <option {!! $data['template']->type == 'minitest' ?'selected':'' !!} value="minitest">Mini Test</option>
                                <option {!! $data['template']->type == 'parttest' ?'selected':'' !!} value="parttest">Part Test</option>
                            </select>
                        </div>
                        <div class=" mb-4" id="duration-block">
                            <label for="duration" class="form-label">Duration</label>
                            <input required type="text" class="form-control" id="duration" name="duration" value="{{$data['template']->duration}}">
                        </div>
                        <div class="form-group mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option {!! $data['template']->status == 'public' ?'selected':'' !!} value="public">Public</option>
                                <option {!! $data['template']->status == 'onhold' ?'selected':'' !!} value="onhold">On Hold</option>
                            </select>
                        </div>
                        <div class=" mb-4">
                            <label for="have_score_range" class="form-label">Have score range</label>
                            <select name="have_score_range" id="have_score_range" class="form-select">
                                <option {!! $data['template']->have_score_range == 1 ?'selected':'' !!} value="yes">Yes</option>
                                <option {!! $data['template']->have_score_range == 0 ?'selected':'' !!} value="no">No</option>
                            </select>
                        </div>
                        <div class="from-group mb-4">
                            <label class="form-label" for="have_audio_file">Have audio file</label>
                            <select name="have_audio_file" id="have_audio_file" class="form-select">
                                <option {!! $data['template']->have_audio_file == 1 ?'selected':'' !!} value="yes">Yes</option>
                                <option {!! $data['template']->have_audio_file == 0 ?'selected':'' !!} value="no">No</option>
                            </select>
                        </div>
                        @foreach ($data["template"]->partTemplates as $part)
                        <div class="d-flex flex-column mb-4 m-3 p-3 border rounded part-block">
                            <div class="d-flex flex-row justify-content-between">
                                <h2 class="card-title display-inline-block">{{ $part->name }}</h2>
                                <button type="button" class="btn btn-danger float-end delete-part">Delete Part</button>
                            </div>
                            <input required type="text" class="d-none part-id" id="part[1]" name="part[1]" value="{{$part->id}}">
                            <label class="form-label label-name">Part name</label>
                            <input required type="text" class="form-control input-name part-name" id="part[1]" name="part[1]" value="{{$part->name}}">
                            <label class="form-label label-order-in-test">Order in test</label>
                            <input required type="number" class="form-control input-order-in-test part-order-in-test" id="partname" name="partname" value="{{$part->order_in_test}}">
                            <label class="form-label label-description">Description</label>
                            <textarea required class="form-control input-description" id="partname" name="partname">{{ trim($part->description) }}</textarea>
                            <label class="form-label label-num-of-question">Total questions</label>
                            <input required type="number" class="form-control input-num-of-question part-num-of-question" id="partname" name="partname" value="{{$part->num_of_question}}">
                            <label class="form-label label-num-of-answer">Total answer of each question</label>
                            <select name="by" id="search-by" class="form-select input-num-of-answer">
                                <option {!! $part->num_of_answer=="3"?'selected':'' !!} value="3">3</option>
                                <option {!! $part->num_of_answer=="4"?'selected':'' !!} value="4">4</option>
                            </select>
                            <label class="form-label label-have-attachment">Question has attachment</label>
                            <select name="by" id="search-by" class="form-select input-have-attachment">
                                <option {!! $part->have_attachment=="1"?'selected':'' !!} value="yes">Yes</option>
                                <option {!! $part->have_attachment=="0"?'selected':'' !!} value="no">No</option>
                            </select>
                            <label class="form-label label-have-question">Question has content</label>
                            <select name="by" id="search-by" class="form-select input-have-question">
                                <option {!! $part->have_question=="1"?'selected':'' !!} value="yes">Yes</option>
                                <option {!! $part->have_question=="0"?'selected':'' !!} value="no">No</option>
                            </select>
                            @foreach ($part->clusterTemplate as $cluster)
                            <div class="d-flex flex-column mb-4 m-3 p-3 border rounded cluster-block">
                                <div class="d-flex flex-row justify-content-between">
                                    <h2 class="card-title display-inline-block">Cluster {{$loop->iteration}}</h2>
                                    <button type="button" class="btn btn-danger float-end delete-cluster">Delete Cluster</button>
                                </div>
                                <label class="form-label label-cluster-num-in-part">Cluster in part</label>
                                <input required type="text" class="form-control input-cluster-num-in-part cluster-num-in-part" id="partname" name="partname" value="{{$cluster->num_in_part}}">
                                <label class="form-label label-cluster-num-of-question">Total question</label>
                                <input required type="text" class="form-control input-cluster-num-of-question cluster-num-in-part" id="partname" name="partname" value="{{$cluster->num_of_question}}">
                                <label class="form-label label-cluster-have-attachment">Question has attachment</label>
                                <select name="by" id="search-by" class="form-select input-cluster-have-attachment">
                                    <option {!! $cluster->have_attachment=="1"?'selected':'' !!} value="yes">Yes</option>
                                    <option {!! $cluster->have_attachment=="0"?'selected':'' !!} value="no">No</option>
                                </select>
                                <label class="form-label label-cluster-have-question">Question has content</label>
                                <select name="by" id="search-by" class="form-select input-cluster-have-question">
                                    <option {!! $cluster->have_question=="1"?'selected':'' !!} value="yes">Yes</option>
                                    <option {!! $cluster->have_question=="0"?'selected':'' !!} value="no">No</option>
                                </select>
                            </div>
                            @endforeach
                            <button type='button' class='btn btn-primary mt-2 ms-auto add-cluster' count='1' belongTo="">Add Cluster</button>
                        </div>
                        @endforeach
                        <button type="button" class="btn btn-primary ms-50" id="add-part" count="0">Add Part</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        let partCount = 1;
        let partId = 1;
        $(".part-block").each((i, item) => {
            let index = ++i;
            let partInput = "parts[" + index + "]";
            $(item).find('h2').text("Part " + index);
            $(item).find('button.add-cluster').attr("belongTo", partInput);
            $(item).find('.part-id').attr({
                "id": partInput + "[id]",
                "name": partInput + "[id]"
            });
            $(item).find('.input-name').attr({
                "id": partInput + "[name]",
                "name": partInput + "[name]"
            });
            $(item).find('.input-order-in-test').attr({
                "id": partInput + "[order_in_test]",
                "name": partInput + "[order_in_test]"
            });
            $(item).find('.input-description').attr({
                "id": partInput + "[description]",
                "name": partInput + "[description]"
            });
            $(item).find('.input-num-of-question').attr({
                "id": partInput + "[num_of_question]",
                "name": partInput + "[num_of_question]"
            });
            $(item).find('.input-num-of-answer').attr({
                "id": partInput + "[num_of_answer]",
                "name": partInput + "[num_of_answer]"
            });
            $(item).find('.input-have-attachment').attr({
                "id": partInput + "[have_attachment]",
                "name": partInput + "[have_attachment]"
            });
            $(item).find('.input-have-question').attr({
                "id": partInput + "[have_question]",
                "name": partInput + "[have_question]"
            });
            $(item).children('.cluster-block').each((j, citem) => {
                let jndex = ++j;
                let clusterName = partInput + "[cluster][" + jndex + "]";
                $(citem).find('.input-cluster-num-in-part').attr({
                    "id": clusterName + "[num_in_part]",
                    "name": clusterName + "[num_in_part]"
                });
                $(citem).find('.input-cluster-num-of-question').attr({
                    "id": clusterName + "[num_of_question]",
                    "name": clusterName + "[num_of_question]"
                });
                $(citem).find('.input-cluster-have-attachment').attr({
                    "id": clusterName + "[have_attachment]",
                    "name": clusterName + "[have_attachment]"
                });
                $(citem).find('.input-cluster-have_question').attr({
                    "id": clusterName + "[have_question]",
                    "name": clusterName + "[have_question]"
                });
                $(item).find('button.add-cluster').attr("count", jndex);
            });
            partCount++;
            partId++;
        });

        $("#add-part").click(() => {
            let partInput = "parts[" + partId + "]";
            let partName = partInput + "[name]";
            let partDescription = partInput + "[description]";
            let partNumOfQuestion = partInput + "[num_of_question]";
            let partNumOfAnswer = partInput + "[num_of_answer]";
            let partOrderInTest = partInput + "[order_in_test]";
            let partHaveAttachment = partInput + "[have_atachment]";
            let partHaveQuestion = partInput + "[have_question]";
            let temp = "Part-" + partCount;
            let partNameValue = temp.split('-').join(' ');
            let block = '<div class="d-flex flex-column mb-4 m-3 p-3 border rounded part-block">';
            block += '<div class="d-flex flex-row justify-content-between">';
            block += "<h2 class='card-title display-inline-block'>Part " + partCount + "</h2>";
            block += '<button type="button" class="btn btn-danger float-end delete-part">Delete Part</button>';
            block += '</div>';
            block += "<label for=" + partName + " class='form-label'>Part name</label>";
            block += "<input required type='text' class='form-control part-name' id=" + partName + " name=" + partName + " value='" + partNameValue + "'>";
            block += "<label for=" + partOrderInTest + " class='form-label'>Order in test</label>";
            block += "<input required type='number' class='form-control part-order-in-test' id=" + partOrderInTest + " name=" + partOrderInTest + " value = " + partCount + ">";
            block += "<label for=" + partDescription + " class='form-label'>Description</label>";
            block += "<textarea required class='form-control' rows='3' id=" + partDescription + " name=" + partDescription + "></textarea>";
            block += "<label for=" + partNumOfQuestion + " class='form-label'>Total questions</label>";
            block += "<input required type='number' class='form-control part-num-of-question' id=" + partNumOfQuestion + " name=" + partNumOfQuestion + ">";
            block += "<label for=" + partNumOfAnswer + " class='form-label'>Total answer of each question</label>";
            block += "<select name=" + partNumOfAnswer + " id=" + partNumOfAnswer + " class='form-select'>";
            block += "<option value='3'>3</option>";
            block += "<option value='4'>4</option>";
            block += "</select>";
            block += "<label for=" + partHaveAttachment + " class='form-label'>Question has attac</label>";
            block += "<select name=" + partHaveAttachment + " id=" + partHaveAttachment + " class='form-select'>";
            block += "<option value='yes'>Yes</option>";
            block += "<option value='no'>No</option>";
            block += "</select>";
            block += "<label for=" + partHaveQuestion + " class='form-label'>Question has attac</label>";
            block += "<select name=" + partHaveQuestion + " id=" + partHaveQuestion + " class='form-select'>";
            block += "<option value='yes'>Yes</option>";
            block += "<option value='no'>No</option>";
            block += "</select>";
            block += "<button type='button' class='btn btn-primary mt-2 ms-auto add-cluster' count='1' belongTo=" + partInput + ">Add Cluster</button>";
            block += '</div>';
            partCount++;
            partId++;
            $("#add-part").before(block);
        });

        $(document).on('click', '.delete-part', function() {
            $(this).closest(".part-block").remove();
            partCount = 1;
            $(".part-block").each((i, item) => {
                console.log($(item).text());
                $(item).find('h2').text("Part " + partCount);
                $(item).find('.part-name').attr("value", "Part " + partCount);
                $(item).find('.part-order-in-test').attr("value", partCount);
                partCount++;
            });
        });

        $(document).on('click', '.add-cluster', function() {
            let clusterId = $(this).attr("count");
            let belongTo = $(this).attr("belongTo");
            let clusterName = belongTo + "[cluster][" + clusterId + "]";
            let numInPart = clusterName + "[num_in_part]";
            let numOfQuestion = clusterName + "[num_of_question]";
            let haveAttachment = clusterName + "[have_attachment]";
            let haveQuestion = clusterName + "[have_question]";
            let block = "<div class='d-flex flex-column mb-4 m-3 p-3 border rounded cluster-block'>";
            block += '<div class="d-flex flex-row justify-content-between">';
            block += "<h2 class='card-title display-inline-block'>Cluster " + clusterId + "</h2>";
            block += '<button type="button" class="btn btn-danger float-end delete-cluster">Delete Cluster</button>';
            block += '</div>';
            block += "<label for=" + numInPart + " class='form-label'>Cluster in part</label>";
            block += "<input required type='number' class='form-control cluster-num-in-part' id=" + numInPart + " name=" + numInPart + ">";
            block += "<label for=" + numOfQuestion + " class='form-label'>Total question</label>";
            block += "<input required type='number' class='form-control cluster-num-of-question' id=" + numOfQuestion + " name=" + numOfQuestion + ">";
            block += "<label for=" + haveAttachment + " class='form-label'>Cluster has attacment</label>";
            block += "<select name=" + haveAttachment + " id=" + haveAttachment + " class='form-select'>";
            block += "<option value='yes'>Yes</option>";
            block += "<option value='no'>No</option>";
            block += "</select>";
            block += "<label for=" + haveQuestion + " class='form-label'>Cluster has content</label>";
            block += "<select name=" + haveQuestion + " id=" + haveQuestion + " class='form-select'>";
            block += "<option value='yes'>Yes</option>";
            block += "<option value='no'>No</option>";
            block += "</select>";
            block += "</div>";
            $(this).before(block);
            $(this).attr("count", ++clusterId);
        });

        $(document).on('click', '.delete-cluster', function() {
            let partBlock = $(this).closest(".part-block");
            $(this).closest(".cluster-block").remove();
            let clusterCount = 1;
            partBlock.children(".cluster-block").each((i, item) => {
                $(item).find('h2').text("Cluster " + clusterCount);
                clusterCount++;
            });
            partBlock.find(".add-cluster").attr("count", clusterCount);
        });

        $(document).on('click', '.delete-cluster', function() {
            let partBlock = $(this).closest(".part-block");
            $(this).closest(".cluster-block").remove();
            let clusterCount = 1;
            partBlock.children(".cluster-block").each((i, item) => {
                $(item).find('h2').text("Cluster " + clusterCount);
                clusterCount++;
            });
            partBlock.find(".add-cluster").attr("count", clusterCount);
        });


        let arr = ["name", "description", "num_of_part", "num_of_question", "duration"];
        $("#type").on("change", function() {
            if ($(this).val() == "parttest") {
                $("#duration-block").addClass("d-none");
            } else {
                $("#duration-block").removeClass("d-none");
            }
        })
        $(document).on('click', '#check-template', function(e) {
            let check = true;
            let numOfPart = $(".part-block").length;
            let stateNumOfPart = $("#num_of_part").val();
            let stateNumOfQuestion = $("#num_of_question").val();
            let numOfQuestion = 0;
            if ($("#type").val() == "parttest") {
                arr.indexOf('duration') !== -1 && arr.splice(arr.indexOf('duration'), 1)
            }

            arr.every(element => {
                let m = templateCheck(element);
                if (m == false) {
                    check = false;
                    return false;
                }
                return true;
            });
            $(".part-block").each((i, item) => {
                let num = $(item).children(".part-num-of-question").val();
                numOfQuestion += parseInt(num);
            });
            if (stateNumOfPart != numOfPart) {
                let message = "Number of part does not match";
                if (stateNumOfPart > numOfPart) message = "You have created less parts than declared."
                if (stateNumOfPart < numOfPart) message = "You have created more parts than declared."
                createAlert(message);
                return false
            }
            if (stateNumOfQuestion != numOfQuestion) {
                let message = "Number of part does not match";
                if (stateNumOfQuestion > numOfQuestion) message = "You have stated less questions than declared."
                if (stateNumOfQuestion < numOfQuestion) message = "You have stated more questions than declared."
                createAlert(message);
                return false
            }
            $(".part-block").each((i, item) => {
                let p = parseInt($(item).attr("partid"));
                let stateQuesInPart = parseInt($(item).children(".part-num-of-question").val());
                let quesInPart = 0;
                let numOfCluster = $(item).children(".cluster-block").length;
                let haveCluster = numOfCluster > 0 ? true : false;
                console.log("x:" + numOfCluster + "  " + haveCluster);
                if (haveCluster) {
                    $(item).children(".cluster-block").each((j, cluster) => {
                        let part = $(cluster).children(".cluster-num-in-part").val();
                        let ques = $(cluster).children(".cluster-num-of-question").val();
                        quesInPart += parseInt(part) * parseInt(ques);
                    });
                    if (stateQuesInPart != quesInPart) {
                        let message = "Number of part does not match";
                        if (stateQuesInPart > quesInPart) message = "At part " + p + ", You have stated less questions than declared."
                        if (stateQuesInPart < quesInPart) message = "At part " + p + ", You have stated more questions than declared."
                        createAlert(message);
                        return false
                    }
                }
            })

            if (check) {
                $("#check-template").addClass("d-none");
                $("#update-template").removeClass("d-none");
            }
        });

        function templateCheck(attr) {
            if ($("#" + attr).val() <= 0) {
                let name = attr;
                if (attr == "num_of_part") name = "total parts";
                if (attr == "num_of_question") name = "total questions";
                let message = "Template's " + name + " cannot be empty";
                createAlert(message);
                return false;
            }
            return true;
        }

        function createAlert(message) {
            let ele = '<div class="admin-top-message"><div class="alert alert-danger mt-3 mb-0 d-flex w-fit-content" role="alert">';
            ele += message;
            ele += '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';

            $(".add-message").prepend(ele);
            setTimeout(function() {
                $(".admin-top-message").remove();
            }, 4000);
        }
    });
</script>

@endsection