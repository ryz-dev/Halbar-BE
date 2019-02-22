@extends('admin.layouts.main')

@section('title', 'Portfolio')

@section('contents')
	<a href="{{ route('portfolio_create') }}" class="new-btn" title="New Portfolio"><i class="glyphicon glyphicon-pencil"></i></a>

	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Portfolio</h1>
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
							<th style="width: 40%">Portfolio Title</th>
							<th colspan="2">View</th>
							<th>Page Created</th>
							<th>Last Update</th>
							<th style="width:120px;"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($portfolio as $p)
							<?php $views = DB::table('visitors')->select('url')->where('url', $_SERVER['HTTP_HOST'].'/'.'portfolio/'.$p->id)->count(); ?>
							<tr>
								<td>
									<a href="{{ $p->link }}">{{ $p->title }}</a>
								</td>
								<td style="width: 100px">
									<div class="progress progress-xs m-t-xs m-b-none">
										<div class="progress-bar bg-info" data-toggle="tooltip" style="width: {{ $views }}%"></div>
									</div>
								</td>
								<td>{{ $views }} Views</td>
								<td>{{ $p->created_at }}</td>
								<td>{{ $p->updated_at }}</td>
								<td>
									<a href="{{ route('portfolio_edit', [ 'id' => $p->id ]) }}" class="btn btn-default btn-xs">Edit</a>
									<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $p->id }}">Delete</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" align="center">No Portfolio, please create a new portfolio</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<div class="text-center m-t-lg m-b-lg">
			<ul class="pagination pagination-md">
				{{ $portfolio->render() }}
			</ul>
		</div>
	</div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('portfolio_delete') }}" method="post">

				{{ csrf_field() }}

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Page</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this portfolio?
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
