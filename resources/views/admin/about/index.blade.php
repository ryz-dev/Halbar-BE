@extends('admin.layouts.main')

@section('title', 'About Page')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Your Team</h1>
	</div>
	<div class="wrapper-md">
		<div class="row">
			<div class="col-md-6">
				<div class="m-b m-t-lg">
				@foreach ($teams as $team)
				<div class="avatar thumb-xs m-r-xs" style="background: url({{ asset('uploaded') }}/media/thumb-{{ $team->image }}) center no-repeat; background-size: cover; width: 34px; height: 34px; vertical-align: middle"></div>
				@endforeach
				<a href="{{ route('about_employees') }}" class="btn btn-success btn-rounded font-bold"> + Add employees </a>
				</div>
			</div>
		</div>
	</div>
@endsection
