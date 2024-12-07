@extends('layouts.app')
@section('subheader',__('messages.projectlisting'))
@section('content')
<div class="m-portlet m-portlet--mobile">
    {{-- <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{ __('messages.project')}}
                </h3>
            </div>
        </div>
    </div> --}}
    <div class="m-portlet__body">
        <h4>{{ ucfirst($project->project_name) }}</h4> <hr/>
            @php $employee = json_decode($project->team_members) @endphp
            <div class="row mt-2">
                @foreach($employee as $emp)
                    @php $employeeData = \App\Models\Employee::find($emp);@endphp
                    @if($employeeData->image)
                @php $image = asset("images/employee/".$employeeData->image); @endphp

                @else
                @php $image = asset('admin-files\assets\image\default.png') @endphp

                @endif
                    <div class="col-md-3">
                        <span><img style="width:40px;height:40px;" class="image-preview img-thumbnail" id="imgPreview" src="{{ $image }}" alt=""></span>
                        <span style="font-size: 13px; font-weight:600"> {{ @@$employeeData->name?ucfirst($employeeData->name):''; }} </span>
                    </div>
                @endforeach
                @if($project->start_date !="" && $project->end_date !="")
                    <div class="col-md-12 mt-4">
                        <p style="margin-top:15px;"><b>Project Date : </b>{{ date('d M, Y',strtotime($project->start_date)) }} <b>To</b> {{ date('d M, Y',strtotime($project->end_date)) }}

                    </div>
                @endif
                @if($project->description !="")
                <div class="col-md-12 mt-4">
                    <h5>Description</h5><hr/>
                    <p>{!! $project->description !!}</p>
                </div>
            @endif
            </div>
            @if(count($project->projectattachment) > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Attachments</h5><hr/>
                    <table class="table" border="0">
                        <thead>
                            <tr class="heading">
                                <th>{{ __('messages.id')}}</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($project->projectattachment) > 0)
                            @foreach ($project->projectattachment as $key => $attch)
                            <tr id="tr_{{$attch->id}}">
                                <td>{{ $key+1 }}</td>
                                <td><a target="_blank" href="{{ asset("storage/projects/".$attch->files) }}">{{ $attch->files }}</a></td>
                                <td><a href="javascript:void(0)" onClick="deleteAjaxRecord({{ $attch->id }})"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center"> No Attchment Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @if(count($project->task) > 0)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5>Project Task</h5><hr/>
                        <table class="table table-striped- table-bordered table-hover table-checkable">
                            <thead>
                                <tr class="heading">
                                    <th>{{ __('messages.id')}}</th>
                                    <th>{{ __('messages.team_member')}}</th>
                                    <th>{{ __('messages.startdate')}}</th>
                                    <th>{{ __('messages.enddate')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($project->task) > 0)
                                @foreach ($project->task as $key => $task)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $task->team_members_name }}</td>
                                    @if($task->start_date !="" && $task->end_date !="")
                                    <td>{{ date('d M, Y',strtotime($task->start_date)) }}</td>
                                    <td>{{ date('d M, Y',strtotime($task->end_date)) }}</td>
                                    @endif
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" align="center"> No Task Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
@push('scripts')
<script>
function deleteAjaxRecord(id){
        var url = '{{ route("projectattachment.destroy", ':projectattachment') }}';
        url = url.replace(':projectattachment', id);
        swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
            }).then(function (e) {
                if(e.value)
                {
                    $.ajax({
                        type:'delete',
                        url:  url,
                        data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                        },
                        success:function(data)
                        {
                            if(data.status==1)
                            {
                                $("#tr_"+id).remove();
                                boostrapNotify(data.msg,'Well done','la la-check','success');
                            }
                            else
                            {
                                boostrapNotify(data.msg,'Oops','la la-times','danger');
                            }
                        },
                        error: function (xhr)
                        {
                            boostrapNotify(data.msg,'Oops','la la-times','danger');
                        },
                    });
                }else{
                    boostrapNotify(data.msg,'Oops','la la-times','danger');
                }

        })
}
</script>
@endpush
