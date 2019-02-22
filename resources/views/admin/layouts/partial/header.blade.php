<header id="header" class="app-header navbar" role="menu">
	<!-- navbar header -->
	<div class="navbar-header bg-black">
		<button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
			<i class="glyphicon glyphicon-cog"></i>
		</button>
		<button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
			<i class="glyphicon glyphicon-align-justify"></i>
		</button>
		<!-- brand -->
		<a href="#/" class="navbar-brand">
			<img src="{{asset('assets/admin/img/logo.png')}}" alt="DTCMS">
		</a>
		<!-- / brand -->
	</div>
	<!-- / navbar header -->
	<!-- navbar collapse -->
	<div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
		<!-- buttons -->
		<div class="nav navbar-nav hidden-xs">
			<a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app">
				<i class="fa fa-dedent fa-fw text"></i>
				<i class="fa fa-indent fa-fw text-active"></i>
			</a>
		</div>
		<!-- / buttons -->
		<!-- nabar right -->
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
					<span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
						<div style="background: #eee url({{ asset('uploaded').'/users/thumb-'.Auth::user()->image }}) no-repeat center; background-size: cover; width: 40px; height: 40px; border-radius: 50%;"></div>
						<i class="on md b-white bottom"></i>
					</span>
					<span class="hidden-sm hidden-md">{{ Auth::user()->fullname }}</span> <b class="caret"></b>
				</a>
				<!-- dropdown -->
				<ul class="dropdown-menu w">
					<li>
						<a href="{{ route('team_edit') }}/{{ Auth::user()->id }}">
							<span>Account Settings</span>
						</a>
					</li>
					<li><a href="{{ route('profile') }}">Profile</a></li>
					<li><a href="{{ route('help') }}">Help</a></li>
					<li class="divider"></li>
					<li>
						<a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
					</li>
				</ul>
				<!-- / dropdown -->
			</li>
		</ul>
		<!-- / navbar right -->
	</div>
	<!-- / navbar collapse -->
</header>
