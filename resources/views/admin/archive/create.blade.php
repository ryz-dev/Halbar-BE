@extends('admin.layouts.main')
@section('title', 'Directory Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Directory</h1>
		<small class="text-muted">With directory, users will feel closer to your business.</small>
	</div>
	<div class="wrapper-md">
		@if (count($errors) > 0)
			<div class="alert-top alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<div class="panel direktori">
			<div class="panel-body">
				<form action="{{ route('item_archive_store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="idgroup" value="{{Request::segment(5)}}">
					<div class="row">
						<div class="col-md-12">
						<div class="form-group">
								<input type="text" name="title" class="form-control input-lg" placeholder="Directory title" value="{!! old('title') !!}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>File Attachments</label>
								<input type="file" name="attachments" class="form-control">
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<div class="btn-group dropup">
									<button name="status" value="publish" class="btn btn-primary">Add new directory</button>
									<button type="button" style="border-left: 1px solid #5a4daa" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#modal-schedule">Schedule Directory</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					{{-- Open Modal --}}
					<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Publishing Schedule</h4>
								</div>
								<div class="modal-body">
									Select a date and time in the future for your submissions for publication.
									<div class="form-group">
										<label>Date</label>
										<input type="date" name="publish_date" value="{!! old('publish_date') !!}" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Set</button>
								</div>
							</div>
						</div>
					</div>
					{{-- End modals --}}
				</form>
			</div>
		</div>
	</div>
@endsection
