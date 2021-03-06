@extends('admin.layouts.main')
@section('title', 'Gallery Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Price Service</h1>
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
				<form action="{{ route('pricing_group_store') }}" method="post">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" name="name" class="form-control input-lg" placeholder="Directory Name" value="{!! old('name') !!}">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<select class="form-control input-lg" name="category">
									<option value="">Select Category</option>
									<option value="Emailblast">Emailblast</option>
									<option value="Docobilling">Docobilling</option>
								</select>
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
