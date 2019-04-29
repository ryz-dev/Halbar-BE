@extends('admin.layouts.main')
@section('title', 'Employees')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Employees</h1>
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
			<div class="panel">
				<div class="panel-body">
					<form action="{{ route('about_employees_store') }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="name" class="form-control" placeholder="Full name" required>
								</div>
								<div class="form-group">
									<label>Biografi</label>
									<textarea name="biografi" class="form-control" cols="30" rows="9"></textarea>
								</div>
								<div class="form-group">
									<label>Tempat Lahir</label>
									<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" >
								</div>
								<div class="form-group">
									<label>Tanggal Lahir</label>
									<input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal lahir " required>
								</div>

								<div class="form-group">
									<label>Jenis Kelamin</label>
									<div class="form-check">
										<input class="form-check-input" name="jenis_kelamin" type="radio" value="Laki - laki" required>
										<label class="form-check-label">
											Laki - laki
										</label>
										<input class="form-check-input" name="jenis_kelamin" type="radio" value="Perempuan" required >
										<label class="form-check-label">
											Perempuan
										</label>
									</div>
								</div>

								<div class="form-group">
									<label>Agama</label>
									<input type="text" name="agama" class="form-control" placeholder="Agama" >
								</div>
								<div class="form-group">
									<label>Pend. terakhir</label>
									<input type="text" name="pendidikan_terakhir" class="form-control" placeholder="Pendidikan terakhir" >
								</div>
								<div class="form-group">
									<label>Masa Bakti</label>
									<input type="text" name="masa_bakti" class="form-control" placeholder="Masa bakti" >
								</div>
								<div class="form-group">
									<label>Alamat Rumah</label>
									<input type="text" name="alamat_rumah" class="form-control" placeholder="Alamat rumah" >
								</div>
								<div class="form-group">
									<label>Alamat Kantor</label>
									<input type="text" name="alamat_kantor" class="form-control" placeholder="Alamat kantor" >
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Phone</label>
									<input type="text" name="phone" class="form-control" placeholder="Phone" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Email Address" required>
								</div>
								<div class="form-group">
									<label>Nip</label>
									<input type="text" name="nip" class="form-control" placeholder="Nip"d>
								</div>
								<div class="form-group">
									<label>Position</label>
									<input type="text" name="position" class="form-control" placeholder="Position" required>
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
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp;&nbsp;Add</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			@foreach ($employees as $e)
			<div class="col-md-3 team-item">
				<div class="panel text-center">
					<div class="team-action">
						<a href="{{ route('about_employees_edit',['id'=>$e->id]) }}" class="btn btn-default"><i class="icon-pencil"></i></a>
						<button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-id="{{ $e->id }}"><i class="icon-close"></i></button>
					</div>
					<div style="background: #ccc url({{ asset('uploaded') }}/media/thumb-{{ $e->image }}) no-repeat center; -webkit-background-size: cover; background-size: cover;padding-bottom: 100%"></div>
					<h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><b>{{ $e->name }}</b></h4>
					<h5>{{ $e->position }}</h5>
				</div>
			</div>
			@endforeach
		</div>
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('about_employees_delete') }}" method="post">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Employees</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id">
						Are you sure you want to delete this file?
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