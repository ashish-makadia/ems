@extends('layouts.app')
@section('subheader',__('messages.employee').' '.__('messages.projectlisting'))
@section('content')
<style>

</style>
@foreach ($projectList as $project)
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{-- {{ __('messages.project')}} --}}
                    {{ ucfirst($project->project_name) }}
				</h3>
			</div>
		</div>
	</div>

	    <div class="m-portlet__body">
            {{-- @php $employee = json_decode($project->team_members) @endphp --}}
            <div class="row mt-2">
                {{-- @foreach ($employee as $emp)
                    @php $employeeData = \App\Models\Employee::find($emp);@endphp
                    @if(@@$employeeData && $employeeData->image)
                        @php $image = asset("storage/images")."/".$employeeData->image; @endphp
                    @else
                        @php $image = asset("admin-files/assets/images/default.png") @endphp
                    @endif
                    <div class="col-md-3">
                        <span><img style="width:50px;height:50px;" class="image-preview img-thumbnail rounded-circle" id="imgPreview" src="{{ $image }}" alt=""></span>
                        <span style="font-size: 13px; font-weight:600"> {{ ucfirst($employeeData->name) }} </span>
                    </div>
                @endforeach --}}
                @if($project->start_date !="" && $project->end_date !="")
                    <div class="col-md-12">
                        <p ><b>Project Date : </b>{{ date('d M, Y',strtotime($project->start_date)) }} <b>To</b> {{ date('d M, Y',strtotime($project->end_date)) }}

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
        </div>
</div>
@endforeach
@endsection

@section('footer_scripts')
@push('scripts')

@endpush
