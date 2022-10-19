@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        @error('name')
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
        @enderror
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Create New Blog</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <form class="display-inline-block float-right w-75" method="POST" action="{{route('admin.blog.store')}}">
                            @csrf
                            <div class=" mb-4">
                                <label for="name" class="form-label">Title</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter blog's title" value="{{ old('name')?old('name'):'' }}">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <textarea class="tinymce-editor" name="blog"></textarea>
                                @error('blog')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success float-end">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount', 'image'
        ],
        toolbar: 'undo redo | formatselect | image ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
</script>
@endsection