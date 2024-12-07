@extends('layouts.app')
@section('subheader',"Change Password")
@section('content')
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Change Password
                </h3>
            </div>
        </div>
    </div>
    <form action="{{route('profile.password_change')}}" method="get" enctype="multipart/form-data" autocomplete="off">
        <div class="m-portlet__body">
            <!-- Start Row  -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name"><b>Old Password</b></label>
                        <input type="text" name="o_password" id="o_password" class="form-control">

                    </div>
                </div>
            </div>
            <div class="row">
                <!-- /.box-header -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name"><b>New Password</b></label>
                        <input type="text" name="n_password" id="n_password" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mobile_no"><b>Confirm Password</b></label>
                        <input type="text" name="c_password" id="c_password" class="form-control">
                    </div>
                </div>
            </div>
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

@section('footer_scripts')
