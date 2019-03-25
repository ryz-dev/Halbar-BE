@extends('admin.layouts.main')
@section('title', 'Opd Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Opd</h1>
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
			<form action="{{ route('opd_store') }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-9">
							<label>Title</label>
							<div class="form-group">
								<input type="text" name="title" class="form-control input-lg" placeholder="Opd title" value="{!! old('title') !!}">
							</div>
							<label>Welcome Message</label>
							<div class="form-group">
								<textarea  name="welcome_message" class="form-control" rows=4 cols=100%>{!! old('welcome_message') !!}</textarea>
							</div>
							<label>Content</label>
							<div class="form-group">
								<textarea name="content" class="editor">{!! old('content') !!}</textarea>
							</div>
							<label>Link</label>
							<div class="form-group">
								<input type="text" name="link" class="form-control">{!! old('link') !!}</textarea>
							</div>
						</div>
						<div class="col-md-3">
							<label>Category</label>
							<div class="form-group">
								<select class="form-control" name="category">
									<option value="0">Uncategorized</option>
									@foreach ($categories as $key => $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endforeach
								</select>
							</div>
							<label>Team</label>
							<div class="form-group">
								<select class="form-control" name="team">
									@foreach ($team as $key => $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Featured image</label>
								<div class="form-group">
									<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/default.jpg') }}" style="width:100%; height:195px;">
									<input type="hidden" name="image" value="default.jpg" id="targetValue_-">
									@include('admin.images.modals')
								</div>
							</div>
						</div>
					</div>					
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-primary">Add new page</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
