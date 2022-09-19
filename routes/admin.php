<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', 'Admin\AuthController@ShowLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\AuthController@LoginCheck')->name('admin.login.check');
Route::group(['as'=>'admin.','prefix' =>'admin','namespace'=>'Admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('roles','RoleController');
    Route::post('/roles/permission','RoleController@create_permission');
    Route::resource('staffs','StaffController');
    Route::resource('brands','BrandController');
    Route::resource('vendors','VendorController');
    Route::resource('drivers','DriverController');
    Route::resource('customers','CustomerController');
    Route::resource('vehicles','VehicleController');
    Route::resource('vehicle-driver-assigns','VehicleDriverAssignController');
    Route::resource('categories','CategoryController');
    Route::resource('overall-cost-categories','OverallCostCategoryController');
    Route::resource('overall-cost','OverallCostController');
    Route::resource('vehicle-cost','VehicleCostController');
    Route::resource('access-logs','AccessLogController');

    // vehicle rent from vendor
    Route::get('vehicle/vendor/rent/due','OrderController@vehicle_vendor_rent_due')->name('vehicle-vendor-rent-due');
    Route::get('vehicle/vendor/rent/list','OrderController@vehicle_vendor_rent_list')->name('vehicle-vendor-rent-list');
    Route::get('vehicle/vendor/rent/create','OrderController@vehicle_vendor_rent_create')->name('vehicle-vendor-rent-create');
    Route::post('vehicle/vendor/rent/store','OrderController@vehicle_vendor_rent_store')->name('vehicle-vendor-rent-store');
    Route::get('vehicle/vendor/rent/show/{id}','OrderController@vehicle_vendor_rent_show')->name('vehicle-vendor-rent-show');
    Route::get('vehicle/vendor/rent/edit/{id}','OrderController@vehicle_vendor_rent_edit')->name('vehicle-vendor-rent-edit');
    Route::put('vehicle/vendor/rent/update/{id}','OrderController@vehicle_vendor_rent_update')->name('vehicle-vendor-rent-update');
    Route::get('order/vendor/print/{id}','OrderController@order_vendor_print')->name('order-vendor-print');

    // vehicle rent to customer
    Route::get('vehicle/customer/rent/due','OrderController@vehicle_customer_rent_due')->name('vehicle-customer-rent-due');
    Route::get('vehicle/customer/rent/list','OrderController@vehicle_customer_rent_list')->name('vehicle-customer-rent-list');
    Route::get('vehicle/customer/rent/create','OrderController@vehicle_customer_rent_create')->name('vehicle-customer-rent-create');
    Route::post('vehicle/customer/rent/store','OrderController@vehicle_customer_rent_store')->name('vehicle-customer-rent-store');
    Route::get('vehicle/customer/rent/show/{id}','OrderController@vehicle_customer_rent_show')->name('vehicle-customer-rent-show');
    Route::get('vehicle/customer/rent/edit/{id}','OrderController@vehicle_customer_rent_edit')->name('vehicle-customer-rent-edit');
    Route::put('vehicle/customer/rent/update/{id}','OrderController@vehicle_customer_rent_update')->name('vehicle-customer-rent-update');
    Route::get('order/customer/print/{id}','OrderController@order_customer_print')->name('order-customer-print');

    Route::get('check/already/vehicle/assigned/to/driver/{id}','VehicleController@check_already_vehicle_assigned_to_driver');
    Route::get('check/already/vehicle/assigned/or/free/{id}','VehicleController@check_already_vehicle_assigned_or_free');
    Route::get('check/already/driver/assigned/or/free/{id}','DriverController@check_already_driver_assigned_or_free');
    Route::post('check/already/vehicle/assigned/or/free/edit','VehicleController@check_already_vehicle_assigned_or_free_edit');
    Route::post('check/already/driver/assigned/or/free/edit','DriverController@check_already_driver_assigned_or_free_edit');
    Route::post('get/vehicle/price','VehicleController@get_vehicle_price');
    //Route::get('check/already/vehicle/rent/or/not/{id}','VehicleController@check_already_vehicle_rent_or_not');
    Route::post('check/already/vehicle/rent/or/not/this/date','VehicleController@check_already_vehicle_rent_or_not_this_date');
    Route::post('get/vehicle/assigned/driver','VehicleDriverAssignController@get_vehicle_assigned_driver');
    Route::post('vendor-pay-due','OrderController@vendorPayDue')->name('vendor.pay.due');
    Route::post('customer-pay-due','OrderController@customerPayDue')->name('customer.pay.due');

    Route::get('check/driver/salary/info/{id}','DriverController@check_driver_salary_info');

    // driver salary
    Route::get('driver/salary/list','DriverSalaryController@driver_salary_list')->name('driver-salary-list');
    Route::get('driver/salary/create','DriverSalaryController@driver_salary_create')->name('driver-salary-create');
    Route::post('driver/salary/store','DriverSalaryController@driver_salary_store')->name('driver-salary-store');
    Route::get('driver/salary/show/{id}','DriverSalaryController@driver_salary_show')->name('driver-salary-show');
    Route::get('driver/salary/edit/{id}','DriverSalaryController@vehicle_customer_rent_edit')->name('driver-salary-edit');
    Route::post('check/driver/salary','DriverSalaryController@check_driver_salary');
    Route::post('check/already/driver/salary','DriverSalaryController@check_already_driver_salary');
    Route::post('driver-pay-due','DriverSalaryController@driverPayDue')->name('driver.pay.due');

    // staff salary
    Route::get('staff/salary/list','StaffSalaryController@staff_salary_list')->name('staff-salary-list');
    Route::get('staff/salary/create','StaffSalaryController@staff_salary_create')->name('staff-salary-create');
    Route::post('staff/salary/store','StaffSalaryController@staff_salary_store')->name('staff-salary-store');
    Route::get('staff/salary/show/{id}','StaffSalaryController@staff_salary_show')->name('staff-salary-show');
    Route::get('staff/salary/edit/{id}','StaffSalaryController@staff_salary_edit')->name('staff-salary-edit');
    Route::post('check/staff/salary','StaffSalaryController@check_staff_salary');
    Route::post('check/already/staff/salary','StaffSalaryController@check_already_staff_salary');
    Route::post('staff-pay-due','StaffSalaryController@staffPayDue')->name('staff.pay.due');

    // report
    Route::get('report/payments','ReportController@reportPayment')->name('get-report-payment');
    Route::post('report/payments','ReportController@reportPayment')->name('report-payment');
    Route::get('report/payments-print/{date_from}/{date_to}','ReportController@report_payment_print');
    // vendor balance sheet
    Route::get('report/vendor-balance-sheet','ReportController@vendor_balance_sheet_form')->name('get-report-vendor-balance-sheet');
    Route::post('report/vendor-balance-sheet','ReportController@vendor_balance_sheet_form')->name('report-vendor-balance-sheet');
    Route::get('report/vendor-balance-sheet-print/{date_from}/{date_to}','ReportController@report_vendor_balance_sheet_print');
    // customer balance sheet
    Route::get('report/customer-balance-sheet','ReportController@customer_balance_sheet_form')->name('get-report-customer-balance-sheet');
    Route::post('report/customer-balance-sheet','ReportController@customer_balance_sheet_form')->name('report-customer-balance-sheet');
    Route::get('report/customer-balance-sheet-print/{date_from}/{date_to}','ReportController@report_customer_balance_sheet_print');
    // driver balance sheet
    Route::get('report/driver-balance-sheet','ReportController@driver_balance_sheet_form')->name('get-report-driver-balance-sheet');
    Route::post('report/driver-balance-sheet','ReportController@driver_balance_sheet_form')->name('report-driver-balance-sheet');
    Route::get('report/driver-balance-sheet-print/{date_from}/{date_to}','ReportController@report_driver_balance_sheet_print');
    // staff balance sheet
    Route::get('report/staff-balance-sheet','ReportController@staff_balance_sheet_form')->name('get-report-staff-balance-sheet');
    Route::post('report/staff-balance-sheet','ReportController@staff_balance_sheet_form')->name('report-staff-balance-sheet');
    Route::get('report/staff-balance-sheet-print/{date_from}/{date_to}','ReportController@report_staff_balance_sheet_print');

    Route::get('report/loss-profit','ReportController@loss_profit')->name('get-report-loss-profit');
    Route::post('report/loss-profit','ReportController@loss_profit')->name('report-loss-profit');
    Route::get('report/loss-profit-print/{date_from}/{date_to}','ReportController@loss_profit_print');
    Route::get('report/loss-profit/export/', 'ReportController@loss_profit_export')->name('report-loss-profit-export');
    Route::get('report/loss-profit-filter-export/{start_date}/{end_date}','ReportController@loss_profit_export_filter')->name('report-loss-profit-filter-export');





    Route::post('categories/is_home', 'CategoryController@updateIsHome')->name('categories.is_home');

    // Admin User Management
    Route::resource('customers','CustomerController');
    Route::get('customers/show/profile/{id}','CustomerController@profileShow')->name('customers.profile.show');
    Route::put('customers/update/profile/{id}','CustomerController@updateProfile')->name('customer.profile.update');
    Route::put('customers/password/update/{id}','CustomerController@updatePassword')->name('customer.password.update');
    Route::get('customers/ban/{id}','CustomerController@banCustomer')->name('customers.ban');

    Route::resource('profile','ProfileController');
    Route::put('password/update/{id}','ProfileController@updatePassword')->name('password.update');

    //performance
    Route::get('/config-cache', 'SystemOptimize@ConfigCache')->name('config.cache');
    Route::get('/clear-cache', 'SystemOptimize@CacheClear')->name('cache.clear');
    Route::get('/view-cache', 'SystemOptimize@ViewCache')->name('view.cache');
    Route::get('/view-clear', 'SystemOptimize@ViewClear')->name('view.clear');
    Route::get('/route-cache', 'SystemOptimize@RouteCache')->name('route.cache');
    Route::get('/route-clear', 'SystemOptimize@RouteClear')->name('route.clear');
    Route::get('/site-optimize', 'SystemOptimize@Settings')->name('site.optimize');

});
