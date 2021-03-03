@extends('layouts.backend.app')

@section('title','Menus')

@push('css')
    <!-- Jquery DataTable Plugin Css -->
<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-menu icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __('All Menus') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.menus.create') }}" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        {{ __('Create Menu') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $key=>$menu)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td>
                                        <code>{{ $menu->name }}</code>
                                    </td>
                                    <td >
                                        {{ $menu->description }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('app.menus.builder',$menu->id) }}" class="btn btn-success btn-sm" type="button" title='Builder'>
                                            <i class="fas fa-list-ul"></i>
                                            <span>{{ __('Builder') }}</span>
                                        </a>
                                        <button value="{{ route('app.menus.edit',$menu->id) }}" type="button" href="" 
                                            class="btn btn-info btn-sm edit_link" title='Edit'>
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </button>
                                        @if($menu->deletable == true)
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $menu->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete</span>
                                        </button>
                                        <form id="delete-form-{{ $menu->id }}"
                                              action="{{ route('app.menus.destroy',$menu->id) }}" method="POST"
                                              style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

<!-- Jquery DataTable Plugin Js -->
<script src="{{ asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>

@endpush
