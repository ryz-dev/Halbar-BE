@extends('admin.layouts.main')
@section('title', 'Posts')
@section('contents')
<a href="{{ route('posts_create') }}" class="new-btn" title="New post"><i class="glyphicon glyphicon-pencil"></i></a>
<div class="bg-light lter b-b wrapper-md">
	<h1 class="m-n font-thin h3">Post</h1>
	<small class="text-muted">With posts, users will feel closer to your business.</small>
</div>
<div class="wrapper-md">
	<div class="row">
		<div class="col-sm-8">
			<div class="blog-post">
				<div class="panel panel-post">
					<div class="action-post">
						<div class="btn-group" role="group" aria-label="...">
							<a href="{{ route('posts_edit', ['id' => $post->id]) }}" type="button" class="btn btn-default">Edit</a>
							<a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="{{ $post->id }}">Delete</a>
						</div>
					</div>
					<div>
						<img src="{{ asset('uploaded/media/'.$post->image) }}" width="100%">
					</div>
					<div class="wrapper-lg">
						<h2 class="m-t-none"><a href="{{ route('posts_detail', ['slug' => $post->slug ]) }}">{{ $post->title }}</a></h2>
						<hr>
						<?php echo $post->content ?>
						<div class="line line-lg b-b b-light"></div>
						<div class="text-muted">
							<i class="glyphicon glyphicon-user"></i> &nbsp;by <a href="#" class="m-r-sm">{{ $post->fullname }}</a>
							<i class="glyphicon glyphicon-time"></i> &nbsp;{{ Carbon\Carbon::parse($post->published)->format('d F Y') }}
							@if ($post->comment == 1 )
								<?php $counts = DB::table('comments')->select('id_posts')->where('id_posts', $post->id)->count(); ?>
								<a class="m-l-sm post-comment-toggle"><i class="glyphicon glyphicon-comment"></i> &nbsp;{{ $counts }} comments</a>
								<h4 class="m-t-lg m-b">{{ $counts }} Comments</h4>
								@foreach ($comment->where('id_posts', $post->id) as $c)
									<div>
										<div>
											<a class="pull-left thumb-sm">
												<img src="{{ asset('uploaded/users') }}/{{ $c->image }}" class="img-circle">
											</a>
											<div class="m-l-xxl m-b">
												<div>
													<a href><strong>{{ $c->fullname }}</strong></a>
													<span class="text-muted text-xs block m-t-xs">
														{{ Carbon\Carbon::parse($c->created_at)->diffForHumans() }}
													</span>
												</div>
												<div class="m-t-sm">{{ $c->comment }}</div>
											</div>
										</div>
										@foreach ($parents->where('id_parent', $c->id) as $parent)
											<div class="m-l-xxl">
												<a class="pull-left thumb-sm">
													<img src="{{ asset('uploaded/users/') }}/{{ $parent->image }}" class="img-circle">
												</a>
												<div class="m-l-xxl m-b">
													<div>
														<a href><strong>{{ $parent->fullname }}</strong></a>
														<span class="text-muted text-xs block m-t-xs">
															{{ Carbon\Carbon::parse($parent->created_at)->diffForHumans() }}
														</span>
													</div>
													<div class="m-t-sm">{{ $parent->comment }}</div>
												</div>
											</div>
										@endforeach
										<div class="m-l-xxl">
											<form action="{{ route('comment_store') }}" method="post">
												{{ csrf_field() }}
												<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
												<input type="hidden" name="id_parent" value="{{ $c->id }}">
												<input type="hidden" name="id_posts" value="{{ $post->id }}">

												<a class="pull-left thumb-sm">
													<img src="{{ asset('uploaded/users').'/thumb-'.Auth::user()->image }}" class="img-circle">
												</a>
												<div class="m-l-xxl m-b">
													<textarea class="form-control" name="comment" rows="3" placeholder="Type your comment"></textarea>
												</div>
												<div class="m-l-xxl m-b">
													<button type="submit" class="btn btn-default"><i class="fa fa-mail-reply"></i>&nbsp; Reply</button>
												</div>
											</form>
										</div>
									</div>
								@endforeach
								<h4 class="m-t-lg m-b">Leave a comment</h4>
								<form action="{{ route('comment_store') }}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
									<input type="hidden" name="id_parent" value="0">
									<input type="hidden" name="id_posts" value="{{ $post->id }}">
									<div class="form-group">
										<textarea class="form-control" rows="5" name="comment" placeholder="Type your comment"></textarea>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-default">Submit comment</button>
									</div>
								</form>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
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
@endsection
