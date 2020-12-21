@extends('layouts.backend.app')

@section('title','Profile')

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
                    <i class="pe-7s-user icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Profile</div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('app.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">PROFILE PHOTO</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-6 mx-auto">
                                <div class="position-relative form-group">
                                    <label for="avatar">Avatar (Only Image are allowed) </label>
                                    <input type="file" name="avatar" id="avatar"
                                           class="dropify @error('avatar') is-invalid @enderror"
                                           data-default-file="{{ Auth::user()->getFirstMediaUrl('avatar') ?? '' }}">
                                    @error('avatar')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">CONTACT INFORMATION</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ Auth::user()->name ?? old('name') }}" required
                                       autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ Auth::user()->email ?? old('email') }}" required
                                       autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    <span>Update</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <!-- Select2 Plugin Js -->
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <!-- Dropify Plugin Js -->
    <script src="{{ asset('assets/plugins/dropify/dropify.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
            $('.js-example-basic-single').select2();
        });
    </script>
@endpush