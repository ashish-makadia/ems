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
        <div class="row justify-content-start">
            <div class="col-md-12">
                <form id="worklogReport" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><b>Start Date</b></label>
                                <input type="text" class="form-control datetime" value="{{ isset($inputData['start_date'])?$inputData['start_date']:date('d-m-Y') }}"
                                    name="start_date" id="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><b>End Date</b></label>
                                <input type="text" class="form-control datetime" value="{{ isset($inputData['end_date'])?$inputData['end_date']:date('d-m-Y') }}"
                                    name="end_date" id="end_date">
                            </div>
                        </div>
                        @if (auth()->user()->role == "Super Admin")
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id"><b>Employee</b></label>
                                <select name="employee_id[]" id="employee_id" class="form-control select2" multiple>
                                    <option value="">..........</option>
                                    @foreach ($employees as $employee )
                                    <option value="{{ $employee['id'] }}" @if(isset($inputData['employee_id']) && in_array($employee['id'],$inputData['employee_id']))) {{"Selected"}} @endif>{{$employee['name']}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee_id'))
                                    <div class="text-danger">{{ $errors->first('employee_id') }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="project_id"><b>Project</b></label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="">Select Project</option>
                                @if(!empty($projectList))
                                    @foreach ($projectList as $prj )
                                        <option value="{{ $prj->id }}" @if(isset($inputData['employee_id']) && $prj->id == $inputData['project_id']) {{"Selected"}} @endif>{{$prj->project_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="project_id"><b>Task</b></label>
                            <select name="task_id" id="task_id" class="form-control">
                                <option value="">Select Task</option>
                                @if(!empty($taskList))
                                @foreach ($taskList as $task )
                                    @if($task->task_summry != "")
                                        <option value="{{ $task->id }}" @if(isset($inputData['task_id']) && $task->id == $inputData['task_id']) {{"Selected"}} @endif>{{$task->summry}}</option>
                                    @endif
                                @endforeach
                            @endif
                            </select>
                            </div>
                        </div>
                        <div class="col-md-10"> </div>
                        <div class="col-md-2">
                            <div class="text-center" style="margin-top:20px;margin-bottom:10px">
                                <button type="submit" id="searchBtn" class="btn btn-primary btn-block submitBtn" style="font-size:16px"><i class="fa fa-search fa-fw "></i> Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
<div class="m-portlet m-portlet--mobile">
@if(isset($employeeReports))
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button id="btnExport" onclick="fnExcelReport();" class="btn btn-primary btn-block float-end" style="font-size:16px"> EXPORT </button>
                </div>
            </div>
            <div class="row">
{{--
                <div class="col-md-12 mt-4" style="border-top:solid rgb(212, 211, 211) 1px;">
                    <h5 class="mt-4">Employee : </b>{{ $eData['employee_name'] }} </h5><br/>
                </div> --}}

                <div class="col-md-12" style="overflow-x: scroll;">

                    <table class="table table-striped- table-bordered table-hover table-checkable"  id="{{$breadcrumb[0]['name']}}">
                            @foreach ($employeeReports as $eData)
                            @php $colspn = count($dayArr)+1; @endphp
                            <tr><th colspan="{{ $colspn+3 }}"></th></tr>
                            <tr>
                                <th colspan="3" style="font-size: 18px;">Employee : {{ $eData['employee_name'] }}</th>
                                <th colspan="{{ $colspn }}"></th>
                            </tr>
                                {{-- <thead> --}}
                                    <tr>
                                        <th>{{ __('messages.id')}}</th>
                                        <th colspan="3">{{ __('messages.project')}}</th>
                                        @foreach($dayArr as $day)
                                        <?php
                                            $date = date('d/M',strtotime($day));
                                            $dayName =  date('D',strtotime($day));
                                            $class = "green";
                                            if($dayName == "Sat" || $dayName == "Sun"){
                                                $class = "red";
                                            }
                                            ?>
                                        <th class="{{ $class }}">{{ $date." (".$dayName.")"}}</th>
                                        @endforeach
                                    </tr>
                                {{-- </thead> --}}
                                <tbody>
                                    @php $totalHour = []; @endphp
                                    @if(count($eData['reportData']) > 0)
                                        @foreach ($eData['reportData'] as $key => $data)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td colspan="3"><a href="{{route("project.show", ['project' => $data['project_id']]) }}"> {{ $data['project_name'] }} </a></td>
                                                @php $a=0; @endphp
                                                @foreach ($data['data'] as $k => $dt)
                                                <?php
                                                $dayName =  date('D',strtotime($dt['log_date']));
                                                $class = "green";
                                                if($dayName == "Sat" || $dayName == "Sun"){
                                                $class = "red";
                                                }
                                                ?>
                                                    <td class="{{$class.' '.$dt['log_date']}}">{{ $dt['hour']>0?$dt['hour'].' H':'' }}</th>
                                                @php
                                                    $totalHour[$k] = ($totalHour[$k]??0) + (float)$dt['hour'];
                                                    // $totalHour[$k] = 0;
                                                    $a++; @endphp
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        @php $clspn = count($dayArr) + 2; @endphp
                                        <td class="text-center" colspan="{{ $clspn }}"> No Worklog reports found</td>
                                    </tr>
                                    @endif

                                </tbody>
                                @if(count($totalHour) > 0)
                                <tr>
                                    <th></th>
                                    <th colspan="3">Total: </th>
                                    @foreach ($data['data'] as $k => $dt)
                                    <?php
                                    $dayName =  date('D',strtotime($dt['log_date']));
                                    $class = "green";
                                    if($dayName == "Sat" || $dayName == "Sun"){
                                    $class = "red";
                                    }
                                    ?>
                                    <td class="{{$class.' '.$dt['log_date']}}">{{ $totalHour[$k]>0?$totalHour[$k].'H':''; }}</th>

                                    @endforeach
                                </tr>
                                @endif
                                @if(count($eData['reportData']) > 0)
                                    <tr class="heading">
                                        <th>{{ __('messages.id')}}</th>
                                        <th>{{ __('messages.project')}}</th>
                                        <th>Issue</th>
                                        <th>Comment</th>
                                        @foreach($dayArr as $day)
                                        <?php
                                            $date = date('d/M',strtotime($day));
                                            $dayName =  date('D',strtotime($day));
                                            $class = "green";
                                            if($dayName == "Sat" || $dayName == "Sun"){
                                                $class = "red";
                                            }
                                            ?>
                                        <th class="{{ $class }}">{{ $date." (".$dayName.")"}}</th>
                                        @endforeach
                                    </tr>

                                    <tbody>
                                        @php $totalHour = []; @endphp
                                        @foreach ($eData['reportData'] as $key => $data)
                                        {{-- @php dd($data['project_name']) @endphp --}}

                                            <tr>
                                                <td rowspan="{{ count($data['task']) }}">{{ $key+1 }}</td>
                                                <td rowspan="{{ count($data['task']) }}"><a href="{{route("project.show", ['project' => $data['project_id']]) }}"> {{ $data['project_name'] }} </a></td>

                                            @foreach ($data['task'] as $tkey => $tsk)
                                            @if (!$loop->first)
                                                </tr>
                                                </tr>
                                            @endif
                                            {{-- <tr> --}}
                                                <td>{{ $tsk['task_name']}}</td>
                                                <td>{!! $tsk['comment'] !!}</td>
                                                    @foreach ($tsk['days'] as $k => $dt)
                                                    <?php
                                                    $dayName =  date('D',strtotime($dt['log_date']));
                                                    $class = "green";
                                                    if($dayName == "Sat" || $dayName == "Sun"){
                                                    $class = "red";
                                                    }
                                                    ?>
                                                        <td class="{{$class.' '.$dt['log_date']}}">{{ $dt['hour']>0?$dt['hour'].' H':'' }}</th>

                                                    @endforeach
                                            {{-- </tr> --}}
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                @endif

                    @endforeach
                </table>
            </div>
        </div>
        </div>
    @endif
</div>
@endsection
@section('footer_scripts')
@include('reports.script')
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var worklogDatatble = $("#{{$breadcrumb[0]['name']}}").dataTable({
        scrollX: true,
    });
    $('#start_date').on('change', function() {
        $("#start_date_export").val($(this).val())
    });
    $('#end_date').on('change', function() {
        $("#end_date_export").val($(this).val())
    });
$(document).ready(function(){
    $("#employee_id").select2();
});
    $("#employee_id").select2();
    $( ".datetime" ).datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });

    $(".submitBtn").on("click",function() {
        if($(this).attr('id') == "searchBtn"){
            var url = "{{ url('reports/worklog_report') }}";
            $('#worklogReport').attr('action', url);
        }
        if($(this).attr('id') == "excelBtn"){
            var url = "{{ url('reports/worklog_report_excel') }}";
            $('#worklogReport').attr('action', url);
        }

    })


function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('{{$breadcrumb[0]['name']}}'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++)
    {
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    // tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);
}
</script>
@include('layouts.customdatatable');
@endsection
