@extends('admin.layouts.main')

@section('title', 'Profile')

@section('contents')
	<div class="hbox hbox-auto-xs hbox-auto-sm">
		<div class="col">
			<div>
				<div class="wrapper-lg bg-white-opacity">
					<div class="row m-t">
						<div class="col-sm-7">
							<div href class="thumb-lg pull-left m-r" style="background: url({{ asset('uploaded').'/users/thumb-'.$team->image }}) center no-repeat; background-size: cover; width: 96px; height: 96px; border-radius: 50%"></div>
							<div class="clear m-b">
								<div class="m-b m-t-sm">
									<span class="h3 text-black">{{ $team->fullname }}</span>
									<small class="m-l">{{ $team->email }}</small>
								</div>
								<a href class="btn btn-sm btn-success btn-rounded">{{ $team->status }}</a>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="pull-right pull-none-xs text-center">
								<a href class="m-b-md inline m">
									<span class="h3 block font-bold">{{ $posts }}</span>
									<small>Posts created</small>
								</a>
								<a href class="m-b-md inline m">
									<span class="h3 block font-bold">{{ $pages }}</span>
									<small>Pages created</small>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
