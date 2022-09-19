@extends('backend.layouts.master')
@section("title","Payment List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush

@section('content')
    <main class="app-content">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Customer Balance Sheet</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('admin.report-customer-balance-sheet') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">From</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_from" value="{{ $date_from }}" id="demoDate" required>
                                @if ($errors->has('date_from'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_from') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">To</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_to" value="{{ $date_to }}" required />
                                @if ($errors->has('date_to'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_to') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>View
                                </button>
                                <a href="{!! route('admin.get-report-customer-balance-sheet') !!}" class="btn btn-primary" type="button"><i class="fa fa-refresh"> Reset</i></a>
                            </div>
                        </div>
                    </form>
                    <div class="card-header">
                        <h3 class="card-title float-left">Customer Balance Sheet from date {{ $date_from }} to date {{ $date_to }}</h3>
                        <div class="float-right">
                            @if($date_from !== '' && $date_to !== '')
                                <a href="{{ url('/admin/report/customer-balance-sheet-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-right">Print</a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr class="bg-secondary">
                            <th width="10%">SL</th>
                            <th width="30%">Customer</th>
                            <th width="30%">Total Paid Amount(TK)</th>
                            <th width="30%">Total Due Amount(TK)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $final_paid_amount = 0;
                            $final_due_amount = 0;
                            $flag = 0;
                            $first_day = date('Y-m-01',strtotime($date_from));
                            $last_day = date('Y-m-t',strtotime($date_from));
                            $sl = 0;
                        @endphp

                        @if(!empty($customer_cash_data_results))

                            @foreach($customer_cash_data_results as $key => $cash_data_result)
                                @php
                                    $customer = \App\Model\Customer::where('id',$cash_data_result->paid_user_id)->pluck('name')->first();
                                    $sl ++;
                                    $final_paid_amount += $cash_data_result->total_paid;

                                    $customer_due = getCustomerTotalDueAmount($cash_data_result->paid_user_id, $date_from, $date_to);
                                    if(!empty($customer_due)){
                                        $customer_due_amount = $customer_due->total_due;
                                        $final_due_amount += $customer_due->total_due;
                                    }else{
                                        $customer_due_amount = 0;
                                    }
                                @endphp

                                <tr>
                                    <td>{{$sl}}</td>
                                    <td>{{$customer}}</td>
                                    <td class="text-right">{{ number_format($cash_data_result->total_paid,2,'.',',') }}</td>
                                    <td class="text-right">{{ number_format($customer_due_amount,2,'.',',') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        <tr class="bg-primary">
                            <td colspan="2">Total:</td>
                            <td class="text-right">{{ number_format($final_paid_amount,2,'.',',') }}</td>
                            <td class="text-right">{{ number_format($final_due_amount,2,'.',',') }}</td>
                        </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>

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


