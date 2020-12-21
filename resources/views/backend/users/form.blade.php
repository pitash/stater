@extends('layouts.backend.app')

@section('title','Users')

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
                <div>{{ __((isset($user) ? 'Edit' : 'Create New') . ' User') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.users.index') }}" class="btn-shadow btn btn-danger">
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
                  action="{{ isset($user) ? route('app.users.update',$user->id) : route('app.users.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">User Info</h5>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name ?? old('name') }}" required autofocus>
                                    
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" required autofocus>
                                    
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" 
                                    placeholder="******" {{ !isset($user) ? 'required' : '' }}>
                                    
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" id="confirm_password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" 
                                    placeholder="******" {{ !isset($user) ? 'required' : '' }}>
                                    
                                    @error('password')
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
                                <h5 class="card-title">Select Role and Status</h5>

                                <div class="form-group">
                                    <label for="role">Select Role</label>
                                    <select id="role" class="js-example-basic-single form-control @error('role') is-invalid @enderror" name="role" required>
                                        @foreach ($roles as $key=>$role)
                                            <option value="{{ $role->id }}" @isset($user) {{ $user->role->id == $role->id ? 'selected' : '' }} @endisset >{{ $role->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <input type="file" id="avatar" class="dropify form-control @error('avatar') is-invalid @enderror" 
                                    name="avatar" data-default-file = "{{ isset($user) ? $user->getFirstMediaUrl('avatar') : '' }}" {{ !isset($user) ? 'required' : '' }}>

                                    @error('avatar')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @isset($user) {{ $user->status == true ? 'checked' : '' }} @endisset>
                                        <label class="custom-control-label" for="status">Status</label>
                                    </div>
                                   
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    @isset($user )
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
                    </div>
                </div>
            </form>
        </div>
    </div>
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