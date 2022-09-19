@extends('backend.layouts.master')
@section("title","Add Driver")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Driver</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Driver</li>
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
                    <h3 class="card-title float-left">Add Driver</h3>
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
                <form role="form" action="{{route('admin.drivers.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name <span>*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone <span>*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="present_address">Present Address</label>
                            <input type="text" class="form-control" name="present_address" id="present_address" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <input type="text" class="form-control" name="permanent_address" id="permanent_address" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="driving_licence_no">Driving Licence NO <span>*</span></label>
                            <input type="text" class="form-control" name="driving_licence_no" id="driving_licence_no" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="driving_experience_duration">Driving Experience Duration <span>*</span></label>
                            <input type="text" class="form-control" name="driving_experience_duration" id="driving_experience_duration" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="salary_type">Salary Type <span>*</span></label>
                            <select name="salary_type" id="salary_type" class="form-control select2" required>
                                <option value="Daily">Daily</option>
                                <option value="Monthly" selected>Monthly</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary <span>*</span></label>
                            <input type="number" class="form-control" name="salary" id="salary" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Driver Image <small>(size: 120 * 80 pixel)</small> <span>*</span></label>
                            <input type="file" class="form-control" name="logo" id="logo" required>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="meta_desc">Meta Description</label>--}}
{{--                            <textarea name="meta_description" id="meta_desc" class="form-control"  rows="3"></textarea>--}}
{{--                        </div>--}}
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
