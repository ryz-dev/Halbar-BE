@extends('admin.layouts.main')

@section('title', 'Event')

@section('contents')
	<a href="{{ route('event_create') }}" class="new-btn" title="New Event"><i class="glyphicon glyphicon-pencil"></i></a>

	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Event</h1>
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
							<th style="width: 30%">Event Name</th>
							<th>Description</th>
							<th style="width: 10%">Date</th>
							<th style="width:120px;"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($event as $e)
							<tr>
								<td>{{ $e->name }}</td>
								<td>{{ strip_tags(str_limit($e->desc, 200)) }}</td>
								<td>{{ $e->date }}</td>
								<td>
									<a href="{{ route('event_edit', [ 'id' => $e->id ]) }}" class="btn btn-default btn-xs">Edit</a>
									<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete" data-id="{{ $e->id }}">Delete</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" align="center">No Event</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<div class="text-center m-t-lg m-b-lg">
			<ul class="pagination pagination-md">
				{{ $event->render() }}
			</ul>
		</div>
	</div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('event_delete') }}" method="post">

				{{ csrf_field() }}

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Event</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this event?
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
