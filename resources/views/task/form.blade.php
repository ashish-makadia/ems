<div class="row">
    <div class="col-md-12">
        <div class="ajaxLoading text-center" style="display:none;width:100%">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw text-maroon"></i>
        </div>

        <div class="row">
            {{-- <div class="col-md-4">
               <div class="form-group">
                    <label for="name"><b>Task Title</b></label>
                    <input type="text" class="form-control" name="task_title" value="{{ isset($task)?$task->task_title:old('task_title')}}"
                        id="task_title">
                </div>
            </div> --}}

            <div class="col-md-4">
                <div class="form-group">
                   <label for="project_id"><b>Project</b></label>
                <select name="project_id" id="project_id" class="form-control">
                    <option value="">Select Project</option>
                    @if(isset($projects))
                    @foreach ($projects as $prj)
                        <option value="{{ $prj->id }}"
                        {{ isset($task->project_id)?($task->project_id == $prj->id?"Selected":''):'' }}>{{$prj->project_name}}</option>
                    @endforeach
                    @endif
                </select>
                </div>
            </div>
            @if(Auth::user()->role == 'Super Admin')
            <div class="col-md-4">
               <div class="form-group">
                   <label for="category_id"><b>Employee</b></label>
                   <select name="team_members[]" id="team_member" multiple class="form-control select2">
                       <option value="">...............</option>
                       @if(isset($employees))
                       @foreach ($employees as $employee )
                       <option value="{{ $employee->id}}" @if(isset($team_members) && in_array($employee->id,$team_members)) {{"Selected"}} @endif>{{$employee->name}}</option>
                       @endforeach
                       @endif
                   </select>
               </div>
           </div>
           @endif

            <div class="col-md-4">
                <div class="form-group">
                    <label for="name"><b>Estimate Hours</b></label>
                    <input type="number" class="form-control" step="any" value="{{ isset($task)?$task->estimate_hour:'' }}"
                        name="estimate_hour">
                    <span class="text-muted">(eg. 2h )</span><br/>
                </div>
            </div>

        <div class="col-md-4">
            <div class="form-group">
               <label for="tasktype_id"><b>Task Type</b></label>
            <select name="tasktype_id" class="form-control">
                <option value="">.....</option>
             @foreach ($tasktype as $key =>  $val)
                    <option value="{{ $key }}"
                    {{ isset($task->tasktype_id)?($task->tasktype_id==$key?"selected":""):""}}>{{$val}}</option>
                @endforeach

            </select>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="name"><b>Summary</b></label>
                <input type="text" class="form-control" name="summry" value="{{ isset($task)?$task->summry:old('summry')}}"
                    id="summry">
            </div>
        </div>

        </div>


       {{-- <div class="row">
         <div class="col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Start Time</b></label>
                            <input type="time" name="start_time" id="start_time" class="form-control " value="">
                                                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name"><b>End Time</b></label>
                            <input type="time" name="end_time" id="end_time" class="form-control " value="">
                                                    </div>
                    </div>
                </div>
            </div> --}}
    <!-- /.box-header -->
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="address"><b>Description</b></label>
                <textarea name="description" id="editor2" class="form-control">{{ $task->description ?? old('description') }}</textarea>
            </div>
        </div>

    </div>
</div>
</div>
<!-- End Row  -->
