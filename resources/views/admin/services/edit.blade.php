@extends('admin.layouts.main')

@section('title', 'Services Edit')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Edit Services</h1>
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
				<form action="{{ route('services_update', [ 'id' => $services->id ]) }}" method="post" enctype="multipart/form-data">

					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="name" class="form-control input-lg" placeholder="Services title" value="{{ $services->name }}">
							</div>

							<div class="form-group">
								<textarea name="desc" id="editor" class="editor">
									{{ $services->desc }}
								</textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Featured image</label>
								<div class="form-group">
									<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/'.$services->image) }}" width="100%">
									<input type="hidden" name="image" value="{{$services->image}}" id="targetValue_-">
									@include('admin.images.modals')
								</div>
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Link</label>
								<input type="text" name="link" value="{{ $services->link }}" class="form-control">
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary">Save change</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
