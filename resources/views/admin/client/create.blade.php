@extends('admin.layouts.main')
@section('title', 'Client Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Client</h1>
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
				<form action="{{ route('client_store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" name="name" class="form-control input-lg" placeholder="Title" value="{!! old('name') !!}">
							</div>
							<div class="form-group">
								<textarea name="message" class="editor">
									{!! old('message') !!}
								</textarea>
							</div>
						</div>
						<div class="col-md-3">
							<label>Featured image</label>
							<div class="form-group">
								<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/default.jpg') }}" style="width:100%; height:195px;">
								<input type="hidden" name="image" value="default.jpg" id="targetValue_-">
								@include('admin.images.modals')
							</div>
							<label>Logo image</label>
							<div class="form-group">
								<input type="file" name="logo" class="form-control" accept=".jpg, .jpeg, .png">
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
