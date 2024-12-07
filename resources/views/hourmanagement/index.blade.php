@extends('layouts.app')
@section('subheader',"Additional Settings")
@section('content')
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                     Hour Management
                </h3>
            </div>
        </div>
    </div>
    <form action="{{route('hour-management.store')}}" method="get" class="userForm" enctype="multipart/form-data">
        <div class="m-portlet__body">
            <!-- Start Row  -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fulltime_hours"><b>Full-Time Hours</b></label>
                        <input type="text" name="fulltime_hours" id="fulltime_hours" class="form-control " value="{{@$hours->fulltime_hours??old('fulltime_hours')}}">
                        <input type="hidden" name="id" value="{{@$hours->id??old('id')}}">

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="parttime_hours"><b>Part-Time Hours</b></label>
                        <input type="text" name="parttime_hours" id="parttime_hours" class="form-control " value="{{@$hours->parttime_hours??old('parttime_hours')}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="halftime_hours"><b>Half-Day Hours</b></label>
                        <input type="text" name="halftime_hours" id="halftime_hours" class="form-control " value="{{@$hours->halftime_hours??old('halftime_hours')}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="m-portlet__body">
           
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="margin-top:30px;margin-bottom:10px">
                        <button type="submit" class="btn btn-primary btn-block" style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection
