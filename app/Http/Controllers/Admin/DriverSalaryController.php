<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Customer;
use App\Model\Driver;
use App\Model\DriverSalary;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Payment;
use App\Model\PaymentType;
use App\Model\Vehicle;
use App\Model\VehicleDriverAssign;
use App\Model\Vendor;
use NumberFormatter;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DriverSalaryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:driver-salary-list|driver-salary-create|driver-salary-edit|driver-salary-delete|driver_salary_show', ['only' => ['driver_salary_list','driver_salary_store']]);
        $this->middleware('permission:driver-salary-create', ['only' => ['driver_salary_create','driver_salary_store']]);
        $this->middleware('permission:driver-salary-edit', ['only' => ['driver_salary_edit','driver_salary_update']]);
        $this->middleware('permission:driver-salary-delete', ['only' => ['driver_salary_destroy']]);
    }

    public function driver_salary_list()
    {
        $driverSalaries = DriverSalary::latest()->get();
        $payment_types = PaymentType::all();
        return view('backend.admin.driver_salaries.driver_salary_list', compact('driverSalaries','payment_types'));
    }

    public function driver_salary_create()
    {
        $drivers = Driver::where('status',1)->get();
        $payment_types = PaymentType::all();
        return view('backend.admin.driver_salaries.driver_salary_create', compact('drivers','payment_types'));
    }

    public function driver_salary_store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name',
        ]);

        $date = date('Y-m-d H:i:s');
        $vehicle = Vehicle::where('id',$request->vehicle_id)->first();
        $vehicleDriver = VehicleDriverAssign::where('vehicle_id',$request->vehicle_id)->first();

        // invoice no
        if($request->payment_type_id == 1){
            $get_invoice_no = DriverSalary::latest()->pluck('invoice_no')->where('payment_type_id',1)->first();
            if(!empty($get_invoice_no)){
                $get_invoice = str_replace("CSDS-","",$get_invoice_no);
                $invoice_no = $get_invoice+1;
            }else{
                $invoice_no = 1;
            }
            $final_invoice = 'CSDS-'.$invoice_no;
        }else{
            $get_invoice_no = DriverSalary::latest()->pluck('invoice_no')->where('payment_type_id',2)->first();
            if(!empty($get_invoice_no)){
                $get_invoice = str_replace("CRDS-","",$get_invoice_no);
                $invoice_no = $get_invoice+1;
            }else{
                $invoice_no = 1;
            }
            $final_invoice = 'CRDS-'.$invoice_no;
        }
        // invoice no

        $driverSalary = new DriverSalary();
        $driverSalary->date = $date;
        $driverSalary->invoice_no = $final_invoice;
        $driverSalary->driver_id = $request->driver_id;
        $driverSalary->year = $request->year;
        $driverSalary->month = $request->month;
        $driverSalary->salary = $request->salary;
        $driverSalary->payment_type_id = $request->payment_type_id;
        //$driverSalary->paid = $request->paid;
        $driverSalary->paid = $request->salary;
        $driverSalary->due = $request->due_price;
        $driverSalary->note = $request->note;
        $driverSalary->save();
        $insert_id = $driverSalary->id;
        if($insert_id){

            if($request->payment_type_id == 1){
                $payment = new Payment();
                $payment->date=date('Y-m-d');
                $payment->transaction_type='Driver Salary';
                $payment->order_id=$insert_id;
                $payment->paid_user_id=$request->driver_id;
                $payment->payment_type_id = 1;
                //$payment->paid = $request->paid;
                $payment->paid = $request->salary;
                $payment->exchange = 0;
                $payment->save();
            }else{
                // paid
                $payment = new Payment();
                $payment->date=date('Y-m-d');
                $payment->transaction_type='Driver Salary';
                $payment->order_id=$insert_id;
                $payment->paid_user_id=$request->driver_id;
                $payment->payment_type_id = 1;
                $payment->paid = $request->paid;
                $payment->exchange = 0;
                $payment->save();

                // due
                $payment = new Payment();
                $payment->date=date('Y-m-d');
                $payment->transaction_type='Driver Salary';
                $payment->order_id=$insert_id;
                $payment->paid_user_id=$request->driver_id;
                $payment->payment_type_id = 2;
                $payment->paid = $request->due_price;
                $payment->exchange = 0;
                $payment->save();
            }


            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Driver Salary';
            $accessLog->action_done='Create';
            $accessLog->action_remarks='Driver Salary ID: '.$insert_id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Driver Salary Created Successfully');
        return redirect()->route('admin.driver-salary-list');
    }

    public function driver_salary_show($id)
    {
        $driverSalary = DriverSalary::where('id',$id)->first();
        $drivers = Driver::latest()->get();
        return view('backend.admin.driver_salaries.driver_salary_show',compact('driverSalary','drivers'));
    }

    public function driver_salary_edit($id)
    {
        $vehicles = Vehicle::where('status',1)->where('own_vehicle_status','Rent')->get();
        $vendors = Vendor::where('status',1)->get();
        $payment_types = PaymentType::all();
        $vehicleVendorRent = Order::where('order_type','Purchases')->where('id',$id)->first();
        $vehicleVendorRentDetail = OrderItem::where('order_id',$id)->first();
        return view('backend.admin.driver_salaries.vehicle_vendor_rent_edit',compact('vehicleVendorRent','vehicleVendorRentDetail','vendors','vehicles','payment_types'));
    }

    public function driver_salary_update(Request $request, $id)
    {
        //dd($request->all());
        //dd($id);
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name,'.$id,
        ]);

        //if($request->rent_type == 'Daily'){
        $start_year = date('Y', strtotime($request->start_date));
        $start_month = date('m', strtotime($request->start_date));
        $start_day = date('d', strtotime($request->start_date));

        $end_year = date('Y', strtotime($request->end_date));
        $end_month = date('m', strtotime($request->end_date));
        $end_day = date('d', strtotime($request->end_date));



        $date1 = $request->start_date;
        $date2 = $request->end_date;

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        // Robeul CUSTOM  ADD 1
        $diff ++;
        //}

        $vehicle = Vehicle::where('id',$request->vehicle_id)->first();
        $vehicleDriver = VehicleDriverAssign::where('vehicle_id',$request->vehicle_id)->first();
        $due_amount = $request->payment_type_id == 1 ? 0 :$request->grand_total;
        //$paid_amount = $request->payment_type_id == 2 ? 0 :$request->grand_total;

        $order = Order::find($id);
        $prev_payment_type_id = $order->payment_type_id;
        $order->vendor_id = $request->vendor_id;
        $order->payment_type_id = $request->payment_type_id;
        $order->sub_total = $request->sub_total;
        $order->discount_type = $request->discount_type;
        $order->discount_percent = $request->discount_percent;
        $order->discount_amount = $request->discount_amount;
        $order->grand_total = $request->grand_total;
        $order->paid = $request->payment_type_id == 1 ? $request->grand_total : $request->paid;
        $order->exchange = 0;
        $order->due_price = $request->payment_type_id == 1 ? 0 : $request->due_price;
        $updated_row = $order->save();

        if($updated_row){
            $orderItem = OrderItem::where('order_id',$id)->first();
            $orderItem->vehicle_id=$request->vehicle_id;
            //$orderItem->driver_id=$vehicleDriver->driver_id;
            $orderItem->rent_type=$request->rent_type;
            $orderItem->start_year=$start_year;
            $orderItem->end_year=$end_year;
            $orderItem->start_month=$start_month;
            $orderItem->end_month=$end_month;
            $orderItem->start_date=$request->start_date;
            $orderItem->end_date=$request->end_date;
            $orderItem->rent_duration_month=$diff;
            $orderItem->rent_duration_day=$request->rent_duration_day;
            $orderItem->quantity=$request->quantity;
            $orderItem->price=$request->price;
            //$orderItem->discount=$request->grand_discount;
            //$orderItem->total=$request->sub_total;
            $orderItem->note=$request->note;
            $orderItem->save();



            if( ($prev_payment_type_id == 1) && ($request->payment_type_id == 1) ){
                $payment = Payment::where('order_id',$id)->where('payment_type_id',1)->first();
                $payment->paid = $request->grand_total;
                $payment->save();
            }elseif(($prev_payment_type_id == 1) && ($request->payment_type_id == 2)){
                // paid
                $payment = Payment::where('order_id',$id)->where('payment_type_id',1)->first();
                $payment->paid = $request->paid;
                $payment->save();

                // due
                $payment = new Payment();
                $payment->date=date('Y-m-d');
                $payment->order_id=$id;
                $payment->payment_type_id = 2;
                $payment->paid = $request->due_price;
                $payment->exchange = 0;
                $payment->save();
            }elseif(($prev_payment_type_id == 2) && ($request->payment_type_id == 2)){
                // paid
                $payment = Payment::where('order_id',$id)->where('payment_type_id',1)->first();
                $payment->paid = $request->paid;
                $payment->save();

                // due
                $payment = Payment::where('order_id',$id)->where('payment_type_id',2)->first();
                $payment->paid = $request->due_price;
                $payment->save();
            }elseif(($prev_payment_type_id == 2) && ($request->payment_type_id == 1)){
                // due
                Payment::where('order_id',$id)->where('payment_type_id',2)->delete();

                // paid
                $payment = Payment::where('order_id',$id)->where('payment_type_id',1)->first();
                $payment->paid = $request->grand_total;
                $payment->save();


            }else{
                Toastr::success('Something went wrong!','Success');
                return back();
            }

            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vehicle Vendor Rent';
            $accessLog->action_done='Update';
            $accessLog->action_remarks='Vehicle Vendor Rent ID: '.$id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vehicle Vendor Rent updated successfully','Success');
        return redirect()->route('admin.vehicle-vendor-rent-list');
    }

//    public function destroy($id)
//    {
//        $vehicleDriverAssign = VehicleDriverAssign::find($id);
//        $deleted_row = $vehicleDriverAssign->delete();
//        if($deleted_row){
//            $accessLog = new AccessLog();
//            $accessLog->user_id=Auth::user()->id;
//            $accessLog->action_module='Vehicle Driver Assign';
//            $accessLog->action_done='Delete';
//            $accessLog->action_remarks='Vehicle Driver Assign ID: '.$id;
//            $accessLog->action_date=date('Y-m-d');
//            $accessLog->save();
//        }
//
//        Toastr::success('Vehicle Driver Assign deleted successfully','Success');
//        return back();
//    }

    public function vehicle_vendor_rent_due()
    {
        $vehicleVendorRents = Order::where('type','Vendor')->where('due_price','>',0)->get();
        $payment_types = PaymentType::where('name','!=','Credit')->get();
        return view('backend.admin.orders.vehicle_vendor_rent_due', compact('vehicleVendorRents','payment_types'));
    }
    public function driverPayDue(Request $request){
        //dd($request->all());

        // update due
        $driverSalary = DriverSalary::find($request->order_id);
        $last_due_price = $driverSalary->due - $request->new_paid;
        $last_paid = $driverSalary->paid + $request->new_paid;
        $driverSalary->paid=$last_paid;
        $driverSalary->due=$last_due_price;
        $driverSalary->save();

        // delete previous due
        Payment::where('order_id',$request->order_id)->where('transaction_type','Driver Salary')->where('payment_type_id',2)->delete();

        // new due paid
        $payment = new Payment();
        $payment->date=date('Y-m-d');
        $payment->transaction_type='Driver Salary';
        $payment->order_id=$request->order_id;
        $payment->payment_type_id = $request->payment_type_id;
        $payment->paid = $request->new_paid;
        $payment->save();

        // current due
        $payment = new Payment();
        $payment->date=date('Y-m-d');
        $payment->transaction_type='Driver Salary';
        $payment->order_id=$request->order_id;
        $payment->payment_type_id = 2;
        $payment->paid = $last_due_price;
        $payment->save();

        $accessLog = new AccessLog();
        $accessLog->user_id=Auth::user()->id;
        $accessLog->action_module='Driver Salary';
        $accessLog->action_done='Due Update';
        $accessLog->action_remarks='Driver Salary Order ID: '.$request->order_id;
        $accessLog->action_date=date('Y-m-d');
        $accessLog->save();

        Toastr::success('Driver Salary Due Paid Successfully');
        return back();
    }

    public function order_vendor_print($id){
        $vehicleVendorRent = Order::where('order_type','Purchases')->where('id',$id)->first();
        $vehicleVendorRentDetail = OrderItem::where('order_id',$id)->first();
        $vendor = Vendor::find($vehicleVendorRent->vendor_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        return view('backend.admin.orders.invoice_vendor',compact('vehicleVendorRent','vehicleVendorRentDetail','vendor','digit'));
    }

    public function check_driver_salary(Request $request){
//        return \App\Model\Driver::where('id',$request->driver_id)
//            ->select('id','salary_type','salary','per_day_salary')->first();

        return VehicleDriverAssign::join('drivers','vehicle_driver_assigns.driver_id','drivers.id')
            ->where('drivers.id',$request->driver_id)
            ->where('vehicle_driver_assigns.month',$request->month)
            ->where('vehicle_driver_assigns.year',$request->year)
            ->select(
                'drivers.id',
                'drivers.salary_type',
                'drivers.salary',
                'drivers.per_day_salary',
                'vehicle_driver_assigns.duration'
            )->first();
    }

    public function check_already_driver_salary(Request $request){
        $check_exists_driver =  DriverSalary::where('driver_id',$request->driver_id)
            ->where('year',$request->year)
            ->where('month',$request->month)
            ->pluck('salary')->first();
        if(!empty($check_exists_driver)){
            return 'Found';
        }else{
            return 'Not Found';
        }
    }
}
