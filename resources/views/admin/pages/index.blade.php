@extends('admin.layouts.main')
@section('title', 'Pages')
@section('contents')
	<a href="{{ route('pages_create') }}" class="new-btn" title="New Pages"><i class="glyphicon glyphicon-pencil"></i></a>
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Pages</h1>
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
		<form  action="{{route('pages')}}" method="get">
			<div class="form-group">
				<input type="type" class="form-control input-lg" name="key" placeholder="Pencarian">
			</div>
		</form>
		<div class="panel">
			<div class="table-responsive">
				<table class="table table-striped m-b-none">
					<thead>
						<tr>
							<th style="width: auto">Page Title</th>
							<th style="width: auto">Category</th>
							<th style="width: auto">Create</th>
							<th style="width:120px;"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($pages as $p)
							<tr>
								<td>
									<a href="{{ route('pages_detail', [ 'slug' => $p->slug ]) }}">{{ $p->title }}</a>
								</td>
								<td>{{ isset($p->Category[0]->name)==true?$p->Category[0]->name:'Uncategorized' }}</td>
								<td>{{ Carbon\Carbon::parse($p->create_at)->format('d F Y') }}</td>
								<td>
									<a href="{{ route('pages_edit', [ 'id' => $p->id ]) }}" class="btn btn-default btn-xs">Edit</a>
									<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $p->id }}">Delete</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" align="center">No pages, please create a new pages or <a href='{{route('pages')}}'>Back</a></td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<div class="text-center m-t-lg m-b-lg">
			<ul class="pagination pagination-md">
				{{ $pages->appends(request()->except('page'))->links() }}
			</ul>
		</div>
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('pages_delete') }}" method="post">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Page</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this page?
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