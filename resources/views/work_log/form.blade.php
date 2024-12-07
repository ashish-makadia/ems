<div class="row">
    <input type="hidden" name="task_id" id="task_id" value="{{ isset($work_log)?$work_log->task_id:'' }}">
    <div class="col-md-12">
        <div class="ajaxLoading text-center" style="display:none;width:100%">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw text-maroon"></i>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name"><b>Time spent</b></label>
                     <input type="number" step="any" class="form-control" name="time_spent" id="time_spent" value="{{ isset($work_log)?$work_log->time_spent:'' }}">
                    <span class="text-muted">(eg. 2h )</span><br/>
                    <span id="time_spent_err" class="text-danger d-none">Time spent hour is greater than estimate hour</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name"><b>Date</b></label>
                    <input type="text" class="form-control" value="{{ isset($work_log)?date('d-m-Y',strtotime($work_log->log_date)):date('d-m-Y') }}"
                        name="log_date" id="log_date">
                </div>
            </div>
        </div>
       {{-- <div class="form-group m-form__group row">
            <label class="col-lg-3 col-form-label" for="name">Remaining Estimate</label>
            <div class="col-lg-9 m-form__group-sub">
                <input type="radio" value="adjust_automatically" name="remaining_estimate_type" @if(isset($work_log) && $work_log->remaining_estimate_type == "adjust_automatically") {{ "checked" }} @endif>
                <label for="name">&nbsp;&nbsp; Adjust Automaticlly</label><br/>
                <span class="text-muted" style="font-size: 10px;">this estimate will be reduced by the amount of work done.but never below 0.</span><br/>

                <input type="radio" value="estimate_one_day" @if(isset($work_log) && $work_log->remaining_estimate_type == "estimate_one_day") {{ "checked" }} @endif name="remaining_estimate_type">
                <label for="name">&nbsp;&nbsp; Use existing estimate of 1 day</label>
                <div class="d-flex row ml-0">
                    <span class="col-md-1 ml-0 pl-0 pr-0">
                    <input type="radio" class="mt-0" value="set_to" @if(isset($work_log) && $work_log->remaining_estimate_type == "set_to") {{ "checked" }} @endif
                    name="remaining_estimate_type"></span><label for="name" class="col-md-4  pl-0 pr-0">Set To</label>
                    <input type="number" name="set_to_time" @if(isset($work_log) && $work_log->remaining_estimate_type == "set_to") value="{{ $work_log->remaining_estimate_time }}"  @else {{ "disabled"}} @endif class="col-md-3 pl-0 form-control"><span class="text-muted mt-2">(eg. 2h )</span><br/>
                </div>
                <div class="d-flex row ml-0 ">
                    <span class="col-md-1 ml-0 pl-0 pr-0">
                    <input type="radio" class="mt-0" value="reduced_by" @if(isset($work_log) && $work_log->remaining_estimate_type == "reduced_by") {{ "checked" }} @endif
                    name="remaining_estimate_type"></span><label for="name" class="col-md-4  pl-0 pr-0">Reduced By</label>
                    <input type="number" name="reduced_by_time"  @if(isset($work_log) && $work_log->remaining_estimate_type == "reduced_by") value="{{ $work_log->remaining_estimate_time }}"  @else {{ "disabled"}} @endif class="col-md-3 mt-1 pl-0 form-control">
                    <span class="text-muted mt-2">(eg. 2h )</span><br/>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address"><b>Description</b></label>
                    <textarea name="description" id="editor2" class="form-control">{{ $work_log->description ?? old('description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-header -->

</div>
</div>
<!-- End Row  -->
