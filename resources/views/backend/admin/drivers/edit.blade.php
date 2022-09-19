@extends('backend.layouts.master')
@section("title","Edit Driver")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Driver</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Driver</li>
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
                        <h3 class="card-title float-left">Edit Driver</h3>
                        <div class="float-right">
                            <a href="{{route('admin.drivers.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.drivers.update',$driver->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{$driver->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone"  value="{{$driver->phone}}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email"  value="{{$driver->email}}">
                            </div>
                            <div class="form-group">
                                <label for="present_address">Present Address</label>
                                <input type="text" class="form-control" name="present_address" id="present_address" value="{{$driver->present_address}}">
                            </div>
                            <div class="form-group">
                                <label for="permanent_address">Permanent Address</label>
                                <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="{{$driver->permanent_address}}">
                            </div>
                            <div class="form-group">
                                <label for="driving_licence_no">Driving Licence NO <span>*</span></label>
                                <input type="text" class="form-control" name="driving_licence_no" id="driving_licence_no" value="{{$driver->driving_licence_no}}" required>
                            </div>
                            <div class="form-group">
                                <label for="driving_experience_duration">Driving Experience Duration <span>*</span></label>
                                <input type="text" class="form-control" name="driving_experience_duration" id="driving_experience_duration" value="{{$driver->driving_experience_duration}}" required>
                            </div>
                            <div class="form-group">
                                <label for="salary_type">Salary Type <span>*</span></label>
                                <select name="salary_type" id="salary_type" class="form-control select2" required>
                                    <option value="Daily" {{$driver->salary_type == 'Daily' ? 'selected' : ''}}>Daily</option>
                                    <option value="Monthly" {{$driver->salary_type == 'Monthly' ? 'selected' : ''}}>Monthly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="salary">Salary <span>*</span></label>
                                <input type="number" class="form-control" name="salary" id="salary" value="{{$driver->salary}}" required>
                            </div>
                            <img src="{{asset('uploads/drivers/'.$driver->logo)}}" width="80" height="50" alt="">
                            <div class="form-group">
                                <label for="logo">Driver Logo <small>(size: 120 * 80 pixel)</small></label>
                                <input type="file" class="form-control" name="logo" id="logo" >
                            </div>
                            <div class="form-group">
                                <label for="status">Status <span>*</span></label>
                                <select name="status" id="status" class="form-control select2" required>
                                    <option value="1" {{$driver->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{$driver->status == 0 ? 'selected' : ''}}>Inactive</option>
                                </select>
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

@endpush
