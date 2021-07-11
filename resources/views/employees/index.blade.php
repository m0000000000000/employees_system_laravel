@extends('layouts.main')

@section('title','Employees')
@push('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>

    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <style>
        .select2 {
            width: 100% !important;
        }

        span.select2-selection.select2-selection--single {
            height: 43px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #ffffff54 !important;
            border: 1px solid #aaaaaa69 !important;;
            border-radius: 35px !important;;
        }
    </style>
@endpush
@php
    $data=$employees
@endphp
@section('content')
    <div class="dropdown no-arrow mb-4">
        <button class="btn  dropdown-toggle d-none d-sm-inline-block   btn-sm btn-primary shadow-sm" type="button"
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('backend.employees.export','xlsx')}}">Excel</a>
            <a class="dropdown-item" href="{{route('backend.employees.export','csv')}}">CSV</a>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 w-100">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">@lang('All Employees')</h6>
            <div>
                <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#createUserModal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                    <span class="text">@lang('Add Employee')</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Manage</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($data as  $item)
                        <tr>
                            <td># {{$item->id}}</td>
                            <td>{{$item->first_name}}</td>
                            <td>{{$item->last_name}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->department->name}}</td>
                            <td>{{$item->country->name}}</td>
                            <td>{{$item->state->name}}</td>
                            <td>{{$item->city->name}}</td>
                            <td>
                                <button
                                    data-url="{{route('backend.employees.edit',$item->id)}}"
                                    data-update-url="{{route('backend.employees.update',$item->id)}}"
                                    class="btn btn-info btn-icon-split editUser" data-toggle="modal"
                                    data-target="#editUserModal"
                                    data-user-id="{{$item->id}}"
                                >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-user-edit"></i>
                                        </span>
                                    <span class="text">Edit</span>
                                </button>
                                <a href="{{route('backend.employees.destroy',$item->id)}}"
                                   class="btn btn-danger btn-icon-split delete-user-btn" data-toggle="modal"
                                   data-target="#deleteUserModal"
                                >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-user-minus"></i>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
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
                                    <h1 class="h4 text-gray-900 mb-4">Add Employee!</h1>
                                </div>
                                <form class="user" action="{{route('backend.employees.store')}}" method="post">
                                    @method('post')
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text"
                                                   class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                                   name="first_name" id="exampleFirstName"
                                                   placeholder="First Name" value="{{old('first_name')}}">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text"
                                                   class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                                   id="exampleLastName"
                                                   placeholder="Last Name" name="last_name"
                                                   value="{{old('last_name')}}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control form-control-user @error('middle_name') is-invalid @enderror"
                                               placeholder="Middle name" name="middle_name"
                                               value="{{old('middle_name')}}">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control form-control-user @error('address') is-invalid @enderror"
                                               placeholder="Address" name="address" value="{{old('address')}}">
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select
                                                class="select2 w-100 form-control form-control-user  @error('department_id') is-invalid @enderror"
                                                name="department_id">
                                                @foreach($departments as  $department)
                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>

                                            @error('department_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <select data-state-url="{{route('backend.states.show','')}}"
                                                    class="country_id select2 w-100 form-control form-control-user  @error('country_id') is-invalid @enderror"
                                                    name="country_id">
                                                <option>select country</option>
                                                @foreach($countries as  $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>

                                            @error('country_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select data-city-url="{{route('backend.cities.show','')}}"
                                                    class=" state_id select2 w-100 form-control form-control-user  @error('state_id') is-invalid @enderror"
                                                    name="state_id">
                                                <option>select state</option>
                                            </select>

                                            @error('state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <select
                                                class="city_id select2 w-100 form-control form-control-user  @error('city_id') is-invalid @enderror"
                                                name="city_id">

                                            </select>

                                            @error('city_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="number"
                                                   class="form-control form-control-user @error('zip_code') is-invalid @enderror"
                                                   name="zip_code" id="exampleFirstName"
                                                   placeholder="Zip Code" value="{{old('zip_code')}}">
                                            @error('zip_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date" name="birthday"
                                                   class="form-control form-control-user @error('birthday') is-invalid @enderror"
                                                   value="{{old('birthday')}}">

                                            @error('birthday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date"
                                                   name="date_hired"
                                                   class="form-control form-control-user @error('date_hired') is-invalid @enderror"
                                                   placeholder="Date hired" value="{{old('date_hired')}}">

                                            @error('date_hired')
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
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
                                    <h1 class="h4 text-gray-900 mb-4">Edit Employee!</h1>
                                </div>
                                <form class="user" method="post" id="editUserForm">
                                    @method('put')
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text"
                                                   class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                                   name="first_name" id="edit-first-name"
                                                   placeholder="First Name" value="{{old('first_name')}}">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text"
                                                   class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                                   id="edit-last-name"
                                                   placeholder="Last Name" name="last_name"
                                                   value="{{old('last_name')}}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="edit-middle-name"
                                               class="form-control form-control-user @error('middle_name') is-invalid @enderror"
                                               placeholder="Middle name" name="middle_name"
                                               value="{{old('middle_name')}}">
                                        @error('middle_name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="edit-address"
                                               class="form-control form-control-user @error('address') is-invalid @enderror"
                                               placeholder="Address" name="address" value="{{old('address')}}">
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select id="edit-department"
                                                    class="select2 w-100 form-control form-control-user  @error('department_id') is-invalid @enderror"
                                                    name="department_id">
                                                @foreach($departments as  $department)
                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>

                                            @error('department_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <select data-state-url="{{route('backend.states.show','')}}"
                                                    id="edit-country-id"
                                                    class="country_id select2 w-100 form-control form-control-user  @error('country_id') is-invalid @enderror"
                                                    name="country_id">
                                                <option>select country</option>
                                                @foreach($countries as  $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>

                                            @error('country_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select
                                                id="edit-state-id"
                                                data-city-url="{{route('backend.cities.show','')}}"
                                                class="state_id select2 w-100 form-control form-control-user  @error('state_id') is-invalid @enderror"
                                                name="state_id">
                                                <option>select state</option>
                                            </select>

                                            @error('state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <select
                                                id="edit-city-id"
                                                class="city_id select2 w-100 form-control form-control-user  @error('city_id') is-invalid @enderror"
                                                name="city_id">

                                            </select>

                                            @error('city_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="form-group row">

                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="number"
                                                   class="form-control form-control-user @error('zip_code') is-invalid @enderror"
                                                   name="zip_code" id="edit-zip-code"
                                                   placeholder="Zip Code" value="{{old('zip_code')}}">
                                            @error('zip_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date" name="birthday"
                                                   class="form-control form-control-user @error('birthday') is-invalid @enderror">

                                            @error('birthday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date"
                                                   name="date_hired"
                                                   class="form-control form-control-user @error('date_hired') is-invalid @enderror"
                                                   placeholder="Date hired">

                                            @error('date_hired')
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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to delete this Employee?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you are ready to delete this Employee.</div>
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
    <script src="{{asset('js/select2.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    <script>
        $(function () {
            $('.state_id').parent().hide();
            $('.city_id').parent().hide();
            $('.country_id').on('change', getData);

            function getData(e) {
                const url = $(this).data('state-url') + '/' + e.target.value;
                $.ajax({
                    url,
                    method: 'GET',
                    success(data) {
                        $('.state_id').parent().show();
                        $('.state_id').children().remove();
                        $('.state_id').append(`<option>....</option>`);
                        data[0].forEach((e) => {
                            $('.state_id').append(`<option value='${e.id}'>${e.name}</option>`)
                        })
                    }
                });
            }

            $('.state_id').on('change', getCities);

            function getCities(e) {
                const url = $(this).data('city-url') + '/' + e.target.value;
                $.ajax({
                    url,
                    method: 'GET',
                    success(data) {
                        $('.city_id').parent().show();
                        $('.city_id').children().remove();
                        $('.state_id').append(`<option>....</option>`);
                        data[0].forEach((e) => {
                            $('.city_id').append(`<option value='${e.id}'>${e.name}</option>`)
                        })
                    }
                });
            }

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
                        console.log(data);
                        fillInputs(data[0], updateUrl);
                    }, error: function (data) {
                        console.log(data, 'err')

                    }
                })
            }

            function fillInputs(data, updateUrl) {
                console.log(data);
                $('#editUserForm').attr('action', updateUrl);
                $("#edit-first-name").val(data.first_name);
                $("#edit-last-name").val(data.last_name);
                $("#edit-middle-name").val(data.middle_name);
                $("#edit-address").val(data.address);
                $("#edit-zip-code").val(data.zip_code);
                $("#edit-country-id option").each((i, e) => {
                    if (e.value == data.country_id) {
                        $(e).prop('selected', true);
                        $("#edit-country-id").trigger('change');
                        $("#edit-state-id").trigger('change');
                    }
                });

            }
            $('.select2').select2({});
        });

    </script>
@endpush
