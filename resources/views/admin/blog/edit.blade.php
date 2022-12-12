@extends('admin.layouts.app')

@section('content')

<div class="container m-0 p-0">
    <div class="row w-100">
        @if(session()->has('blogCreateSuccess'))
        <div class="alert alert-success ms-5 mt-3 mb-0 w-auto d-flex " role="alert">
            {{ session()->get('blogCreateSuccess') }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session()->has('blogChangeSuccess'))
        <div class="alert alert-success ms-5 mt-3 mb-0 w-auto d-flex " role="alert">
            {{ session()->get('blogChangeSuccess') }}
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="col-lg-12 grid-margin stretch-card ps-5 pt-4 w-100 ">
            <div class="card w-100 shadow">
                <div class="card-body">
                    <h4 class="card-title display-inline-block">Edit Blog {{$data["blog"]->name }}</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <form class="display-inline-block float-right w-75" method="POST" action="{{route('admin.blog.update',$data['blog']->id)}}">
                            @csrf
                            @method('PUT')
                            <div class=" mb-4">
                                <label for="name" class="form-label">Title</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter blog's title" value="{{ $data['blog']->name }}">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4 d-flex flex-column">
                                <div class="w-100">
                                    <img src="{{asset('storage/'.$data['blog']->banner)}}" class="w-100" alt="">
                                </div>
                                <label for="banner" class="form-label">New Banner</label>
                                <input type="file" class="form-control" id="banner" name="banner">
                                @error('banner')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <textarea class="tinymce-editor" name="blog" value="{{$data['blog']->blog}}"></textarea>
                                @error('blog')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <input type="text" class="d-none" id="id" name="id" value="{{ $data['blog']->name }}">
                            <button type="submit" class="btn btn-success float-end">Save</button>
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
    var blog = {!!  json_encode(old('blog')?old('blog'):$data['blog']->blog) !!};
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 400,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount', 'image'
        ],
        toolbar: 'undo redo | formatselect | image ' +
            'bold italic backcolor link unlink| alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css',
        setup: function(editor) {
            editor.on('init', function(e) {
                editor.setContent(blog);
            });
        }
    });
</script>
@endsection