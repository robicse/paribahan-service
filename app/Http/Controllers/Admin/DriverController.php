<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Driver;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DriverController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:driver-list|driver-create|driver-edit|driver-delete', ['only' => ['index','store']]);
        $this->middleware('permission:driver-create', ['only' => ['create','store']]);
        $this->middleware('permission:driver-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:driver-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $drivers = Driver::all();
        return view('backend.admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('backend.admin.drivers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:drivers,name',
        ]);

        $get_driver_code = Driver::latest('id','desc')->pluck('driver_code')->first();
        if(!empty($get_driver_code)){
            $get_driver_code_after_replace = str_replace("DC-","",$get_driver_code);
            $driver_code = $get_driver_code_after_replace+1;
        }else{
            $driver_code = 1;
        }
        $final_driver_code = 'DC-'.$driver_code;

        if($request->salary_type == 'Daily'){
            $per_day_salary = $request->salary;
        }else{
            $per_day_salary = $request->salary/30;
        }


        $driver = new Driver();
        $driver->name = $request->name;
        $driver->driver_code = $final_driver_code;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->present_address = $request->present_address;
        $driver->permanent_address = $request->permanent_address;
        $driver->driving_licence_no = $request->driving_licence_no;
        $driver->driving_experience_duration = $request->driving_experience_duration;
        $driver->salary_type = $request->salary_type;
        $driver->salary = $request->salary;
        $driver->per_day_salary = $per_day_salary;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/drivers/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $driver->logo = $imagename;
        $driver->save();
        $insert_id = $driver->id;
        if($insert_id){
            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Driver';
            $accessLog->action_done='Create';
            $accessLog->action_remarks='Driver ID: '.$insert_id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }
        Toastr::success('Driver Created Successfully');
        return redirect()->route('admin.drivers.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $driver = Driver::find($id);
        return view('backend.admin.drivers.edit',compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:drivers,name,'.$id,
        ]);

        if($request->salary_type == 'Daily'){
            $per_day_salary = $request->salary;
        }else{
            $per_day_salary = $request->salary/30;
        }

        $driver = Driver::find($id);
        $driver->name = $request->name;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->present_address = $request->present_address;
        $driver->permanent_address = $request->permanent_address;
        $driver->driving_licence_no = $request->driving_licence_no;
        $driver->driving_experience_duration = $request->driving_experience_duration;
        $driver->salary_type = $request->salary_type;
        $driver->salary = $request->salary;
        $driver->per_day_salary = $per_day_salary;
        $driver->status = $request->status;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(Storage::disk('public')->exists('uploads/drivers/'.$driver->logo))
            {
                Storage::disk('public')->delete('uploads/drivers/'.$driver->logo);
            }
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/drivers/' . $imagename, $proImage);

        }else {
            $imagename = $driver->logo;
        }
        $driver->logo = $imagename;
        $updated_row = $driver->save();
        if($updated_row){
            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Driver';
            $accessLog->action_done='Update';
            $accessLog->action_remarks='Driver ID: '.$id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Driver updated successfully','Success');
        return back();
    }

//    public function destroy($id)
//    {
//        $vendor = Vendor::find($id);
//        if(Storage::disk('public')->exists('uploads/vendors/'.$vendor->image))
//        {
//            Storage::disk('public')->delete('uploads/vendors/'.$vendor->image);
//        }
//        $deleted_row = $vendor->delete();
//        if($deleted_row){
//            $accessLog = new AccessLog();
//            $accessLog->user_id=Auth::user()->id;
//            $accessLog->action_module='Driver';
//            $accessLog->action_done='Delete';
//            $accessLog->action_remarks='Driver ID: '.$id;
//            $accessLog->action_date=date('Y-m-d');
//            $accessLog->save();
//        }
//
//        Toastr::success('Vendor deleted successfully','Success');
//        return back();
//    }

    public function check_already_driver_assigned_or_free($driver_id){
        return checkAlreadyDriverAssignedOrFree($driver_id);
    }

    public function check_already_driver_assigned_or_free_edit(Request $request){
        return checkAlreadyDriverAssignedOrFreeEdit($request->driver_id, $request->vehicle_driver_assign_id);
    }

    public function check_driver_salary_info($driver_id){
        return checkDriverSalaryInfo($driver_id);
    }

}
