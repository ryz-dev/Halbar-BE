@extends('admin.layouts.main')

@section('title', 'Team')

@section('contents')
	<a href="{{ route('team_add') }}" class="new-btn" title="New post"><i class="icon-user-follow"></i></a>

	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Team</h1>
	</div>
	<div class="wrapper-md">
		@if ( Session::has('success') )
			<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				{{ session('success') }}
			</div>
		@endif

		<div class="panel">
			<div class="table-responsive">
				<table class="table table-striped m-b-none">
					<thead>
						<tr>
							<th>Name</th>
							<th>Username</th>
							<th>Status</th>
							<th>Email</th>
							<th style="width:120px;"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($team as $t)
							@if ($t->status != 'Guest')
								<tr>
									<td>{{ $t->fullname }}</td>
									<td>{{ $t->username }}</td>
									<td>
										<div class="label bg-{{ $t->status == 'Super Admin' || $t->status == 'Admin' ? 'primary' : 'light' }}">{{ $t->status }}</div>
									</td>
									<td><a href="mailto:{{ $t->email }}">{{ $t->email }}</a></td>
									<td>
										@if ($t->status != 'Super Admin')
											@if ($t->status == 'Admin')
												@if (Auth::user()->status == 'Super Admin')
													<a href="{{ route('team_edit', ['id' => $t->id ]) }}" class="btn btn-default btn-xs">Edit</a>
													<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $t->id }}">Delete</button>
												@endif
												@else
													<a href="{{ route('team_edit', ['id' => $t->id ]) }}" class="btn btn-default btn-xs">Edit</a>
													<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $t->id }}">Delete</button>
											@endif

										@endif
									</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('team_delete') }}" method="post">

				{{ csrf_field() }}

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete User</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this user?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
