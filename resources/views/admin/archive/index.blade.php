@extends('admin.layouts.main')
@section('title', 'Directory')
@section('contents')
	<a href="{{ route('item_archive_create',['id'=>Request::segment(4)]) }}" class="new-btn" title="New Directory"><i class="glyphicon glyphicon-pencil"></i></a>
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Directory</h1>
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
		<form  action="{{route('item_archive',['id'=>Request::segment(4)])}}" method="get">
			<div class="form-group">
				<input type="type" class="form-control input-lg" name="key" placeholder="Pencarian">
			</div>
		</form>
		<div class="panel">
			<div class="table-responsive">
				<table class="table table-striped m-b-none">
					<thead>
						<tr>
							<th style="width: auto">Title</th>
							<th style="width: auto">Link</th>
							<th style="width: auto">Directory Created</th>
							<th style="width: auto">Last Update</th>
							<th style="width: auto;"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($archive as $r)
							<tr>
								<td>{{ $r->title }}</td>
								<td><a href="{{ asset('uploaded/download/'.$r->file)}}" target="_blank">{{ asset('uploaded/download/'.$r->file)}}</a></td>
								<td>{{ GlobalClass::time($r->created_at) }}</td>
								<td>{{ GlobalClass::time($r->updated_at) }}</td>
								<td>
									<a href="{{ route('item_archive_edit', ['id' => $r->id]) }}" class="btn btn-default btn-xs">Edit</a>
									<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $r->id }}">Delete</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" align="center">No Directory <a href='{{route('item_archive',['id'=>Request::segment(4)])}}'>Back</a> </td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<div class="text-center m-t-lg m-b-lg">
			<ul class="pagination pagination-md">
				{{ $archive->appends(request()->except('page'))->links() }}
			</ul>
		</div>
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('item_archive_delete') }}" method="post">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Directory</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this directory?
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
