@extends('backend.layouts.master')
@section("title","Vehicle Driver Assign List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vehicle Driver Assign List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Vehicle Driver Assign List</li>
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
                        <h3 class="card-title float-left">Vehicle Driver Assign Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.vehicle-driver-assigns.create')}}">
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
                                <th>Vehicle</th>
                                <th>Driver</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Salary Type</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicleDriverAssigns as $key => $vehicleDriverAssign)
                            <tr class="{{$vehicleDriverAssign->end_status == 0 ? 'bg-success' : ''}}">
                                <td>{{$key + 1}}</td>
                                <td>{{$vehicleDriverAssign->vehicle->vehicle_name}} ({{$vehicleDriverAssign->vehicle->vehicle_code}})</td>
                                <td>{{$vehicleDriverAssign->driver->name}} ({{$vehicleDriverAssign->driver->driver_code}})</td>
                                <td>{{$vehicleDriverAssign->year}}</td>
                                <td>{{$vehicleDriverAssign->month}}</td>
                                <td>{{$vehicleDriverAssign->start_date}}</td>
                                <td>{{$vehicleDriverAssign->end_date}}</td>
                                <td>{{$vehicleDriverAssign->end_status == 1 ? 'Closed' : 'Running'}}</td>
                                <td>{{$vehicleDriverAssign->driver->salary_type}}</td>
                                <td>{{$vehicleDriverAssign->duration}}</td>
                                <td>
{{--                                    @if($vehicleDriverAssign->end_status == 0)--}}
                                    <a class="btn btn-info waves-effect" href="{{route('admin.vehicle-driver-assigns.edit',$vehicleDriverAssign->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
{{--                                    <button class="btn btn-danger waves-effect" type="button"--}}
{{--                                            onclick="deleteVehicle({{$vehicle->id}})">--}}
{{--                                        <i class="fa fa-trash"></i>--}}
{{--                                    </button>--}}
{{--                                    @endif--}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Vehicle</th>
                                <th>Driver</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Salary Type</th>
                                <th>Duration</th>
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
