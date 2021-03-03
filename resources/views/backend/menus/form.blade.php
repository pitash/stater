@extends('layouts.backend.app')

@section('title','Menu')

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-menu icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __((isset($menu) ? 'Edit' : 'Create New') . ' Menu') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.menus.index') }}" class="btn-shadow btn btn-danger">
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
                  action="{{ isset($menu) ? route('app.menus.update',$menu->id) : route('app.menus.store') }}">
                @csrf
                @if (isset($menu))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Basic Info</h5>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $menu->name ?? old('name') }}" required>
                                    
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="" cols="" rows="" class="form-control @error('description') is-invalid @enderror">{{ $menu->description ?? old('description') }}</textarea>
                                    
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    @isset($menu )
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
