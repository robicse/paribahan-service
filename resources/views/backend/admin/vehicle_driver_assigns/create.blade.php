@extends('backend.layouts.master')
@section("title","Add Vehicle Driver Assign")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Vehicle Driver Assign</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Vehicle Driver Assign</li>
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
                    <h3 class="card-title float-left">Add Vehicle Driver Assign</h3>
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
                <form role="form" action="{{route('admin.vehicle-driver-assigns.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="vehicle_id">Vehicle <span>*</span></label>
                            <select name="vehicle_id" id="vehicle_id" class="form-control select2" required>
                                <option value="">Select</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->vehicle_name}} ({{$vehicle->vehicle_code}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="driver_id">Driver <span>*</span></label>
                            <select name="driver_id" id="driver_id" class="form-control select2" required>
                                <option value="">Select</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->name}} ({{$driver->driver_code}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salary_type">Salary Type <span>*</span></label>
                            <input type="text" class="form-control" name="salary_type" id="salary_type" readonly required>
                        </div>
                        <div id="monthly_basis">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select name="year" id="year" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select name="month" id="month" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="form-group" style="display: none">
                                <label for="rent_duration_month">Rent Duration Month <span>*</span></label>
                                <input type="text" class="form-control" name="rent_duration_month" id="rent_duration_month" readonly>
                            </div>
                        </div>
                        <div id="daily_basis">
                            <div class="form-group">
                                <label for="start_date">Start Date <span>*</span></label>
                                <input type="text" class="datepicker form-control" name="start_date" id="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date <span>*</span></label>
                                <input type="text" class="datepicker form-control" name="end_date" id="end_date" required>
                            </div>
                            <div class="form-group" style="display: none">
                                <label for="rent_duration_day">Rent Duration Day <span>*</span></label>
                                <input type="text" class="form-control" name="rent_duration_day" id="rent_duration_day" readonly>
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
            //alert();
            {{--var vehicle_id = $('#vehicle_id').val();--}}
            {{--$.ajax({--}}
            {{--    url:"{{URL('/admin/check/already/vehicle/assigned/or/free')}}/" + vehicle_id,--}}
            {{--    method:"GET",--}}
            {{--    success:function (data){--}}
            {{--        //console.log(data)--}}
            {{--        if(data > 0){--}}
            {{--            alert('Please select another vehicle, This vehicle already assigned.');--}}
            {{--            $('#vehicle_id').val('');--}}
            {{--        }--}}
            {{--    },--}}
            {{--    error:function (err){--}}
            {{--        console.log(err)--}}
            {{--    }--}}
            {{--})--}}
        })

        $('#monthly_basis').hide();
        $('#daily_basis').hide();
        $('#driver_id').change(function (){
            //alert();
            var driver_id = $('#driver_id').val();

            $.ajax({
                url:"{{URL('/admin/check/driver/salary/info')}}/" + driver_id,
                method:"GET",
                success:function (data){
                    console.log(data)
                    if(data.salary_type == "Monthly"){
                        $('#monthly_basis').show();
                        $('#daily_basis').hide();
                        $('#salary_type').val("Monthly");
                    }else{
                        $('#monthly_basis').hide();
                        $('#daily_basis').show();
                        $('#salary_type').val("Daily");
                    }
                },
                error:function (err){
                    console.log(err)
                }
            })

            {{--$.ajax({--}}
            {{--    url:"{{URL('/admin/check/already/driver/assigned/or/free')}}/" + driver_id,--}}
            {{--    method:"GET",--}}
            {{--    success:function (data){--}}
            {{--        //console.log(data)--}}
            {{--        if(data > 0){--}}
            {{--            alert('Please select another driver, This driver already assigned.');--}}
            {{--            $('#driver_id').val('');--}}
            {{--        }--}}
            {{--    },--}}
            {{--    error:function (err){--}}
            {{--        console.log(err)--}}
            {{--    }--}}
            {{--})--}}
        })

        var getDaysInMonth = function(month,year) {
            // Here January is 1 based
            //Day 0 is the last day in the previous month
            return new Date(year, month, 0).getDate();
            // Here January is 0 based
            // return new Date(year, month+1, 0).getDate();
        };

        $('#month').change(function (){
            var vehicle_id = $('#vehicle_id').val();
            var year = $('#year').val();
            var month = $('#month').val();
            if(vehicle_id == ''){
                alert('Year Select Vehicle!');
                $('#month').val('');
            }
            if(month == ''){
                alert('Year Select First!');
                $('#month').val('');
            }

            var start_date = year+'-'+month+'-01';
            var dt = new Date(start_date);
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var month_days = getDaysInMonth(month, year);
            console.log(month_days);
            var end_date = year+'-'+month+'-'+month_days;

            $.ajax({
                url:"{{URL('admin/get/vehicle/assigned/driver')}}",
                method:"post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    vehicle_id:vehicle_id,
                    start_date:start_date
                },
                success:function (data){
                    console.log(data)
                    if(data === ''){

                        $('#start_date').val(start_date)
                        $('#end_date').val(end_date)


                        //alert(start_date);
                        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
                        const firstDate = new Date(start_date);
                        const secondDate = new Date(end_date);

                        //const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
                        const diffMonths = Math.round(Math.abs((firstDate - secondDate) / (oneDay*month_days)));
                        //$('#rent_duration_day').val(diffDays);
                        $('#rent_duration_day').val(month_days);
                        $('#rent_duration_month').val(diffMonths);
                    }else{
                        alert('Already Assigned Among This Durations For This Vehicle!');
                        $('#start_date').val('');
                        $('#end_date').val('');
                        $('#year').val('')
                        $('#month').val('')
                    }
                },
                error:function (err){
                    console.log(err)
                }
            })


        })

        $('#end_date').change(function (){
            var vehicle_id = $('#vehicle_id').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if(vehicle_id == ''){
                alert('Year Select Vehicle!');
                $('#month').val('');
            }
            if(start_date == ''){
                alert('Start Date Select First!');
                $('#end_date').val('');
            }

            var dt = new Date(start_date);
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var month_days = getDaysInMonth(month, year);
            console.log(month_days);
            console.log('month=',month)

            //alert(start_date);
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(start_date);
            const secondDate = new Date(end_date);

            //const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
            const diffMonths = Math.round(Math.abs((firstDate - secondDate) / (oneDay*month_days)));

            if(diffMonths > 1){
                alert('End Date Must be in same date!');
                $('#end_date').val('');
            }

            $.ajax({
                url:"{{URL('admin/get/vehicle/assigned/driver')}}",
                method:"post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    vehicle_id:vehicle_id,
                    start_date:start_date
                },
                success:function (data){
                    console.log(data)
                    if(data === ''){
                        $('#year').val(year)
                        $('#month').val(month)

                        //$('#rent_duration_day').val(diffDays);
                        $('#rent_duration_day').val(month_days);
                        $('#rent_duration_month').val(diffMonths);
                    }else{
                        alert('Already Assigned Among This Durations For This Vehicle!');
                        $('#start_date').val('');
                        $('#end_date').val('');
                        $('#year').val('')
                        $('#month').val('')
                    }
                },
                error:function (err){
                    console.log(err)
                }
            })
        })
    </script>
@endpush
