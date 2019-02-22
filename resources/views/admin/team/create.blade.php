@extends('admin.layouts.main')

@section('title', 'Setting Tambah Data')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Team</h1>
	</div>
	<div class="wrapper-md">
		<div class="row">
			<div class="col-md-4">
				<div class="panel">
					<div class="panel-body">
						<form action="{{ route('team_add_store') }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="">Full Name</label>
								</label>
								<input type="text" name="fullname" class="form-control" value="{!! old('fullname') !!}" min="5" required>
							</div>

							<div class="form-group">
								<label for="">Username</label>
								</label>
								<input type="text" name="username" class="form-control" value="{!! old('username') !!}" required>
							</div>

							<div class="form-group">
								<label for="">Email</label>
								</label>
								<input type="email" name="email" class="form-control" placeholder="ex: example@mail.com" value="{!! old('email') !!}" required>
							</div>

							<div class="form-group">
								<label for="">Status</label>
								<select class="form-control" name="status">
									@php
										if (Auth::user()->status == 'Super Admin') {
											$status = ['Admin', 'Writer', 'Customer Service'];
										} elseif(Auth::user()->status == 'Admin') {
											$status = ['Writer', 'Customer Service'];
										}
									@endphp
									@for ($i=0; $i < count($status); $i++)
										<option value="{{ $status[$i] }}" {{ $status[$i] == old('status') ? 'selected' : '' }}>{{ $status[$i] }}</option>
									@endfor
								</select>
							</div>

							<div class="form-group">
								<label for="">Profil Image</label>
								</label>
								<input type="file" name="image" class="form-control" accept=".jpg, .jpeg, .png" required>
							</div>

							<div class="form-group">
								<label for="">Passsword</label>
								</label>
								<input type="password" name="password" class="form-control" min="5" required>
							</div>

							<hr>

							<div class="row">
								<div class="col-md-12 text-right">
									<button type="submit" class="btn btn-primary">Add</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-4">
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
			</div>
		</div>
	</div>
@endsection
