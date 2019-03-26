@extends('admin.layouts.main')

@section('title', 'Event Create')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Event</h1>
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

		<div class="panel">
			<div class="panel-body">
				<form action="{{ route('event_store') }}" method="post" enctype="multipart/form-data">

					{{ csrf_field() }}

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="name" class="form-control input-lg" placeholder="Event Name" value="{!! old('title') !!}">
							</div>

							<div class="form-group">
								<textarea name="desc" class="editor">
									{!! old('desc') !!}
								</textarea>
							</div>

							<div class="form-group">
								<label>Keyword for SEO</label><br>
								<input ui-jq="tagsinput" ui-options="" name="keyword" class="form-control input-lg" value="{!! old('keyword') !!}" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Featured image</label>
								<div class="form-group">
									<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('assets/admin/img/default.jpg') }}" width="100%">
									<input type="hidden" name="image" value="default.jpg" id="targetValue_-">
									@include('admin.images.modals')
								</div>
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Date</label>
								<input type="date" name="date" class="form-control" placeholder="Date" required>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary">Add</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
