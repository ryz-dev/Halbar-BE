@extends('admin.layouts.main')
@section('title', 'Opd Edit')
@section('contents')
<div class="bg-light lter b-b wrapper-md">
	<h1 class="m-n font-thin h3">Edit Opd</h1>
</div>
<div class="wrapper-md">
	@if (count($errors) > 0)
	<div class="alert-top alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	<div class="panel">
		<form action="{{ route('opd_update', [ 'id' => $opd->id ]) }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
			<div class="panel-body">
				<div class="row">		
					<div class="col-md-9">
						<label>Title</label>
						<div class="form-group">
							<input type="text" name="title" class="form-control input-lg" placeholder="Page title" value="{{ $opd->title }}">
						</div>
						<label>Welcome Message</label>
							<div class="form-group">
								<textarea  name="welcome_message" class="form-control" rows=4 cols=100%>{{ $opd->welcome_message }}</textarea>
							</div>						
						<div class="form-group">
							<textarea name="content" class="editor">
								{{ $opd->content }}
							</textarea>
						</div>
						<label>Link</label>
						<div class="form-group">
							<input type="text" name="link" class="form-control" value="{{ $opd->link }}">
						</div>
					</div>
					<div class="col-md-3">
						<label>Category</label>
						<div class="form-group">
							<select class="form-control" name="category">
								<option value="0">Uncategorized</option>
								@foreach ($categories as $key => $value)
									@if ($opd->category == $value->id) 										
										<option selected value="{{$value->id}}">{{$value->name}}</option>
										@else
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<label>Team</label>
						<div class="form-group">
							<select class="form-control" name="team">
								@foreach ($team as $key => $value)
									@if ($opd->team_id == $value->id) 										
										<option selected value="{{$value->id}}">{{$value->name}}</option>
										@else
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<label>Featured image</label>
						<div class="form-group">
							<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/'.$opd->image) }}" style="width:100%; height:100%;">
							<input type="hidden" name="image" value="{{$opd->image}}" id="targetValue_-">
							@include('admin.images.modals')
						</div>
					</div>					
				</div>
			<hr>
			<div class="row">
				<div class="col-md-12 text-right">
					<button type="submit" class="btn btn-primary">Save changed</button>
				</div>
			</div>
		</div>
	</form>
</div>
</div>
@endsection
