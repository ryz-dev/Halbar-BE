@extends('admin.layouts.main')
@section('title', 'Opd')
@section('contents')
	<a href="{{ route('opd_create') }}" class="new-btn" title="New Opd"><i class="glyphicon glyphicon-pencil"></i></a>
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Opd</h1>
	</div>
	<div class="wrapper-md">
		<div class="row">
			<div class="col-sm-8">
				<div class="blog-post">
					<div class="panel panel-post">
						<div class="action-post">
							<div class="btn-group" role="group" aria-label="...">
								<a href="{{ route('opd_edit', ['id' => $opd->id]) }}" type="button" class="btn btn-default">Edit</a>
								<a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="{{ $opd->id }}">Delete</a>
							</div>
						</div>
						<div>
							<img src="{{ asset('uploaded/media/'.$opd->image) }}" width="100%">
						</div>
						<div class="wrapper-lg">
							<h2 class="m-t-none"><a href="{{ route('opd_detail', ['slug' => $opd->slug ]) }}">{{ $opd->title }}</a></h2>
							<div class="max-width-image">
								<hr>
								{{ $opd->welcome_message }}
								<hr>
								<?php echo $opd->content ?>
								
								@if($opd->link)
									<a class="btn btn-success" href="{{ $opd->link }}">Lihat Profil Resmi</a>
								@endif

							</div>
							<div class="line line-lg b-b b-light"></div>
							<div class="text-muted">
								<i class="glyphicon glyphicon-user"></i> &nbsp;by <a href="page_profile.html" class="m-r-sm">{{ $opd->fullname }}</a>
								<i class="glyphicon glyphicon-time"></i> &nbsp;{{ Carbon\Carbon::parse($opd->create_at)->format('d F Y') }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<h5 class="font-bold">Recent Pages</h5>
				<div>
					@foreach ($recent->slice(0,5) as $r)
						<div>
							<a class="pull-left thumb thumb-wrapper m-r">
								<div class="img-recent" style="background-image:url('{{ asset('uploaded/media/'.$r->image) }}')">
								</div>
							</a>
							<div class="clear">
								<a href="{{ route('opd_detail', ['slug' => $r->slug ]) }}" class="font-semibold text-ellipsis">{{ $r->title }}</a>
								<div class="text-xs block m-t-xs">{{ Carbon\Carbon::parse($r->created_at)->diffForHumans() }}</div>
							</div>
						</div>
						<div class="line"></div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('opd_delete') }}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Opd</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this opd?
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
