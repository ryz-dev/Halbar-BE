@extends('admin.layouts.main')
@section('title', 'Gallery Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Album</h1>
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
				<form action="{{ route('media_store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="name" class="form-control input-lg" placeholder="Album Name" value="{!! old('name') !!}">
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea name="desc" class="editor"></textarea>
							</div>
							<div class="form-group">
								<label>Category</label>
								<input type="text" name="category" class="form-control input-lg" placeholder="Album Category" value="{!! old('category') !!}">
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
