@extends('admin.layouts.main')
@section('title', 'Messages Compose')	
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
					<li><a href="{{ route('pengaduan') }}">Pengaduan</a></li>
					<li><a href="{{ route('messages_sent') }}">Sent</a></li>
					<li><a href="{{ route('messages_trash') }}">Trash</a></li>
				</ul>
			</div>
		</div>
		<div class="col">
			<!-- header -->
			<div class="wrapper bg-light lter b-b">
				<div class="btn-group m-r-sm">
					<h4>New Message</h4>
				</div>
			</div>
			<!-- / header -->
			<div class="wrapper">
				<form action="{{ route('messages_send') }}" method="post" class="form-horizontal m-t-lg ng-pristine ng-valid">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="col-lg-8">
							<label>To:</label>
							<input type="text" name="email" class="form-control" autocomplete="off" placeholder="ex: example@mail.com">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-8">
							<label>Subject:</label>
							<input type="text" name="subject" class="form-control ng-pristine ng-untouched ng-valid" ng-model="mail.subject" aria-invalid="false">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8">
							<label>Content</label>
							<textarea ui-jq="wysiwyg" class="form-control h-auto" style="min-height:200px; max-width: 100%;" contenteditable="true" name="content"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-8 col-lg-offset-2">
							<button class="btn btn-info w-xs">Send</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection