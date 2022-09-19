<?php

namespace App\Http\Controllers\Admin;

use App\Model\Attribute;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Customer;
use App\Model\Driver;
use App\Model\Order;
use App\Model\Product;
use App\Model\Subcategory;
use App\Model\SubSubcategory;
use App\Model\Vehicle;
use App\Model\VehicleDriverAssign;
use App\Model\Vendor;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
//        $expired_driver_assign_data = DB::table('vehicle_driver_assigns')
//            ->select('driver_id', DB::raw('SELECT end_date'))
//            ->where('end_date', '<',date('Y-m-d'))
//            ->groupBy('driver_id')
//            ->get();

        $expired_driver_assign_data = VehicleDriverAssign::select('driver_id','end_date')->where('end_date', '<',date('Y-m-d'))
            ->whereIn('id', function($query) {
                $query->from('vehicle_driver_assigns')->groupBy('driver_id')->selectRaw('MAX(id)');
            })->get();
        //dd($expired_driver_assign_data);

        if(count($expired_driver_assign_data) > 0){
            foreach ($expired_driver_assign_data as $data){
                // driver update
                $driver = Driver::find($data->driver_id);
                $driver->vehicle_id = NULL;
                $driver->save();

                // vehicle update
                $vehicle = Vehicle::where('driver_id',$data->driver_id)->latest()->first();
                if(!empty($vehicle)){
                    $vehicle->driver_id = NULL;
                    $vehicle->save();
                }
            }
        }


        $totalStaffs = User::where('user_type','staff')->count();
        $totalUsers = User::where('user_type','customer')->count();
        $totalCategories = Category::count();
        $totalSubCategories = Subcategory::count();
        $totalBrands = Brand::count();
        $totalVendors = Vendor::count();
        $totalDrivers = Driver::count();
        $totalCustomers = Customer::count();
        $totalVehicles = Vehicle::count();
        $totalVehicleDriverAssigns = VehicleDriverAssign::count();
        $totalVehicleVendorRents = Order::where('type','Vendor')->count();

        return view('backend.admin.dashboard',
            compact(
                'totalStaffs',
                'totalBrands',
                'totalUsers',
                'totalCategories',
                'totalSubCategories',
                'totalVendors',
                'totalDrivers',
                'totalCustomers',
                'totalVehicles',
                'totalVehicleDriverAssigns',
                'totalVehicleVendorRents'
            ));
    }
}
