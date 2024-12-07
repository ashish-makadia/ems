<div class="row">
    <div class="col-md-12">
        <div class="ajaxLoading text-center" style="display:none;width:100%">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw text-maroon"></i>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name"><b>Name</b></label>
                    <input type="text" name="project_name" id="name" class="form-control "
                        value="{{ $project->project_name ?? old('project_name') }}">
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label for="category_id"><b>Employee</b></label>
                    <select name="team_members[]" id="team_member" multiple class="form-control select2">
                        <option value="">..........</option>
                          @foreach ($employees as $employee)
                         <option value="{{ $employee->id}}" @if(isset($team_members) && in_array($employee->id,$team_members)) {{"Selected"}} @endif>{{$employee->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
        </div>

        <!-- Start Row  -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name"><b>Start Date</b> (Optional)</label>
                    @if(@$project->start_date)
                    <input type="text" class="form-control datepicker" value="{{ date('d-m-Y',strtotime(@$project->start_date)) }}"
                        name="start_date" id="start_date">
                        @else
                        <input type="text" class="form-control datepicker" value="" name="start_date" id="start_date">
                        @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name"><b>End Date</b> (Optional)</label>
                    @if(@$project->end_date)
                    <input type="text" class="form-control datepicker" value="{{ date('d-m-Y',strtotime(@$project->end_date)) }}"
                        name="end_date" id="end_date">
                        @else
                        <input type="text" class="form-control datepicker" value="" name="end_date" id="end_date">
                        @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputFile"><b>Status</b></label>
                    <select name="project_status" class="form-control">
                        <option value="">Select Status</option>
                        @foreach ($projectStatus as $key =>  $val)
                            <option value="{{ $key }}"
                            {{ @@$project->project_status?($project->project_status==$key?"selected":""):""}}>{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputFile"><b>Attachment</b></label>
                    <input type="file" name="attachment" id="attachment" style="padding: 10px;height:45px"  class="form-control image" value="">{{ isset($project)?$project->attachment:""}}
                </div>
            </div> --}}
        </div>

    <!-- /.box-header -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="address"><b>Description</b></label>
                <textarea name="description" id="editor2" class="form-control">{{ $project->description ?? old('description') }}</textarea>
            </div>
        </div>

    </div>
</div>
</div>
<!-- End Row  -->
