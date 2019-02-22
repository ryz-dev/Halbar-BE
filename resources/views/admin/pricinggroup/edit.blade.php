@extends('admin.layouts.main')
@section('title', 'Price Service')
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
				<form action="{{ route('pricing_group_update',['id'=>$pricing->id]) }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">
					<input type="hidden" name="id" value="{{ $pricing->id }}">
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" name="name" class="form-control input-lg" value="{{ $pricing->name }}" placeholder="Album Name">
							</div>
						</div>
						<div class="col-md-3">
							<select class="form-control input-lg" name="category">
								<option value="">Select Category</option>
								@if ($pricing->category == 'Emailblast')
										<option value="Emailblast" checked>Emailblast</option>
										<option value="Docobilling">Docobilling</option>
									@else
										<option value="Emailblast">Emailblast</option>
										<option value="Docobilling" checked>Docobilling</option>
								@endif
							</select>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
