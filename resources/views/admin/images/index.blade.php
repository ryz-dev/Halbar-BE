@extends('admin.layouts.main')
@section('title', 'Gallery')
@section('contents')
<a data-toggle="modal" data-target="#modal-upload" class="new-btn" title="Add Image"><i class="icon-cloud-upload"></i></a>
<div class="wrapper-md">
	@if (Request::segment(4) == '')
	<div class="panel panel-tab">
		<div class="row">
			<div class="col-md-8 tab">
				<ul class="list-inline">
					<li class="btnFilter active" id="all"><a href="#">All</a></li>
					<li class="btnFilter" id='image'><a href="#">Images</a></li>
					<li class="btnFilter" id='document'><a href="#">Documents</a></li>
					<li class="btnFilter" id='archive'><a href="#">Archive</a></li>
				</ul>
			</div>
		</div>
	</div>
	@endif
	<div class="media" id='boxGalleries'>
		<div class="row">
			@forelse ($images as $res)
			@php
				$ext = explode('.',$res->file_name)[1];
			@endphp
			@if ($ext == 'pdf' or $ext == 'xls' or $ext == 'doc' or $ext == 'docx')
			<div class="col-md-2 item document">
				<button class="btn btn-danger delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $res->id }}">Delete</button>
				<a href="{{ url('uploaded/'.$res->dir.'/',$res->file_name) }}" target="_blank">
					@if ($ext == 'pdf')
						<div class="media-item" style="background-image: url('{{ url('assets/admin/img/PDF.png') }}');"></div>
					@elseif ($ext == 'xls')
						<div class="media-item" style="background-image: url('{{ url('assets/admin/img/Excel.png') }}');"></div>
					@elseif ($ext == 'docx' || $ext = 'doc')
						<div class="media-item" style="background-image: url('{{ url('assets/admin/img/Word.png') }}');"></div>
					@endif
				</a>
			</div>
			@elseif ($ext == 'rar' || $ext == 'zip')
			<div class="col-md-2 item archive">
				<button class="btn btn-danger delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $res->id }}">Delete</button>
				<a href="{{ url('uploaded/'.$res->dir.'/',$res->file_name) }}" target="_blank">
					<div class="media-item" style="background-image: url('{{ url('assets/admin/img/Rar_Zip.png') }}');"></div>
				</a>
			</div>
			@else
			<div class="col-md-2 item image">
				<button class="btn btn-danger delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $res->id }}">Delete</button>
				@if ($res->dir == 'download')
					@php
					$link = url('uploaded/'.$res->dir.'/',$res->file_name);
					@endphp
					@else
					@php
						$link = url('uploaded/'.$res->dir.'/','thumb-'.$res->file_name);
					@endphp
				@endif
				<a href="{{ $link }}" target="_blank">
					@if ($res->dir == 'download')
						<div class="media-item" style="background-image: url('{{ url('uploaded/'.$res->dir.'/',$res->file_name) }}');"></div>
						@else
						<div class="media-item" style="background-image: url('{{ url('uploaded/'.$res->dir.'/','thumb-'.$res->file_name) }}');"></div>
					@endif
				</a>
			</div>
			@endif
			@empty
			<h4 class="text-center">No Images Found.</h4>
			@endforelse
		</div>
		<div class="text-center">
			{{ $images->render() }}
		</div>
	</div>
</div>
@endsection
@section('modal')
<div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="closeModal close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Images</h4>
			</div>
			<div class="modal-body">
				<div id="form-errors">

				</div>
				<div class="dropzone dz-clickable" id="uploadImages">
					<div class="dz-message">
						<h3>Drop files here or click to upload.</h3>
						<p>Pilih gambar dengan format PNG, JPG & JPEG - Ukuran Maks 5 Mb</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="closeModal btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<form action="{{ route('images_delete') }}" method="post">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Delete Images</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id">
					Are you sure you want to delete this photo?
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
@section('registerscript')
<script>
	Dropzone.autoDiscover = false;
	let id = '{{ Request::segment(4) }}';
	$('#uploadImages').dropzone({
		url: "{{ route('images_store') }}",
		autoProcessQueue: true,
		method: "post",
		acceptedFiles: "image/*",
		paramName: "filename",
		maxFilesize: 5,
		dictInvalidFileType: "File type not authorized",
		sending: function(file, xhr, formData) {
			formData.append("_token", "{{ csrf_token() }}");
			formData.append("id_albums", id);
		},
		init: function() {
			this.on("success",function(file, done){
				$('#pagination').twbsPagination('destroy');
				$.ajax({
					url:'{{route('images_list')}}',
					type:'GET',
					dataType:'JSON',
					success: function(data) {
						$('#pagination').twbsPagination({
							totalPages: data.paging.last_page,
							visiblePages: 5,
							onPageClick: function (event, page) {
								dataImg(page);
							}
						});
					}
				});			
				$("#boxGalleries").load(location.href + " #boxGalleries");	
				this.removeFile(file);
			});
			this.on("error", function(file, done) { 
				$('.dz-error-message span').text('This image rejected by server');
			});				
		}
	});

	$('.closeModal').click(function() {
		Dropzone.forElement("#uploadImages").removeAllFiles(true);
	});
</script>
@endsection


