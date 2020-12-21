@extends('layouts.backend.app')

@section('title','Pages')

@push('css')
    <!-- Jquery DataTable Plugin Css -->
<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-news-paper icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __('All Pages') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.pages.create') }}" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        {{ __('Create Page') }}
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
                            <th class="text-center">Title</th>
                            <th class="text-center">URl</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Last Modified</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $key=>$page)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td>
                                        {{ $page->title }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('page',$page->slug) }}">{{ $page->slug }}</a>
                                    </td>
                                    <td class="text-center">
                                        @if ($page->status)
                                            <div class="badge badge-success">Active</div>
                                        @else
                                            <div class="badge badge-danger">Inactive</div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $page->updated_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        <button value="{{ route('app.pages.edit',$page->id) }}" type="button" href="" class="btn btn-info btn-sm edit_link" title='Edit'>
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $page->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete</span>
                                        </button>
                                        <form id="delete-form-{{ $page->id }}"
                                              action="{{ route('app.pages.destroy',$page->id) }}" method="POST"
                                              style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
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