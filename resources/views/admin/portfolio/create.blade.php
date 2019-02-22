@extends('admin.layouts.main')

@section('title', 'Portfolio Create')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Portfolio</h1>
		<small class="text-muted">With portfolio, users will feel closer to your business.</small>
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
				<form action="{{ route('portfolio_store') }}" method="post" enctype="multipart/form-data">

					{{ csrf_field() }}

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="title" class="form-control input-lg" placeholder="Portfolio title" value="{!! old('title') !!}">
							</div>

							<div class="form-group">
								<input type="text" name="shortdesc" class="form-control input-lg" placeholder="Short description" value="{!! old('shortdesc') !!}">
							</div>

							<div class="form-group">
								<textarea name="content" class="editor">
									{!! old('content') !!}
								</textarea>
							</div>

							<div class="form-group">
								<label>Tag</label><br>
								<input ui-jq="tagsinput" ui-options="" name="tag" class="form-control input-lg" value="{!! old('tag') !!}" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Featured image</label>
								<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/default.jpg') }}" width="100%">
								<input type="hidden" name="image" value="default.jpg" id="targetValue_-">
								@include('admin.images.modals')
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Link</label>
								<input type="text" name="link" class="form-control" placeholder="Link Portfolio" value="{!! old('portfolio') !!}">
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Category</label>
								<input type="text" name="category" class="form-control" list="category" placeholder="Group your works with category" value="{!! old('category') !!}" autocomplete="off">
								<datalist id="category" class="datalist">
									@foreach ($categories as $category)
										<option value="{{ $category->category }}">
									@endforeach
								</datalist>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary">Add new portfolio</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Publishing Schedule</h4>
					</div>
					<div class="modal-body">
						Select a date and time in the future for your submissions for publication.

						<div class="form-group">
							<label>Date</label>
							<input type="date" name="publish-date" class="form-control">
						</div>

						<div class="form-group">
							<label>Time</label>
							<input type="time" name="publish-time" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Schedule</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
