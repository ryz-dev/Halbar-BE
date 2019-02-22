@extends('admin.layouts.main')

@section('title', 'Messages')
	
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
					<li><a href="{{ route('messages_sent') }}">Sent</a></li>
					<li class="active"><a href="{{ route('messages_trash') }}">Trash</a></li>
				</ul>
			</div>
		</div>
		<div class="col">
			
			<div>
				<!-- header -->
				<div class="wrapper bg-light lter b-b">
					<div class="btn-group pull-right">
						<?php
							$prev = $messages->currentPage() > 1 ? $linkpage.( $messages->currentPage() - 1)  : "#";
							$next = $messages->hasMorePages() > 0 ? $linkpage.( $messages->currentPage() + 1)  : "#";
						?>
						<a href="{{ $prev }}" type="button" class="btn btn-sm btn-bg btn-default"><i class="fa fa-chevron-left"></i></a>
						<a href="{{ $next }}" type="button" class="btn btn-sm btn-bg btn-default"><i class="fa fa-chevron-right"></i></a>
					</div>
					<div class="btn-toolbar">
						<div class="btn-group dropdown">
						</div>
					</div>
				</div>
				<!-- / header -->

				<!-- list -->
				<ul class="list-group list-group-lg no-radius m-b-none m-t-n-xxs">
					@forelse ($messages as $message)
						<li class="list-group-item clearfix {{ $message->read_status == '0' ? 'b-l-3x b-l-info' : '' }}">
							<div class="pull-right text-sm text-muted">
								<span class="hidden-xs ">{{ Carbon\Carbon::parse($message->deleted_at)->diffForHumans() }}</span>
								<i class="fa fa-paperclip m-l-sm"></i>
							</div>
							<div class="clear">
								<div><a class="text-md {{ $message->read_status == '0' ? 'font-bold' : '' }}" href="{{ route('messages_detail', ['id' => $message->id]) }}">{{ $message->fullname }}</a></div>
								<div class="text-ellipsis m-t-xs ">{{ str_limit($message->message, 100) }}</div>
							</div>
						</li>
					@empty
						<li class="list-group-item clearfix">
							<div class="clear">
								You have no messages.
							</div>
						</li>
					@endforelse
				</ul>
				<!-- / list -->
			</div>

		</div>
	</div>
@endsection