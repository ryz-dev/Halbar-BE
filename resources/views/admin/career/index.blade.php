@extends('admin.layouts.main')

@section('title', 'Career')

@section('contents')
	<a href="{{ route('career_create') }}" class="new-btn" title="New Job"><i class="glyphicon glyphicon-pencil"></i></a>

	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Career</h1>
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
							<th style="width: 30%">Job Title</th>
							<th>Description</th>
							<th style="width:120px;"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($career as $e)
							<tr>
								<td>{{ $e->name }}</td>
								<td>{{ strip_tags(str_limit($e->desc, 50)) }}</td>
								<td>
									<a href="{{ route('career_edit', [ 'id' => $e->id ]) }}" class="btn btn-default btn-xs">Edit</a>
									<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $e->id }}">Delete</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" align="center">No Job Available</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<div class="text-center m-t-lg m-b-lg">
			<ul class="pagination pagination-md">
				{{ $career->render() }}
			</ul>
		</div>
	</div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('career_delete') }}" method="post">

				{{ csrf_field() }}

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Job</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this career?
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
