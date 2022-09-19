
<div id="printArea">
    <style>
        /* Styles go here */

        .page-header, .page-header-space {
            height: 150px;
        }

        .page-footer, .page-footer-space {
            height: 100px;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-top: 1px solid black; /* for demo */
            /*background: yellow;*/ /* for demo */
            /*padding: 5px 20px;*/
        }

        .page-header {
            position: fixed;
            top: 0mm;
            left: 0;
            width: 100%;
            /*height: 100px;*/
            border-bottom: 1px solid black; /* for demo */
            /*background: yellow;*/ /* for demo */
        }

        .page {
            page-break-after: always;
        }

        @page {
            /*margin: 20mm;*/
            /*size: A4;
            margin: 11mm 17mm 17mm 17mm;*/
        }

        @media screen {
            .page-header {display: none;}
            .page-footer {display: none;}
        }

        @media print {
            table { page-break-inside:auto }
            tr    { page-break-inside:auto; page-break-after:auto }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }

            button {display: none;}

            body {margin: 0;}
        }

        /*custom part start*/
        .invoice {
            border-collapse: collapse;
            /*width: 100%;*/
            width: 280mm;
            text-align: center
        }
        .invoice th, .invoice td {
            border: 1px solid #000;
        }
        /*custom part end*/

    </style>
    <main class="app-content">
        <div class="row">
            <div class="col-md-12">

{{--                <div class="page-header" style="text-align: left">--}}
{{--                    <img src="{{ asset('backend/2020-11-21.png') }}" width="200px" height="150px" alt="header img">--}}
{{--                </div>--}}
                <div class="col-md-8" style="text-align: center; margin-left: 100px">
                    <h2>StarIT LTD</h2>
                    <p style="margin: 0px"><b>SHASCHAND PARIBAHAN SONGTHA</b></p>
                    <p style="margin: 0px"><b>All Driver Balance Sheet</b> </p>
                    <p style="margin: 0px"><b>From Date: {{$date_from}}</b> </p>
                    <p style="margin: 0px"><b>To Date: {{$date_to}}</b> </p>

                </div>
{{--                <div class="page-footer">--}}
{{--                    <img src="{{ asset('footer.png') }}" width="100%" height="auto" alt="footer img">--}}
{{--                </div>--}}
                <table>
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <!--place holder for the fixed-position header-->--}}
{{--                            <div class="page-header-space"></div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
                    <tbody>
                    <tr>
                        <td>
                            <!--*** CONTENT GOES HERE ***-->
                            <div class="page" style="padding: 10px;">
                                <h5 align="center">Driver Balance Sheet from date {{ $date_from }} to date {{ $date_to }}</h5>
                                <table class="invoice">
                                    <tr>
                                        <th width="10%">SL</th>
                                        <th width="30%">Driver</th>
                                        <th width="10%">Total Paid Amount(TK)</th>
                                        <th width="10%">Total Due Amount(TK)</th>
                                    </tr>
                                    @php
                                        $final_paid_amount = 0;
                                        $final_due_amount = 0;
                                        $flag = 0;
                                        $first_day = date('Y-m-01',strtotime($date_from));
                                        $last_day = date('Y-m-t',strtotime($date_from));
                                        $sl = 0;
                                    @endphp
                                    @if(!empty($driver_cash_data_results))
                                        @foreach($driver_cash_data_results as $key => $cash_data_result)
                                            @php
                                                $driver = \App\Model\Driver::where('id',$cash_data_result->paid_user_id)->pluck('name')->first();
                                                $sl ++;
                                                $final_paid_amount += $cash_data_result->total_paid;

                                                $driver_due = getDriverTotalDueAmount($cash_data_result->paid_user_id, $date_from, $date_to);
                                                if(!empty($driver_due)){
                                                    $driver_due_amount = $driver_due->total_due;
                                                    $final_due_amount += $driver_due->total_due;
                                                }else{
                                                    $driver_due_amount = 0;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td>{{$driver}}</td>
                                                <td style="text-align: right">{{ number_format($cash_data_result->total_paid,2,'.',',') }}</td>
                                                <td style="text-align: right">{{ number_format($driver_due_amount,2,'.',',') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>Total</td>
                                        <td style="text-align: right">{{ number_format($final_paid_amount,2,'.',',') }}</td>
                                        <td style="text-align: right">{{ number_format($final_due_amount,2,'.',',') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>

{{--                    <tfoot>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <!--place holder for the fixed-position footer-->--}}
{{--                            <div class="page-footer-space"></div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    </tfoot>--}}
                </table>
            </div>
        </div>
    </main>
</div>

<!-- select2-->
<script src="{!! asset('backend/js/plugins/select2.min.js') !!}"></script>
<script src="{!! asset('backend/js/plugins/bootstrap-datepicker.min.js') !!}"></script>
<script>
    window.print();
</script>



