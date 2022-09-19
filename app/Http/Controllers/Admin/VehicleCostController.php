<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Payment;
use App\Model\Vehicle;
use App\Model\VehicleCost;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VehicleCostController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:overall-cost-list|overall-cost-create|overall-cost-edit|overall-cost-delete', ['only' => ['index','store']]);
//        $this->middleware('permission:overall-cost-create', ['only' => ['create','store']]);
//        $this->middleware('permission:overall-cost-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:overall-cost-delete', ['only' => ['destroy']]);
//    }

    public function index()
    {
        $vehicleCosts = VehicleCost::latest()->get();
        return view('backend.admin.vehicleCost.index', compact('vehicleCosts'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('backend.admin.vehicleCost.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'vehicle_id'=> 'required',
            'payment_type'=> 'required',
            'amount'=> 'required',
            'date'=> 'required',
            'note'=> 'required',
        ]);
        //dd($request->all());
        $vehicleCost = new VehicleCost();
        $vehicleCost->user_id = Auth::id();
        $vehicleCost->vehicle_id = $request->vehicle_id;
        $vehicleCost->payment_type = $request->payment_type;
        $vehicleCost->cheque_number = $request->cheque_number ? $request->cheque_number : NULL;
        $vehicleCost->amount = $request->amount;
        $vehicleCost->date = $request->date;
        $vehicleCost->note = $request->note;
        $vehicleCost->save();
        $insert_id = $vehicleCost->id;

        $payment = new Payment();
        $payment->date=$request->date;
        $payment->transaction_type='Vehicle Cost';
        $payment->order_id=$insert_id;
        $payment->paid_user_id=NULL;
        $payment->payment_type_id = 1;
        $payment->paid = $request->amount;
        $payment->exchange = 0;
        $payment->save();

        Toastr::success('Vehicle Cost Created Successfully');
        return redirect()->route('admin.vehicle-cost.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vehicleCost = VehicleCost::find($id);
        $vehicles = Vehicle::all();
        return view('backend.admin.vehicleCost.edit', compact('vehicleCost','vehicles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'vehicle_id'=> 'required',
            'payment_type'=> 'required',
            'amount'=> 'required',
            'date'=> 'required',
            'note'=> 'required',
        ]);

        $vehicleCost = VehicleCost::find($id);
        $vehicleCost->user_id = Auth::id();
        $vehicleCost->vehicle_id = $request->vehicle_id;
        $vehicleCost->payment_type = $request->payment_type;
        $vehicleCost->cheque_number = $request->cheque_number ? $request->cheque_number : NULL;
        $vehicleCost->amount = $request->amount;
        $vehicleCost->date = $request->date;
        $vehicleCost->note = $request->note;
        $vehicleCost->save();

        $payment = Payment::where('order_id',$id)
            ->where('payment_type_id',1)
            ->where('transaction_type','Vehicle Cost')
            ->first();
        $payment->paid = $request->amount;
        $payment->save();

        Toastr::success('Vehicle Cost Updated Successfully');
        return redirect()->route('admin.vehicle-cost.index');
    }

    public function destroy($id)
    {
        //OfficeCostingCategory::destroy($id);
        Toastr::warning('Vehicle Cost not deleted possible, Please contact with administrator!');
        return redirect()->route('admin.vehicle-cost.index');
    }
}
