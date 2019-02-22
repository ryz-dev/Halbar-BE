@extends('admin.layouts.main')

@section('title', 'Sharing')
	
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Sharing</h1>
	</div>
	<div class="wrapper-md">
		<div class="row">
			<div class="col-md-6">
				<div class="panel b-a sharing">
					<div class="panel-heading b-b b-light">
						<a href class="font-bold">Social Media Connections</a>
					</div>
					<ul class="list-group list-group-lg no-bg auto">
						<li class="list-group-item clearfix">
							<div class="row">
								<div class="col-sm-8">
									<span class="pull-left thumb-sm avatar m-r">
										<i class="fa fa-facebook"></i>
									</span>
									<span class="clear">
										<span>Facebook</span>
										<small class="text-muted clear text-ellipsis">Share posts to your news feed.</small>
									</span>
								</div>
								<div class="col-sm-4 text-right">
									<button class="btn btn-default">CONNECTED</button>
								</div>
							</div>
						</li>

						<li class="list-group-item clearfix">
							<div class="row">
								<div class="col-sm-8">
									<span class="pull-left thumb-sm avatar m-r">
										<i class="fa fa-twitter"></i>
									</span>
									<span class="clear">
										<span>Twitter</span>
										<small class="text-muted clear text-ellipsis">Share posts to your Twitter feed.</small>
									</span>
								</div>
								<div class="col-sm-4 text-right">
									<button class="btn btn-info font-bold">CONNECT</button>
								</div>
							</div>
						</li>

						<li class="list-group-item clearfix">
							<div class="row">
								<div class="col-sm-8">
									<span class="pull-left thumb-sm avatar m-r">
										<i class="fa fa-google-plus"></i>
									</span>
									<span class="clear">
										<span>Google+</span>
										<small class="text-muted clear text-ellipsis">Comment and share to your profile.</small>
									</span>
								</div>
								<div class="col-sm-4 text-right">
									<button class="btn btn-info font-bold">CONNECT</button>
								</div>
							</div>
						</li>

						<li class="list-group-item clearfix">
							<div class="row">
								<div class="col-sm-8">
									<span class="pull-left thumb-sm avatar m-r">
										<i class="fa fa-linkedin"></i>
									</span>
									<span class="clear">
										<span>LinkedIn</span>
										<small class="text-muted clear text-ellipsis">Share posts to your connections.</small>
									</span>
								</div>
								<div class="col-sm-4 text-right">
									<button class="btn btn-info font-bold">CONNECT</button>
								</div>
							</div>
						</li>

						<li class="list-group-item clearfix">
							<div class="row">
								<div class="col-sm-8">
									<span class="pull-left thumb-sm avatar m-r">
										<i class="fa fa-tumblr"></i>
									</span>
									<span class="clear">
										<span>Tumblr</span>
										<small class="text-muted clear text-ellipsis">Share posts to your Tumblr blog.</small>
									</span>
								</div>
								<div class="col-sm-4 text-right">
									<button class="btn btn-info font-bold">CONNECT</button>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<form action="">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Publishing Schedule</h4>
					</div>
					<div class="modal-body">
						Select a date and time in the future for your submissions for publication.
						
						<div class="form-group">
							<label>Date</label>
							<input type="date" name="publish-date" class="form-control">
						</div>

						<div class="form-group">
							<label>Time</label>
							<input type="time" name="publish-time" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Schedule</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection