@extends('admin.layouts.main')
@section('title', 'Setting')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Setting</h1>
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
		<div class="panel">
			<div class="panel-body">
				<form action="{{ route('setting_update') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Site Title</label>
								<input type="text" name="meta_title" class="form-control input-lg" value="{{ $setting->meta_title }}" required>
							</div>
							<div class="form-group">
								<label>Site Description</label>
								<input type="text" name="meta_description" class="form-control input-lg" value="{{ $setting->meta_description }}" required>
								<i>In a few words, explain what this site is about.</i>
							</div>
							<div class="form-group">
								<label>Keyword for SEO</label><br>
								<input ui-jq="tagsinput" ui-options="" name="meta_keyword" class="form-control input-lg" value="{{ $setting->meta_keyword }}" required/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Featured image</label>
								@if ($setting->og_image != '')
									<img src="{{ asset('uploaded').'/setting//'.$setting->og_image }}" width="100%">
								@endif
								<input type="file" name="og_image" class="form-control" accept=".jpg, .jpeg, .png">
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Logo (50px * 50px)</label>
								@if ($setting->logo != '')
									<br>
									<img src="{{ asset('uploaded').'/setting//'.$setting->logo }}" width="50px">
									<br>
									<br>
								@endif
								<input type="file" name="logo" class="form-control" accept=".jpg, .jpeg, .png">
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Favicon (16px * 16px)</label>
								@if ($setting->favicon != '')
									<br>
									<img src="{{ asset('uploaded').'/setting//'.$setting->favicon }}" width="16px">
									<br>
									<br>
								@endif
								<input type="file" name="favicon" class="form-control" accept=".jpg, .jpeg, .png">
							</div>
						</div>
						<div class="col-md-12">
							<hr>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Site Timezone</label>
								<select class="form-control" name="timezone">
									<?php
										$timezone = ['Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura'];
										for ($i=0; $i < count($timezone); $i++) {
									?>
									<option value="{{ $timezone[$i] }}" {{ $timezone[$i] == $setting->timezone ? 'selected' : '' }}>{{ $timezone[$i] }}</option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Maintenance Status</label><br>
								<label class="i-switch m-t-xs m-r">
									<input type="checkbox" name="maintenance" {{ $setting->maintenance == 1 ? 'checked' : '' }}>
									<i></i>
								</label>
							</div>
						</div>
						<div class="col-md-12">
							<hr>
							<h4>Contact</h4>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" value="{{ $setting->email }}" required>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Phone</label>
								<input type="tel" ui-jq="tagsinput" ui-options="" name="phone" class="form-control" value="{{ $setting->phone }}" required>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label>Address</label>
								<input type="text" name="address" class="form-control" value="{{ $setting->address }}" required>
							</div>
						</div>
						<div class="col-md-12">
							<hr>
							<h4>Link Social Media</h4>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Facebook</label>
							<div class="input-group m-b">
								<span class="input-group-addon">https://www.facebook.com/</span>
								<input type="text" class="form-control" placeholder="youraccount/" value="{{ $setting->facebook }}" name="facebook">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Twitter</label>
							<div class="input-group m-b">
								<span class="input-group-addon">https://twitter.com/</span>
								<input type="text" class="form-control" placeholder="youraccount" value="{{ $setting->twitter }}" name="twitter">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Youtube</label>
							<div class="input-group m-b">
								<span class="input-group-addon">https://www.youtube.com/</span>
								<input type="text" class="form-control" placeholder="watch?v=juchgUPL0E8" value="{{ $setting->youtube }}" name="youtube">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Instagram</label>
							<div class="input-group m-b">
								<span class="input-group-addon">https://www.instagram.com/</span>
								<input type="text" class="form-control" placeholder="your_account/" value="{{ $setting->instagram }}" name="instagram">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Google+</label>
							<div class="input-group m-b">
								<span class="input-group-addon">https://plus.google.com/</span>
								<input type="text" class="form-control" placeholder="u/0/999998888888877774649" value="{{ $setting->google }}" name="google">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<label>Linkedin</label>
							<div class="input-group m-b">
								<span class="input-group-addon">https://www.linkedin.com/</span>
								<input type="text" class="form-control" placeholder="in/youraccount-m-99a99999/" value="{{ $setting->linkedin }}" name="linkedin">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-primary">Save Settings</button>
						</div>
					</div>
				</form>
				<hr>
				<div class="row">
					<div class="col-lg-2">
						@if ($setting->key_token == null)
							<form action="{{ route('key_token') }}" method="post">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-primary" name="button">Generate API Key</button>
							</form>
							@else
								<button type="submit" class="btn btn-primary" name="button" disabled>Generate API Key</button>
						@endif
					</div>
					<div class="col-lg-8">
						<blockquote>
							Api Key : {{ $setting->key_token==null?'---------------------':$setting->key_token }}
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection