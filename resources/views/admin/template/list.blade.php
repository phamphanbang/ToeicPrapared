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
            @if(session()->has('templateCreateSuccess'))
            <div class="alert alert-success ms-5 my-3 d-flex w-fit-content" role="alert">
                {{ session()->get('templateCreateSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('templateUpdateSuccess'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content" role="alert">
                {{ session()->get('templateUpdateSuccess') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('deleteTemplateSuccessfully'))
            <div class="alert alert-success ms-5 mt-3 mb-0 d-flex w-fit-content " role="alert">
                {{ session()->get('deleteTemplateSuccessfully') }}
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="col-lg-12 grid-margin stretch-card px-5 pt-4 w-100">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Test Template</h4>
                    <div class="d-flex flex-row py-2 justify-content-between">
                        <form class="d-flex flex-row justify-content-start align-items-center" method="POST" action="{{route('admin.template.search')}}">
                            @csrf
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control d-inline-block ms-2" value="{{request('search')?request('search'):'' }}">
                            <button type="submit" class="btn btn-primary ms-4 d-flex">
                                <i class="bi bi-search pe-2"></i>
                                Search
                            </button>
                        </form>
                        <a href="{{route('admin.template.create')}}" class="btn btn-success ">
                            <i class="bi bi-plus pe-2"></i>Create new test template</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="">Id</th>
                                    <th class="">Name</th>
                                    <th class="">Total Question</th>
                                    <th class="">Total Parts</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @foreach ($data["templates"] as $template)
                            <tbody>
                                <tr>
                                    <td class="">{{ $template->id }}</td>
                                    <td class="">{{ $template->name }}</td>
                                    <td class="">{{ $template->num_of_question }}</td>
                                    <td class="">{{ $template->num_of_part }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info px-1 py-0" href="{{route('admin.template.show',$template->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-eye pe-2"></i>
                                                Show
                                            </label>
                                        </a>
                                        <a class="btn btn-primary px-1 py-0" href="{{route('admin.template.edit',$template->id)}}">
                                            <label class="badge badge-info">
                                                <i class="bi bi-pencil-square pe-2"></i>
                                                Edit
                                            </label>
                                        </a>
                                        <div class="btn btn-danger px-1 py-0">
                                            <label for="{{ 'submit-delete-'.$template->id }}" class="badge badge-danger">
                                                <i class="bi bi-trash pe-2"></i>
                                                Delete
                                            </label>
                                        </div>
                                        <input type="submit" class="d-none" form="{{ 'delete-'.$template->id }}" id="{{ 'submit-delete-'.$template->id }}" />
                                        <form action="{{ route('admin.template.destroy',$template->id) }}" method="post" id="{{ 'delete-'.$template->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
                        @if ($data["templates"]->count() == 0)
                            <div class="d-flex justify-content-center ">
                                <h4>No result found</h4>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="ms-4">
                    {{ $data["templates"]->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection