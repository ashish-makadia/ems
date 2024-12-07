@extends('layouts.app')
@section('subheader',__('messages.worklogreport'))
@section('content')
<style>
.table {
    overflow: scroll;
  }
  .red {
    background : #ffc9c9;
  }
</style>
{{-- <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{ __('messages.worklogreport')}}
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="row justify-content-start">
            <div class="col-md-6">
                <form id="worklogReport" method="post">
                    @csrf
                    <div class="row">
                         <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                   <b> Show Weekends </b>
                                </div>
                                <div class="col-md-8">
                                    <label class="ms-3 m-checkbox m-checkbox--solid">
                                       <input type="checkbox" class="checkbox" name="show_weekends" value="1" checked="">
                                        <span></span>
                                    </label>
                                    <p class="text-muted mt-2" style="font-size:10px;">Whether or not to show weekends in timesheet</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                <b> Show Details </b>
                                </div>
                                <div class="col-md-8">
                                    <label class="ms-3 m-checkbox m-checkbox--solid">
                                        <input type="checkbox" class="checkbox" name="show_details" value="1" checked="">
                                        <span></span>
                                    </label>
                                        <p class="text-muted mt-2" style="font-size:10px;">Show detailed report per user</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                <b> Month View </b>
                                </div>
                                <div class="col-md-8">
                                    <label class="ms-3 m-checkbox m-checkbox--solid">
                                        <input type="checkbox" class="checkbox" name="show_details" value="1" checked="">
                                        <span></span>
                                    </label>
                                    <p class="text-muted mt-2" style="font-size:10px;">Show detailed report per user</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"><b>Sum By</b></label>
                                <select class="form-control" name="sum_by">
                                    <option value="">Select</option>
                                    <option value="days">Day</option>
                                    <option value="week">weekly</option>
                                    <option value="month">Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <b> Show Empty Log </b>
                                </div>
                                <div class="col-md-8">
                                    <label class="ms-3 m-checkbox m-checkbox--solid">
                                        <input type="checkbox" class="checkbox" name="show_details" value="1" checked="">
                                        <span></span>
                                    </label>
                                    <p class="text-muted mt-2" style="font-size:10px;">Show rows without worklog</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"><b>Start Date</b></label>
                                <input type="text" class="form-control datetime" value="{{ isset($inputData['start_date'])?$inputData['start_date']:date('d-m-Y') }}"
                                    name="start_date" id="start_date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"><b>End Date</b></label>
                                <input type="text" class="form-control datetime" value="{{ isset($inputData['end_date'])?$inputData['end_date']:date('d-m-Y') }}"
                                    name="end_date" id="end_date">
                            </div>
                        </div>
                        @if (auth()->user()->role == "Super Admin")
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_id"><b>Employee</b></label>
                                <select name="employee_id[]" id="employee_id" class="form-control select2" multiple>
                                    <option value="">..........</option>
                                    @foreach ($employees as $employee )
                                    <option value="{{ $employee['id'] }}" @if(isset($inputData['employee_id']) && $inputData['employee_id'] == $employee['id'])) {{"Selected"}} @endif multiple>{{$employee['name']}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee_id'))
                                    <div class="text-danger">{{ $errors->first('employee_id') }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="project_id"><b>Project</b></label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="">Select Project</option>
                                @if(!empty($projectList))
                                    @foreach ($projectList as $prj )
                                        <option value="{{ $prj->id }}" {{ (isset($projectId) && $projectId == $prj->id)? "Selected":'' }}>{{$prj->project_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="project_id"><b>Task</b></label>
                            <select name="task_id" id="task_id" class="form-control">
                                <option value="">Select Task</option>
                                @if(!empty($taskList))
                                @foreach ($taskList as $task )
                                    @if($task->task_summry != "")
                                        <option value="{{ $task->id }}" @if(isset($taskId) && $taskId == $task->id) {{"Selected"}} @endif>{{$task->summry}}</option>
                                    @endif
                                @endforeach
                            @endif
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center" style="margin-top:20px;margin-bottom:10px">
                                <button type="submit" id="searchBtn" class="btn btn-primary btn-block submitBtn" style="font-size:16px"><i class="fa fa-search fa-fw "></i> Search</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center" style="margin-top:20px;margin-bottom:10px">
                            <button type="submit" id="excelBtn" class="btn btn-primary btn-block submitBtn" style="font-size:16px">
                                <i class="fa fa-save"></i> Export
                            </button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{ __('messages.worklogreport')}}
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        {!! $reportHtml !!}
    </div>
</div>

</div>
@endsection
@section('footer_scripts')
@include('reports.script')
{{-- <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script> --}}
<script type="text/javascript">
    var worklogDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable({
        scrollX: true,
    });

</script>
@include('layouts.customdatatable');
@endsection
