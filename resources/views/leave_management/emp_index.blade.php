@extends('layouts.app')
@section('subheader',"Leave Applied")
@section('content')

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

		<table class="table table-striped- table-bordered table-hover table-checkable" id="{{$breadcrumb[0]['name']}}">
			<thead>
				<tr class="heading">
					<th>{{ __('messages.name')}}</th>
					<th>From - To Date</th>
					<th>Type</th>
					<th>Description</th>
					<th>Status</th>
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
					<td>{{ $data->status }}</td>

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