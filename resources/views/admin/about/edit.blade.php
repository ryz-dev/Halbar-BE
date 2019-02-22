@extends('admin.layouts.main')
@section('title', 'Employees')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Your Team</h1>
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
		@if (Session::has('message'))
			<div class="alert-top alert alert-success">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				{{ Session::get('message') }}
			</div>
		@endif
		<div class="row">
			<div class="panel">
				<div class="panel-body">
					<form action="{{ route('about_employees_update') }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="id" value="{{$employee->id}}">
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="name" value="{{$employee->name}}" class="form-control" placeholder="Full name" required>
								</div>
								<div class="form-group">
									<label>Biografi</label>
									<textarea name="biografi" class="form-control" cols="30" rows="9">{{ $employee->biografi }}</textarea>
								</div>									
							</div>
							<div class="col-md-3">								
								<div class="form-group">
									<label>Position</label>
									<input type="text" name="position" value="{{$employee->position}}" class="form-control" placeholder="Position" required>
								</div>
								<div class="form-group">
									<label>Phone</label>
									<input type="text" name="phone" value="{{$employee->phone}}" class="form-control" placeholder="Phone" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" value="{{$employee->email}}" class="form-control" placeholder="Email Address" required>
								</div>
								<div class="form-group">
									<label>Featured image</label>
									<div class="form-group">
										<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/'.$employee->image) }}" style="width:100%; height:100%;">
										<input type="hidden" name="image" value="{{$employee->image}}" id="targetValue_-">
										@include('admin.images.modals')
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
