@extends('admin.layouts.main')
@section('title', 'Pages')
@section('contents')
	<a href="{{ route('pages_create') }}" class="new-btn" title="New post"><i class="glyphicon glyphicon-pencil"></i></a>
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Pages</h1>
		<small class="text-muted">With posts, users will feel closer to your business.</small>
	</div>
	<div class="wrapper-md">
		<div class="row">
			<div class="col-sm-8">
				<div class="blog-post">
					<div class="panel panel-post">
						<div class="action-post">
							<div class="btn-group" role="group" aria-label="...">
								<a href="{{ route('pages_edit', ['id' => $pages->id]) }}" type="button" class="btn btn-default">Edit</a>
								<a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="{{ $pages->id }}">Delete</a>
							</div>
						</div>
						<div>
							<img src="{{ asset('uploaded/media/'.$pages->image) }}" width="100%">
						</div>
						<div class="wrapper-lg">
							<h2 class="m-t-none"><a href="{{ route('pages_detail', ['slug' => $pages->slug ]) }}">{{ $pages->title }}</a></h2>
							<div class="max-width-image">
								<hr>
								<?php echo $pages->content ?>
							</div>
							<div class="line line-lg b-b b-light"></div>
							<div class="text-muted">
								<i class="glyphicon glyphicon-user"></i> &nbsp;by <a href="page_profile.html" class="m-r-sm">{{ $pages->fullname }}</a>
								<i class="glyphicon glyphicon-time"></i> &nbsp;{{ Carbon\Carbon::parse($pages->create_at)->format('d F Y') }}
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
								<a href="{{ route('pages_detail', ['slug' => $r->slug ]) }}" class="font-semibold text-ellipsis">{{ $r->title }}</a>
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
			<form action="{{ route('pages_delete') }}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Post</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this post?
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
