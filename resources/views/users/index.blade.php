@extends('layouts.main')

@section('title','Users')
@push('css')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush
@section('content')
    <!-- Page Heading -->

    <div class="dropdown no-arrow mb-4">
        <button class="btn  dropdown-toggle d-none d-sm-inline-block   btn-sm btn-primary shadow-sm" type="button"
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('backend.users.export','xlsx')}}">Excel</a>
             <a class="dropdown-item" href="{{route('backend.users.export','csv')}}">CSV</a>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 w-100">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">@lang('All Users')</h6>
            <div>
                <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#createUserModal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                    <span class="text">@lang('Add User')</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Manage</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as  $user)
                        <tr>
                            <td># {{$user->id}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <button
                                    data-url="{{route('backend.users.edit',$user->id)}}"
                                    data-update-url="{{route('backend.users.update',$user->id)}}"
                                    class="btn btn-info btn-icon-split editUser" data-toggle="modal"
                                    data-target="#editUserModal"
                                    data-user-id="{{$user->id}}"
                                >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-user-edit"></i>
                                        </span>
                                    <span class="text">Edit</span>
                                </button>
                                <a href="{{route('backend.users.destroy',$user->id)}}"
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
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
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
                                    <h1 class="h4 text-gray-900 mb-4">Add User!</h1>
                                </div>
                                <form class="user" action="{{route('backend.users.store')}}" method="post">
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
                                               class="form-control form-control-user @error('username') is-invalid @enderror"
                                               placeholder="User name" name="username" value="{{old('username')}}">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="email"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="exampleInputEmail"
                                               placeholder="Email Address" name="email" value="{{old('email')}}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password"
                                                   class="form-control form-control-user @error('password') is-invalid @enderror"
                                                   id="exampleInputPassword" placeholder="Password" name="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user"
                                                   id="exampleRepeatPassword" placeholder="Repeat Password"
                                                   name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                             <div class="card mt-3 tab-card">
                                                @php
                                                    $models=['users','countries','states','cities','employees','departments'];
                                                @endphp
{{--                                                tabs header --}}
                                                <div class="card-header tab-card-header">
                                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                @foreach($models as  $model)
                                                        <li class="nav-item">
                                                            <a class="nav-link"   data-toggle="tab" href="#{{$model}}" role="tab" aria-controls="One" aria-selected="true">{{$model}}</a>
                                                        </li>
                                                @endforeach
                                                    </ul>
                                                </div>
{{--                                                tabs header --}}
{{--                                                tabs cody--}}
                                                <div class="tab-content" id="myTabContent">
                                                @foreach($models as  $k=>$model)
                                                        <div class="tab-pane fade show @if($k==0) active @endif p-3" id="{{$model}}" role="tabpanel" aria-labelledby="one-tab">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <label for="{{$model}}-create">Create</label>
                                                                    <input type="checkbox" id="{{$model}}-create" value="{{$model}}-create" class=" form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                                <div>
                                                                    <label for="{{$model}}-read">Read</label>
                                                                    <input type="checkbox" id="{{$model}}-read" value="{{$model}}-read" class=" form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                                <div>
                                                                    <label for="{{$model}}-update">Update</label>
                                                                    <input type="checkbox" id="{{$model}}-update" value="{{$model}}-update" class=" form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                                <div>
                                                                    <label for="{{$model}}-delete">Delete</label>
                                                                    <input type="checkbox" id="{{$model}}-delete" value="{{$model}}-delete" class="form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
{{--                                                tabs cody--}}
                                            </div>

                                            @error('permissions')
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
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
                                    <h1 class="h4 text-gray-900 mb-4">Edit User!</h1>
                                </div>
                                <form class="user" method="post" id="editUserForm">
                                    @method('put')
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="@error('first_name') is-invalid @enderror form-control form-control-user"
                                                   id="edit-user-first-name"
                                                   placeholder="First Name"
                                                   name="first_name">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                                   id="edit-user-last-name"
                                                   placeholder="Last Name"
                                            name="last_name">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror"
                                               id="edit-user-username"
                                               placeholder="User name" name="username">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="edit-user-email"
                                               name="email"
                                               placeholder="Email Address">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                   id="exampleInputPassword" placeholder="Password" name="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user"
                                                   id="exampleRepeatPassword" placeholder="Repeat Password" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <div class="card mt-3 tab-card">
                                                @php
                                                    $models=['users','countries','states','cities','employees','departments'];
                                                @endphp
                                                {{--                                                tabs header --}}
                                                <div class="card-header tab-card-header">
                                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                        @foreach($models as  $model)
                                                            <li class="nav-item">
                                                                <a class="nav-link"   data-toggle="tab" href="#edit-id-{{$model}}" role="tab" aria-controls="One" aria-selected="true">{{$model}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                {{--                                                tabs header --}}
                                                {{--                                                tabs cody--}}
                                                <div class="tab-content" id="myTabContent">
                                                    @foreach($models as  $k=>$model)
                                                        <div class="tab-pane fade show @if($k==0) active @endif p-3" id="edit-id-{{$model}}" role="tabpanel" aria-labelledby="one-tab">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <label for="edit-{{$model}}-create">Create</label>
                                                                    <input type="checkbox" id="edit-{{$model}}-create" value="{{$model}}-create" class=" form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                                <div>
                                                                    <label for="edit-{{$model}}-read">Read</label>
                                                                    <input type="checkbox" id="edit-{{$model}}-read" value="{{$model}}-read" class=" form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                                <div>
                                                                    <label for="edit-{{$model}}-update">Update</label>
                                                                    <input type="checkbox" id="edit-{{$model}}-update" value="{{$model}}-update" class=" form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                                <div>
                                                                    <label for="edit-{{$model}}-delete">Delete</label>
                                                                    <input type="checkbox" id="edit-{{$model}}-delete" value="{{$model}}-delete" class="form-control-user @error('permissions') is-invalid @enderror"  name="permissions[]">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                                {{--                                                tabs cody--}}
                                            </div>

                                            @error('permissions')
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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you are ready to delete this user.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger"
                       onclick="event.preventDefault();document.getElementById('delete-user-form').submit(); ">Delete</button>
                    <form id="delete-user-form"  method="POST" class="d-none">
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
                $('#delete-user-form').attr('action',$(this).attr('href'));

             })

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
                        console.log(updateUrl);
                        fillInputs(data[0], updateUrl);
                    }, error: function (data) {
                        console.log(data, 'err')

                    }
                })
            }

            function fillInputs(data, updateUrl) {
            $(`#editUserForm input[type='checkbox']`).each((i,e)=>$(e).prop('checked',false));
                data.permissions.forEach((e,i)=>{
                     $(`#editUserForm  #edit-${e.name}`).prop('checked',true);
                })
                // #edit-id-${e.name.split('-')[0]}
                $('#editUserForm').attr('action', updateUrl);
                $("#edit-user-first-name").val(data.first_name);
                $("#edit-user-last-name").val(data.last_name);
                $("#edit-user-username").val(data.username);
                $("#edit-user-email").val(data.email);
            }

        });
    </script>
@endpush
