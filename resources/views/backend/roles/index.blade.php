@extends('layouts.backend.app')

@push('css')
<!-- Jquery DataTable Plugin Css -->
<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-check icon-gradient bg-mean-fruit">
                        </i>
                </div>
                <div>Roles Management
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.roles.create') }}" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-1">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        Create Role
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
                                <th class="text-center">Permissions</th>
                                <th class="text-center">Updated At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key=>$role)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $role->name }}</td>
                                    <td class="text-center">
                                        @if ($role->permissions->count() > 0)
                                            <span class="badge badge-info">{{ $role->permissions->count() }}</span>
                                        @else
                                            <span class="badge badge-danger">No Permission Found</span>
                                            
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $role->updated_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        <button value="{{ route('app.roles.edit',$role->id) }}" type="button" href="" class="btn btn-info btn-sm edit_link" title='Edit'>
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </button>
                                        @if ($role->deletable == true)
                                            <button type="button" onclick="deleteData({{ $role->id }})" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Delete</span>
                                            </button>
                                            <form id="delete-form-{{ $role->id }}" method="POST" action="{{ route('app.roles.destroy',$role->id) }}" style="display: none">
                                                @csrf
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