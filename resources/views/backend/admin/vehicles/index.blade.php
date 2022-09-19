@extends('backend.layouts.master')
@section("title","Vehicle List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vehicle List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Vehicle List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Vehicle Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.vehicles.create')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i>
                                    Add
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Image</th>
                                <th>Owner Type</th>
                                <th>Owner Name</th>
                                <th>Vehicle Name</th>
                                <th>Code</th>
                                <th>Registration NO</th>
                                <th>Active/Inactive</th>
                                <th>Running Driver</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicles as $key => $vehicle)
                            <tr class="@if($vehicle->status == 0) bg-warning @elseif($vehicle->driver_id == NULL) bg-warning @endif">
                                <td>{{$key + 1}}</td>
                                <td>
                                    <img src="{{asset('uploads/vehicles/'.$vehicle->image)}}" width="80" height="50" alt="">
                                </td>
                                <td>{{$vehicle->own_vehicle_status}}</td>
                                <td>{{$vehicle->owner_name}}</td>
                                <td>{{$vehicle->vehicle_name}}</td>
                                <td>{{$vehicle->vehicle_code}}</td>
                                <td>{{$vehicle->registration_no}}</td>
                                <td>{{$vehicle->status == 1 ? 'Active' : 'Inactive'}}</td>
                                <td>
{{--                                    {{checkAlreadyVehicleAssignedOrFree($vehicle->id) > 0 ? 'Assigned' : 'Free'}}--}}
                                    @if($vehicle->driver_id != NULL)
                                        {{$vehicle->driver->name}}
                                    @else
                                        No Driver Assign Yet!
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info waves-effect" href="{{route('admin.vehicles.edit',$vehicle->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
{{--                                    <button class="btn btn-danger waves-effect" type="button"--}}
{{--                                            onclick="deleteVehicle({{$vehicle->id}})">--}}
{{--                                        <i class="fa fa-trash"></i>--}}
{{--                                    </button>--}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Image</th>
                                <th>Owner Type</th>
                                <th>Owner Name</th>
                                <th>Vehicle Name</th>
                                <th>Code</th>
                                <th>Registration NO</th>
                                <th>Active/Inactive</th>
                                <th>Running Driver</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        //sweet alert
        function deleteVehicle(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
