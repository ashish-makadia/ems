<div class="row">
    <div class="ajaxLoading text-center" style="display:none;width:100%">
        <i class="fa fa-spinner fa-spin fa-3x fa-fw text-maroon"></i>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="category_id"><b>Category</b></label>
            <select name="category_id" id="category_id" class="form-control select2">
                <option value="">..........</option>
                @foreach ($categories as $key)
               <option value="{{ $key->id }}" <?php if(@$employee->category_id == $key->id){ echo "selected"; } ?>>{{$key->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="designation_id"><b>Designation</b></label>
            <select name="designation_id" id="designation_id" class="form-control select2">
                <option value="">..........</option>
                @foreach ($designations as $key => $desig)
                <option value="{{ $desig->id }}" <?php if(@$employee->designation_id == $desig->id){ echo "selected"; } ?>>{{$desig->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="team_id"><b>Team</b></label>
            <select name="team_id" id="team_id" class="form-control select2">
                <option value="">..........</option>
                @foreach ($team as $key => $team_data)
                <option value="{{ $team_data->id }}" <?php if(@$employee->team_id == $team_data->id){ echo "selected"; } ?>>{{$team_data->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="employee_type"><b>Employee Type</b></label>
            <select name="employee_type[]"  class="form-control select2">
                <option value="">..........</option>
                  @foreach ($employee_type as $key => $design)
                <option value="{{ $design }}" {{ @@$employee->
                            employee_type?($employee->employee_type==$design?"selected":""):""}}>{{$design}}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>

<!-- Start Row  -->
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="name"><b>Name</b></label>
            <input type="text" name="name" id="name" class="form-control " value="{{$employee->name??old('name')}}">

        </div>
    </div>
    <!-- /.box-header -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="name"><b>Email Address</b></label>
            <input type="email" name="email" id="email" class="form-control " value="{{$employee->email??old('email')}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone"><b>Phone</b></label>
            <input type="number" name="phone" id="phone" class="form-control " value="{{$employee->phone??old('phone')}}">
            </div>
        </div>

    </div>
    {{--<div class="row">

             <div class="col-md-4">
                    <div class="form-group">
                        <label for="name"><b>Employee Password</b></label>
                        <input type="password" name="password" id="password" class="form-control">

                    </div>
                </div>
      </div>  --}}

<div class="row">

    <div class="col-md-8">
        <div class="form-group">
            <label for="address"><b>Address</b></label>
            <input type="text" name="address" id="address" class="form-control " value="{{$employee->address??old('address')}}">
        </div>
    </div>


    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputFile"><b>Image</b></label>
            <input type="file" name="image" id="employeeImage" style="padding: 10px;height:45px" class="form-control image ">
            <div class="imagePreview">

                @if(isset($employee) && $employee->image)
                @php $image = asset("images/employee/".$employee->image); @endphp
                @else
                @php $image = asset('admin-files\assets\image\default.png') @endphp
                @endif
                <img style="width:200px;height:160px;margin-top:5px" class="image-preview img-thumbnail" id="imgPreview" src="{{ $image }}" alt="">
                <input type="hidden" name="old_image" id="employeeImage" style="padding: 10px;height:45px"  value="{{$employee->image??old('image')}}" class="form-control">
            </div>
        </div>

    </div>

</div>
<!-- End Row  -->
