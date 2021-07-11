@extends('layouts.main')

@section('title','Countries')
@push('css')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush
@php
    $data=$countries;
    $loading=false
@endphp
@section('content')
    <div class="dropdown no-arrow mb-4">
        <button class="btn  dropdown-toggle d-none d-sm-inline-block   btn-sm btn-primary shadow-sm" type="button"
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('backend.countries.export','xlsx')}}">Excel</a>
            <a class="dropdown-item" href="{{route('backend.countries.export','csv')}}">CSV</a>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 w-100">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">@lang('All Countries')</h6>
            <div>
                <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#createUserModal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                    <span class="text">@lang('Add Country')</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Country Name</th>
                        <th>Country Code</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Country Name</th>
                        <th>Country Code</th>
                        <th>Manage</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($data as  $item)
                        <tr>
                            <td># {{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->country_code}}</td>
                            <td>
                                <button
                                    data-url="{{route('backend.countries.edit',$item->id)}}"
                                    data-update-url="{{route('backend.countries.update',$item->id)}}"
                                    class="btn btn-info btn-icon-split editUser" data-toggle="modal"
                                    data-target="#editUserModal"
                                    data-user-id="{{$item->id}}"
                                >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    <span class="text">Edit</span>
                                </button>
                                <a href="{{route('backend.countries.destroy',$item->id)}}"
                                   class="btn btn-danger btn-icon-split delete-user-btn" data-toggle="modal"
                                   data-target="#deleteUserModal"
                                >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    <span class="text">Delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- create Modal-->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Country</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--                    modal body--}}
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Add Country!</h1>
                                </div>
                                <form class="user" action="{{route('backend.countries.store')}}" method="post">
                                    @method('post')
                                    @csrf
                                    <div class="form-group row">

                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text"
                                                   class="form-control form-control-user @error('name') is-invalid @enderror"
                                                   name="name" id="exampleFirstName"
                                                   placeholder="Country Name" value="{{old('name')}}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="text"
                                                   class="form-control form-control-user @error('country_code') is-invalid @enderror"
                                                   id="exampleLastName"
                                                   placeholder="Country Code" name="country_code"
                                                   value="{{old('country_code')}}">
                                            @error('country_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Add
                                    </button>
                                    <hr>
                                </form>
                                <hr>
                            </div>
                        </div>
                    </div>
                    {{--                    modal body--}}
                     </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- edit Modal-->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--                    modal body--}}
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Edit Country!</h1>
                                </div>
                                <form class="user" method="post" id="editUserForm">
                                    @method('put')
                                    @csrf
                                    <div class="form-group row">

                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text"
                                                   class="@error('name') is-invalid @enderror form-control form-control-user"
                                                   id="edit-country-name"
                                                   placeholder="Name"
                                                   name="name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="text"
                                                   class="form-control form-control-user @error('country_code') is-invalid @enderror"
                                                   id="edit-country-code"
                                                   placeholder="Country Code"
                                                   name="country_code">
                                            @error('country_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Update
                                    </button>
                                    <hr>
                                </form>
                                <hr>
                            </div>
                        </div>
                    </div>
                    {{--                    modal body--}}

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- delete Modal-->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Delete this Country?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you are ready to delete this country.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger"
                            onclick="event.preventDefault();document.getElementById('delete-user-form').submit(); ">
                        Delete
                    </button>
                    <form id="delete-user-form" method="POST" class="d-none">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    <script>
        $(function () {
            $('.delete-user-btn').on('click', function () {
                $('#delete-user-form').attr('action', $(this).attr('href'));

            });

            $('.editUser').on('click', function () {
                const url = $(this).data('url');
                const id = $(this).data('user-id');
                const updateUrl = $(this).data('update-url');
                getUser(url, {id}, updateUrl);
            });

            function getUser(url, data, updateUrl) {
                $.ajax({
                    method: "GET",
                    url,
                    data,
                    success: function (data) {
                         fillInputs(data[0], updateUrl);
                    }, error: function (data) {
                        console.log(data, 'err')

                    }
                })
            }

            function fillInputs(data, updateUrl) {
                 $('#editUserForm').attr('action', updateUrl);
                $("#edit-country-name").val(data.name);
                $("#edit-country-code").val(data.country_code);
            }
        });
    </script>
@endpush
