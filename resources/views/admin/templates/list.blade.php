@extends('admin.layouts.main')
@section('title', 'Templates Setup')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Theme</h1>
	</div>
	<div class="wrapper-md">
		@if (Session::has('message'))
			<div class="alert-top alert alert-success">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				{{ Session::get('message') }}
			</div>
		@endif
		<div class="row">
			@forelse ($template as $res)
				<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<a href="{{route('screenshot',[$res['path'], $res['screenshot']])}}" data-fancybox="gallery">
							<img src="{{route('screenshot',[$res['path'], $res['screenshot']])}}" alt="{{ucwords($res['template'])}}">
						</a>
						<div class="caption">
							<h4>{{ucwords($res['template'])}}</h4>
							<small>Author {{$res['author']}}</small>
							@if (isset($theme->path))
								@if ($theme->path == $res['path'])
									<i class="fa fa-check"></i>
								@endif
							@endif
							<p>{!!$res['description']!!}</p>
							@if (isset($theme->path))
								@if ($theme->path !== $res['path'])
									<p>
										<a href="{{route('templates_set',['path'=>$res['path']])}}" class="btn btn-primary">Install</a>
									</p>
								@endif
								@else
									<p>
										<a href="{{route('templates_set',['path'=>$res['path']])}}" class="btn btn-primary">Install</a>
									</p>
							@endif
					</div>
				</div>
			</div>
		@empty
			<h4 class="text-center">No Images Found.</h4>
		@endforelse
		</div>
	</div>
@endsection
