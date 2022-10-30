@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        <!-- @error('name')
        <div class="alert alert-danger ms-5 mt-3 mb-0 w-auto d-flex float-alert" role="alert">
            {{ $message }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror
        @error('blog')
        <div class="alert alert-danger ms-5 mt-3 mb-0 w-auto d-flex float-alert" role="alert">
            {{ $message }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror -->
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
                        <h4 class="card-title display-inline-block">Create New Test's Template</h4>

                    </div>

                    <form class="display-inline-block float-right w-75 " id="template-form" method="POST" action="{{route('admin.template.store')}}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" rows="3" id="description" name="description" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="num_of_part" class="form-label">Total parts</label>
                            <input type="number" class="form-control" id="num_of_part" name="num_of_part" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="num_of_question" class="form-label">Total questions</label>
                            <input type="number" class="form-control" id="num_of_question" name="num_of_question" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="public">Public</option>
                                <option value="onhold">On Hold</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="have_score_range" class="form-label">Have score range</label>
                            <select name="have_score_range" id="have_score_range" class="form-select">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <!-- <div class="d-flex flex-column mb-4 m-3 p-3 border rounded">
                            <div class="d-flex flex-row justify-content-between">
                                <h2 class="card-title display-inline-block">Part 1</h2>
                                <button type="button" class="btn btn-danger float-end">Delete Part</button>
                            </div>
                            <label for="part[1]" class="form-label">Part name</label>
                            <input type="text" class="form-control" id="part[1]" name="part[1]" placeholder="" value="">
                            <label for="partname" class="form-label">Order in test</label>
                            <input type="text" class="form-control" id="partname" name="partname" placeholder="" value="">
                            <label for="partname" class="form-label">Description</label>
                            <input type="text" class="form-control" id="partname" name="partname" placeholder="" value="">
                            <label for="partname" class="form-label">Total questions</label>
                            <input type="text" class="form-control" id="partname" name="partname" placeholder="" value="">
                            <div class="d-flex flex-column mb-4 m-3 p-3 border rounded">
                                <div class="d-flex flex-row justify-content-between">
                                    <h2 class="card-title display-inline-block">Cluster 1</h2>
                                    <button type="button" class="btn btn-danger float-end">Delete Cluster</button>
                                </div>
                                <label for="partname" class="form-label">Cluster in part</label>
                                <input type="text" class="form-control" id="partname" name="partname" placeholder="" value="">
                                <label for="partname" class="form-label">Total question</label>
                                <input type="text" class="form-control" id="partname" name="partname" placeholder="" value="">
                            </div>
                            <button type="button" class="btn btn-primary mt-2 ms-auto" id="add-cluster" count="0">Add Cluster</button>
                        </div> -->
                        <button type="button" class="btn btn-primary ms-50" id="add-part" count="0">Add Part</button>
                        <button type="submit" form="template-form" class="btn btn-success ms-auto d-block mt-5">Create Template</button>
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
        $("#add-part").click(() => {
            let partInput = "parts[" + partId + "]";
            let partName = partInput + "[name]";
            let partDescription = partInput + "[description]";
            let partNumOfQuestion = partInput + "[num_of_question]";
            let partNumOfAnswer = partInput + "[num_of_answer]";
            let partOrderInTest = partInput + "[order_in_test]";
            let partHaveScoreRange = partInput + "[have_score-range]";
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
            block += "<input required type='number' class='form-control' id=" + partNumOfQuestion + " name=" + partNumOfQuestion + ">"
            block += "<label for=" + partNumOfAnswer + " class='form-label'>Total answer of each question</label>";
            // block += "<input required type='number' class='form-control' id=" + partNumOfAnswer + " name=" + partNumOfAnswer + ">"
            block += "<select name="+partNumOfAnswer+" id="+partNumOfAnswer+" class='form-select'>";
            block += "<option value='3'>3</option>";
            block += "<option value='4'>4</option>";
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
            let block = "<div class='d-flex flex-column mb-4 m-3 p-3 border rounded cluster-block'>";
            block += '<div class="d-flex flex-row justify-content-between">';
            block += "<h2 class='card-title display-inline-block'>Cluster " + clusterId + "</h2>";
            block += '<button type="button" class="btn btn-danger float-end delete-cluster">Delete Cluster</button>';
            block += '</div>';
            block += "<label for=" + numInPart + " class='form-label'>Cluster in part</label>";
            block += "<input required type='number' class='form-control' id=" + numInPart + " name=" + numInPart + ">";
            block += "<label for=" + numOfQuestion + " class='form-label'>Total question</label>";
            block += "<input required type='number' class='form-control' id=" + numOfQuestion + " name=" + numOfQuestion + ">";
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
    });
</script>

@endsection