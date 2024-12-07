@extends('layouts.app')
@section('subheader',"Leave Applied")
@section('content')
<style>
	.hide {
		display: none;
	}

	.tab-content {
		padding: 25px;
	}

	#material-tabs {
		position: relative;
		display: block;
		padding: 0;
		border-bottom: 1px solid #e0e0e0;
	}

	#material-tabs>a {
		position: relative;
		display: inline-block;
		text-decoration: none;
		padding: 22px;
		text-transform: uppercase;
		font-size: 14px;
		font-weight: 600;
		color: #424f5a;
		text-align: center;
		outline: ;
	}

	#material-tabs>a.active {
		font-weight: 700;
		outline: none;
	}

	#material-tabs>a:not(.active):hover {
		background-color: inherit;
		color: #7c848a;
	}

	@media only screen and (max-width: 520px) {
		.nav-tabs#material-tabs>li>a {
			font-size: 11px;
		}
	}

	.yellow-bar {
		position: absolute;
		z-index: 10;
		bottom: 0;
		height: 3px;
		background: #458CFF;
		display: block;
		left: 0;
		transition: left .2s ease;
		-webkit-transition: left .2s ease;
	}

	#tab1-tab.active~span.yellow-bar {
		left: 0;
		width: 100px;
	}

	#tab2-tab.active~span.yellow-bar {
		left: 119px;
		width: 100px;
	}

	#tab3-tab.active~span.yellow-bar {
		left: 237px;
		width: 100px;
	}

	#tab4-tab.active~span.yellow-bar {
		left: 392px;
		width: 163px;
	}
</style>
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Leave Management
				</h3>
			</div>
		</div>
		{{--@if(Auth::user()->role == 'Super Admin')
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					@can('add user')
					<li class="m-portlet__nav-item">
						<a href="{{route('attendance.create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
		<span>
			<i class="la la-plus"></i>
			<span>{{ __('messages.addrecord')}}</span>
		</span>
		</a>
		</li>
		@endcan
		</ul>
	</div>
	@endif--}}
</div>
<div class="m-portlet__body">
	<div class="container">
		<header>
			<div id="material-tabs">
				<a id="tab1-tab" href="#tab1" class="active">PENDING</a>
				<a id="tab2-tab" href="#tab2">APPROVED</a>
				<a id="tab3-tab" href="#tab3">REJECTED</a>
				<span class="yellow-bar"></span>
			</div>
		</header>

		<div class="tab-content">
			<div id="tab1">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
                    <thead>
                        <tr class="heading">
                            <th>{{ __('messages.name')}}</th>
                            <th>From - To Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($leaveData)
                        @foreach ($leaveData as $data)
                        <tr>
                            <td>{{ $data->username }}</td>
                            <td>{{ date('d M, Y',strtotime($data->from_date)) }} - {{ date('d M, Y',strtotime($data->to_date)) }}</td>
                            <td>
                                @if($data->type==1)
                                Opt Holiday
                                @elseif($data->type==2)
                                Present
                                @elseif($data->type==3)
                                Leave
                                @else
                                Comp off
                                @endif
                            </td>
                            <td>{{ $data->description }}</td>
                            <td>
                            <a class="edit editclick" style="margin-bottom: 5px;" title="Approve" href="{{route('leave-management.change_status',['id'=>$data->id,'status'=>'approved'])}}"><i class="la la-check"></i></a>
                            <a class="edit editclick" style="margin-bottom: 5px;" title="Reject" href="{{route('leave-management.change_status',['id'=>$data->id,'status'=>'rejected'])}}"><i class="la la-close"></i></a>
                            </td>

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
			<div id="tab2">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
                    <thead>
                        <tr class="heading">
                            <th>{{ __('messages.name')}}</th>
                            <th>From - To Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($approveData)
                        @foreach ($approveData as $data)
                        <tr>
                            <td>{{ $data->username }}</td>
                            <td>{{ date('d M, Y',strtotime($data->from_date)) }} - {{ date('d M, Y',strtotime($data->to_date)) }}</td>
                            <td>
                                @if($data->type==1)
                                Opt Holiday
                                @elseif($data->type==2)
                                Present
                                @elseif($data->type==3)
                                Leave
                                @else
                                Comp off
                                @endif
                            </td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->status }}</td>
                            <td><a class="edit editclick" style="margin-bottom: 5px;" title="Undo" href="{{route('leave-management.change_status',['id'=>$data->id,'status'=>'pending'])}}"><i class="la la-undo"></i></a></td>
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
			<div id="tab3">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
                    <thead>
                        <tr class="heading">
                            <th>{{ __('messages.name')}}</th>
                            <th>From - To Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($rejectData)
                        @foreach ($rejectData as $data)
                        <tr>
                            <td>{{ $data->username }}</td>
                            <td>{{ date('d M, Y',strtotime($data->from_date)) }} - {{ date('d M, Y',strtotime($data->to_date)) }}</td>
                            <td>
                                @if($data->type==1)
                                Opt Holiday
                                @elseif($data->type==2)
                                Present
                                @elseif($data->type==3)
                                Leave
                                @else
                                Comp off
                                @endif
                            </td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->status }}</td>
                            <td><a class="edit editclick" style="margin-bottom: 5px;" title="Undo" href="{{route('leave-management.change_status',['id'=>$data->id,'status'=>'pending'])}}"><i class="la la-undo"></i></a></td>
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
	</div>
	<!--begin: Datatable -->

</div>
</div>


@endsection
@section('footer_scripts')
<script>
	$(document).ready(function() {
		$('#material-tabs').each(function() {

			var $active, $content, $links = $(this).find('a');

			$active = $($links[0]);
			$active.addClass('active');

			$content = $($active[0].hash);

			$links.not($active).each(function() {
				$(this.hash).hide();
			});

			$(this).on('click', 'a', function(e) {

				$active.removeClass('active');
				$content.hide();

				$active = $(this);
				$content = $(this.hash);

				$active.addClass('active');
				$content.show();

				e.preventDefault();
			});
		});
	});
</script>

@include('layouts.customdatatable');
@endsection
