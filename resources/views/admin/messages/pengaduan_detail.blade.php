@extends('admin.layouts.main')
@section('title', 'Pengaduan Detail')
@section('contents')
	<div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
		<div class="col w-md bg-light dk b-r bg-auto">
			<div class="wrapper b-b bg">
				<button class="btn btn-sm btn-default pull-right visible-sm visible-xs" ui-toggle="show" target="#email-menu"><i class="fa fa-bars"></i></button>
				<a href="{{ route('messages_create') }}" class="btn btn-sm btn-primary w-xs font-bold">Compose</a>
			</div>
			<div class="wrapper hidden-sm hidden-xs" id="email-menu">
				<ul class="nav nav-pills nav-stacked nav-sm">
					<li><a href="{{ route('messages') }}">Inbox</a></li>
					<!-- <li><a href="{{ route('proposal') }}">Request Proposal</a></li> -->
					<li class="active"><a href="{{ route('pengaduan') }}">Pengaduan</a></li>
					<li><a href="{{ route('messages_sent') }}">Sent</a></li>
					<li><a href="{{ route('messages_trash') }}">Trash</a></li>
				</ul>
			</div>
		</div>
		<div class="col">
			<div class="wrapper bg-light lter b-b">
				<!-- @if ($message->type == 'inbox')
					<a href="{{ route('messages') }}" class="btn btn-sm btn-default w-xxs m-r-sm"><i class="fa fa-long-arrow-left"></i></a>
				@else
					<a href="{{ route('messages_sent') }}" class="btn btn-sm btn-default w-xxs m-r-sm"><i class="fa fa-long-arrow-left"></i></a>
				@endif -->
				<button class="btn btn-sm btn-default w-xxs w-auto-xs" title="Delete" data-toggle="modal" data-target="#modal-delete-message"><i class="fa fa-trash"></i></button>
			</div>
			<!-- / header -->
			<div class="wrapper b-b">
				<h2 class="font-thin m-n ng-binding">{{ $pengaduan->informer_fullname }}</h2>
			</div>
			<div class="wrapper b-b ng-binding">
				From <a href="#" class="font-bold">{{ $pengaduan->informer_email }}</a> on {{ $pengaduan->created_at }}
			</div>
			<div class="wrapper ng-binding">
				<strong>Nama Pelapor: </strong>{{ $pengaduan->informer_fullname }} <br>
				<strong>Alamat Pelapor : </strong>{{ $pengaduan->informer_address }} <br>
				<strong>Email Pelapor : </strong>{{ $pengaduan->informer_email }} <br>
				<strong>No. Telp. Pelapor : </strong>{{ $pengaduan->informer_phone }} <br>
				<hr>
				<strong>Nama Terlapor: </strong>{{ $pengaduan->suspect_fullname }} <br>
				<strong>Jabatan : </strong>{{ $pengaduan->suspect_department }} <br>
				<strong>Satuan Kerja : </strong>{{ $pengaduan->suspect_division }} <br>
				<hr>
				<strong>Subject Pengaduan : </strong>{{ $pengaduan->subject }} <br>
				<strong>Isi Pengaduan : </strong>{{ $pengaduan->complaint }} <br>
			</div>
			<div class="wrapper">
				<div class="panel b-a">
					<div class="" ng-show="reply" aria-hidden="false">
						<form action="{{ route('messages_reply') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="email" value="{{ $pengaduan->informer_email }}">
							<div class="panel-heading b-b b-light ng-binding">
								Reply for {{ $pengaduan->informer_email }}
							</div>
							<textarea class="wrapper" contenteditable="true" style="min-height:100px; max-width: 100%; border: 0" name="content" cols="138" rows="5"></textarea>
							<div class="panel-footer bg-light lt">
								<button class="btn btn-info w-xs font-bold">Send</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('modal')
	<div class="modal fade" id="modal-delete-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="{{ route('delete_pengaduan') }}" method="post">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Delete Mail</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" value="{{ $pengaduan->id }}">
						Are you sure you want to delete this mail?
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
