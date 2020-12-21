@extends('layouts.backend.app')

@section('title','Page')

@push('css')
    <!-- Select2 Plugin Css -->
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <!-- Dropify Plugin Css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('assets/plugins/dropify/dropify.min.css') }}" rel="stylesheet"> --}}
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __((isset($page) ? 'Edit' : 'Create New') . ' Page') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.pages.index') }}" class="btn-shadow btn btn-danger">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-arrow-circle-left fa-w-20"></i>
                        </span>
                        {{ __('Back to list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- form start -->
            <form role="form" id="userFrom" method="POST"
                  action="{{ isset($page) ? route('app.pages.update',$page->id) : route('app.pages.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if (isset($page))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Basic Info</h5>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $page->title ?? old('title') }}" required autofocus>
                                    
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="excerpt">Excerpt</label>
                                    <textarea name="excerpt" id="" cols="" rows="" class="form-control @error('excerpt') is-invalid @enderror">{{ $page->excerpt ?? old('excerpt') }}</textarea>
                                    
                                    @error('excerpt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea name="body" id="body" cols="" rows="" class="form-control @error('body') is-invalid @enderror">{{ $page->body ?? old('body') }}</textarea>
                                    
                                    @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> 
                                
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Select Image and Status</h5>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" id="image" class="dropify form-control @error('image') is-invalid @enderror" 
                                    name="image" data-default-file = "{{ isset($page) ? $page->getFirstMediaUrl('image') : '' }}" {{ !isset($page) ? 'required' : '' }}>

                                    @error('image')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @isset($page) {{ $page->status == true ? 'checked' : '' }} @endisset>
                                        <label class="custom-control-label" for="status">Status</label>
                                    </div>
                                   
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    @isset($page )
                                        <i class="fas fa-arrow-circle-up"></i>
                                        <span>Update</span>
                                    @else
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Create</span>
                                    @endisset
                                </button>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Meta Info</h5>

                                <div class="form-group">
                                    <label for="name">Meta Description</label>
                                    <textarea name="meta_description" id="" cols="" rows="" class="form-control @error('meta_description') is-invalid @enderror">{{ $page->meta_description ?? old('meta_description') }}</textarea>
                                    
                                    @error('meta_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Meta Keywords</label>
                                    <textarea name="meta_keywords" id="" cols="" rows="" class="form-control @error('meta_keywords') is-invalid @enderror">{{ $page->meta_keywords ?? old('meta_keywords') }}</textarea>
                                    
                                    @error('meta_keywords')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <!-- Tiny Plugin Js -->
    <script src="https://cdn.tiny.cloud/1/77mc4wxbfwduse0kaiteb9x2jncv2n7xo3vp9emy9e31563u/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Dropify Plugin Js -->
    <script src="{{ asset('assets/plugins/dropify/dropify.min.js') }}"></script>
    
    <script>
        tinymce.init({
            selector: '#body',
            plugins: 'print preview paste importcss searchreplace autolink directionality code visualblocks visualchars image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | preview | insertfile image media link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            image_advtab: true,
            content_css: '//www.tiny.cloud/css/codepen.min.css',
            importcss_append: true,
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
        });

        $(document).ready(function() {
            $('.dropify').dropify();
            $('.js-example-basic-single').select2();
        });
    </script>
@endpush