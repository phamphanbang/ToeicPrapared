@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <div class="mb-3 d-flex flex-row align-items-center">
                        <a class="btn btn-primary" href="{{url()->previous()}}" role="button">
                            <i class="bi bi-arrow-left pe-2"></i>
                            Back
                        </a>
                        <a class="btn btn-primary ms-auto" href="{{route('admin.template.edit',$data['template']->id)}}" role="button">
                            <i class="bi bi-pencil-square pe-2"></i>
                            Edit
                        </a>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title display-inline-block">{{$data['template']->name}}</h4>
                    </div>

                    <form class="display-inline-block float-right w-75 template-form" method="POST" action="{{route('admin.template.store')}}" id="create_template">
                        @csrf
                        <div class=" mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$data['template']->name}}" readonly>
                        </div>
                        <div class=" mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" rows="3" id="description" name="description" readonly>{{trim($data['template']->description)}}</textarea>
                        </div>
                        <div class=" mb-4">
                            <label for="num_of_part" class="form-label">Total parts</label>
                            <input type="number" class="form-control" id="num_of_part" name="num_of_part" value="{{$data['template']->num_of_part}}" readonly>
                        </div>
                        <div class=" mb-4">
                            <label for="num_of_question" class="form-label">Total questions</label>
                            <input type="number" class="form-control" id="num_of_question" name="num_of_question" value="{{$data['template']->num_of_question}}" readonly>
                        </div>
                        <div class=" mb-4">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" value="{{$data['template']->duration}}" readonly>
                        </div>
                        <div class=" mb-4">
                            <label for="have_score_range" class="form-label">Have score range</label>
                            <select name="have_score_range" id="have_score_range" class="form-select" readonly>
                                <option {!! $data['template']->have_score_range?"selected":"" !!} value="yes">Yes</option>
                                <option {!! $data['template']->have_score_range?"selected":"" !!} value="no">No</option>
                            </select>
                        </div>
                        @foreach ($data["template"]->partTemplates as $part)
                        <div class="d-flex flex-column mb-4 m-3 p-3 border rounded">
                            <div class="d-flex flex-row justify-content-between">
                                <h2 class="card-title display-inline-block">{{ $part->name }}</h2>
                            </div>
                            <label class="form-label">Part name</label>
                            <input type="text" class="form-control" id="part[1]" name="part[1]" value="{{$part->name}}" readonly>
                            <label class="form-label">Order in test</label>
                            <input type="number" class="form-control" id="partname" name="partname" value="{{$part->order_in_test}}" readonly>
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="partname" name="partname" readonly>{{ trim($part->description) }}</textarea>
                            <div class="d-flex justify-content-between">
                                <div class="w-40">
                                    <label class="form-label">Total questions</label>
                                    <input type="number" class="form-control" id="partname" name="partname" value="{{$part->num_of_question}}" readonly>
                                </div>
                                <div class="w-40">
                                    <label class="form-label">Total answer of each question</label>
                                    <input type="number" class="form-control" id="partname" name="partname" value="{{$part->num_of_answer}}" readonly>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="w-40">
                                    <label class="form-label">Question has content</label>
                                    <input type="text" class="form-control" id="partname" name="partname" value="{!! $part->have_question == 1 ? 'Yes':'No' !!}" readonly>
                                </div>
                                <div class="w-40">
                                    <label class="form-label">Question has attachment</label>
                                    <input type="text" class="form-control" id="partname" name="partname" value="{!! $part->have_attachment == 1 ? 'Yes':'No' !!}" readonly>
                                </div>
                            </div>
                            <div class="w-40">
                                <label class="form-label">Part has cluster</label>
                                <input type="text" class="form-control" id="partname" name="partname" value="{!! $part->have_cluster == 1 ? 'Yes':'No' !!}" readonly>
                            </div>
                            @foreach ($part->clusterTemplate as $cluster)
                            <div class="d-flex flex-column mb-4 m-3 p-3 border rounded">
                                <div class="d-flex flex-row justify-content-between">
                                    <h2 class="card-title display-inline-block">Cluster {{$loop->iteration}}</h2>
                                </div>
                                <label class="form-label">Cluster in part</label>
                                <input type="text" class="form-control" id="partname" name="partname" value="{{$cluster->num_in_part}}" readonly>
                                <label class="form-label">Total question</label>
                                <input type="text" class="form-control" id="partname" name="partname" value="{{$cluster->num_of_question}}" readonly>
                                <label class="form-label">Cluster has attacment</label>
                                <input type="text" class="form-control" id="partname" name="partname" value="{!! $cluster->have_attachment == 1 ? 'Yes':'No' !!}" readonly>
                                <label class="form-label">Cluster has content</label>
                                <input type="text" class="form-control" id="partname" name="partname" value="{!! $cluster->have_question == 1 ? 'Yes':'No' !!}" readonly>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection