<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VendorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:vendor-list|vendor-create|vendor-edit|vendor-delete', ['only' => ['index','store']]);
        $this->middleware('permission:vendor-create', ['only' => ['create','store']]);
        $this->middleware('permission:vendor-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:vendor-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $vendors = Vendor::all();
        return view('backend.admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('backend.admin.vendors.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vendors,name',
        ]);

        $get_vendor_code = Vendor::latest('id','desc')->pluck('vendor_code')->first();
        if(!empty($get_vendor_code)){
            $get_vendor_code_after_replace = str_replace("VC-","",$get_vendor_code);
            $vendor_code = $get_vendor_code_after_replace+1;
        }else{
            $vendor_code = 1;
        }
        $final_vendor_code = 'VC-'.$vendor_code;

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->vendor_code = $final_vendor_code;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->vendor_address = $request->vendor_address;
        $vendor->company_name = $request->company_name;
        $vendor->company_address = $request->company_address;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/vendors/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $vendor->logo = $imagename;
        $vendor->save();
        $insert_id = $vendor->id;
        if($insert_id){
            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vendor';
            $accessLog->action_done='Create';
            $accessLog->action_remarks='Vendor ID: '.$insert_id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vendor Created Successfully');
        return redirect()->route('admin.vendors.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return view('backend.admin.vendors.edit',compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:vendors,name,'.$id,
        ]);

        $vendor = Vendor::find($id);
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->vendor_address = $request->vendor_address;
        $vendor->company_name = $request->company_name;
        $vendor->company_address = $request->company_address;
        $vendor->status = $request->status;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(Storage::disk('public')->exists('uploads/vendors/'.$vendor->logo))
            {
                Storage::disk('public')->delete('uploads/vendors/'.$vendor->logo);
            }
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/vendors/' . $imagename, $proImage);

        }else {
            $imagename = $vendor->logo;
        }
        $vendor->logo = $imagename;
        $updated_row =$vendor->save();
        if($updated_row){
            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vendor';
            $accessLog->action_done='Update';
            $accessLog->action_remarks='Vendor ID: '.$id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vendor updated successfully','Success');
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
//            $accessLog->action_module='Vendor';
//            $accessLog->action_done='Delete';
//            $accessLog->action_remarks='Vendor ID: '.$id;
//            $accessLog->action_date=date('Y-m-d');
//            $accessLog->save();
//        }
//
//        Toastr::success('Vendor deleted successfully','Success');
//        return back();
//    }
}
