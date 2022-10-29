@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row">
        <!-- @if(session()->has('deleteUserSuccessfully'))
        <div class="alert alert-success ms-5 my-3 d-flex" role="alert">
            {{ session()->get('deleteUserSuccessfully') }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif -->
        <div class="admin-top-message">
            @if(session()->has('testCreateSuccess'))
            <div class="alert alert-success ms-5 my-3 d-flex w-fit-content" role="alert">
                {{ session()->get('testCreateSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('testUpdateSuccess'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ session()->get('testUpdateSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('deleteTestSuccessfully'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content " role="alert">
                {{ session()->get('deletetestSuccessfully') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="col-lg-12 grid-margin stretch-card px-5 pt-4 w-100">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Test</h4>
                    <div class="d-flex flex-row py-2 justify-content-between">
                        <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.test.search')}}">
                            @csrf
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control d-inline-block ms-2" value="{{request('search')?request('search'):'' }}">
                            <button type="submit" class="btn btn-primary ms-4 d-flex">
                                <i class="bi bi-search pe-2"></i>
                                Search
                            </button>
                        </form>
                        <a href="{{route('admin.test.create')}}" class="btn btn-success ">
                            <i class="bi bi-plus pe-2"></i>Create new test</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="">Id</th>
                                    <th class="">Name</th>
                                    <th class="">Total Question</th>
                                    <th class="">Created At</th>
                                    <th class="">Score Range</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @foreach ($data["tests"] as $test)
                            <tbody>
                                <tr>
                                    <td class="">{{ $test->id }}</td>
                                    <td class="">{{ $test->name }}</td>
                                    <td class="">{{ $test->num_of_question }}</td>
                                    <td class="">{{ $test->created_at }}</td>
                                    <td class="">{{ $test->score_range ? $test->score_range : 'None' }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info px-1 py-0" href="{{route('admin.test.show',$test->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-eye pe-2"></i>
                                                Show
                                            </label>
                                        </a>
                                        <a class="btn btn-primary px-1 py-0" href="{{route('admin.test.edit',$test->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-pencil-square pe-2"></i>
                                                Edit
                                            </label>
                                        </a>
                                        <div class="btn btn-danger px-1 py-0">
                                            <label for="{{ 'submit-delete-'.$test->id }}" class="badge badge-danger">
                                                <i class="bi bi-trash pe-2"></i>
                                                Delete
                                            </label>
                                        </div>
                                        <input type="submit" class="d-none" form="{{ 'delete-'.$test->id }}" id="{{ 'submit-delete-'.$test->id }}" />
                                        <form action="{{ route('admin.test.destroy',$test->id) }}" method="post" id="{{ 'delete-'.$test->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
                        @if ($data["tests"]->count() == 0)
                            <div class="d-flex justify-content-center ">
                                <h4>No record available</h4>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="ms-4">
                    {{ $data["tests"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection