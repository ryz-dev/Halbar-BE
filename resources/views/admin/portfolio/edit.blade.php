@extends('admin.layouts.main')

@section('title', 'Portfolio Edit')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Edit Portfolio</h1>
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
			<div class="panel-body">
				<form action="{{ route('portfolio_update', [ 'id' => $portfolio->id ]) }}" method="post" enctype="multipart/form-data">

					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="title" class="form-control input-lg" placeholder="Portfolio title" value="{{ $portfolio->title }}">
							</div>

							<div class="form-group">
								<input type="text" name="shortdesc" class="form-control input-lg" placeholder="Short description" value="{{ $portfolio->shortdesc }}">
							</div>

							<div class="form-group">
								<textarea name="content" class="editor">
									{{ $portfolio->content }}
								</textarea>
							</div>

							<div class="form-group">
								<label>Tag</label><br>
								<input ui-jq="tagsinput" ui-options="" name="tag" class="form-control input-lg" value="{{ $portfolio->tag }}" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Featured image</label>
								<img id="previewImage_-" data-toggle="modal" data-target="#modal-galleries" src="{{ asset('uploaded/media'.$portfolio->image) }}" width="100%">
								<input type="hidden" name="image" value="{{$portfolio->image}}" id="targetValue_-">
								@include('admin.images.modals')
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Link</label>
								<input type="text" name="link" class="form-control" placeholder="Link Portfolio" value="{{ $portfolio->link }}">
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Category</label>
								<input type="text" name="category" class="form-control" list="category" placeholder="Group your works with category" value="{{ $portfolio->category }}" autocomplete="off">
								<datalist id="category" class="datalist">
									@foreach ($categories as $category)
										<option value="{{ $category->category }}">
									@endforeach
								</datalist>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary">Save change</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
