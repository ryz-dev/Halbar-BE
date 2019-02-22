<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@yield('title', 'Admin')</title>
		@include('admin.layouts.partial.meta')
		@yield('styles')
	</head>
	<body>
		<div class="loader">
			<img src="{{asset('assets/admin/img/load.gif')}}" alt="Loader">
		</div>
		<div class="app app-header-fixed">
			<!-- header -->
			@include('admin.layouts.partial.header')
			<!-- / header -->
			<!-- aside -->
			@include('admin.layouts.partial.aside')
			<!-- / aside -->
			<!-- content -->
			<div id="content" class="app-content" role="main">
				<div class="app-content-body theiaStickySidebar">
					@yield('contents')
				</div>
			</div>
			<!-- /content -->
			<!-- footer -->
			@include('admin.layouts.partial.footer')
			<!-- / footer -->
		</div>
		@include('admin.layouts.partial.modal')
		@yield('modal')
		<!-- Javascript Libraries -->
		@include('admin.layouts.partial.script')
		@yield('registerscript')
	</body>
</html>
