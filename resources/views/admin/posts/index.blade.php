@extends('admin.layouts.main')
@section('title', 'Posts')
@section('contents')
	<a href="{{ route('posts_create') }}" class="new-btn" title="New Posts"><i class="glyphicon glyphicon-pencil"></i></a>
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Post</h1>
		<small class="text-muted">With posts, users will feel closer to your business.</small>
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
		<div class="row">
			<div class="col-sm-8">
				@if (count($posts) > 0)
				<div class="blog-post">
					@foreach ($posts as $p)
						@if ($p->deleted_at == NULL)
							<div class="panel panel-post">
								<div class="action-post">
									<div class="btn-group" role="group" aria-label="...">
										<a href="{{ route('posts_edit', ['id' => $p->id]) }}" type="button" class="btn btn-default">Edit</a>
										<a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="{{ $p->id }}">Delete</a>
									</div>
								</div>
								<div>
									<img src="{{ asset('uploaded/media/'.$p->image) }}" width="100%">
								</div>
								<div class="wrapper-lg">
									<h2 class="m-t-none"><a href="{{ route('posts_detail', ['slug' => $p->slug ]) }}">{{ $p->title }}</a></h2>
									<div>
										<p>{{ readMore(['text' => $p->content, 'limit' => 150]) }}</p>
									</div>
									<a href="{{ route('posts_detail', ['slug' => $p->slug ]) }}">Read More...</a>
									<div class="line line-lg b-b b-light"></div>
									<div class="text-muted">
										<i class="glyphicon glyphicon-user"></i> &nbsp;by <a href="#" class="m-r-sm">{{ $p->fullname }}</a>
										<i class="glyphicon glyphicon-time"></i> &nbsp;{{ Carbon\Carbon::parse($p->published)->format('d F Y') }}
									</div>
								</div>
							</div>
						@endif
					@endforeach
				</div>
				<div class="text-center m-t-lg m-b-lg">
					<ul class="pagination pagination-md">
						{{ $posts->appends(request()->except('page'))->links() }}
					</ul>
				</div>
				@else
					<div class="col-sm-12 text-center">
						<br><br>
						<h2>You don't have a post yet, <a style="text-decoration:underline;" href='{{route('posts')}}'>Back !</a></h2>
						<br><br>
					</div>
				@endif
			</div>
			<div class="col-sm-4">
				<form  action="{{route('posts')}}" method="get">
					<div class="form-group">
						<input type="type" class="form-control input-lg" name="key" placeholder="Pencarian">
					</div>
				</form>
				@if ($drafts->count() > 0)
					<h5 class="font-bold">You have {{ $drafts->count() }}</span> draft</h5>
					<ul class="list-group">
						@foreach ($drafts as $draft)
							<li class="list-group-item">
								<a href="{{ route('posts_edit', ['id' => $draft->id ]) }}">
									{{ $draft->title }}
								</a>
							</li>
						@endforeach
					</ul>
				@endif
				<h5 class="font-bold">Categories</h5>
				<ul class="list-group">
					@forelse ($categories as $valuePosts)
						@foreach ($category as $valueCategory)

							@if ($valuePosts->category == $valueCategory->id)
								<li class="list-group-item">
									<a href="{{ route('posts_view_category', ['category' => $valueCategory->id ]) }}">
										<span class="badge bg-default pull-right">{{ $valuePosts->count }}</span>
										{{ $valueCategory->name }}
									</a>
								</li>
							@endif

						@endforeach
					@empty
						<small>No category found</small>
					@endforelse
				</ul>
				<h5 class="font-bold">Recent Posts</h5>
				<div>
					@forelse ($recent_posts as $rp)
						<div>
							<a class="pull-left thumb thumb-wrapper m-r">
								<div class="img-recent" style="background-image:url('{{ asset('uploaded/media/'.$rp->image) }}')"></div>
							</a>
							<div class="clear">
								<a href="{{ route('posts_detail', ['slug' => $rp->slug ]) }}" class="font-semibold text-ellipsis">{{ $rp->title }}</a>
								<div class="text-xs block m-t-xs">{{ Carbon\Carbon::parse($rp->published)->diffForHumans() }}</div>
							</div>
						</div>
						<div class="line"></div>
					@empty
						<small>No recent posts found</small>
					@endforelse
				</div>
			</div>
		</div>
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('posts_delete') }}" method="post">
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
	{{-- <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('posts_delete') }}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Post</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this posts?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</div>
			</form>
		</div>
	</div> --}}
@endsection
