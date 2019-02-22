@extends('admin.layouts.main')
@section('title', 'Pages Edit')
@section('contents')
<div class="bg-light lter b-b wrapper-md">
	<h1 class="m-n font-thin h3">Edit Page</h1>
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
		<form action="{{ route('pages_update', [ 'id' => $page->id ]) }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
			<div class="panel-body">
				<div class="row">		
					<div class="col-md-9">
						<label>Title</label>
						<div class="form-group">
							<input type="text" name="title" class="form-control input-lg" placeholder="Page title" value="{{ $page->title }}">
						</div>						
						<div class="form-group">
							<textarea name="content" class="editor">
								{{ $page->content }}
							</textarea>
						</div>
					</div>
					<div class="col-md-3">
						@php
							$related = json_decode($page->related);
						@endphp
						<label>Related Page</label>
						<div class="form-group">
							<select data-placeholder="Select page or post" name='related[]' class="chosen-select form-control input-lg" multiple>
							<option value=""></option>
								<optgroup label="Pages">
									@if ($pages->count())
										@foreach ($pages as $p)
											@if (isset($related) && in_array($p->id,$related))
												<option selected value="{{ $p->id }}">{{ $p->title}}</option>
											@else
												<option value="{{ $p->id }}">{{ $p->title}}</option>
											@endif												
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
									@if ($page->category == $value->id) 										
										<option selected value="{{$value->id}}">{{$value->name}}</option>
										@else
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<label>Featured image</label>
						<div class="form-group">
							<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media/'.$page->image) }}" style="width:100%; height:100%;">
							<input type="hidden" name="image" value="{{$page->image}}" id="targetValue_-">
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
