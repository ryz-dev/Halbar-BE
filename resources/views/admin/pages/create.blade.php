@extends('admin.layouts.main')
@section('title', 'Pages Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Page</h1>
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
			<form action="{{ route('pages_store') }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-9">
							<label>Title</label>
							<div class="form-group">
								<input type="text" name="title" class="form-control input-lg" placeholder="Page title" value="{!! old('title') !!}">
							</div>
							<div class="form-group">
								<textarea name="content" class="editor">{!! old('content') !!}</textarea>
							</div>
						</div>
						<div class="col-md-3">
							<label>Related Page</label>
							<div class="form-group">
								<select data-placeholder="Select page or post" name='related[]' class="chosen-select form-control input-lg" multiple>
								<option value=""></option>
									<optgroup label="Pages">
										@if ($pages->count())
											@foreach ($pages as $page)
												<option value="{{ $page->id }}">{{ $page->title}}</option>
											@endforeach												
										@endif
									<optgroup>												
								</select>								
							</div>
							<label>Category</label>
							<div class="form-group">
								<select class="form-control" name="category">
									<option value="0">Uncategorized</option>
									@foreach ($categories as $key => $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Featured image</label>
								<div class="form-group">
									<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('assets/admin/img/default.jpg') }}" style="width:100%; height:195px;">
									<input type="hidden" name="image" value="default.jpg" id="targetValue_-">
									@include('admin.images.modals')
								</div>
							</div>
						</div>
					</div>					
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-primary">Add new page</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
