@extends('admin.layouts.main')
@section('title', 'Category')
@section('contents')
	<a href="{{ route('category_create') }}" class="new-btn" title="New Category"><i class="glyphicon glyphicon-pencil"></i></a>
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Posts Category</h1>
	</div>
	<div class="row">
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
			<div class="panel col-md-6">
				<div class="table-responsive">
					<table class="table table-striped m-b-none">
						<thead>
							<tr>
								<th colspan="2" width="100%;">Name</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($category as $c)
								<tr>
									<td>{{ $c->name }}</td>
									<td>
										<a href="{{ route('category_edit', [ 'id' => $c->id ]) }}" class="btn btn-default btn-xs">Edit</a>
										<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $c->id }}">Delete</button>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="2" align="center">No category</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>		
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('category_delete') }}" method="post">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete category</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this category?
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
