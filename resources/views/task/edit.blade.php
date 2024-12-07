@extends('layouts.app')
@section('subheader',__('messages.tasklisting'))
@section('content')
<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{ __('messages.task')}}
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
        <form id="mtaskForm" action="{{ route("task.update", ['task' => $task->id]) }}" method="POST" class="userForm" enctype="multipart/form-data">
            @include('task.form')
            @method('patch')
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="margin-top:30px;margin-bottom:10px">
                        <button type="submit" class="btn btn-primary btn-block" style="font-size:16px"><i class="fa fa-check fa-fw fa-lg"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>
@endsection

@section('footer_scripts')
@push('scripts')
    @include('task.script')
@endpush
