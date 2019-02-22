@extends('admin.layouts.main')
@section('title', 'Posts Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Post</h1>
		<small class="text-muted">With posts, users will feel closer to your business.</small>
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
				<form id='formPost' action="{{ route('posts_store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" name="title" class="form-control input-lg" placeholder="Post title" value="{!! old('title') !!}">
							</div>
							<div class="form-group">
								<textarea name="content" class="editor">
									{!! old('content') !!}
								</textarea>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Featured image</label>
								<div class="form-group">
									<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/default.jpg') }}" style="width:100%; height:195px;">
									<input type="hidden" name="image" value="default.jpg" id="targetValue_-">
									@include('admin.images.modals')
								</div>
							</div>
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" name="category">
									<option value="0">Uncategorized</option>
									@foreach ($categories as $key => $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="">Comment</label>
								<select class="form-control" name="comment">
									<option value="1">Allow comment for this post</option>
									<option value="0">Dont allow</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<button name="status" value="draft" class="btn btn-default">Save to draft</button>
							<div class="btn-group dropup">
								<button name="status" value="publish" class="btn btn-primary">Publish this post</button>
								<button type="button" style="border-left: 1px solid #5a4daa" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu pull-right">
									<li><a href="#" data-toggle="modal" data-target="#modal-schedule">Schedule Post</a></li>
								</ul>
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

									<div class="form-group">
										<label>Time</label>
										<input type="time" name="publish_time" value="{!! old('publish_time') !!}" class="form-control">
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