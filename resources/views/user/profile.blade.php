@extends('layouts.app')
@section('subheader',"Profile")
@section('content')
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    User Information
                </h3>
            </div>
        </div>
    </div>
    <form action="{{route('profiles.update',$user->id)}}" method="POST" class="userForm" enctype="multipart/form-data">
    @csrf
        <div class="m-portlet__body">
            <!-- Start Row  -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name"><b>Name</b></label>
                        <input type="text" name="name" id="name" class="form-control " value="{{$user->name??old('name')}}">

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name"><b>Email Address</b></label>
                        <input type="email" name="email" id="email" class="form-control " value="{{$user->email??old('email')}}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mobile_no"><b>Phone</b></label>
                        <input type="text" name="mobile_no" id="mobile_no" class="form-control " value="{{$user->mobile_no??old('mobile_no')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Additional Information
                        <hr>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address"><b>Address</b></label>
                        <input type="text" name="address" id="address" class="form-control " value="{{$employee->address??old('address')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pincode"><b>Pincode</b></label>
                        <input type="text" name="pincode" id="pincode" class="form-control " value="{{$employee->pincode??old('pincode')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pan"><b>PAN</b></label>
                        <input type="text" name="pan" id="pan" class="form-control " value="{{$employee->pan??old('pan')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputFile"><b>Image</b></label>
                        
                       
                        @if(@$employee->image)
                @php $image = asset("images/employee/".$employee->image); @endphp
                
                @else
                @php $image = asset('admin-files\assets\image\default.png') @endphp
                
                @endif
                <input type="file" name="image" id="employeeImage" style="padding: 10px;height:45px"  class="form-control">
                <input type="hidden" name="old_image"  style="padding: 10px;height:45px"  value="{{$employee->image??old('image')}}" class="form-control">     
            <div class="imagePreview">
            
            <img style="width:200px;height:160px;margin-top:5px" class="image-preview img-thumbnail" id="imgPreview" src="{{ $image }}" alt="">
                        </div>
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
@push('scripts')
<script type="text/javascript">
    $("#employeeImage").change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $("#imgPreview")
                    .attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush