@extends('backend.layouts.master')
@section("title","Edit Vehicle Driver Assign")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Vehicle Driver Assign</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Vehicle Driver Assign</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Edit Vehicle Driver Assign</h3>
                        <div class="float-right">
                            <a href="{{route('admin.vehicle-driver-assigns.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.vehicle-driver-assigns.update',$vehicleDriverAssign->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="vehicle_driver_assign_id" id="vehicle_driver_assign_id" value="{{$vehicleDriverAssign->id}}">
                            <div class="form-group">
                                <label for="vehicle_id">Vehicle <span>*</span></label>
                                <select name="vehicle_id" id="vehicle_id" class="form-control select2" required>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}" {{$vehicle->id == $vehicleDriverAssign->vehicle_id ? 'selected' : ''}}>{{$vehicle->vehicle_name}} ({{$vehicle->vehicle_code}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="driver_id">Driver <span>*</span></label>
                                <select name="driver_id" id="driver_id" class="form-control select2" required>
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}" {{$driver->id == $vehicleDriverAssign->driver_id ? 'selected' : ''}}>{{$driver->name}} ({{$driver->driver_code}})</option>
                                    @endforeach
                                </select>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="text">Start Date</label>--}}
{{--                                <input type="text" class="datepicker form-control" name="start_date" id="start_date" value="{{$vehicleDriverAssign->start_date}}">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="text">End Date</label>--}}
{{--                                <input type="text" class="datepicker form-control" name="end_date" id="end_date" value="{{$vehicleDriverAssign->end_date}}" >--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label for="salary_type">Salary Type <span>*</span></label>
                                <input type="text" class="form-control" name="salary_type" id="salary_type" value="{{$vehicleDriverAssign->salary_type}}" readonly required>
                            </div>
                            <div id="monthly_basis" @if($vehicleDriverAssign->salary_type == 'Daily') style="display: none" @endif>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-control select2">
                                        <option value="">Select</option>
                                        <option value="2021" {{$vehicleDriverAssign->year == "2021" ? 'selected' : ''}}>2021</option>
                                        <option value="2022" {{$vehicleDriverAssign->year == "2022" ? 'selected' : ''}}>2022</option>
                                        <option value="2023" {{$vehicleDriverAssign->year == "2023" ? 'selected' : ''}}>2023</option>
                                        <option value="2024" {{$vehicleDriverAssign->year == "2024" ? 'selected' : ''}}>2024</option>
                                        <option value="2025" {{$vehicleDriverAssign->year == "2025" ? 'selected' : ''}}>2025</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="month">Month</label>
                                    <select name="month" id="month" class="form-control select2">
                                        <option value="">Select</option>
                                        <option value="01" {{$vehicleDriverAssign->month == "01" ? 'selected' : ''}}>January</option>
                                        <option value="02" {{$vehicleDriverAssign->month == "02" ? 'selected' : ''}}>February</option>
                                        <option value="03" {{$vehicleDriverAssign->month == "03" ? 'selected' : ''}}>March</option>
                                        <option value="04" {{$vehicleDriverAssign->month == "04" ? 'selected' : ''}}>April</option>
                                        <option value="05" {{$vehicleDriverAssign->month == "05" ? 'selected' : ''}}>May</option>
                                        <option value="06" {{$vehicleDriverAssign->month == "06" ? 'selected' : ''}}>June</option>
                                        <option value="07" {{$vehicleDriverAssign->month == "07" ? 'selected' : ''}}>July</option>
                                        <option value="08" {{$vehicleDriverAssign->month == "08" ? 'selected' : ''}}>August</option>
                                        <option value="09" {{$vehicleDriverAssign->month == "09" ? 'selected' : ''}}>September</option>
                                        <option value="10" {{$vehicleDriverAssign->month == "10" ? 'selected' : ''}}>October</option>
                                        <option value="11" {{$vehicleDriverAssign->month == "11" ? 'selected' : ''}}>November</option>
                                        <option value="12" {{$vehicleDriverAssign->month == "12" ? 'selected' : ''}}>December</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display: none">
                                    <label for="rent_duration_month">Rent Duration Month <span>*</span></label>
                                    <input type="text" class="form-control" name="rent_duration_month" id="rent_duration_month" value="1" readonly>
                                </div>
                            </div>
                            <div id="daily_basis" @if($vehicleDriverAssign->salary_type == 'Monthly') style="display: none" @endif>
                                <div class="form-group">
                                    <label for="start_date">Start Date <span>*</span></label>
                                    <input type="text" class="datepicker form-control" name="start_date" id="start_date" value="{{$vehicleDriverAssign->start_date}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date <span>*</span></label>
                                    <input type="text" class="datepicker form-control" name="end_date" id="end_date" value="{{$vehicleDriverAssign->end_date}}" required>
                                </div>
                                <div class="form-group" style="display: none">
                                    <label for="rent_duration_day">Rent Duration Day <span>*</span></label>
                                    <input type="text" class="form-control" name="rent_duration_day" id="rent_duration_day" value="{{$vehicleDriverAssign->duration}}" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script>
        $('.demo-select2').select2();
        // $("#demo-dp-range .input-daterange").datepicker({
        //     startDate: "-0d",
        //     todayBtn: "linked",
        //     autoclose: true,
        //     todayHighlight: true,
        // });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d',
            //startDate: '-0d',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        $('#vehicle_id').change(function (){
            var vehicle_id = $('#vehicle_id').val();
            var vehicle_driver_assign_id = $('#vehicle_driver_assign_id').val();
            $.ajax({
                url:"{{URL('/admin/check/already/vehicle/assigned/or/free/edit')}}",
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    vehicle_id : vehicle_id,
                    vehicle_driver_assign_id : vehicle_driver_assign_id,
                },
                success:function (data){
                     // console.log(data)
                    if(data > 0){
                        alert('Please select another vehicle, This vehicle already assigned.');
                        $('#vehicle_id').val('');
                    }
                },
                error:function (err){
                    console.log(err)
                }
            })
        })

        $('#driver_id').change(function (){
            var driver_id = $('#driver_id').val();
            var vehicle_driver_assign_id = $('#vehicle_driver_assign_id').val();
            $.ajax({
                url:"{{URL('/admin/check/already/driver/assigned/or/free/edit')}}",
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    driver_id : driver_id,
                    vehicle_driver_assign_id : vehicle_driver_assign_id,
                },
                success:function (data){
                    //console.log(data)
                    if(data > 0){
                        alert('Please select another driver, This driver already assigned.');
                        $('#driver_id').val('');
                    }
                },
                error:function (err){
                    console.log(err)
                }
            })
        })

        var getDaysInMonth = function(month,year) {
            // Here January is 1 based
            //Day 0 is the last day in the previous month
            return new Date(year, month, 0).getDate();
            // Here January is 0 based
            // return new Date(year, month+1, 0).getDate();
        };

        $('#end_date').change(function (){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if(start_date == ''){
                alert('Start Date Select First!');
                $('#end_date').val('');
            }

            var dt = new Date(start_date);
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var month_days = getDaysInMonth(month, year);
            console.log(month_days);

            //alert(start_date);
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(start_date);
            const secondDate = new Date(end_date);

            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
            const diffMonths = Math.round(Math.abs((firstDate - secondDate) / (oneDay*month_days)));

            if(diffMonths > 1){
                alert('End Date Must be in same date!');
                $('#end_date').val('');
            }
            $('#rent_duration_day').val(diffDays+1);
            $('#rent_duration_month').val(diffMonths);
        })
    </script>
@endpush
