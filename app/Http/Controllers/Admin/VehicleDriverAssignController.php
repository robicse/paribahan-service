<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Driver;
use App\Model\Vehicle;
use App\Model\Brand;
use App\Model\Category;
use App\Model\VehicleDriverAssign;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VehicleDriverAssignController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:vehicle-driver-assign-list|vehicle-driver-assign-create|vehicle-driver-assign-edit|vehicle-driver-assign-delete', ['only' => ['index','store']]);
        $this->middleware('permission:vehicle-driver-assign-create', ['only' => ['create','store']]);
        $this->middleware('permission:vehicle-driver-assign-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:vehicle-driver-assign-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $vehicleDriverAssigns = VehicleDriverAssign::all();
        return view('backend.admin.vehicle_driver_assigns.index', compact('vehicleDriverAssigns'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status',1)->get();
        $drivers = Driver::where('status',1)->get();
        return view('backend.admin.vehicle_driver_assigns.create', compact('vehicles','drivers'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name',
        ]);

//        $end_status = 0;
//        $duration = 0;
//        if($request->end_date != NULL){
//            $end_status = 1;
//
//            $date1 = date_create($request->start_date);
//            $date2 = date_create($request->end_date);
//            //difference between two dates
//            $diff = date_diff($date1,$date2);
//            //count days
//            $duration = $diff->format("%a");
//        }

        $year = date('Y', strtotime($request->start_date));
        $month = date('m', strtotime($request->start_date));

        $vehicleDriverAssign = new VehicleDriverAssign();
        $vehicleDriverAssign->vehicle_id = $request->vehicle_id;
        $vehicleDriverAssign->driver_id = $request->driver_id;
        $vehicleDriverAssign->year = $year;
        $vehicleDriverAssign->month = $month;
        $vehicleDriverAssign->salary_type = $request->salary_type;
        $vehicleDriverAssign->start_date = $request->start_date;
        $vehicleDriverAssign->end_date = $request->end_date;
        $vehicleDriverAssign->start_status = 1;
        //$vehicleDriverAssign->end_status = $end_status;
        $vehicleDriverAssign->end_status = 1;
        //$vehicleDriverAssign->duration = $duration;
        $vehicleDriverAssign->duration = $request->rent_duration_day;
        $vehicleDriverAssign->save();
        $insert_id = $vehicleDriverAssign->id;
        if($insert_id){

            // vehicle update
            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle->driver_id = $request->driver_id;
            $vehicle->save();

            // driver update
            $driver = Driver::find($request->driver_id);
            $driver->vehicle_id = $request->vehicle_id;
            $driver->save();

            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vehicle Driver Assign';
            $accessLog->action_done='Create';
            $accessLog->action_remarks='Vehicle Driver Assign ID: '.$insert_id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vehicle Driver Assign Created Successfully');
        return back();
    }

//    public function store(Request $request)
//    {
//        dd($request->all());
//        $this->validate($request, [
//            //'name'=> 'required|unique:vehicles,name',
//        ]);
//
//
//
//
//
//        $rent_duration_month = $request->rent_duration_month;
//        for($i=0;$i<$rent_duration_month;$i++){
//            $end_status = 0;
//            $duration = 0;
//            if($request->end_date != NULL){
//                $end_status = 1;
//
//                $date1 = date_create($request->start_date);
//                $date2 = date_create($request->end_date);
//                //difference between two dates
//                $diff = date_diff($date1,$date2);
//                //count days
//                $duration = $diff->format("%a");
//            }
//
//            $year = date('Y', strtotime($request->start_date));
//            $month = date('m', strtotime($request->start_date));
//
//
//
//
//            $start_year = date('Y', strtotime($request->start_date));
//            $start_month = date('m', strtotime($request->start_date));
//            $start_day = date('d', strtotime($request->start_date));
//
//            $end_year = date('Y', strtotime($request->end_date));
//            $end_month = date('m', strtotime($request->end_date));
//            $end_day = date('d', strtotime($request->end_date));
//
//
//
//            $date1 = $request->start_date;
//            $date2 = $request->end_date;
//
//            $ts1 = strtotime($date1);
//            $ts2 = strtotime($date2);
//
//            $year1 = date('Y', $ts1);
//            $year2 = date('Y', $ts2);
//
//            $month1 = date('m', $ts1);
//            $month2 = date('m', $ts2);
//
//            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
//
//            // Robeul CUSTOM  ADD 1
//            $diff ++;
//
//
//            $vehicleDriverAssign = new VehicleDriverAssign();
//            $vehicleDriverAssign->vehicle_id = $request->vehicle_id;
//            $vehicleDriverAssign->driver_id = $request->driver_id;
//            $vehicleDriverAssign->year = $year;
//            $vehicleDriverAssign->month = $month;
//            $vehicleDriverAssign->start_date = $request->start_date;
//            $vehicleDriverAssign->end_date = $request->end_date;
//            $vehicleDriverAssign->start_status = 1;
//            $vehicleDriverAssign->end_status = $end_status;
//            $vehicleDriverAssign->duration = $duration;
//            $vehicleDriverAssign->save();
//            $insert_id = $vehicleDriverAssign->id;
//            if($insert_id){
//                $accessLog = new AccessLog();
//                $accessLog->user_id=Auth::user()->id;
//                $accessLog->action_module='Vehicle Driver Assign';
//                $accessLog->action_done='Create';
//                $accessLog->action_remarks='Vehicle Driver Assign ID: '.$insert_id;
//                $accessLog->action_date=date('Y-m-d');
//                $accessLog->save();
//            }
//        }
//
//
//        Toastr::success('Vehicle Driver Assign Created Successfully');
//        return back();
//    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vehicles = Vehicle::where('status',1)->get();
        $drivers = Driver::where('status',1)->get();
        $vehicleDriverAssign = VehicleDriverAssign::find($id);
        return view('backend.admin.vehicle_driver_assigns.edit',compact('vehicleDriverAssign','drivers','vehicles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name,'.$id,
        ]);

//        $end_status = 0;
//        $duration = 0;
//        if($request->end_date != NULL){
//            $end_status = 1;
//
//            $date1 = date_create($request->start_date);
//            $date2 = date_create($request->end_date);
//            //difference between two dates
//            $diff = date_diff($date1,$date2);
//            //count days
//            $duration = $diff->format("%a");
//        }

        $year = date('Y', strtotime($request->start_date));
        $month = date('m', strtotime($request->start_date));

        $vehicleDriverAssign = VehicleDriverAssign::find($id);
        $vehicleDriverAssign->vehicle_id = $request->vehicle_id;
        $vehicleDriverAssign->driver_id = $request->driver_id;
        $vehicleDriverAssign->year = $year;
        $vehicleDriverAssign->month = $month;
        $vehicleDriverAssign->salary_type = $request->salary_type;
        $vehicleDriverAssign->start_date = $request->start_date;
        $vehicleDriverAssign->end_date = $request->end_date;
        //$vehicleDriverAssign->start_status = 1;
        //$vehicleDriverAssign->end_status = $end_status;
        //$vehicleDriverAssign->duration = $duration;
        $vehicleDriverAssign->duration = $request->rent_duration_day;
        $updated_row = $vehicleDriverAssign->save();
        if($updated_row){

            $vehicle = Vehicle::find($request->vehicle_id);
            if($vehicle->driver_id != $request->driver_id){
                $vehicle->driver_id = $request->driver_id;
                $vehicle->save();
            }

            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vehicle Driver Assign';
            $accessLog->action_done='Update';
            $accessLog->action_remarks='Vehicle Driver Assign ID: '.$id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vehicle Driver Assign updated successfully','Success');
        return back();
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

    public function get_vehicle_assigned_driver(Request $request){
        return getVehicleAssignedDriver($request->vehicle_id, $request->start_date);
    }
}
