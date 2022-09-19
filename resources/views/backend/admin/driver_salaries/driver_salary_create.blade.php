@extends('backend.layouts.master')
@section("title","Add Driver Salary Rent")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Driver Salary Rent</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Driver Salary Rent</li>
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
                    <h3 class="card-title float-left">Add Driver Salary Rent</h3>
                    <div class="float-right">
                        <a href="{{route('admin.driver-salary-list')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('admin.driver-salary-store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
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
                            <label for="year">Year</label>
                            <select name="year" id="year" class="form-control select2" required>
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
                            <select name="month" id="month" class="form-control select2" required>
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
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" name="salary" id="salary" >
                        </div>
                        <div class="form-group">
                            <label for="payment_type_id">Payment Type <span>*</span></label>
                            <select name="payment_type_id" id="payment_type_id" class="form-control select2" required>
                                <option value="">Select</option>
                                @foreach($payment_types as $payment_type)
                                    <option value="{{$payment_type->id}}">{{$payment_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="paid_div">
                            <label for="paid">Paid</label>
                            <input type="number" class="form-control" name="paid" id="paid">
                        </div>
                        <div class="form-group" id="due_price_div">
                            <label for="due_price">Due</label>
                            <input type="number" class="form-control" name="due_price" id="due_price" readonly>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="exchange">Exchange</label>--}}
{{--                            <input type="number" class="form-control" name="exchange" id="exchange" >--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea type="text" class="form-control" name="note" id="note" ></textarea>
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

        $('.datepicker2').datepicker({
            format: 'yyyy-mm',
            startDate: '-3d',
            //startDate: '-0d',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });



        var getDaysInMonth = function(month,year) {
            // Here January is 1 based
            //Day 0 is the last day in the previous month
            return new Date(year, month, 0).getDate();
            // Here January is 0 based
            // return new Date(year, month+1, 0).getDate();
        };



        $('#month').change(function (){
            $('#salary').val('');
            var driver_id = $('#driver_id').val();
            var year = $('#year').val();
            var month = $('#month').val();
            if(driver_id == ''){
                alert('Driver Select First!');
                $('#month').val('');
            }
            if(year == ''){
                alert('Start Year Select First!');
                $('#month').val('');
            }

            var month_days = getDaysInMonth(month, year);
            console.log(month_days);

            var start_date = year+'-'+month+'-'+'01';
            var end_date = year+'-'+month+'-'+month_days;

            $.ajax({
                url:"{{URL('admin/check/already/driver/salary')}}",
                method:"post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    driver_id:driver_id,
                    year:year,
                    month:month
                },
                success:function (data){
                    console.log(data)
                    if(data === 'Found'){
                        alert('Salary Already Created This Month, Please select another!');
                        $('#month').val('');
                    }else{


                        $.ajax({
                            url:"{{URL('admin/check/driver/salary')}}",
                            method:"post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                driver_id:driver_id,
                                //start_date:start_date,
                                //end_date:end_date,
                                //month_days:month_days,
                                year:year,
                                month:month
                            },
                            success:function (data){
                                console.log(data)
                                if(data.salary_type == "Monthly"){
                                    $('#salary').val(data.salary);
                                }else{
                                    $('#salary').val(data.per_day_salary*data.duration);
                                }
                            },
                            error:function (err){
                                console.log(err)
                            }
                        })


                    }
                },
                error:function (err){
                    console.log(err)
                }
            })
        })

        $('#paid').keyup(function (){
            var salary = $('#salary').val();
            var paid = $('#paid').val();
            var due_price = salary - paid;
            $('#due_price').val(due_price);
        })

        // check cash or credit paid
        $('#paid_div').hide();
        $('#due_price_div').hide();
        $('#payment_type_id').change(function (){
            var payment_type_id = $('#payment_type_id').val();
            if(payment_type_id == 2){
                $('#paid_div').show();
                $('#due_price_div').show();
                $('#paid').val(0);
                var salary = $('#salary').val();
                $('#due_price').val(salary);
            }else{
                $('#paid_div').hide();
                $('#due_price_div').hide();
                var salary = $('#salary').val();
                $('#paid').val(salary);
                $('#due_price').val(0);
            }
        })
    </script>
@endpush
