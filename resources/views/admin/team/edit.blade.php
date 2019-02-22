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
						<form action="{{ route('team_edit_update', ['id' => $team->id ]) }}" method="post" enctype="multipart/form-data">

							{{ csrf_field() }}
							<input type="hidden" name="_method" value="PUT">

							<div class="form-group">
								<label for="">Full Name</label>
								<input type="text" name="fullname" class="form-control" value="{{ $team->fullname }}" required>
							</div>

							<div class="form-group">
								<label for="">Username</label>
								<input type="text" name="username" class="form-control" value="{{ $team->username }}" required>
							</div>

							<div class="form-group">
								<label for="">Email</label>
								<input type="email" name="email" class="form-control" placeholder="ex: example@mail.com" value="{{ $team->email }}" required>
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
									@if ($team->status == 'Super Admin')
										@php
											$status = ['Super Admin'];
										@endphp
									@endif
									@for ($i=0; $i < count($status); $i++)
										<option value="{{ $status[$i] }}" {{ $status[$i] == $team->status ? 'selected' : '' }}>{{ $status[$i] }}</option>
									@endfor
								</select>
							</div>

							<div class="form-group">
								<label for="">Profil Image</label>
								@if ($team->image != '')
									<br>
									<img src="{{ asset('uploaded').'/users/thumb-'.$team->image }}" width="100%">
									<br>
									<br>
								@endif
								<input type="file" name="image" class="form-control" accept=".jpg, .jpeg, .png">
							</div>

							<div class="form-group">
								<label for="">Change Passsword</label>
								<input type="password" name="password" class="form-control">
							</div>

							<hr>

							<div class="row">
								<div class="col-md-12 text-right">
									<button type="submit" class="btn btn-primary">Save Change</button>
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
